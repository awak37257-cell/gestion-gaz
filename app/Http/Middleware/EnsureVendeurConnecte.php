<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Vendeur;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendeurConnecte
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si le token du vendeur est présent dans la session
        if (session()->has('vendeur_token')) {
            $vendeur = Vendeur::where('token_qr', session('vendeur_token'))->first();
            
            if ($vendeur && $vendeur->actif) {
                // On s'assure que l'ID est toujours synchro
                session(['vendeur_id' => $vendeur->id]);
                return $next($request);
            }
        }

        // Si la session a sauté, au lieu de perdre l'utilisateur, 
        // on peut le rediriger proprement vers une page d'erreur ou l'inviter à rescanner
        return redirect('/')->with('erreur', 'Session expirée, veuillez scanner à nouveau le QR code.');
    }
}