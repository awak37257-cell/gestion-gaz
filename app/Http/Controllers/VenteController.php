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
            $stock = Stock::where('depot_id', $vendeur->depot_id)
                ->where('couleur_id', $donnees['couleur_vendue_id'])
                ->lockForUpdate()
                ->first();

            if (! $stock || $stock->quantite_pleines < $donnees['quantite']) {
                throw ValidationException::withMessages([
                    'couleur_vendue_id' => 'Stock insuffisant pour cette couleur dans ce dépôt.',
                ]);
            }

            $stock->decrement('quantite_pleines', $donnees['quantite']);
            $stock->increment('quantite_vides', $donnees['quantite']);

            // Le prix est figé au moment de la vente : si l'admin change le prix
            // de la couleur plus tard, ce reçu doit rester correct.
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