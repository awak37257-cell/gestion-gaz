<?php

namespace App\Http\Controllers;

use App\Models\Couleur;
use App\Models\Stock;
use App\Models\Vendeur;
use App\Models\Vente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VenteController extends Controller
{
    public function index(): View
{
    $vendeurId = session('vendeur_id');

    $ventes = Vente::where('vendeur_id', $vendeurId)
        ->with(['couleurVendue.marque', 'couleurDemandee'])
        ->latest('date_heure')
        ->paginate(15); // Pagination pour afficher proprement l'historique

    return view('vendeur.ventes.index', compact('ventes'));
}
    public function create(): View
    {
        $vendeur = Vendeur::findOrFail(session('vendeur_id'));

        // Uniquement les couleurs qui ont une ligne de stock dans le dépôt du vendeur
        $couleurs = Couleur::with('marque')
            ->whereHas('stocks', fn ($q) => $q->where('depot_id', $vendeur->depot_id))
            ->get();

        return view('vendeur.ventes.create', compact('couleurs'));
    }

public function store(Request $request): RedirectResponse
    {
        $vendeur = Vendeur::findOrFail(session('vendeur_id'));

        $donnees = $request->validate([
            'couleur_vendue_id' => ['required', 'exists:couleurs,id'],
            'quantite' => ['required', 'integer', 'min:1'],
            'changement_effectue' => ['required', 'boolean'],
            'couleur_demandee_id' => ['required_if:changement_effectue,1', 'nullable', 'exists:couleurs,id'],
        ]);

        $vente = DB::transaction(function () use ($vendeur, $donnees) {
            // 1. Gestion du stock de la couleur vendue (sortie des pleines)
            $stockVendu = Stock::where('depot_id', $vendeur->depot_id)
                ->where('couleur_id', $donnees['couleur_vendue_id'])
                ->lockForUpdate()
                ->first();

            if (! $stockVendu || $stockVendu->quantite_pleines < $donnees['quantite']) {
                throw ValidationException::withMessages([
                    'couleur_vendue_id' => 'Stock insuffisant pour cette couleur dans ce dépôt.',
                ]);
            }

            $stockVendu->decrement('quantite_pleines', $donnees['quantite']);

            // 2. Gestion des bouteilles vides récupérées
            if ($donnees['changement_effectue'] && !empty($donnees['couleur_demandee_id'])) {
                // Si changement : les vides vont dans le stock de la couleur demandée par le client
                $stockDemande = Stock::firstOrCreate(
                    [
                        'depot_id' => $vendeur->depot_id,
                        'couleur_id' => $donnees['couleur_demandee_id'],
                    ],
                    [
                        'client_id' => $vendeur->client_id,
                        'quantite_pleines' => 0,
                        'quantite_vides' => 0,
                    ]
                );

                // On verrouille la ligne pour la mise à jour sécurisée
                $stockDemande = Stock::where('depot_id', $vendeur->depot_id)
                    ->where('couleur_id', $donnees['couleur_demandee_id'])
                    ->lockForUpdate()
                    ->first();

                $stockDemande->increment('quantite_vides', $donnees['quantite']);
            } else {
                // Pas de changement : les vides vont dans la même couleur
                $stockVendu->increment('quantite_vides', $donnees['quantite']);
            }

            // 3. Enregistrement de la vente
            $couleurVendue = Couleur::findOrFail($donnees['couleur_vendue_id']);

            return Vente::create([
                'client_id' => $vendeur->client_id,
                'vendeur_id' => $vendeur->id,
                'couleur_vendue_id' => $donnees['couleur_vendue_id'],
                'couleur_demandee_id' => $donnees['changement_effectue'] ? $donnees['couleur_demandee_id'] : null,
                'quantite' => $donnees['quantite'],
                'prix_unitaire' => $couleurVendue->prix_unitaire,
                'date_heure' => now(),
            ]);
        });

        return redirect()->route('vendeur.ventes.recu', $vente)->with('succes', 'Vente enregistrée.');
    }
    // Reçu imprimable à remettre au client.
    public function recu(Vente $vente): View
    {
        $vendeur = Vendeur::findOrFail(session('vendeur_id'));

        abort_unless($vente->vendeur_id === $vendeur->id, 403);

        $vente->load('couleurVendue.marque', 'vendeur.depot');

        return view('vendeur.ventes.recu', compact('vente'));
    }
}