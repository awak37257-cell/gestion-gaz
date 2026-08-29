@extends('layouts.admin')

@section('titre', 'Dépôts')

@section('content')
    <div class="entete-page">
        <h1>Dépôts</h1>
        <a href="{{ route('admin.depots.create') }}" class="bouton bouton-primaire">+ Nouveau dépôt</a>
    </div>

    <div class="carte">
        <table>
            <thead><tr><th>Nom</th><th>Localisation</th><th>Vendeurs</th><th></th></tr></thead>
            <tbody>
                @forelse ($depots as $depot)
                    <tr>
                        <td>{{ $depot->nom }}</td>
                        <td>{{ $depot->localisation ?? '—' }}</td>
                        <td>{{ $depot->vendeurs_count }}</td>
                        <td>
                            <a href="{{ route('admin.depots.edit', $depot) }}" class="bouton bouton-secondaire bouton-petit">Modifier</a>
                            <form class="inline" method="POST" action="{{ route('admin.depots.destroy', $depot) }}" onsubmit="return confirm('Supprimer ce dépôt ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bouton bouton-danger bouton-petit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Aucun dépôt pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
