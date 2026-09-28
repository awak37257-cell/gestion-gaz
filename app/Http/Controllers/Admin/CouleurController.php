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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CouleurController extends Controller
{
    public function index(): View
    {
        $clientId = Auth::guard('client')->id() ?? auth()->user()->client_id;
        
        // On filtre les marques par client
        $marques = Marque::where('client_id', $clientId)->with('couleurs')->get();

        return view('admin.couleurs.index', compact('marques'));
    }

    public function create(): View
    {
        $clientId = Auth::guard('client')->id() ?? auth()->user()->client_id;
        
        $marques = Marque::where('client_id', $clientId)->get();
        $depots = Depot::where('client_id', $clientId)->get();

        return view('admin.couleurs.create', compact('marques', 'depots'));
    }

    public function store(Request $request): RedirectResponse
    {
        $clientId = Auth::guard('client')->id() ?? auth()->user()->client_id;

        $donnees = $request->validate([
            'marque_id' => ['required', 'exists:marques,id'],
            'nom_couleur' => ['required', 'string', 'max:255'],
            'poids' => ['required', 'string', 'max:50'],
            'prix_unitaire' => ['required', 'integer', 'min:0'],
            'type' => ['required', 'string', 'max:50'],
            'depot_id' => ['required', 'exists:depots,id'],
            'quantite_pleines' => ['required', 'integer', 'min:0'],
            'quantite_vides' => ['required', 'integer', 'min:0'],
        ]);

        // Extraction des données spécifiques au stock initial pour ne garder que la couleur
        $depotId = $donnees['depot_id'];
        $qtePleines = $donnees['quantite_pleines'];
        $qteVides = $donnees['quantite_vides'];
        
        unset($donnees['depot_id'], $donnees['quantite_pleines'], $donnees['quantite_vides']);

        DB::transaction(function () use ($donnees, $clientId, $depotId, $qtePleines, $qteVides) {
            $couleur = Couleur::create([
                'client_id' => $clientId,
                ...$donnees,
            ]);

            // Initialisation des stocks pour tous les dépôts du client
            foreach (Depot::where('client_id', $clientId)->get() as $depot) {
                Stock::create([
                    'client_id' => $clientId,
                    'couleur_id' => $couleur->id,
                    'depot_id' => $depot->id,
                    // Si c'est le dépôt choisi, on applique les quantités saisies, sinon 0
                    'quantite_pleines' => ($depot->id == $depotId) ? $qtePleines : 0,
                    'quantite_vides' => ($depot->id == $depotId) ? $qteVides : 0,
                ]);
            }
        });

        return redirect()->route('admin.couleurs.index')->with('succes', 'Couleur créée avec succès.');
    }

    public function edit(Couleur $couleur): View
    {
        $clientId = Auth::guard('client')->id() ?? auth()->user()->client_id;
        $marques = Marque::where('client_id', $clientId)->get();

        return view('admin.couleurs.edit', compact('couleur', 'marques'));
    }

    public function update(Request $request, Couleur $couleur): RedirectResponse
    {
        $donnees = $request->validate([
            'marque_id' => ['required', 'exists:marques,id'],
            'nom_couleur' => ['required', 'string', 'max:255'],
            'poids' => ['required', 'string', 'max:50'],
            'prix_unitaire' => ['required', 'integer', 'min:0'],
            'type' => ['required', 'string', 'max:50'],
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