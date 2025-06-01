<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PostService
{
    public function __construct(
        public Post $model
    ) {}

    public function getPosts(): Paginator|Collection
    {
        return \Cache::rememberForever('lastPosts', function () {
            return $this->model::query()
                ->select(['id', 'title', 'subtitle', 'slug'])
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
                ->get(['id', 'title', 'subtitle', 'slug']);
        });
    }

}
