<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $vendeur = Vendeur::with('depot')->findOrFail(session('vendeur_id'));

        $ventesDuJour = $vendeur->ventes()
            ->whereDate('date_heure', today())
            ->with(['couleurVendue.marque', 'couleurDemandee'])
            ->latest('date_heure')
            ->get();

        $nombreVentes = $ventesDuJour->count();

        $changementsEffectues = $ventesDuJour->filter->estSubstitution();

        $demandesEnAttente = $vendeur->demandesApprovisionnement()
            ->where('statut', 'en_attente')
            ->with(['marque', 'couleur'])
            ->latest('date')
            ->get();

        return view('vendeur.dashboard', compact(
            'vendeur',
            'ventesDuJour',
            'nombreVentes',
            'changementsEffectues',
            'demandesEnAttente',
        ));
    }
}