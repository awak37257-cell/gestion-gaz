<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use Illuminate\Contracts\View\View;

class PaiementController extends Controller
{
    public function index(): View
    {
        $paiements = Paiement::with('client')->latest('date_paiement')->get();

        $totalEncaisse = $paiements->sum('montant');

        return view('super-admin.paiements.index', compact('paiements', 'totalEncaisse'));
    }
}