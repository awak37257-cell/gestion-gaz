<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depot;
use App\Models\Stock;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request): View
    {
        $depots = Depot::all();

        $depotSelectionne = $request->integer('depot_id') ?: $depots->first()?->id;

        $stocks = Stock::with('couleur.marque')
            ->where('depot_id', $depotSelectionne)
            ->get();

        return view('admin.stocks.index', compact('depots', 'stocks', 'depotSelectionne'));
    }

    // Ajustement manuel (réception physique, correction d'inventaire).
    public function update(Request $request, Stock $stock): RedirectResponse
    {
        $donnees = $request->validate([
            'quantite_pleines' => ['required', 'integer', 'min:0'],
            'quantite_vides' => ['required', 'integer', 'min:0'],
        ]);

        $stock->update($donnees);

        return back()->with('succes', 'Stock ajusté.');
    }
}