<?php

namespace App\Http\Controllers\Crawler\Concursos;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Jobs\GenerateContentWithIaFromPostUrlJob;
use App\Jobs\ImproveSeoPostIaJob;
use App\Models\Post;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\JsonResponse;
use OpenAI\Laravel\Facades\OpenAI;

class FolhaDirigidaController extends Controller
{
    const URL = 'https://folha.qconcursos.com/e/concursos-piaui-pi';
    const SOURCE = 'Folha Dirigida';

    const CATEGORY_CONCURSO = 933;

    const USER_CRAWLER = 1;

    public function __invoke(): JsonResponse
    {
        $items = $this->getItemsToProcess();

        $totalPostsToProcess = $this->processPosts($items);

        return response()->json(['message' => "$totalPostsToProcess posts salvos para serem processados."]);
    }

    private function getItemsToProcess(): array
    {
        $items = [];

        $html = file_get_contents(self::URL);

        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        $xpath = new DOMXPath($dom);

        $sectionListNews = $xpath->query("//section[contains(@class, 'c-PJLV')]");

        foreach ($sectionListNews as $section) {
            foreach ($xpath->query(".//a[starts-with(@href, '/n/')]", $section) as $link) {
                $items[] = [
                    'title' => $link->getAttribute('title'),
                    'link'  => "https://folha.qconcursos.com/" . $link->getAttribute('href'),
                ];
            }
        }

        return $items;
    }

    private function processPosts(array $items): int
    {
        $linksPostsSaved = Post::whereHas('categories', fn($query) => $query->where('content_category_id', self::CATEGORY_CONCURSO))
            ->where('attributes->crawler', true)
            ->where('attributes->source', self::SOURCE)
            ->get(['attributes->link AS LINK_SOURCE'])
            ->toArray();

        $totalPostsProcessed = 0;

        if (count($linksPostsSaved)) {
            $items = array_filter($items, fn($item) => !in_array($item['link'], array_column($linksPostsSaved, 'LINK_SOURCE')));
        }

        foreach ($items as $item) {
            $post = Post::create([
                'title'        => $item['title'],
                'subtitle'     => $item['title'],
                'content'      => $item['title'],
                'published_at' => now(),
                'status'       => StatusEnum::INACTIVE->name,
            ]);

            $post->categories()->sync([self::CATEGORY_CONCURSO]);
            $post->users()->sync([self::USER_CRAWLER]);

            $post->attributes->set([
                'link'    => $item['link'],
                'crawler' => true,
                'source'  => self::SOURCE,
            ]);

            $post->save();

            GenerateContentWithIaFromPostUrlJob::dispatch($post, $item['title'], $item['link']);

            if ($post->wasRecentlyCreated) {
                $totalPostsProcessed++;
            }
        }

        return $totalPostsProcessed;
    }

}
