<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeApprovisionnement;
use App\Models\Stock;
use App\Models\Vente;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    private const SEUIL_STOCK_BAS = 5;

    public function index(): View
    {
        $ventesParDepot = Vente::whereDate('date_heure', today())
            ->join('vendeurs', 'vendeurs.id', '=', 'ventes.vendeur_id')
            ->join('depots', 'depots.id', '=', 'vendeurs.depot_id')
            ->selectRaw('depots.nom as depot_nom, count(*) as total')
            ->groupBy('depots.nom')
            ->get();

        $totalVentesDuJour = $ventesParDepot->sum('total');

        $stocksBas = Stock::with(['couleur.marque', 'depot'])
            ->where('quantite_pleines', '<', self::SEUIL_STOCK_BAS)
            ->get();

        $demandesEnAttente = DemandeApprovisionnement::where('statut', 'en_attente')->count();

        return view('admin.dashboard', compact(
            'ventesParDepot',
            'totalVentesDuJour',
            'stocksBas',
            'demandesEnAttente',
        ));
    }
}