<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaire;
use Illuminate\Contracts\View\View;

class InventaireController extends Controller
{
    public function index(): View
    {
        $inventaires = Inventaire::with(['vendeur.depot', 'lignes.couleur.marque'])
            ->latest('date_heure')
            ->get();

        return view('admin.inventaires.index', compact('inventaires'));
    }
}