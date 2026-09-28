@extends('layouts.super-admin')

@section('titre', $client->nom)

@section('content')
    <div class="card-header" style="border-bottom:none;padding-bottom:0;margin-bottom:1.5rem;">
        <div>
            <h2 style="font-family:'Outfit',sans-serif;font-size:1.6rem;font-weight:800;color:var(--text-main);">
                {{ $client->nom }}
            </h2>
            <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.2rem;">
                Client enregistré le {{ $client->created_at->format('d/m/Y') }} • ID #{{ $client->id }}
            </div>
        </div>
        <div style="display:flex;gap:0.6rem;flex-wrap:wrap;">
            <form method="POST" action="{{ route('super-admin.clients.impersonner', $client) }}">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Vous connecter en tant qu\'administrateur de ce client ?')">
                    🚀 Se connecter au compte (Impersonner)
                </button>
            </form>
            <form method="POST" action="{{ route('super-admin.clients.renouveler', $client) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-secondary btn-sm">Prolonger abonnement</button>
            </form>
            <form method="POST" action="{{ route('super-admin.clients.basculer-statut', $client) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn {{ $client->statut === 'actif' ? 'btn-danger-outline' : 'btn-secondary' }} btn-sm">
                    {{ $client->statut === 'actif' ? 'Suspendre l\'accès' : 'Activer l\'accès' }}
                </button>
            </form>
            <a href="{{ route('super-admin.clients.edit', $client) }}" class="btn btn-secondary btn-sm">Modifier</a>
        </div>
    </div>

    @if (session('mot_de_passe_genere'))
        <div class="key-banner">
            <h3 style="color:#a855f7;font-family:'Outfit',sans-serif;margin-bottom:0.4rem;">🔑 Identifiants d'accès générés pour le client</h3>
            <p style="font-size:0.88rem;color:#cbd5e1;">
                Communiquez ces identifiants à l'administrateur du dépôt. Ce mot de passe temporaire ne sera plus affiché après avoir quitté cette page.
            </p>
            <div style="margin-top:0.8rem;">
                <div><strong>Email de connexion :</strong> {{ session('email_client') ?? $client->users->first()?->email }}</div>
                <div><strong>Mot de passe :</strong></div>
                <div class="key-code">{{ session('mot_de_passe_genere') }}</div>
            </div>
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
        <!-- Détails de l'abonnement -->
        <div class="card" style="margin-bottom:0;">
            <div class="card-header">
                <h3 class="card-title">💳 Détails de l'abonnement</h3>
            </div>
            <table>
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Statut</td>
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
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Périodicité</td>
                    <td style="text-transform:capitalize;">{{ $client->periode_abonnement }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Montant</td>
                    <td style="font-family:'JetBrains Mono',monospace;font-weight:700;">{{ number_format($client->montant_abonnement, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Date de début</td>
                    <td>{{ $client->date_debut_abonnement->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Date d'expiration</td>
                    <td style="font-weight:700;color:{{ $client->date_fin_abonnement->isPast() ? 'var(--danger)' : 'var(--text-main)' }};">
                        {{ $client->date_fin_abonnement->format('d/m/Y') }}
                        @if ($client->date_fin_abonnement->isFuture())
                            <span style="font-size:12px;color:var(--text-muted);font-weight:normal;">({{ now()->diffInDays($client->date_fin_abonnement) }} jours restants)</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Coordonnées & Utilisateurs -->
        <div class="card" style="margin-bottom:0;">
            <div class="card-header">
                <h3 class="card-title">📞 Coordonnées & Utilisateurs</h3>
            </div>
            <table>
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Email contact</td>
                    <td>{{ $client->email_contact ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Téléphone</td>
                    <td>{{ $client->telephone ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Comptes Admin</td>
                    <td>
                        @foreach ($client->users as $u)
                            <div><strong>{{ $u->name }}</strong> ({{ $u->email }})</div>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td style="color:var(--text-muted);font-weight:600;">Dépôts gérés</td>
                    <td>{{ $client->depots->count() }} dépôt(s) configuré(s)</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Enregistrer un paiement -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">💰 Enregistrer un nouveau règlement</h3>
        </div>
        <form method="POST" action="{{ route('super-admin.clients.paiements.store', $client) }}" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:1rem;align-items:flex-end;">
            @csrf
            <div>
                <label class="form-label" for="montant">Montant (FCFA)</label>
                <input type="number" name="montant" id="montant" class="form-control" value="{{ $client->montant_abonnement }}" required>
            </div>
            <div>
                <label class="form-label" for="mode">Mode de règlement</label>
               <select name="mode" id="mode" class="form-control">
    <option value="espece">Espèces</option>
    <option value="wave">Wave</option>
    <option value="orange_money">Orange Money</option>
    <option value="mtn_momo">MTN Momo</option>
</select>
            </div>
            <div>
                <label class="form-label" for="reference">Référence / Reçu</label>
                <input type="text" name="reference" id="reference" class="form-control" placeholder="Ex: TRX-998822">
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Encaisser le paiement</button>
            </div>
        </form>
    </div>

    <!-- Historique des paiements de ce client -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📜 Historique des paiements de {{ $client->nom }}</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Mode</th>
                        <th>Référence</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($client->paiements->sortByDesc('created_at') as $p)
                        <tr>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td style="font-family:'JetBrains Mono',monospace;font-weight:700;">{{ number_format($p->montant, 0, ',', ' ') }} FCFA</td>
                            <td><span class="badge badge-purple">{{ $p->methode}}</span></td>
                            <td>{{ $p->reference ?? '—' }}</td> 
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;color:var(--text-muted);padding:2rem;">Aucun paiement enregistré pour ce client.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
