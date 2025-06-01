<?php

namespace App\Console;

use App\Http\Controllers\Crawler\Concursos\ConcursoNewsController;
use App\Http\Controllers\Crawler\Concursos\FolhaDirigidaController;
use App\Http\Controllers\Crawler\Novelas\TvPopController;
use App\Jobs\PrintHomepageJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule::job(new PrintHomepageJob())->dailyAt('09:00');

        $schedule->call(new ConcursoNewsController())->hourly()->between('7:00', '22:00');

        $schedule->call(new FolhaDirigidaController())->hourly()->between('7:00', '22:00');

//        $schedule->call(new TvPopController())->hourly()->between('7:00', '22:00');
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
