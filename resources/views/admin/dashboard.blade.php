@extends('layouts.admin')

@section('titre', 'Tableau de bord')

@section('content')
    <div class="entete-page" style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Tableau de bord</h1>

    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="carte carte-accent carte-stat" style="margin-bottom: 0;">
            <div class="icone-badge">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.6"><path d="M3 17l5-5 4 4 8-9"/><path d="M15 7h5v5"/></svg>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--couleur-texte-clair); text-transform: uppercase; letter-spacing: 0.05em;">Ventes aujourd'hui</div>
                <div style="font-size: 32px; font-weight: 700; color: var(--couleur-primaire); font-family: var(--police-chiffres);">{{ $totalVentesDuJour }}</div>
            </div>
        </div>
        
        <div class="carte carte-accent carte-stat" style="margin-bottom: 0;">
            <div class="icone-badge icone-badge-c">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.6"><path d="M6 3h9l3 3v14.5H6V3z"/><path d="M9 9h6M9 12.5h6M9 16h4"/></svg>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--couleur-texte-clair); text-transform: uppercase; letter-spacing: 0.05em;">Demandes en attente</div>
                <div style="font-size: 32px; font-weight: 700; color: #06B6D4; font-family: var(--police-chiffres);">{{ $demandesEnAttente }}</div>
            </div>
        </div>

        <div class="carte carte-accent-danger carte-stat" style="margin-bottom: 0;">
            <div class="icone-badge danger">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.6"><path d="M12 3l9 16H3L12 3z"/><path d="M12 10v4"/><circle cx="12" cy="17" r="0.6" fill="#fff" stroke="none"/></svg>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--couleur-texte-clair); text-transform: uppercase; letter-spacing: 0.05em;">Couleurs en stock bas</div>
                <div style="font-size: 32px; font-weight: 700; color: var(--couleur-danger); font-family: var(--police-chiffres);">{{ $stocksBas->count() }}</div>
            </div>
        </div>
    </div>

    <div class="carte">
        <h3 style="margin-top: 0; margin-bottom: 16px; color: var(--couleur-primaire-fonce); font-size: 18px;">Ventes du jour par dépôt</h3>
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
                            <td style="text-align: right; font-family: var(--police-chiffres); font-weight: 600;">{{ $ligne->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
                                Aucune vente aujourd'hui.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="carte">
        <h3 style="margin-top: 0; margin-bottom: 16px; color: var(--couleur-primaire-fonce); font-size: 18px;">Alertes stock bas</h3>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Dépôt</th>
                        <th>Type / Couleur</th>
                        <th style="text-align: right;">Stock pleines</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocksBas as $stock)
                        <tr style="transition: background 0.15s;">
                            <td style="color: var(--couleur-texte-clair);">{{ $stock->depot->nom }}</td>
                            <td style="font-weight: 500;">{{ $stock->couleur->nomComplet() }}</td>
                            <td style="text-align: right;">
                                <span class="badge badge-attente" style="font-family: var(--police-chiffres);">{{ $stock->quantite_pleines }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
                                Aucune alerte pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection