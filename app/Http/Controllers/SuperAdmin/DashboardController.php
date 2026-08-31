<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Paiement;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $clients = Client::withCount('depots')->get();

        $clientsActifs = $clients->where('statut', 'actif')->count();

        // Revenu mensuel récurrent : on ramène chaque abonnement à son
        // équivalent mensuel pour pouvoir les additionner entre eux.
        $mrr = $clients->where('statut', 'actif')->sum(function ($client) {
            return match ($client->periode_abonnement) {
                'mensuel' => $client->montant_abonnement,
                'trimestriel' => $client->montant_abonnement / 3,
                'annuel' => $client->montant_abonnement / 12,
            };
        });

        $expirationProche = $clients->filter(function ($client) {
            return $client->statut === 'actif'
                && $client->date_fin_abonnement->isFuture()
                && now()->diffInDays($client->date_fin_abonnement) <= 30;
        })->count();

        $totalDepots = $clients->sum('depots_count');

        $paiementsRecents = Paiement::where('date_paiement', '>=', now()->subMonths(5)->startOfMonth())->get();

        $revenusParMois = collect(range(5, 0))->map(function ($moisAvant) use ($paiementsRecents) {
            $mois = now()->subMonths($moisAvant);

            return [
                'label' => $mois->translatedFormat('M Y'),
                'total' => $paiementsRecents->filter(fn ($p) => $p->date_paiement->isSameMonth($mois))->sum('montant'),
            ];
        });

        return view('super-admin.dashboard', compact(
            'clientsActifs',
            'clients',
            'mrr',
            'expirationProche',
            'totalDepots',
            'revenusParMois',
        ));
    }
}