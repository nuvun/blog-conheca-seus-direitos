<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class InvalidatePostCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $postId;

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public function handle(): void
    {
        Cache::forget('post_' . $this->postId);
        Cache::forget('post_' . $this->postId . '_related');

        Cache::forget('lastPosts');
        Cache::forget('postsBloggersHome');
        Cache::forget('postsCategoriesHome');
        Cache::forget('featuredPosts');
    }
}
