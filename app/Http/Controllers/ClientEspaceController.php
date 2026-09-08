<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Contracts\View\View;

class ClientEspaceController extends Controller
{
    public function show(Client $client): View
    {
        // Tu peux charger ici les données propres à ce client (ses ventes, ses dépôts, etc.)
        // Exemple : $depots = $client->depots;

        return view('client.espace', compact('client'));
    }
}