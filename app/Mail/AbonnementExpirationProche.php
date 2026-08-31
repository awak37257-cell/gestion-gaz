<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbonnementExpirationProche extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Client $client)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre abonnement expire bientôt',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.abonnement-expiration',
        );
    }
}