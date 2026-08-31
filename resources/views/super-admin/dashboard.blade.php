@extends('layouts.super-admin')

@section('titre', 'Tableau de bord Super Admin')

@section('content')
    <!-- KPIs -->
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
                <div class="stat-label">Dépôts Gérés</div>
                <div class="stat-value">{{ $totalDepots }}</div>
            </div>
        </div>
    </div>

    <!-- Demandes d'accès récentes en attente -->
    @php
        $demandesRecentes = \App\Models\DemandeAcces::where('statut', 'en_attente')->latest()->take(5)->get();
    @endphp
    @if ($demandesRecentes->count() > 0)
        <div class="card" style="border-left: 4px solid var(--danger);">
            <div class="card-header">
                <h3 class="card-title" style="color:var(--danger);">
                    <span>🔥</span> Demandes d'accès en attente ({{ $demandesRecentes->count() }})
                </h3>
                <a href="{{ route('super-admin.demandes.index') }}" class="btn btn-secondary btn-sm">Voir tout</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Entreprise</th>
                            <th>Contact</th>
                            <th>Formule</th>
                            <th>Téléphone / Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demandesRecentes as $demande)
                            <tr>
                                <td style="font-weight:700;">{{ $demande->nom_entreprise }}</td>
                                <td>{{ $demande->nom_contact }}</td>
                                <td><span class="badge badge-purple">{{ ucfirst($demande->periode_souhaitee) }}</span></td>
                                <td>{{ $demande->email }} • {{ $demande->telephone }}</td>
                                <td>
                                    <form method="POST" action="{{ route('super-admin.demandes.valider', $demande) }}" style="display:inline;" onsubmit="return confirm('Créer le compte client pour {{ addslashes($demande->nom_entreprise) }} ?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">✨ Créer l'accès</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Graphique Revenus -->
    @php $maxRevenu = max(1, $revenusParMois->max('total')); @endphp
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📈 Revenus encaissés (6 derniers mois)</h3>
            <a href="{{ route('super-admin.paiements.index') }}" class="btn btn-secondary btn-sm">Historique complet</a>
        </div>
        @if ($revenusParMois->sum('total') > 0)
            <div style="display:flex;align-items:flex-end;gap:18px;height:160px;padding-top:10px;">
                @foreach ($revenusParMois as $mois)
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:8px;">
                        <div style="font-size:11px;font-weight:700;color:var(--text-muted);font-family:'JetBrains Mono',monospace;">
                            {{ number_format($mois['total'], 0, ',', ' ') }}
                        </div>
                        <div style="width:100%;max-width:44px;height:{{ max(8, ($mois['total'] / $maxRevenu) * 105) }}px;background:linear-gradient(180deg, var(--primary), var(--primary-dark));border-radius:8px 8px 0 0;box-shadow:0 4px 10px rgba(139,92,246,0.3);"></div>
                        <div style="font-size:11.5px;font-weight:600;color:var(--text-muted);text-transform:capitalize;">{{ $mois['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color:var(--text-muted);font-size:0.88rem;padding:1rem 0;">Aucun paiement enregistré pour le moment. Enregistrez les paiements depuis la fiche de chaque client.</p>
        @endif
    </div>

    <!-- Derniers clients inscrits -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🏢 Derniers clients enregistrés</h3>
            <a href="{{ route('super-admin.clients.index') }}" class="btn btn-secondary btn-sm">Gérer les clients</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Entreprise</th>
                        <th>Abonnement</th>
                        <th>Échéance</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients->take(5) as $client)
                        <tr>
                            <td style="font-weight:700;">
                                <a href="{{ route('super-admin.clients.show', $client) }}" style="color:var(--text-main);text-decoration:none;">
                                    {{ $client->nom }}
                                </a>
                            </td>
                            <td>{{ number_format($client->montant_abonnement, 0, ',', ' ') }} FCFA / {{ $client->periode_abonnement }}</td>
                            <td>{{ $client->date_fin_abonnement->format('d/m/Y') }}</td>
                            <td>
                                @if ($client->statut === 'actif')
                                    <span class="badge badge-actif">Actif</span>
                                @elseif ($client->statut === 'suspendu')
                                    <span class="badge badge-suspendu">Suspendu</span>
                                @else
                                    <span class="badge badge-expire">Expiré</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('super-admin.clients.show', $client) }}" class="btn btn-secondary btn-sm">Gérer</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;color:var(--text-muted);padding:2rem;">Aucun client pour l'instant.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
