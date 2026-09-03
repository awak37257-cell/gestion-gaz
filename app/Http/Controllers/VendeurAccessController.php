<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use Illuminate\Http\RedirectResponse;

class VendeurAccessController extends Controller
{
    // Point d'entrée du QR code personnel du vendeur.
public function scan(string $tokenQr): RedirectResponse
{
    $vendeur = Vendeur::where('token_qr', $tokenQr)->firstOrFail();

    request()->session()->regenerate();

    // On stocke le token du QR code qui ne change jamais
    session([
        'vendeur_id' => $vendeur->id,
        'vendeur_token' => $vendeur->token_qr
    ]);

    request()->session()->save();

    return redirect()->route('vendeur.dashboard', ['tokenQr' => $vendeur->token_qr]);
}

    // Fin de service : on vide la session du vendeur.
    public function deconnexion(): RedirectResponse
    {
        session()->forget('vendeur_id');

        return redirect('/');
    }
}