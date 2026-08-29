<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Couleur;
use App\Models\Depot;
use App\Models\Marque;
use App\Models\Stock;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouleurController extends Controller
{
    public function index(): View
    {
        $marques = Marque::with('couleurs')->get();

        return view('admin.couleurs.index', compact('marques'));
    }

    public function create(): View
    {
        $marques = Marque::all();

        return view('admin.couleurs.create', compact('marques'));
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'marque_id' => ['required', 'exists:marques,id'],
            'nom_couleur' => ['required', 'string', 'max:255'],
            'poids' => ['required', 'string', 'max:50'],
            'prix_unitaire' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($donnees) {
            $couleur = Couleur::create($donnees);

            // Une ligne de stock à 0 est créée pour chaque dépôt existant,
            // pour que la nouvelle couleur apparaisse partout sans étape manuelle.
            foreach (Depot::all() as $depot) {
                Stock::create([
                    'couleur_id' => $couleur->id,
                    'depot_id' => $depot->id,
                    'quantite_pleines' => 0,
                    'quantite_vides' => 0,
                ]);
            }
        });

        return redirect()->route('admin.couleurs.index')->with('succes', 'Couleur créée.');
    }

    public function edit(Couleur $couleur): View
    {
        $marques = Marque::all();

        return view('admin.couleurs.edit', compact('couleur', 'marques'));
    }

    public function update(Request $request, Couleur $couleur): RedirectResponse
    {
        $donnees = $request->validate([
            'marque_id' => ['required', 'exists:marques,id'],
            'nom_couleur' => ['required', 'string', 'max:255'],
            'poids' => ['required', 'string', 'max:50'],
            'prix_unitaire' => ['required', 'integer', 'min:0'],
        ]);

        $couleur->update($donnees);

        return redirect()->route('admin.couleurs.index')->with('succes', 'Couleur mise à jour.');
    }

    public function destroy(Couleur $couleur): RedirectResponse
    {
        $couleur->delete();

        return redirect()->route('admin.couleurs.index')->with('succes', 'Couleur supprimée.');
    }
}