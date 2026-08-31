@extends('layouts.super-admin')

@section('titre', 'Historique des Paiements')

@section('content')
    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        <div class="stat-card accent-green">
            <div class="stat-icon-wrapper">💵</div>
            <div class="stat-content">
                <div class="stat-label">Total Encaissé</div>
                <div class="stat-value">{{ number_format($totalEncaisse, 0, ',', ' ') }} <span style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">FCFA</span></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper">🧾</div>
            <div class="stat-content">
                <div class="stat-label">Nombre de règlements</div>
                <div class="stat-value">{{ $paiements->count() }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📜 Relevé de tous les paiements</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Mode</th>
                        <th>Référence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($paiements as $paiement)
                        <tr>
                            <td style="font-family:'JetBrains Mono',monospace;font-size:0.82rem;">
                                {{ $paiement->date_paiement->format('d/m/Y') }}
                            </td>
                            <td style="font-weight:700;">
                                @if ($paiement->client)
                                    <a href="{{ route('super-admin.clients.show', $paiement->client) }}" style="color:var(--primary);text-decoration:none;">
                                        {{ $paiement->client->nom }}
                                    </a>
                                @else
                                    <span style="color:var(--text-muted);">Client supprimé</span>
                                @endif
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace;font-weight:700;color:var(--text-main);">
                                {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                            </td>
                            <td>
                                <span class="badge badge-purple">{{ ucfirst($paiement->mode ?? 'Virement') }}</span>
                            </td>
                            <td style="color:var(--text-muted);font-size:0.82rem;">
                                {{ $paiement->reference ?? '—' }}
                            </td>
                            <td>
                                @if ($paiement->client)
                                    <a href="{{ route('super-admin.clients.show', $paiement->client) }}" class="btn btn-secondary btn-sm">
                                        Fiche client
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:var(--text-muted);padding:2.5rem;">
                                Aucun paiement enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
