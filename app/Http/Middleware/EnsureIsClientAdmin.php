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
        $user = $request->user();

        if (! $user || $user->estSuperAdmin()) {
            abort(403, 'Cette section est réservée aux comptes clients.');
        }

        if (! $user->client || ! $user->client->estActif()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('erreur', "Votre abonnement est expiré ou suspendu. Contactez l'éditeur du logiciel.");
        }

        return $next($request);
    }
}