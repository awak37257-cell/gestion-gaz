<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemandeAcces;
use App\Mail\AccesClientMail;
use Illuminate\Support\Facades\Mail;

class DemandeAccesController extends Controller
{
    /**
     * Affiche la liste des demandes d'accès avec les statistiques et les filtres.
     */
    public function index(Request $request)
    {
        $statutFiltre = $request->get('statut');

        // Statistiques globales
        $totalEnAttente = DemandeAcces::where('statut', 'en_attente')->count();
        $totalValidees = DemandeAcces::where('statut', 'validee')->count();
        $totalRejetees = DemandeAcces::where('statut', 'rejetee')->count();

        // Requête avec filtre optionnel
        $query = DemandeAcces::with('client')->latest();

        if ($statutFiltre) {
            $query->where('statut', $statutFiltre);
        }

        $demandes = $query->get();

        return view('super-admin.demandes.index', compact(
            'demandes',
            'totalEnAttente',
            'totalValidees',
            'totalRejetees',
            'statutFiltre'
        ));
    }

    /**
     * Affiche la vue du formulaire pour personnaliser le lien de la demande validée.
     */
    public function formulaireLien(DemandeAcces $demande)
    {
        if (!$demande->client) {
            return redirect()->back()->with('error', 'Veuillez d\'abord valider cette demande pour créer le compte client.');
        }

        $client = $demande->client;

        return view('super-admin.demandes.formulaire-lien', compact('demande', 'client'));
    }

    /**
     * Enregistre le slug personnalisé et envoie l'e-mail d'accès au client.
     */
    public function envoyerAcces(Request $request, DemandeAcces $demande)
    {
        $client = $demande->client;

        // Valide le champ personnalisé saisi par le super-admin
        $request->validate([
            'slug' => 'required|string|unique:clients,slug,' . $client->id,
        ]);

        // Met à jour le slug du client avec ce que le super-admin a choisi
        $client->update([
            'slug' => $request->slug,
        ]);

        // Envoie l'e-mail avec le lien contenant le nouveau slug personnalisé
        Mail::to($client->email_contact)->send(new AccesClientMail($client, $client->email_contact, 'Mot de passe sécurisé'));

        return redirect()->route('super-admin.demandes.index')->with('success', 'Lien configuré et e-mail d\'accès envoyé avec succès au client !');
    }
}