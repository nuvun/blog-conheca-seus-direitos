<?php

namespace App\Http\Controllers\Site;

use App\Models\Video;
use Illuminate\View\View;

class VideoController
{

    public function index(): View
    {
        $title = 'Vídeos ' . config('app.name');

        $videos = Video::query()
            ->with(['media'])
            ->latest('id')
            ->simplePaginate()
            ->withQueryString();

        return view('site.videos.index', compact('title', 'videos'));
    }

    public function show(string $slug, Video $video): View
    {
        views($video)->record();

        $title = $video->title;

        $video->load('media');

        return view('site.videos.show', compact('video', 'title'));
    }

}
