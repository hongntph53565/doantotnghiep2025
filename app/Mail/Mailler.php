<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Mailler extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $htmlContent;

    public function __construct($subjectText, $htmlContent)
    {
        $this->subjectText = $subjectText;
        $this->htmlContent = $htmlContent;
    }

    public function build()
    {
        return $this->subject($this->subjectText)->html($this->htmlContent);
    }
}
