<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VideogameRecommendations extends Mailable
{
    use Queueable, SerializesModels;

    public $games;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($games)
    {
        $this->games = $games;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.videogame-recommendations-master-list')
                    ->subject('New Video Game Recommendations For You!');
    }
}