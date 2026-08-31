<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    // Le super-admin se connecte comme le premier admin du client, pour
    // l'aider à résoudre un problème sans lui redemander ses identifiants.
    public function demarrer(Client $client): RedirectResponse
    {
        $utilisateurClient = $client->users()->first();

        if (! $utilisateurClient) {
            return back()->with('erreur', "Ce client n'a aucun compte administrateur à utiliser.");
        }

        session(['impersonateur_id' => auth()->id()]);

        Auth::login($utilisateurClient);

        return redirect()->route('admin.dashboard')->with('succes', "Connecté en tant que {$client->nom}.");
    }

    // Restaure la session du super-admin d'origine.
    public function quitter(): RedirectResponse
    {
        $superAdminId = session('impersonateur_id');

        if (! $superAdminId) {
            return redirect()->route('admin.dashboard');
        }

        session()->forget('impersonateur_id');

        Auth::login(User::findOrFail($superAdminId));

        return redirect()->route('super-admin.clients.index');
    }
}