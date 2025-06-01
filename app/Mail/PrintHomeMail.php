<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrintHomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function build(): self
    {
        return $this->from("portal.pensarpiaui@gmail.com", config('app.name'))
            ->to("italoplus@gmail.com", config('app.name'))
            ->subject("Print - ".date('d/m/Y'). " - ".config('app.url'))
            ->view('emails.print-home')
            ->with([
                'url' => config('app.url'),
                'date' => date('d/m/Y'),
            ])
            ->attach($this->file);
    }


}
