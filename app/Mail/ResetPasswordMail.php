<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $user;

    public function __construct($url, $user)
    {
        $this->url = $url;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Restablece tu contraseña')
                    ->view('emails.reset-password');
    }
}
