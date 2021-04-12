<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailDebit extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $deduct;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $deduct)
    {
        $this->user = $user;
        $this->deduct = $deduct;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.debitEmail');
    }
}
