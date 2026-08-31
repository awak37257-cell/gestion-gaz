<?php

namespace App\Http\Controllers;

use App\Models\Inventaire;
use App\Models\InventaireLigne;
use App\Models\Stock;
use App\Models\Vendeur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventaireController extends Controller
{
    public function create(): View
    {
        $vendeur = Vendeur::findOrFail(session('vendeur_id'));

        $stocks = Stock::with('couleur.marque')
            ->where('depot_id', $vendeur->depot_id)
            ->get();

        return view('vendeur.inventaires.create', compact('stocks'));
    }

    public function store(Request $request): RedirectResponse
    {
        $vendeur = Vendeur::findOrFail(session('vendeur_id'));

        $donnees = $request->validate([
            'comptes' => ['required', 'array'],
            'comptes.*.couleur_id' => ['required', 'exists:couleurs,id'],
            'comptes.*.quantite_pleines_comptee' => ['required', 'integer', 'min:0'],
            'comptes.*.quantite_vides_comptee' => ['required', 'integer', 'min:0'],
        ]);

        $inventaire = DB::transaction(function () use ($vendeur, $donnees) {
            $inventaire = Inventaire::create([
                'client_id' => $vendeur->client_id,
                'vendeur_id' => $vendeur->id,
                'depot_id' => $vendeur->depot_id,
                'date_heure' => now(),
            ]);

            foreach ($donnees['comptes'] as $compte) {
                $stock = Stock::where('depot_id', $vendeur->depot_id)
                    ->where('couleur_id', $compte['couleur_id'])
                    ->lockForUpdate()
                    ->first();

                InventaireLigne::create([
                    'client_id' => $vendeur->client_id,
                    'inventaire_id' => $inventaire->id,
                    'couleur_id' => $compte['couleur_id'],
                    'quantite_pleines_comptee' => $compte['quantite_pleines_comptee'],
                    'quantite_vides_comptee' => $compte['quantite_vides_comptee'],
                    'quantite_pleines_theorique' => $stock?->quantite_pleines ?? 0,
                    'quantite_vides_theorique' => $stock?->quantite_vides ?? 0,
                ]);

                // Le comptage physique devient la nouvelle référence du stock :
                // il corrige les écarts (casse, erreur non enregistrée, etc.).
                if ($stock) {
                    $stock->update([
                        'quantite_pleines' => $compte['quantite_pleines_comptee'],
                        'quantite_vides' => $compte['quantite_vides_comptee'],
                    ]);
                }
            }

            return $inventaire;
        });

        return redirect()->route('vendeur.inventaires.show', $inventaire)->with('succes', 'Inventaire enregistré.');
    }

    public function show(Inventaire $inventaire): View
    {
        $vendeur = Vendeur::findOrFail(session('vendeur_id'));

        abort_unless($inventaire->vendeur_id === $vendeur->id, 403);

        $inventaire->load('lignes.couleur.marque');

        return view('vendeur.inventaires.show', compact('inventaire'));
    }
}