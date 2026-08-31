<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Models\Vente;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientController extends Controller
{
 public function index(Request $request): View
{
    $recherche = $request->string('recherche')->trim()->toString();
    $statutFiltre = $request->string('statut')->toString();

    $clients = Client::withCount(['depots', 'users'])
        ->when($recherche, fn ($q) => $q->where('nom', 'like', "%{$recherche}%"))
        ->when($statutFiltre, fn ($q) => $q->where('statut', $statutFiltre))
        ->latest()
        ->get();

    // Calcul des statistiques pour les cartes du haut
    $clientsActifs = $clients->where('statut', 'actif')->count();
    $mrr = $clients->where('statut', 'actif')->sum('prix_abonnement');
    
    $expirationProche = $clients->filter(function ($client) {
        return isset($client->date_expiration) && 
               \Carbon\Carbon::parse($client->date_expiration)->isBetween(now(), now()->addDays(30));
    })->count();

    // Calcul du total des dépôts sur l'ensemble des clients chargés (ou via la relation/somme des depots_count)
    $totalDepots = $clients->sum('depots_count');

    foreach ($clients as $client) {
        $client->derniere_activite = Vente::where('client_id', $client->id)->max('date_heure');
        $client->ventes_ce_mois = Vente::where('client_id', $client->id)
            ->whereMonth('date_heure', now()->month)
            ->whereYear('date_heure', now()->year)
            ->count();
    }

    return view('super-admin.clients.index', compact(
        'clients', 
        'recherche', 
        'statutFiltre', 
        'clientsActifs', 
        'mrr', 
        'expirationProche', 
        'totalDepots'
    ));
}

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email_contact' => ['nullable', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'periode_abonnement' => ['required', 'in:mensuel,trimestriel,annuel'],
            'montant_abonnement' => ['required', 'integer', 'min:0'],
            'date_debut_abonnement' => ['required', 'date'],
            'admin_nom' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'unique:users,email'],
        ]);

        $dateDebut = Carbon::parse($donnees['date_debut_abonnement']);
        $dateFin = match ($donnees['periode_abonnement']) {
            'mensuel' => $dateDebut->copy()->addMonth(),
            'trimestriel' => $dateDebut->copy()->addMonths(3),
            'annuel' => $dateDebut->copy()->addYear(),
        };

        // Mot de passe généré automatiquement : affiché une seule fois à la
        // création, jamais stocké en clair ni renvoyé ensuite.
        $motDePasseGenere = Str::random(10);

        $client = DB::transaction(function () use ($donnees, $dateDebut, $dateFin, $motDePasseGenere) {
            $client = Client::create([
                'nom' => $donnees['nom'],
                'email_contact' => $donnees['email_contact'] ?? null,
                'telephone' => $donnees['telephone'] ?? null,
                'periode_abonnement' => $donnees['periode_abonnement'],
                'montant_abonnement' => $donnees['montant_abonnement'],
                'date_debut_abonnement' => $dateDebut,
                'date_fin_abonnement' => $dateFin,
                'statut' => 'actif',
            ]);

            User::create([
                'client_id' => $client->id,
                'name' => $donnees['admin_nom'],
                'email' => $donnees['admin_email'],
                'password' => $motDePasseGenere,
            ]);

            return $client;
        });

        return redirect()->route('super-admin.clients.show', $client)
            ->with('mot_de_passe_genere', $motDePasseGenere)
            ->with('succes', 'Client créé.');
    }

    public function show(Client $client): View
    {
        $client->load('users', 'depots', 'paiements');

        return view('super-admin.clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        return view('super-admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email_contact' => ['nullable', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'periode_abonnement' => ['required', 'in:mensuel,trimestriel,annuel'],
            'montant_abonnement' => ['required', 'integer', 'min:0'],
            'date_debut_abonnement' => ['required', 'date'],
            'date_fin_abonnement' => ['required', 'date'],
            'statut' => ['required', 'in:actif,suspendu,expire'],
        ]);

        $client->update($donnees);

        return redirect()->route('super-admin.clients.index')->with('succes', 'Client mis à jour.');
    }

    // Prolonge l'abonnement d'une période (mensuelle/trimestrielle/annuelle)
    // à partir de la date de fin actuelle, et repasse le client en actif.
    public function renouveler(Client $client): RedirectResponse
    {
        $nouvelleDateFin = match ($client->periode_abonnement) {
            'mensuel' => $client->date_fin_abonnement->copy()->addMonth(),
            'trimestriel' => $client->date_fin_abonnement->copy()->addMonths(3),
            'annuel' => $client->date_fin_abonnement->copy()->addYear(),
        };

        $client->update([
            'date_fin_abonnement' => $nouvelleDateFin,
            'statut' => 'actif',
        ]);

        return back()->with('succes', "Abonnement renouvelé jusqu'au {$nouvelleDateFin->format('d/m/Y')}.");
    }

    // Bascule rapide entre actif et suspendu, sans passer par le formulaire.
    public function basculerStatut(Client $client): RedirectResponse
    {
        $client->update([
            'statut' => $client->statut === 'actif' ? 'suspendu' : 'actif',
        ]);

        return back()->with('succes', 'Statut mis à jour.');
    }

    // Génère un nouveau mot de passe pour le premier admin du client,
    // affiché une seule fois — utile si le client l'a perdu.
    public function reinitialiserMotDePasse(Client $client): RedirectResponse
    {
        $utilisateur = $client->users()->first();

        if (! $utilisateur) {
            return back()->with('erreur', "Ce client n'a aucun compte administrateur.");
        }

        $nouveauMotDePasse = Str::random(10);

        $utilisateur->update(['password' => $nouveauMotDePasse]);

        return back()
            ->with('mot_de_passe_genere', $nouveauMotDePasse)
            ->with('succes', 'Mot de passe réinitialisé.');
    }

    public function enregistrerPaiement(Request $request, Client $client): RedirectResponse
    {
        $donnees = $request->validate([
            'montant' => ['required', 'integer', 'min:0'],
            'methode' => ['required', 'in:espece,wave,orange_money,mtn_momo,virement'],
            'date_paiement' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $client->paiements()->create($donnees);

        return back()->with('succes', 'Paiement enregistré.');
    }

    // Export CSV (compatible Excel) de la liste des clients.
    public function exporter(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $clients = Client::withCount('depots')->get();

        $nomFichier = 'clients_' . now()->format('Y_m_d') . '.csv';

        $callback = function () use ($clients) {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8 pour qu'Excel affiche correctement les accents.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['Nom', 'Email', 'Téléphone', 'Périodicité', 'Montant', 'Début', 'Fin', 'Statut', 'Dépôts']);

            foreach ($clients as $client) {
                fputcsv($handle, [
                    $client->nom,
                    $client->email_contact,
                    $client->telephone,
                    $client->periode_abonnement,
                    $client->montant_abonnement,
                    $client->date_debut_abonnement->format('d/m/Y'),
                    $client->date_fin_abonnement->format('d/m/Y'),
                    $client->statut,
                    $client->depots_count,
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $nomFichier, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}