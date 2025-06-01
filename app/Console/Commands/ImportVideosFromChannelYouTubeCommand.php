<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportVideosFromChannelYouTubeCommand extends Command
{
    protected $signature = 'import:videos-from-channel-youtube';

    protected $description = 'Import videos from channel YouTube';
    const CHANNEL_ID = 'UCsUhBLPHeQ1oYysyn04zkeg';

    const MAX_RESULTS = 50;

    public function handle(): void
    {
        $apiKey = config('services.google.api_key_youtube');

        $urlApiYouTube = 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.self::CHANNEL_ID.'&maxResults='.self::MAX_RESULTS.'&key='.$apiKey;
        $listVideos    = json_decode(file_get_contents($urlApiYouTube));

        $idsVideosYouTube = array_map(
            fn($video) => $video->id->videoId,
            array_filter($listVideos->items, fn($video) => isset($video->id->videoId))
        );

        $idsYouTubeVideosSaved = Video::query()
            ->selectRaw("substring_index(substring_index(external_link, 'v=', -1), '&', 1) as youtubeId")
            ->pluck('youtubeId')
            ->toArray();

        $videosToSave = array_filter(
            $listVideos->items,
            fn($video) => isset($video->id->videoId) && !in_array($video->id->videoId, $idsYouTubeVideosSaved)
        );

        $videosToSave = array_reverse($videosToSave);

        $count = 0;
        $this->withProgressBar($videosToSave, function ($video) use (&$count) {
            $youtubeId = $video->id->videoId;
            $titleVideo = $video->snippet->title;

            $video = Video::create([
                'title'         => $titleVideo,
                'description'   => $video->snippet->description,
                'external_link' => 'https://www.youtube.com/watch?v='.$youtubeId,
            ]);

            $featuredImage = "https://img.youtube.com/vi/".$youtubeId."/hqdefault.jpg";

            $video
                ->addMediaFromUrl($featuredImage)
                ->usingFileName(Str::slug($titleVideo).'.'.pathinfo($featuredImage, PATHINFO_EXTENSION))
                ->toMediaCollection('featured_image');

            $count++;
        });

        $this->info('Total de vídeos importados: '.$count);

    }

}
