@extends('layouts.admin')

@section('titre', 'Tableau de bord')

@section('content')
    <div class="entete-page">
        <h1>Tableau de bord</h1>
    </div>

    {{-- Indicateurs Clés (KPIs) avec disposition responsive et design soigné --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 24px;">
        <div class="carte" style="text-align: center; margin-bottom: 0; border-left: 4px solid var(--couleur-primaire);">
            <div style="font-size: 13px; color: var(--couleur-texte-clair); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Ventes aujourd'hui</div>
            <div style="font-size: 38px; font-weight: 700; color: var(--couleur-primaire); margin-top: 8px;">{{ $totalVentesDuJour }}</div>
            <div style="font-size: 12px; color: var(--couleur-texte-clair); margin-top: 4px;">Tous dépôts confondus</div>
        </div>

        <div class="carte" style="text-align: center; margin-bottom: 0; border-left: 4px solid #f59e0b;">
            <div style="font-size: 13px; color: var(--couleur-texte-clair); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Demandes en attente</div>
            <div style="font-size: 38px; font-weight: 700; color: #f59e0b; margin-top: 8px;">{{ $demandesEnAttente }}</div>
            <div style="font-size: 12px; color: var(--couleur-texte-clair); margin-top: 4px;">Nécessitent une validation</div>
        </div>

        <div class="carte" style="text-align: center; margin-bottom: 0; border-left: 4px solid var(--couleur-danger);">
            <div style="font-size: 13px; color: var(--couleur-texte-clair); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Couleurs en stock bas</div>
            <div style="font-size: 38px; font-weight: 700; color: var(--couleur-danger); margin-top: 8px;">{{ $stocksBas->count() }}</div>
            <div style="font-size: 12px; color: var(--couleur-texte-clair); margin-top: 4px;">Seuil critique atteint</div>
        </div>
    </div>

    {{-- Tableaux de données mis en valeur --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(480px, 1fr)); gap: 24px;">
        
        {{-- Ventes du jour par dépôt --}}
        <div class="carte" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 16px; color: #112719;">Ventes du jour par dépôt</h3>
            </div>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Dépôt</th>
                            <th style="text-align: right;">Ventes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventesParDepot as $ligne)
                            <tr style="transition: background 0.15s;">
                                <td style="font-weight: 500;">{{ $ligne->depot_nom }}</td>
                                <td style="text-align: right;"><span class="badge badge-livree" style="font-weight: 600;">{{ $ligne->total }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="text-align: center; color: var(--couleur-texte-clair); padding: 24px;">Aucune vente enregistrée aujourd'hui.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Alertes stock bas --}}
        <div class="carte" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 16px; color: var(--couleur-danger);">Alertes stock bas</h3>
            </div>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Dépôt</th>
                            <th>Couleur</th>
                            <th style="text-align: right;">Stock pleines</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stocksBas as $stock)
                            <tr style="transition: background 0.15s;">
                                <td style="font-weight: 500;">{{ $stock->depot->nom }}</td>
                                <td>{{ $stock->couleur->nomComplet() }}</td>
                                <td style="text-align: right;">
                                    <span class="badge" style="background: #fbe9e7; color: var(--couleur-danger); font-weight: 600;">
                                        {{ $stock->quantite_pleines }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; color: var(--couleur-texte-clair); padding: 24px;">Aucune alerte de stock bas. Tout va bien !</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection