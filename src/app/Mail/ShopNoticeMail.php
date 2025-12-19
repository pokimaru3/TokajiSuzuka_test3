<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShopNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;
    public $subjectText;
    public $bodyText;

    public function __construct($shop, $subjectText, $bodyText)
    {
        $this->shop = $shop;
        $this->subjectText = $subjectText;
        $this->bodyText = $bodyText;
    }

    public function build()
    {
        return $this
            ->from($this->shop->email, $this->shop->name)
            ->subject($this->subjectText)
            ->view('emails.shop_notice');
    }
}
