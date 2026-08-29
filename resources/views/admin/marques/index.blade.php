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
        <table>
            <thead><tr><th>Nom</th><th>Couleurs</th><th></th></tr></thead>
            <tbody>
                @forelse ($marques as $marque)
                    <tr>
                        <td>{{ $marque->nom }}</td>
                        <td>{{ $marque->couleurs_count }}</td>
                        <td>
                            <a href="{{ route('admin.marques.edit', $marque) }}" class="bouton bouton-secondaire bouton-petit">Modifier</a>
                            <form class="inline" method="POST" action="{{ route('admin.marques.destroy', $marque) }}" onsubmit="return confirm('Supprimer cette marque ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bouton bouton-danger bouton-petit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">Aucune marque pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
