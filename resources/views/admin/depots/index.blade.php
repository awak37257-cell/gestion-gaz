@extends('layouts.admin')

@section('titre', 'Dépôts')

@section('content')
    <div class="entete-page">
        <h1>Dépôts</h1>
        <a href="{{ route('admin.depots.create') }}" class="bouton bouton-primaire">+ Nouveau dépôt</a>
    </div>

    <div class="carte">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Localisation</th>
                        <th>Vendeurs</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($depots as $depot)
                        <tr style="transition: background 0.15s;">
                            <td style="font-weight: 500;">{{ $depot->nom }}</td>
                            <td>{{ $depot->localisation ?? '—' }}</td>
                            <td>
                                <span class="badge" style="background: #eef2f7; color: #334155; font-weight: 600;">
                                    {{ $depot->vendeurs_count }}
                                </span>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="{{ route('admin.depots.edit', $depot) }}" class="bouton bouton-secondaire bouton-petit" style="margin-right: 4px; text-decoration: none;">Modifier</a>
                                <form class="inline" method="POST" action="{{ route('admin.depots.destroy', $depot) }}" onsubmit="return confirm('Supprimer ce dépôt ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bouton bouton-danger bouton-petit" style="background: var(--couleur-danger); border: none; cursor: pointer;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
                                Aucun dépôt pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection