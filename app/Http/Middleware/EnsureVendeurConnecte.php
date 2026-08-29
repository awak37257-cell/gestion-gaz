<?php

namespace App\Http\Middleware;

use App\Models\Vendeur;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendeurConnecte
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('vendeur_id')) {
            return redirect('/')->with('erreur', 'Veuillez scanner votre QR code pour accéder à votre espace.');
        }

        $vendeur = Vendeur::find(session('vendeur_id'));

        if (! $vendeur || ! $vendeur->actif) {
            session()->forget('vendeur_id');

            return redirect('/')->with('erreur', 'Ce compte vendeur est désactivé. Contactez votre administrateur.');
        }

        return $next($request);
    }
}