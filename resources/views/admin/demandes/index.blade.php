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
        <table>
            <thead>
                <tr><th>Vendeur</th><th>Dépôt</th><th>Marque</th><th>Couleur</th><th>Quantité</th><th>Statut</th><th>Date</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($demandes as $demande)
                    <tr>
                        <td>{{ $demande->vendeur->nom }}</td>
                        <td>{{ $demande->vendeur->depot->nom }}</td>
                        <td>{{ $demande->marque->nom }}</td>
                        <td>{{ $demande->couleur->nom_couleur }} ({{ $demande->couleur->poids }})</td>
                        <td>{{ $demande->quantite_demandee }}</td>
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
                        <td>
                            @if ($demande->statut === 'en_attente')
                                <form class="inline" method="POST" action="{{ route('admin.demandes.valider', $demande) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bouton bouton-secondaire bouton-petit">Valider</button>
                                </form>
                            @elseif ($demande->statut === 'validee')
                                <form class="inline" method="POST" action="{{ route('admin.demandes.livrer', $demande) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bouton bouton-primaire bouton-petit">Marquer livrée</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">Aucune demande pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
