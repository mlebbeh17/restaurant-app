<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue {
    use Queueable;

    public $ingredient;
    public $remaining;
    public $merchant_name;
    public $merchant_email;

    public function __construct($ingredient, $remaining, $merchant_name, $merchant_email) {
        $this->ingredient     = $ingredient;
        $this->remaining      = $remaining;
        $this->merchant_name  = $merchant_name;
        $this->merchant_email = $merchant_email;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed                                            $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Ingredient alert')
            ->replyTo('mhd.abulebbeh2@gmail.com')
            ->view('emails.ticket', [
                    'ingredient'   => $this->ingredient,
                    'remaining'   => $this->remaining,
                    'merchant_name'   => $this->merchant_name,
                    'ingredient'   => $this->ingredient,
                ]
            )
            ->from('noreply@classera.net');

        return $mail;
    }
}
