<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Essayer de connecter en tant qu'administrateur (table users)
        if (Auth::attempt($donnees, $request->boolean('se_souvenir'))) {
            $request->session()->regenerate();

            if (auth()->user()->estSuperAdmin()) {
                return redirect()->intended(route('super-admin.dashboard'));
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        // 2. Si ce n'est pas un admin, chercher dans la table clients
        $client = \App\Models\Client::where('email', $donnees['email'])->first();

        if ($client && \Illuminate\Support\Facades\Hash::check($donnees['password'], $client->password)) {
            // Utiliser explicitement le guard 'client'
            Auth::guard('client')->login($client, $request->boolean('se_souvenir'));
            $request->session()->regenerate();

            // Rediriger vers l'espace personnalisé du client en passant son slug
            return redirect()->intended(route('admin.dashboard', $client->slug)); 
        }

        // 3. Si aucun des deux ne correspond
        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }
    public function destroy(Request $request): RedirectResponse
    {
        // Déconnecter du guard par défaut et/ou du guard client
        Auth::logout();
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}