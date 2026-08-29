@extends('layouts.admin')

@section('titre', "Demandes d'approvisionnement")

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><path d="M4 1.5h6l2.5 2.5V14.5h-8.5V1.5z"/><path d="M6 7h4M6 9.5h4M6 12h2.5"/></svg>
            </div>
            <h1>Demandes d'approvisionnement</h1>
        </div>
    </div>

    <div class="carte">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Vendeur</th>
                        <th>Dépôt</th>
                        <th>Marque</th>
                        <th>Type / Couleur</th>
                        <th>Quantité</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($demandes as $demande)
                        <tr style="transition: background 0.15s;">
                            <td style="font-weight: 500;">{{ $demande->vendeur->nom }}</td>
                            <td>{{ $demande->vendeur->depot->nom }}</td>
                            <td>{{ $demande->marque->nom }}</td>
                            <td>
                                <span style="font-weight: 600;">{{ $demande->couleur->type ?? '' }}</span> 
                                <span style="color: var(--couleur-texte-clair); font-size: 13px;">({{ $demande->couleur->nom_couleur }} - {{ $demande->couleur->poids }})</span>
                            </td>
                            <td style="font-weight: 600;">{{ $demande->quantite_demandee }}</td>
                            <td>
                                @if ($demande->statut === 'en_attente')
                                    <span class="badge badge-attente">En attente</span>
                                @elseif ($demande->statut === 'validee')
                                    <span class="badge badge-validee">Validée</span>
                                @else
                                    <span class="badge badge-livree">Livrée</span>
                                @endif
                            </td>
                            <td style="color: var(--couleur-texte-clair); font-size: 13px;">{{ $demande->date->format('d/m/Y') }}</td>
                            <td style="text-align: right; white-space: nowrap;">
                                @if ($demande->statut === 'en_attente')
                                    <form class="inline" method="POST" action="{{ route('admin.demandes.valider', $demande) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bouton bouton-secondaire bouton-petit" style="cursor: pointer;">Valider</button>
                                    </form>
                                @elseif ($demande->statut === 'validee')
                                    <form class="inline" method="POST" action="{{ route('admin.demandes.livrer', $demande) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bouton bouton-primaire bouton-petit" style="cursor: pointer;">Marquer livrée</button>
                                    </form>
                                @else
                                    <span style="color: var(--couleur-texte-clair); font-size: 13px;">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
                                Aucune demande pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection