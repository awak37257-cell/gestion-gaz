@extends('layouts.admin')

@section('titre', 'Couleurs')

@section('content')
    <div class="entete-page">
        <h1>Couleurs</h1>
        <a href="{{ route('admin.couleurs.create') }}" class="bouton bouton-primaire">+ Nouvelle couleur</a>
    </div>

    @forelse ($marques as $marque)
        <div class="carte">
            <h3 style="margin-top: 0; margin-bottom: 16px; color: #112719; border-bottom: 2px solid var(--couleur-fond); padding-bottom: 8px;">
                {{ $marque->nom }}
            </h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Couleur</th>
                            <th>Poids</th>
                            <th>Prix unitaire</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($marque->couleurs as $couleur)
                            <tr style="transition: background 0.15s;">
                                <td style="font-weight: 500;">{{ $couleur->nom_couleur }}</td>
                                <td>{{ $couleur->poids }}</td>
                                <td style="font-weight: 600; color: var(--couleur-primaire);">{{ number_format($couleur->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <a href="{{ route('admin.couleurs.edit', $couleur) }}" class="bouton bouton-secondaire bouton-petit" style="margin-right: 4px; text-decoration: none;">Modifier</a>
                                    <form class="inline" method="POST" action="{{ route('admin.couleurs.destroy', $couleur) }}" onsubmit="return confirm('Supprimer cette couleur ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bouton bouton-danger bouton-petit" style="background: var(--couleur-danger); border: none; cursor: pointer;">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--couleur-texte-clair); padding: 16px;">Aucune couleur enregistrée pour cette marque.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="carte" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
            Aucune marque créée pour le moment. Veuillez d'abord ajouter une marque.
        </div>
    @endforelse
@endsection