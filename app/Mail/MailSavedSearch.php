<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSavedSearch extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $search;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $search)
    {
        $this->user = $user;
        $this->search = $search;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.savedSearchEmail');
    }
}
