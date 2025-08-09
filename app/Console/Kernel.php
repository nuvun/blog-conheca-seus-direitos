<?php

namespace App\Console;

use App\Jobs\SendCaseToNuvunJob;
use App\Models\ChatUserData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         Schedule::call(function () {
             $chatsUserData = ChatUserData::query()
                 ->withWhereHas('chatMessages')
                 ->where('sent_to_nuvun', false)
                 ->orderByDesc('id')
                 ->get();

             foreach ($chatsUserData as $chatUserData) {
                 SendCaseToNuvunJob::dispatch($chatUserData);
             }

        })->everySixHours();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
