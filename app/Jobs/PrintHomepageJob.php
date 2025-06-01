<?php

namespace App\Jobs;

use App\Mail\PrintHomeMail;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Ilovepdf\Ilovepdf;

class PrintHomepageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $ilovepdf = new Ilovepdf(config('services.ilovepdf.public_key'), config('services.ilovepdf.secret_key'));
        $myTaskHtmlpdf = $ilovepdf->newTask('htmlpdf');
        $myTaskHtmlpdf = $ilovepdf->setRemovePopups(true);
        $myTaskHtmlpdf->addUrl("https://pensarpiaui.com?removeScripts");
        $fileName = "print-".date('d-m-Y').".pdf";
        $myTaskHtmlpdf->setOutputFilename($fileName);
        $myTaskHtmlpdf->execute();
        $myTaskHtmlpdf->download(storage_path('app/public'));

        $file = storage_path('app/public/'.$fileName);

        Mail::queue(new PrintHomeMail($file));
    }

    public function retryUntil(): DateTime
    {
        return now()->addMinutes(5);
    }

}
