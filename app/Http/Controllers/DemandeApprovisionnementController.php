<?php

namespace App\Http\Controllers;

use App\Models\DemandeApprovisionnement;
use App\Models\Marque;
use App\Models\Vendeur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DemandeApprovisionnementController extends Controller
{
    public function create(): View
{
    $marques = Marque::with('couleurs')->get();

    // On prépare les données proprement pour le JavaScript
    $donneesParMarque = $marques->mapWithKeys(function ($marque) {
        return [
            $marque->id => $marque->couleurs->map(function ($couleur) {
                return [
                    'id' => $couleur->id,
                    'nom_couleur' => $couleur->nom_couleur,
                    'type' => $couleur->type,
                ];
            })
        ];
    });

    return view('vendeur.demandes.create', compact('marques', 'donneesParMarque'));
}

    public function store(Request $request): RedirectResponse
    {
        $vendeur = Vendeur::findOrFail(session('vendeur_id'));

        $donnees = $request->validate([
            'marque_id' => ['required', 'exists:marques,id'],
            'couleur_id' => ['required', 'exists:couleurs,id'], // Récupère l'ID correspondant au type choisi
            'quantite_demandee' => ['required', 'integer', 'min:1'],
        ]);

        DemandeApprovisionnement::create([
            'client_id' => $vendeur->client_id,
            'vendeur_id' => $vendeur->id,
            'marque_id' => $donnees['marque_id'],
            'couleur_id' => $donnees['couleur_id'],
            'quantite_demandee' => $donnees['quantite_demandee'],
            'statut' => 'en_attente',
            'date' => now()->toDateString(),
        ]);

        return redirect()->route('vendeur.dashboard')->with('succes', "Demande d'approvisionnement envoyée.");
    }
}