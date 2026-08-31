<?php

namespace App\Console\Commands;

use App\Mail\AbonnementExpirationProche;
use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifierExpirationProche extends Command
{
    protected $signature = 'clients:notifier-expiration';

    protected $description = "Envoie un email aux clients dont l'abonnement expire dans 7 jours";

    public function handle(): int
    {
        $dateCible = now()->addDays(7)->toDateString();

        $clientsConcernes = Client::where('statut', 'actif')
            ->whereDate('date_fin_abonnement', $dateCible)
            ->whereNotNull('email_contact')
            ->get();

        foreach ($clientsConcernes as $client) {
            Mail::to($client->email_contact)->send(new AbonnementExpirationProche($client));
            $this->info("Email envoyé à : {$client->nom} ({$client->email_contact})");
        }

        $this->info("{$clientsConcernes->count()} email(s) envoyé(s).");

        return self::SUCCESS;
    }
}