@extends('layouts.super-admin')

@section('titre', $client->nom)

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
            </div>
            <h1>{{ $client->nom }}</h1>
        </div>
        <div style="display:flex;gap:8px;">
            <form method="POST" action="{{ route('super-admin.clients.renouveler', $client) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="bouton bouton-secondaire">Renouveler</button>
            </form>
            <form method="POST" action="{{ route('super-admin.clients.basculer-statut', $client) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="bouton bouton-secondaire">{{ $client->statut === 'actif' ? 'Suspendre' : 'Activer' }}</button>
            </form>
            <a href="{{ route('super-admin.clients.edit', $client) }}" class="bouton bouton-primaire">Modifier</a>
        </div>
    </div>

    @if (session('mot_de_passe_genere'))
        <div class="carte carte-accent">
            <h3 style="margin-top:0;">Identifiants générés</h3>
            <p style="font-size:13px;color:var(--couleur-texte-clair);">
                Communique ces identifiants au client — ce mot de passe ne sera plus jamais affiché après avoir quitté cette page.
            </p>
            <p style="margin-bottom:4px;"><strong>Email :</strong> {{ $client->users->last()?->email }}</p>
            <div class="mot-de-passe-bloc">{{ session('mot_de_passe_genere') }}</div>
        </div>
    @endif

    <div class="carte">
        <h3 style="margin-top:0;">Abonnement</h3>
        <table>
            <tr><td style="color:var(--couleur-texte-clair);">Périodicité</td><td style="text-transform:capitalize;">{{ $client->periode_abonnement }}</td></tr>
            <tr><td style="color:var(--couleur-texte-clair);">Montant</td><td>{{ number_format($client->montant_abonnement, 0, ',', ' ') }} FCFA</td></tr>
            <tr><td style="color:var(--couleur-texte-clair);">Début</td><td>{{ $client->date_debut_abonnement->format('d/m/Y') }}</td></tr>
            <tr><td style="color:var(--couleur-texte-clair);">Fin</td><td>{{ $client->date_fin_abonnement->format('d/m/Y') }}</td></tr>
            <tr>
                <td style="color:var(--couleur-texte-clair);">Statut</td>
                <td>
                    @if ($client->statut === 'actif')
                        <span class="badge badge-actif">Actif</span>
                    @elseif ($client->statut === 'suspendu')
                        <span class="badge badge-suspendu">Suspendu</span>
                    @else
                        <span class="badge badge-expire">Expiré</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="carte">
        <h3 style="margin-top:0;">Comptes administrateurs</h3>
        <table>
            <thead><tr><th>Nom</th><th>Email</th><th></th></tr></thead>
            <tbody>
                @forelse ($client->users as $utilisateur)
                    <tr>
                        <td>{{ $utilisateur->name }}</td>
                        <td>{{ $utilisateur->email }}</td>
                        <td></td>
                    </tr>
                @empty
                    <tr><td colspan="3">Aucun compte pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($client->users->isNotEmpty())
            <div style="display:flex;gap:8px;margin-top:14px;">
                <form method="POST" action="{{ route('super-admin.clients.impersonner', $client) }}">
                    @csrf
                    <button type="submit" class="bouton bouton-secondaire bouton-petit">Se connecter en tant que ce client</button>
                </form>
                <form method="POST" action="{{ route('super-admin.clients.reinitialiser-mot-de-passe', $client) }}" onsubmit="return confirm('Générer un nouveau mot de passe pour ce client ?');">
                    @csrf
                    <button type="submit" class="bouton bouton-secondaire bouton-petit">Réinitialiser le mot de passe</button>
                </form>
            </div>
        @endif
    </div>

    <div class="carte carte-accent">
        <h3 style="margin-top:0;">Paiements</h3>

        <table style="margin-bottom:18px;">
            <thead><tr><th>Date</th><th>Montant</th><th>Méthode</th><th>Notes</th></tr></thead>
            <tbody>
                @forelse ($client->paiements->sortByDesc('date_paiement') as $paiement)
                    <tr>
                        <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                        <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                        <td style="text-transform:capitalize;">{{ str_replace('_', ' ', $paiement->methode) }}</td>
                        <td>{{ $paiement->notes ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Aucun paiement enregistré pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>

        <form method="POST" action="{{ route('super-admin.clients.paiements.store', $client) }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            @csrf

            <div>
                <label for="montant">Montant (FCFA)</label>
                <input type="number" name="montant" id="montant" min="0" required style="margin-bottom:0;max-width:160px;">
            </div>

            <div>
                <label for="methode">Méthode</label>
                <select name="methode" id="methode" required style="margin-bottom:0;">
                    <option value="espece">Espèces</option>
                    <option value="wave">Wave</option>
                    <option value="orange_money">Orange Money</option>
                    <option value="mtn_momo">MTN MoMo</option>
                    <option value="virement">Virement</option>
                </select>
            </div>

            <div>
                <label for="date_paiement">Date</label>
                <input type="date" name="date_paiement" id="date_paiement" value="{{ now()->toDateString() }}" required style="margin-bottom:0;">
            </div>

            <div style="flex:1;min-width:160px;">
                <label for="notes">Notes (optionnel)</label>
                <input type="text" name="notes" id="notes" style="margin-bottom:0;">
            </div>

            <button type="submit" class="bouton bouton-primaire">Enregistrer le paiement</button>
        </form>
        @error('montant')<div class="erreur-champ">{{ $message }}</div>@enderror
    </div>

    <div class="carte">
        <h3 style="margin-top:0;">Dépôts</h3>
        <table>
            <thead><tr><th>Nom</th><th>Localisation</th></tr></thead>
            <tbody>
                @forelse ($client->depots as $depot)
                    <tr><td>{{ $depot->nom }}</td><td>{{ $depot->localisation ?? '—' }}</td></tr>
                @empty
                    <tr><td colspan="2">Aucun dépôt créé par ce client pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('super-admin.clients.index') }}" class="bouton bouton-secondaire">← Retour à la liste</a>
@endsection
