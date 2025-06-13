<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResponseToMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $messageData;
    public $responseText;

    public function __construct($messageData, $responseText)
    {
        $this->messageData = $messageData;
        $this->responseText = $responseText;
    }

    public function build()
    {
        return $this->subject('Respuesta a tu mensaje')
                    ->view('emails.response-message')
                    ->with([
                        'messageData' => $this->messageData,
                        'responseText' => $this->responseText,
                    ]);
    }
}
