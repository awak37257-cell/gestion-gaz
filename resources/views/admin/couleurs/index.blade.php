@extends('layouts.admin')

@section('titre', 'Couleurs')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="8" r="6.2"/><circle cx="8" cy="5.3" r="0.9" fill="#fff" stroke="none"/><circle cx="5.3" cy="9.5" r="0.9" fill="#fff" stroke="none"/><circle cx="10.7" cy="9.5" r="0.9" fill="#fff" stroke="none"/></svg>
            </div>
            <h1>Couleurs</h1>
        </div>
        <a href="{{ route('admin.couleurs.create') }}" class="bouton bouton-primaire">+ Nouvelle couleur</a>
    </div>

    @forelse ($marques as $marque)
        <div class="carte">
            <h3 style="margin-top:0;">{{ $marque->nom }}</h3>
            <table>
                <thead><tr><th>Couleur</th><th>Poids</th><th></th></tr></thead>
                <tbody>
                    @forelse ($marque->couleurs as $couleur)
                        <tr>
                            <td>{{ $couleur->nom_couleur }}</td>
                            <td>{{ $couleur->poids }}</td>
                            <td>
                                <a href="{{ route('admin.couleurs.edit', $couleur) }}" class="bouton bouton-secondaire bouton-petit">Modifier</a>
                                <form class="inline" method="POST" action="{{ route('admin.couleurs.destroy', $couleur) }}" onsubmit="return confirm('Supprimer cette couleur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bouton bouton-danger bouton-petit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3">Aucune couleur pour cette marque.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @empty
        <div class="carte">Aucune marque créée pour le moment.</div>
    @endforelse
@endsection
