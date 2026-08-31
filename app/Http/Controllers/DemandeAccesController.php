<?php

namespace App\Http\Controllers;

use App\Models\DemandeAcces;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DemandeAccesController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'nom_contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'periode_souhaitee' => ['required', 'in:mensuel,trimestriel,annuel'],
            'message' => ['nullable', 'string', 'max:1000'],
        ], [
            'nom_entreprise.required' => 'Le nom de votre entreprise ou dépôt est requis.',
            'nom_contact.required' => 'Votre nom complet est requis.',
            'email.required' => 'Une adresse email valide est requise.',
            'email.email' => 'Veuillez renseigner une adresse email correcte.',
            'telephone.required' => 'Un numéro de téléphone / WhatsApp est requis.',
            'periode_souhaitee.required' => 'Veuillez sélectionner une formule d\'abonnement.',
        ]);

        DemandeAcces::create([
            'nom_entreprise' => $validated['nom_entreprise'],
            'nom_contact' => $validated['nom_contact'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'periode_souhaitee' => $validated['periode_souhaitee'],
            'message' => $validated['message'] ?? null,
            'statut' => 'en_attente',
        ]);

        return redirect()->to(url('/#demande-acces'))
            ->with('succes_demande', '🎉 Votre demande d\'accès a été envoyée avec succès au Super Administrateur ! Vos accès vous seront transmis très rapidement après validation.');
    }
}
