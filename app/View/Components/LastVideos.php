<?php

namespace App\View\Components;

use App\Models\Video;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class LastVideos extends Component
{
    public function render(): View
    {
        $lastVideos = Cache::rememberForever('lastVideos', function () {
            return Video::with('media')
                ->orderByDesc('id')
                ->take(5)
                ->get();
        });

        return view('components.last-videos', compact('lastVideos'));
    }
}
