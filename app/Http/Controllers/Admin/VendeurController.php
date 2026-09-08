<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depot;
use App\Models\Vendeur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendeurController extends Controller
{
    public function index(): View
    {
        $vendeurs = Vendeur::with('depot')->get();

        return view('admin.vendeurs.index', compact('vendeurs'));
    }

    public function create(): View
    {
        $depots = Depot::all();

        return view('admin.vendeurs.create', compact('depots'));
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'depot_id' => ['required', 'exists:depots,id'],
            'nom' => ['required', 'string', 'max:255'],
        ]);

        $vendeur = Vendeur::create([
            'client_id' => auth()->user()->client_id,
            ...$donnees,
            'token_qr' => Str::random(32),
            'actif' => true,
        ]);

        return redirect()->route('admin.vendeurs.show', $vendeur)->with('succes', 'Vendeur créé.');
    }

    // Affiche la fiche du vendeur avec son QR code à imprimer/donner.
    public function show(Vendeur $vendeur): View
    {
      $urlScan = 'https://thousands-corps-bag-eminem.trycloudflare.com' . route('vendeur.scan', ['tokenQr' => $vendeur->token_qr], false);

        return view('admin.vendeurs.show', compact('vendeur', 'urlScan'));
    }

    public function edit(Vendeur $vendeur): View
    {
        $depots = Depot::all();

        return view('admin.vendeurs.edit', compact('vendeur', 'depots'));
    }

    public function update(Request $request, Vendeur $vendeur): RedirectResponse
    {
        $donnees = $request->validate([
            'depot_id' => ['required', 'exists:depots,id'],
            'nom' => ['required', 'string', 'max:255'],
            'actif' => ['required', 'boolean'],
        ]);

        $vendeur->update($donnees);

        return redirect()->route('admin.vendeurs.index')->with('succes', 'Vendeur mis à jour.');
    }

    public function destroy(Vendeur $vendeur): RedirectResponse
    {
        $vendeur->delete();

        return redirect()->route('admin.vendeurs.index')->with('succes', 'Vendeur supprimé.');
    }
}