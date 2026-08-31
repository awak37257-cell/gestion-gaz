@extends('layouts.admin')

@section('titre', 'Tableau de bord')

@section('content')
    <div class="entete-page">
        <h1>📊 Tableau de bord Dépôt</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper">💰</div>
            <div class="stat-content">
                <div class="stat-label">Ventes Aujourd'hui</div>
                <div class="stat-value">{{ $totalVentesDuJour }} <span style="font-size:0.9rem;color:var(--text-muted);font-weight:500;">bouteille(s)</span></div>
            </div>
        </div>

        <div class="stat-card accent-yellow">
            <div class="stat-icon-wrapper">🚚</div>
            <div class="stat-content">
                <div class="stat-label">Demandes en attente</div>
                <div class="stat-value">{{ $demandesEnAttente }}</div>
            </div>
        </div>

        <div class="stat-card {{ $stocksBas->count() > 0 ? 'accent-red' : 'accent-green' }}">
            <div class="stat-icon-wrapper">⚠️</div>
            <div class="stat-content">
                <div class="stat-label">Alertes Stock Bas</div>
                <div class="stat-value" style="{{ $stocksBas->count() > 0 ? 'color:var(--danger);' : '' }}">{{ $stocksBas->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Ventes du jour par dépôt -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🏬 Ventes du jour par dépôt</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nom du Dépôt</th>
                        <th style="text-align: right;">Bouteilles vendues</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventesParDepot as $ligne)
                        <tr>
                            <td style="font-weight: 700;">{{ $ligne->depot_nom }}</td>
                            <td style="text-align: right; font-family: 'JetBrains Mono', monospace; font-weight: 800; color: var(--primary);">
                                {{ $ligne->total }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                                Aucune vente enregistrée aujourd'hui.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alertes stock bas -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">⚠️ Bouteilles en stock critique (Stock bas)</h3>
            <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary btn-sm">Voir tout le stock</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Dépôt</th>
                        <th>Marque & Format</th>
                        <th style="text-align: right;">Bouteilles Pleines</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocksBas as $stock)
                        <tr>
                            <td style="color: var(--text-muted);">{{ $stock->depot->nom }}</td>
                            <td style="font-weight: 700;">{{ $stock->couleur->nomComplet() }}</td>
                            <td style="text-align: right;">
                                <span class="badge badge-suspendu" style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                                    {{ $stock->quantite_pleines }} restante(s)
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                                ✅ Tous les stocks sont au-dessus des seuils d'alerte.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection