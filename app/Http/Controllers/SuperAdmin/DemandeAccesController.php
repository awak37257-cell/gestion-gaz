<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DemandeAcces;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemandeAccesController extends Controller
{
    public function index(Request $request): View
    {
        $statutFiltre = $request->string('statut')->toString();

        $demandes = DemandeAcces::with('client')
            ->when($statutFiltre, fn ($q) => $q->where('statut', $statutFiltre))
            ->latest()
            ->get();

        $totalEnAttente = DemandeAcces::where('statut', 'en_attente')->count();
        $totalValidees = DemandeAcces::where('statut', 'validee')->count();
        $totalRejetees = DemandeAcces::where('statut', 'rejetee')->count();

        return view('super-admin.demandes.index', compact(
            'demandes',
            'statutFiltre',
            'totalEnAttente',
            'totalValidees',
            'totalRejetees'
        ));
    }

    public function valider(DemandeAcces $demande): RedirectResponse
    {
        if ($demande->statut === 'validee' && $demande->client_id) {
            return redirect()->route('super-admin.clients.show', $demande->client_id)
                ->with('info', 'Cette demande a déjà été validée.');
        }

        // Vérifier si l'email existe déjà dans users
        if (User::where('email', $demande->email)->exists()) {
            return back()->with('erreur', "Un compte utilisateur existe déjà avec l'adresse email {$demande->email}.");
        }

        $montant = match ($demande->periode_souhaitee) {
            'trimestriel' => 40000,
            'annuel' => 150000,
            default => 15000,
        };

        $dateDebut = Carbon::now();
        $dateFin = match ($demande->periode_souhaitee) {
            'trimestriel' => $dateDebut->copy()->addMonths(3),
            'annuel' => $dateDebut->copy()->addYear(),
            default => $dateDebut->copy()->addMonth(),
        };

        $motDePasseGenere = Str::random(10);

        $client = DB::transaction(function () use ($demande, $montant, $dateDebut, $dateFin, $motDePasseGenere) {
            $client = Client::create([
                'nom' => $demande->nom_entreprise,
                'email_contact' => $demande->email,
                'telephone' => $demande->telephone,
                'periode_abonnement' => $demande->periode_souhaitee,
                'montant_abonnement' => $montant,
                'date_debut_abonnement' => $dateDebut,
                'date_fin_abonnement' => $dateFin,
                'statut' => 'actif',
            ]);

            User::create([
                'client_id' => $client->id,
                'name' => $demande->nom_contact,
                'email' => $demande->email,
                'password' => $motDePasseGenere,
            ]);

            $demande->update([
                'statut' => 'validee',
                'client_id' => $client->id,
            ]);

            return $client;
        });

        return redirect()->route('super-admin.clients.show', $client)
            ->with('mot_de_passe_genere', $motDePasseGenere)
            ->with('email_client', $demande->email)
            ->with('succes', "Compte client créé avec succès pour {$demande->nom_entreprise} ! Communiquez les identifiants ci-dessous au client.");
    }

    public function rejeter(DemandeAcces $demande): RedirectResponse
    {
        $demande->update(['statut' => 'rejetee']);

        return back()->with('succes', "La demande de {$demande->nom_entreprise} a été marquée comme rejetée.");
    }

    public function destroy(DemandeAcces $demande): RedirectResponse
    {
        $demande->delete();

        return back()->with('succes', 'Demande supprimée.');
    }
}
