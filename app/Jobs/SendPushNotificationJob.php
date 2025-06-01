<?php

namespace App\Jobs;

use Berkayk\OneSignal\OneSignalClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly string $title,
        public readonly string $url,
    ) { }

    public function handle(): void
    {
        $oneSignal = new OneSignalClient(
            config('onesignal.app_id'),
            config('services.onesignal.app_key'),
            "",
        );

        $oneSignal->sendNotificationToAll(
            $this->title,
            $this->url,
            $data = null,
            $buttons = null,
            $schedule = null,
            config('site.site_name'),
            "",
        );
    }
}
