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
        // On récupère les ventes groupées par dépôt sans bloquer sur la date d'aujourd'hui
        $ventesParDepot = Vente::join('vendeurs', 'vendeurs.id', '=', 'ventes.vendeur_id')
            ->join('depots', 'depots.id', '=', 'vendeurs.depot_id')
            ->selectRaw('depots.id as depot_id, depots.nom as depot_nom, sum(ventes.quantite) as total')
            ->groupBy('depots.id', 'depots.nom')
            ->get();

        // Total général de toutes les bouteilles vendues depuis le début
        $totalVentesGlobal = $ventesParDepot->sum('total');

        $stocksBas = Stock::with(['couleur.marque', 'depot'])
            ->where('quantite_pleines', '<', self::SEUIL_STOCK_BAS)
            ->get();

        $tousLesStocks = Stock::with(['couleur.marque', 'depot'])->get();

        $demandesEnAttente = DemandeApprovisionnement::where('statut', 'en_attente')->count();

        return view('admin.dashboard', compact(
            'ventesParDepot',
            'totalVentesGlobal', // Remplacé totalVentesDuJour par le total global
            'stocksBas',
            'tousLesStocks',
            'demandesEnAttente',
        ));
    }
    public function ventesParDepotJour(int $depotId): View
    {
        $depot = \App\Models\Depot::findOrFail($depotId);

        // On récupère toutes les ventes du dépôt sans filtre de date
        $ventes = Vente::with(['vendeur', 'couleur.marque'])
            ->whereHas('vendeur', function ($query) use ($depotId) {
                $query->where('depot_id', $depotId);
            })
            ->latest('date_heure') // Optionnel : affiche les plus récentes en premier
            ->get();

        return view('admin.ventes.depot-jour', compact('depot', 'ventes'));
    }
}