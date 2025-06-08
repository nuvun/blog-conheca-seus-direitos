<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PostService
{
    public function __construct(
        public Post $model
    ) {}

    public function getPosts(): Paginator|Collection
    {
        return \Cache::rememberForever('lastPosts', function () {
            return $this->model::query()
                ->with('categories:id,name')
                ->select(['id', 'title', 'subtitle'])
                ->with(['media'])
                ->active()
                ->validPeriod()
                ->latest('published_at')
                ->simplePaginate()
                ->withQueryString();
        });
    }

    public function getPost(int $postId): Post
    {
        $cacheKey = 'post_' . $postId;

        return \Cache::rememberForever($cacheKey, function () use ($postId) {
            return $this->model::query()
                ->with(['media'])
                ->findOrFail($postId);
        });
    }

    public function getRelatedPosts(int $postId): Collection
    {
        $cacheKey = 'post_' . $postId;

        return \Cache::remember($cacheKey . '_related', now()->addMinutes(30), function () use ($postId) {
            return $this->model::query()
                ->with(['media'])
                ->validPeriod()
                ->where('id', '!=', $postId)
                ->latest('published_at')
                ->limit(3)
                ->get(['id', 'title', 'subtitle']);
        });
    }

    public function getArticlesHome(): Collection
    {
        return \Cache::rememberForever('getArticlesHome', function () {
            return $this->model::query()
                ->with(['media'])
                ->isFromArticle()
                ->active()
                ->validPeriod()
                ->latest('published_at')
                ->limit(4)
                ->get(['id', 'title', 'subtitle', 'attributes']);
        });
    }

    public function getArticles(): Paginator|Collection
    {
        return \Cache::rememberForever('getArticles', function () {
            return $this->model::query()
                ->with('categories:id,name')
                ->select(['id', 'title', 'subtitle', 'attributes'])
                ->with(['media'])
                ->isFromArticle()
                ->active()
                ->validPeriod()
                ->latest('published_at')
                ->simplePaginate()
                ->withQueryString();
        });
    }

    public function getPostsMostRead()
    {
        return \Cache::remember('postsMostRead', now()->addHours(4), function () {
            return $this->model::query()
                ->withCount('views')
                ->with('media')
                ->orderByDesc('views_count')
                ->limit(5)
                ->get(['id', 'title', 'subtitle']);
        });
    }

}
