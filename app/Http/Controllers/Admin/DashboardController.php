<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeApprovisionnement;
use App\Models\Stock;
use App\Models\Vente;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    private const SEUIL_STOCK_BAS = 5;

  public function index(): View
    {
        // Récupération des ventes par dépôt en passant par la table 'vendeurs'
        $ventesParDepot = DB::table('ventes')
            ->join('vendeurs', 'ventes.vendeur_id', '=', 'vendeurs.id')
            ->join('depots', 'vendeurs.depot_id', '=', 'depots.id')
            ->select('depots.id as depot_id', 'depots.nom as depot_nom', DB::raw('SUM(ventes.quantite) as total'))
            ->groupBy('depots.id', 'depots.nom')
            ->orderByDesc('total')
            ->get();

        // Total général de toutes les bouteilles vendues depuis le début
        $totalVentesGlobal = $ventesParDepot->sum('total');

        $stocksBas = Stock::with(['couleur.marque', 'depot'])
            ->where('quantite_pleines', '<', self::SEUIL_STOCK_BAS)
            ->get();
            
        $tousLesStocks = Stock::with(['couleur.marque', 'depot'])->get();
        $demandesEnAttente = DemandeApprovisionnement::where('statut', 'en_attente')->count();

        return view('admin.dashboard', compact('totalVentesGlobal', 'demandesEnAttente', 'stocksBas', 'tousLesStocks', 'ventesParDepot'));
    }
   public function ventesParDepotJour(int $depotId): View
    {
        $depot = \App\Models\Depot::findOrFail($depotId);

        $ventes = Vente::with(['vendeur', 'couleurVendue.marque'])
            ->whereHas('vendeur', function ($query) use ($depotId) {
                $query->where('depot_id', $depotId);
            })
            ->latest('date_heure')
            ->get();

        return view('admin.ventes.depot-jour', compact('depot', 'ventes'));
    }
}