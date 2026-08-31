<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;

class VerifierExpirationAbonnements extends Command
{
    protected $signature = 'clients:verifier-expiration';

    protected $description = "Passe automatiquement au statut \"expire\" les clients dont l'abonnement est dépassé";

    public function handle(): int
    {
        $clientsExpires = Client::where('statut', 'actif')
            ->where('date_fin_abonnement', '<', now()->toDateString())
            ->get();

        foreach ($clientsExpires as $client) {
            $client->update(['statut' => 'expire']);
            $this->info("Client expiré : {$client->nom}");
        }

        $this->info("{$clientsExpires->count()} client(s) passé(s) en expiré.");

        return self::SUCCESS;
    }
}