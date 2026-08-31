<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Couleur;
use App\Models\Depot;
use App\Models\Stock;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepotController extends Controller
{
    public function index(): View
    {
        $depots = Depot::withCount('vendeurs')->get();

        return view('admin.depots.index', compact('depots'));
    }

    public function create(): View
    {
        return view('admin.depots.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'localisation' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($donnees) {
            $depot = Depot::create([
                'client_id' => auth()->user()->client_id,
                ...$donnees,
            ]);

            // Une ligne de stock à 0 est créée pour chaque couleur existante,
            // pour que le nouveau dépôt démarre avec un inventaire complet.
            foreach (Couleur::all() as $couleur) {
                Stock::create([
                    'client_id' => auth()->user()->client_id,
                    'couleur_id' => $couleur->id,
                    'depot_id' => $depot->id,
                    'quantite_pleines' => 0,
                    'quantite_vides' => 0,
                ]);
            }
        });

        return redirect()->route('admin.depots.index')->with('succes', 'Dépôt créé.');
    }

    public function edit(Depot $depot): View
    {
        return view('admin.depots.edit', compact('depot'));
    }

    public function update(Request $request, Depot $depot): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'localisation' => ['nullable', 'string', 'max:255'],
        ]);

        $depot->update($donnees);

        return redirect()->route('admin.depots.index')->with('succes', 'Dépôt mis à jour.');
    }

    public function destroy(Depot $depot): RedirectResponse
    {
        $depot->delete();

        return redirect()->route('admin.depots.index')->with('succes', 'Dépôt supprimé.');
    }
}