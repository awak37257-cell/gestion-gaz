@extends('layouts.admin')

@section('titre', "Demandes d'approvisionnement")

@section('content')
    <div class="entete-page">
        <h1>Demandes d'approvisionnement</h1>
    </div>

    <div class="carte">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Vendeur</th>
                        <th>Dépôt</th>
                        <th>Marque</th>
                        <th>Couleur</th>
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
                            <td>{{ $demande->couleur->nom_couleur }} ({{ $demande->couleur->poids }})</td>
                            <td><strong style="color: var(--couleur-primaire-fonce);">{{ $demande->quantite_demandee }}</strong></td>
                            <td>
                                @if ($demande->statut === 'en_attente')
                                    <span class="badge badge-attente">En attente</span>
                                @elseif ($demande->statut === 'validee')
                                    <span class="badge badge-validee">Validée</span>
                                @else
                                    <span class="badge badge-livree">Livrée</span>
                                @endif
                            </td>
                            <td>{{ $demande->date->format('d/m/Y') }}</td>
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
                                    <span style="font-size: 13px; color: var(--couleur-texte-clair);">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
                                Aucune demande d'approvisionnement pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection