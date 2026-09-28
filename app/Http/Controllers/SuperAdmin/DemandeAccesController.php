<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemandeAcces;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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
     * Méthode de secours pour intercepter l'appel 'create' de la route 
     * et rediriger vers le formulaire de personnalisation du lien.
     */
public function create(DemandeAcces $demande)
{
    // Si aucun client n'est encore lié à cette demande, on le crée automatiquement
    if (!$demande->client_id) {
        // Récupère la période souhaitée depuis la demande (attention au nom exact de la colonne en base)
        $periode = $demande->periode_souhaitee ?? $demande->periode_souhaitée ?? 'mensuel';
        
        // Attribue un montant selon la période choisie
        $montant = match($periode) {
            'mensuel' => 15000,
            'trimestriel' => 45000,
            'annuel' => 150000,
            default => 10000,
        };

        // Calcule la date de fin selon la période
        $dateDebut = now();
        $dateFin = match($periode) {
            'mensuel' => $dateDebut->copy()->addMonth(),
            'trimestriel' => $dateDebut->copy()->addMonths(3),
            'annuel' => $dateDebut->copy()->addYear(),
            default => $dateDebut->copy()->addMonth(),
        };

        $client = \App\Models\Client::create([
            'nom' => $demande->nom_entreprise ?? 'Client ' . $demande->id,
            'email' => $demande->email ?? '',
            'telephone' => $demande->telephone ?? null,
            'slug' => \Illuminate\Support\Str::slug($demande->nom_entreprise ?? 'client-' . $demande->id),
            'periode_abonnement' => $periode, // On stocke la période dans le client
            'montant_abonnement' => $montant, // On stocke le montant calculé
            'date_debut_abonnement' => $dateDebut,
            'date_fin_abonnement' => $dateFin,
            'statut' => 'actif',
        ]);

        // Associe le client à la demande et valide cette dernière
        $demande->update([
            'client_id' => $client->id,
            'statut' => 'validee'
        ]);
        $demande->refresh();
    } else {
        // Si le client existe déjà, on met à jour ses infos (email, période, montant ET téléphone) au cas où
        $demande->client->update([
            'email' => $demande->email ?? $demande->client->email,
            'periode_abonnement' => $demande->periode_souhaitee,
            'montant_abonnement' => $demande->client->montant_abonnement ?? 0,
            'telephone' => $demande->telephone ?? $demande->client->telephone,
        ]);
    }

    $client = $demande->client;

    return view('super-admin.demandes.formulaire-lien', compact('demande', 'client'));
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

    // Générer un mot de passe temporaire sécurisé en clair pour l'e-mail
    $password = Str::password(12);

    // Met à jour le slug ET le mot de passe (haché) du client
    $client->update([
        'slug' => $request->slug,
        'password' => Hash::make($password),
    ]);

    // Mettez à jour le statut de la demande ici pour qu'elle ne soit plus "en attente"
    $demande->update([
        'statut' => 'validee'
    ]);

    // Envoie l'e-mail avec le lien contenant le nouveau slug personnalisé ET le vrai mot de passe
$emailDestinataire = $client->email ?? $demande->email;

Mail::to($emailDestinataire)->send(new AccesClientMail($client, $emailDestinataire, $password));
    return redirect()->route('super-admin.demandes.index')->with('success', 'Lien configuré et e-mail d\'accès envoyé avec succès au client !');
}
}