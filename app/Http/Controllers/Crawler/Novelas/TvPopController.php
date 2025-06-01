<?php

namespace App\Http\Controllers\Crawler\Novelas;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Jobs\Crawler\GenerateContentWithIaFromPostUrlTvPopJob;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class TvPopController extends Controller
{
    const URL = 'https://www.tvpop.com.br/editoria/novelas/feed/';
    const SOURCE = 'TV Pop';

    const CATEGORY = 933;

    const USER_CRAWLER = 1;

    public function __invoke(): JsonResponse
    {
        $items = $this->getItemsToProcess();

        $totalPostsToProcess = $this->processPosts($items);

        return response()->json(['message' => "$totalPostsToProcess posts salvos para serem processados."]);
    }

    private function getItemsToProcess(): array
    {
        $xml        = simplexml_load_file(self::URL);
        $namespaces = $xml->getNamespaces(true);

        $items = [];
        $i     = 0;

        foreach ($xml->channel->item as $item) {
            $pubDate = Carbon::parse($item->pubDate);

            $items[$i]['title']                 = (string) $item->title;
            $items[$i]['subtitle']              = (string) $item->description;
            $items[$i]['content']               = (string) $item->children($namespaces['content'])->encoded;
            $items[$i]['published_at']          = $pubDate->format('Y-m-d H:i:s');
            $items[$i]['status']                = StatusEnum::INACTIVE->value;
            $items[$i]['attributes']['link']    = (string) $item->link; // (string) $item->guid;
            $items[$i]['attributes']['crawler'] = true;
            $items[$i]['attributes']['source']  = self::URL;

            $i++;
        }

        return $items;
    }

    private function processPosts(array $items): int
    {
        $linksPostsSaved = Post::whereHas('categories', fn($query) => $query->where('content_category_id', self::CATEGORY))
            ->where('attributes->crawler', true)
            ->where('attributes->source', self::SOURCE)
            ->get(['attributes->link AS LINK_SOURCE'])
            ->toArray();

        $totalPostsProcessed = 0;

        if (count($linksPostsSaved)) {
            $items = array_filter($items, fn($item) => !in_array($item['attributes']['link'], array_column($linksPostsSaved, 'LINK_SOURCE')));
        }

//        foreach ($items as $item) {
        foreach (array_slice($items, 0, 1) as $item) {
            $link = $item['attributes']['link'];

            $post = Post::create([
                'title'        => $item['title'],
                'subtitle'     => $item['title'],
                'content'      => $item['title'],
                'published_at' => now(),
                'status'       => StatusEnum::INACTIVE->name,
            ]);

            $post->categories()->sync([self::CATEGORY]);
            $post->users()->sync([self::USER_CRAWLER]);

            $post->attributes->set([
                'link'    => $link,
                'crawler' => true,
                'source'  => self::SOURCE,
            ]);

            $post->save();

            GenerateContentWithIaFromPostUrlTvPopJob::dispatch($post, $item['title'], $link);

            if ($post->wasRecentlyCreated) {
                $totalPostsProcessed++;
            }
        }

        return $totalPostsProcessed;
    }

}
