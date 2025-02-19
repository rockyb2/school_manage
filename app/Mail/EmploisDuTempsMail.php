<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EmploisDuTempsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emplois;
    public $enseignant;

    public function __construct($emplois, $enseignant)
    {
        $this->emplois = $emplois;
        $this->enseignant = $enseignant;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Les emplois du temps pour le semestre sont disponibles.',
        );
    }


    public function content()
    {
        return new Content(
            view: 'emails.emplois_du_temps',
        );
    }
}
