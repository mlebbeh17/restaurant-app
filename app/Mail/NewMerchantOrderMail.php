<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMerchantOrderMail extends Mailable {
    use Queueable, SerializesModels;

    public $receiver_name;
    public $ingredient_name;

    /**
     * Create a new message instance.
     *
     *
     *
     * @return void
     */
    public function __construct($receiver_name, $ingredient_name) {
        $this->receiver_name   = $receiver_name;
        $this->ingredient_name = $ingredient_name;

    }

    /**
     * Build the message.
     *
     *
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Ingredient order')->view('emails.NewMerchantOrderMail');
    }

}