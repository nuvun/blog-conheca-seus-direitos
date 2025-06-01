<?php

namespace App\Http\Controllers\Crawler\Concursos;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Jobs\ImproveSeoPostIaJob;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ConcursoNewsController extends Controller
{
    const URL_CONCURSO_NEWS = 'https://concursonews.com/noticias/concursos-abertos-e-previstos-piaui/feed';
    const SOURCE_CONCURSO_NEWS = 'Concurso News';

    const CATEGORY_CONCURSO = 933;

    const USER_CRAWLER = 1;

    public function __invoke(): JsonResponse
    {
        $items = $this->getItemsToSave();

        $totalPostsSaved = $this->savePosts($items);

        return response()->json(['message' => "$totalPostsSaved posts salvos."]);
    }

    private function getItemsToSave(): array
    {
        $xml        = simplexml_load_file(self::URL_CONCURSO_NEWS);
        $namespaces = $xml->getNamespaces(true);

        $items = [];
        $i     = 0;

        foreach ($xml->channel->item as $item) {
            $pubDate = Carbon::parse($item->pubDate);

            if ($pubDate->format('Y') == '2024' && $pubDate->format('m') < '08') {
                continue;
            }

            $items[$i]['title']                 = (string) $item->title;
            $items[$i]['subtitle']              = (string) $item->description;
            $items[$i]['content']               = (string) $item->children($namespaces['content'])->encoded;
            $items[$i]['published_at']          = $pubDate->format('Y-m-d H:i:s');
            $items[$i]['status']                = StatusEnum::INACTIVE->value;
            $items[$i]['attributes']['link']    = (string) $item->guid;
            $items[$i]['attributes']['crawler'] = true;
            $items[$i]['attributes']['source']  = self::SOURCE_CONCURSO_NEWS;

            $i++;
        }

        return $items;
    }

    private function savePosts(array $items): int
    {
        $linksPostsSavedFromConcursosNews = Post::whereHas('categories', fn($query) => $query->where('content_category_id', self::CATEGORY_CONCURSO))
            ->where('attributes->crawler', true)
            ->where('attributes->source', self::SOURCE_CONCURSO_NEWS)
            ->get(['attributes->link AS LINK_SOURCE'])
            ->toArray();

        $itemsToSave     = array_filter($items, fn($item) => !in_array($item['attributes']['link'], array_column($linksPostsSavedFromConcursosNews, 'LINK_SOURCE')));
        $totalPostsSaved = 0;

        foreach ($itemsToSave as $item) {
            $post = Post::create($item);

            if (!empty($item['attributes'])) {
                $post->attributes->set($item['attributes']);
                $post->save();
            }

            $post->categories()->sync([self::CATEGORY_CONCURSO]);
            $post->users()->sync([self::USER_CRAWLER]);

            ImproveSeoPostIaJob::dispatch($post);

            if ($post->wasRecentlyCreated) {
                $totalPostsSaved++;
            }
        }

        return $totalPostsSaved;
    }

}
