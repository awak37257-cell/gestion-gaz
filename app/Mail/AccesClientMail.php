<?php
namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccesClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public Client $client;
    public string $emailClient;
    public string $motDePasseClair;
    public string $urlAcces; // Nouvelle propriété pour le lien welcome

    public function __construct(Client $client, string $emailClient, string $motDePasseClair)
    {
        $this->client = $client;
        $this->emailClient = $emailClient;
        $this->motDePasseClair = $motDePasseClair;
        
        // Génère automatiquement le lien pointant vers la page welcome avec le slug du client
        $this->urlAcces = route('home', ['client' => $client->slug]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vos accès officiels à votre espace de gestion',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.acces-client', // Le fichier de vue HTML de l'email
            // (Optionnel) Si tu veux explicitement passer des variables avec un autre nom :
            // with: [
            //     'urlAcces' => $this->urlAcces,
            // ]
        );
    }
}