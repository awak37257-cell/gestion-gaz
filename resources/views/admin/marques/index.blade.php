@extends('layouts.admin')

@section('titre', 'Marques')

@section('content')
    <div class="entete-page">
        <h1>Marques</h1>
        <a href="{{ route('admin.marques.create') }}" class="bouton bouton-primaire">+ Nouvelle marque</a>
    </div>

    <div class="carte">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Couleurs</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($marques as $marque)
                        <tr style="transition: background 0.15s;">
                            <td style="font-weight: 500;">{{ $marque->nom }}</td>
                            <td>
                                <span class="badge" style="background: #eef2f7; color: #334155; font-weight: 600;">
                                    {{ $marque->couleurs_count }}
                                </span>
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