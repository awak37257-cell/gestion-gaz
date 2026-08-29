@extends('layouts.admin')

@section('titre', 'Tableau de bord')

@section('content')
    <div class="entete-page">
        <h1>Tableau de bord</h1>
    </div>

    <div style="display:flex;gap:16px;margin-bottom:20px;">
        <div class="carte" style="flex:1;text-align:center;">
            <div style="font-size:13px;color:var(--couleur-texte-clair);">Ventes aujourd'hui (tous dépôts)</div>
            <div style="font-size:36px;font-weight:700;color:var(--couleur-primaire);">{{ $totalVentesDuJour }}</div>
        </div>
        <div class="carte" style="flex:1;text-align:center;">
            <div style="font-size:13px;color:var(--couleur-texte-clair);">Demandes en attente</div>
            <div style="font-size:36px;font-weight:700;color:var(--couleur-primaire);">{{ $demandesEnAttente }}</div>
        </div>
        <div class="carte" style="flex:1;text-align:center;">
            <div style="font-size:13px;color:var(--couleur-texte-clair);">Couleurs en stock bas</div>
            <div style="font-size:36px;font-weight:700;color:var(--couleur-danger);">{{ $stocksBas->count() }}</div>
        </div>
    </div>

    <div class="carte">
        <h3 style="margin-top:0;">Ventes du jour par dépôt</h3>
        <table>
            <thead><tr><th>Dépôt</th><th>Ventes</th></tr></thead>
            <tbody>
                @forelse ($ventesParDepot as $ligne)
                    <tr><td>{{ $ligne->depot_nom }}</td><td>{{ $ligne->total }}</td></tr>
                @empty
                    <tr><td colspan="2">Aucune vente aujourd'hui.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="carte">
        <h3 style="margin-top:0;">Alertes stock bas</h3>
        <table>
            <thead><tr><th>Dépôt</th><th>Couleur</th><th>Stock pleines</th></tr></thead>
            <tbody>
                @forelse ($stocksBas as $stock)
                    <tr>
                        <td>{{ $stock->depot->nom }}</td>
                        <td>{{ $stock->couleur->nomComplet() }}</td>
                        <td>{{ $stock->quantite_pleines }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">Aucune alerte pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
