@extends('layouts.admin')

@section('titre', 'Détails des ventes du dépôt')

@section('content')
    <div class="entete-page">
        <h1>📋 Historique des ventes - Dépôt : {{ $depot->nom }}</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Retour au tableau de bord</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Heure</th>
                        <th>Vendeur</th>
                        <th>Produit (Marque & Type)</th>
                        <th style="text-align: right;">Quantité vendue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventes as $vente)
                        <tr>
                            <td style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($vente->date_heure)->format('H:i') }}</td>
                            <td style="font-weight: 600;">{{ $vente->vendeur->nom ?? 'N/A' }} {{ $vente->vendeur->prenoms ?? '' }}</td>
                           <td>{{ $vente->couleurVendue->marque->nom ?? 'N/A' }} - {{ $vente->couleurVendue->nom_couleur ?? '' }} ({{ $vente->couleurVendue->type ?? '' }})</td>
                            <td style="text-align: right; font-family: 'JetBrains Mono', monospace; font-weight: 800; color: var(--primary);">
                                {{ $vente->quantite }} unité(s)
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                                Aucune vente enregistrée pour ce dépôt aujourd'hui.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection