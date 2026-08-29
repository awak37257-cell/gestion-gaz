@extends('layouts.admin')

@section('titre', 'Marques')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><path d="M2 2h5.5L14 8.5 8.5 14 2 7.5V2z"/><circle cx="5" cy="5" r="0.8" fill="#fff" stroke="none"/></svg>
            </div>
            <h1>Marques</h1>
        </div>
        <a href="{{ route('admin.marques.create') }}" class="bouton bouton-primaire">+ Nouvelle marque</a>
    </div>

    <div class="carte">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Types / Couleurs associés</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($marques as $marque)
                        <tr style="transition: background 0.15s;">
                            <td style="font-weight: 600;">{{ $marque->nom }}</td>
                            <td>
                                <span style="font-weight: 500;">{{ $marque->couleurs_count }}</span>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="{{ route('admin.marques.edit', $marque) }}" class="bouton bouton-secondaire bouton-petit" style="margin-right: 4px; text-decoration: none;">Modifier</a>
                                <form class="inline" method="POST" action="{{ route('admin.marques.destroy', $marque) }}" onsubmit="return confirm('Supprimer cette marque ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bouton bouton-danger bouton-petit" style="background: var(--couleur-danger); border: none; cursor: pointer;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
                                Aucune marque pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection