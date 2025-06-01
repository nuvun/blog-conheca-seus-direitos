<?php

namespace App\View\Components;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class PostsMostRead extends Component
{
    public function render(): View
    {
        $postsMostRead = Cache::remember('postsMostRead', 5000, function () {
            return Post::withCount('views')
                ->orderByDesc('views_count')
                ->take(5)
                ->get(['id', 'title']);
        });

        return view('components.posts-most-read', compact('postsMostRead'));
    }
}
