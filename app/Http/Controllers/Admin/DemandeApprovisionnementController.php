<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeApprovisionnement;
use App\Models\Stock;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class DemandeApprovisionnementController extends Controller
{
    public function index(): View
    {
        $demandes = DemandeApprovisionnement::with(['vendeur.depot', 'marque', 'couleur'])
            ->latest('date')
            ->get();

        return view('admin.demandes.index', compact('demandes'));
    }

    public function valider(DemandeApprovisionnement $demande): RedirectResponse
    {
        $demande->update(['statut' => 'validee']);

        return back()->with('succes', 'Demande validée.');
    }

    // Marque la demande comme livrée ET incrémente automatiquement le stock concerné.
    public function livrer(DemandeApprovisionnement $demande): RedirectResponse
    {
        DB::transaction(function () use ($demande) {
            $stock = Stock::where('depot_id', $demande->vendeur->depot_id)
                ->where('couleur_id', $demande->couleur_id)
                ->lockForUpdate()
                ->first();

            if ($stock) {
                $stock->increment('quantite_pleines', $demande->quantite_demandee);
            }

            $demande->update(['statut' => 'livree']);
        });

        return back()->with('succes', 'Demande marquée comme livrée, stock mis à jour.');
    }
}
