<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
public function index(): View
    {
        $vendeur = Vendeur::with('depot')->findOrFail(session('vendeur_id'));

        // Ventes du jour
        $ventesDuJour = $vendeur->ventes()
            ->whereDate('date_heure', today())
            ->with(['couleurVendue.marque', 'couleurDemandee'])
            ->latest('date_heure')
            ->get();

        // Somme des quantités vendues aujourd'hui
        $nombreVentesJour = $ventesDuJour->sum('quantite');

        // Somme des quantités vendues ce mois-ci
        $nombreVentesMois = $vendeur->ventes()
            ->whereMonth('date_heure', now()->month)
            ->whereYear('date_heure', now()->year)
            ->sum('quantite');

        $changementsEffectues = $ventesDuJour->filter->estSubstitution();

        $demandesEnAttente = $vendeur->demandesApprovisionnement()
            ->where('statut', 'en_attente')
            ->with(['marque', 'couleur'])
            ->latest('date')
            ->get();

        // Récupération des stocks en manque (quantité de bouteilles pleines critique ou nulle)
        $stocksEnManque = Stock::where('depot_id', $vendeur->depot_id)
            ->with('couleur.marque')
            ->where('quantite_pleines', '<=', 2) // Seuil d'alerte (modifiable selon vos besoins)
            ->get();

        return view('vendeur.dashboard', compact(
            'vendeur',
            'ventesDuJour',
            'nombreVentesJour',
            'nombreVentesMois',
            'changementsEffectues',
            'demandesEnAttente',
            'stocksEnManque', // <-- Ajouté ici pour l'affichage de l'alerte
        ));
    }
}