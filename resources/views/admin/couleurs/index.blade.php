@extends('layouts.admin')

@section('titre', 'Couleurs et types')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="8" r="6.2"/><circle cx="8" cy="5.3" r="0.9" fill="#fff" stroke="none"/><circle cx="5.3" cy="9.5" r="0.9" fill="#fff" stroke="none"/><circle cx="10.7" cy="9.5" r="0.9" fill="#fff" stroke="none"/></svg>
            </div>
            <h1>Couleurs et types</h1>
        </div>
        <a href="{{ route('admin.couleurs.create') }}" class="bouton bouton-primaire">+ Nouvelle couleur</a>
    </div>

    @forelse ($marques as $marque)
        <div class="carte">
            <h3 style="margin-top: 0; margin-bottom: 16px; color: var(--couleur-primaire-fonce); font-size: 18px;">{{ $marque->nom }}</h3>
            
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Couleur</th>
                            <th>Poids</th>
                            <th>Prix unitaire</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($marque->couleurs as $couleur)
                            <tr style="transition: background 0.15s;">
                                <td style="font-weight: 600;">{{ $couleur->type }}</td>
                                <td>{{ $couleur->nom_couleur }}</td>
                                <td>{{ $couleur->poids }}</td>
                                <td>{{ number_format($couleur->prix_unitaire, 0, ',', ' ') }} FCFA</td>
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
                                <td colspan="5" style="text-align: center; color: var(--couleur-texte-clair); padding: 24px;">
                                    Aucune couleur pour cette marque.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="carte" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
            Aucune marque créée pour le moment.
        </div>
    @endforelse
@endsection