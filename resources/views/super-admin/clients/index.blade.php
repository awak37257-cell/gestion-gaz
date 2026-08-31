@extends('layouts.super-admin')

@section('titre', 'Gestion des Clients')

@section('content')
    <!-- KPIs Clients -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper">👥</div>
            <div class="stat-content">
                <div class="stat-label">Clients Actifs</div>
                <div class="stat-value">{{ $clientsActifs }} <span style="font-size:1rem;color:var(--text-muted);font-weight:500;">/ {{ $clients->count() }}</span></div>
            </div>
        </div>

        <div class="stat-card accent-pink">
            <div class="stat-icon-wrapper">💰</div>
            <div class="stat-content">
                <div class="stat-label">Revenu Mensuel (MRR)</div>
                <div class="stat-value">{{ number_format($mrr, 0, ',', ' ') }} <span style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">FCFA</span></div>
            </div>
        </div>

        <div class="stat-card {{ $expirationProche > 0 ? 'accent-red' : 'accent-orange' }}">
            <div class="stat-icon-wrapper">⏳</div>
            <div class="stat-content">
                <div class="stat-label">Fin sous 30 jours</div>
                <div class="stat-value" style="{{ $expirationProche > 0 ? 'color:var(--danger);' : '' }}">{{ $expirationProche }}</div>
            </div>
        </div>

        <div class="stat-card accent-green">
            <div class="stat-icon-wrapper">🏭</div>
            <div class="stat-content">
                <div class="stat-label">Dépôts Total</div>
                <div class="stat-value">{{ $totalDepots }}</div>
            </div>
        </div>
    </div>

    <!-- Filtres et Recherche -->
    <div class="card">
        <form method="GET" action="{{ route('super-admin.clients.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:1;min-width:220px;">
                <label class="form-label" for="recherche">Rechercher une entreprise</label>
                <input type="text" name="recherche" id="recherche" class="form-control" style="max-width:100%;margin-bottom:0;" value="{{ $recherche }}" placeholder="Nom du dépôt ou de l'entreprise...">
            </div>
            <div style="min-width:160px;">
                <label class="form-label" for="statut">Statut abonnement</label>
                <select name="statut" id="statut" class="form-control" style="margin-bottom:0;">
                    <option value="">Tous les statuts</option>
                    <option value="actif" @selected($statutFiltre == 'actif')>Actif</option>
                    <option value="suspendu" @selected($statutFiltre == 'suspendu')>Suspendu</option>
                    <option value="expire" @selected($statutFiltre == 'expire')>Expiré</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filtrer</button>
            <a href="{{ route('super-admin.clients.exporter') }}" class="btn btn-secondary">📥 Exporter (CSV)</a>
            <a href="{{ route('super-admin.clients.create') }}" class="btn btn-primary">+ Nouveau client</a>
        </form>
    </div>

    <!-- Tableau des Clients -->
    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Entreprise</th>
                        <th>Abonnement</th>
                        <th>Échéance</th>
                        <th>Statut</th>
                        <th>Dernière activité</th>
                        <th>Ventes ce mois</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <td>
                                <div style="font-weight:700;">
                                    <a href="{{ route('super-admin.clients.show', $client) }}" style="color:var(--text-main);text-decoration:none;">
                                        {{ $client->nom }}
                                    </a>
                                </div>
                                <div style="font-size:12px;color:var(--text-muted);">
                                    {{ $client->depots_count }} dépôt(s) • {{ $client->users_count }} utilisateur(s)
                                </div>
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace;">
                                {{ number_format($client->montant_abonnement, 0, ',', ' ') }} FCFA
                                <div style="font-size:11px;color:var(--text-muted);font-family:inherit;">
                                    {{ ucfirst($client->periode_abonnement) }}
                                </div>
                            </td>
                            <td>
                                <div style="font-size:0.85rem;font-weight:600;">
                                    {{ $client->date_fin_abonnement->format('d/m/Y') }}
                                </div>
                                @if ($client->statut === 'actif' && $client->date_fin_abonnement->isFuture() && now()->diffInDays($client->date_fin_abonnement) <= 30)
                                    <span class="badge badge-suspendu" style="font-size:10px;padding:2px 6px;">Échéance proche</span>
                                @endif
                            </td>
                            <td>
                                @if ($client->statut === 'actif')
                                    <span class="badge badge-actif">Actif</span>
                                @elseif ($client->statut === 'suspendu')
                                    <span class="badge badge-suspendu">Suspendu</span>
                                @else
                                    <span class="badge badge-expire">Expiré</span>
                                @endif
                            </td>
                            <td style="font-size:12px;color:var(--text-muted);">
                                {{ $client->derniere_activite ? \Illuminate\Support\Carbon::parse($client->derniere_activite)->format('d/m/Y H:i') : 'Aucune' }}
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace;font-weight:700;">
                                {{ $client->ventes_ce_mois }}
                            </td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('super-admin.clients.show', $client) }}" class="btn btn-secondary btn-sm">Voir</a>
                                <a href="{{ route('super-admin.clients.edit', $client) }}" class="btn btn-secondary btn-sm">Modifier</a>
                                <form method="POST" action="{{ route('super-admin.clients.renouveler', $client) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-secondary btn-sm">Renouveler</button>
                                </form>
                                <form method="POST" action="{{ route('super-admin.clients.basculer-statut', $client) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn {{ $client->statut === 'actif' ? 'btn-danger-outline' : 'btn-secondary' }} btn-sm">
                                        {{ $client->statut === 'actif' ? 'Suspendre' : 'Activer' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;color:var(--text-muted);padding:3rem;">
                                Aucun client ne correspond aux critères.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
