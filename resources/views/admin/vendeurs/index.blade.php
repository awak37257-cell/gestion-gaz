@extends('layouts.admin')

@section('titre', 'Vendeurs')

@section('content')
    <div class="entete-page">
        <h1>Vendeurs</h1>
        <a href="{{ route('admin.vendeurs.create') }}" class="bouton bouton-primaire">+ Nouveau vendeur</a>
    </div>

    <div class="carte">
        <table>
            <thead><tr><th>Nom</th><th>Dépôt</th><th>Statut</th><th></th></tr></thead>
            <tbody>
                @forelse ($vendeurs as $vendeur)
                    <tr>
                        <td>{{ $vendeur->nom }}</td>
                        <td>{{ $vendeur->depot->nom }}</td>
                        <td>
                            @if ($vendeur->actif)
                                <span class="badge badge-livree">Actif</span>
                            @else
                                <span class="badge badge-inactif">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.vendeurs.show', $vendeur) }}" class="bouton bouton-secondaire bouton-petit">QR code</a>
                            <a href="{{ route('admin.vendeurs.edit', $vendeur) }}" class="bouton bouton-secondaire bouton-petit">Modifier</a>
                            <form class="inline" method="POST" action="{{ route('admin.vendeurs.destroy', $vendeur) }}" onsubmit="return confirm('Supprimer ce vendeur ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bouton bouton-danger bouton-petit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Aucun vendeur pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
