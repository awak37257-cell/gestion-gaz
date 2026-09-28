<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsClientAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Récupérer le client connecté via le guard 'client'
        $client = Auth::guard('client')->user();

        // 2. Si aucun client n'est connecté, on bloque ou on redirige vers le login
        if (! $client) {
            return redirect()->route('login')->withErrors([
                'email' => 'Veuillez vous connecter pour accéder à cette section.',
            ]);
        }

        // 3. Vérifier si le client est actif (méthode définie dans votre modèle Client)
        if (! $client->estActif()) {
            Auth::guard('client')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('erreur', "Votre abonnement est expiré ou suspendu. Contactez l'éditeur du logiciel.");
        }

        return $next($request);
    }
}