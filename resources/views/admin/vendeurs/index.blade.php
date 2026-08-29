@extends('layouts.admin')

@section('titre', 'Vendeurs')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
            </div>
            <h1>Vendeurs</h1>
        </div>
        <a href="{{ route('admin.vendeurs.create') }}" class="bouton bouton-primaire">+ Nouveau vendeur</a>
    </div>

    <div class="carte">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Dépôt</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vendeurs as $vendeur)
                        <tr style="transition: background 0.15s;">
                            <td style="font-weight: 600;">{{ $vendeur->nom }}</td>
                            <td style="color: var(--couleur-texte-clair);">{{ $vendeur->depot->nom }}</td>
                            <td>
                                @if ($vendeur->actif)
                                    <span class="badge badge-livree">Actif</span>
                                @else
                                    <span class="badge badge-inactif">Inactif</span>
                                @endif
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="{{ route('admin.vendeurs.show', $vendeur) }}" class="bouton bouton-secondaire bouton-petit" style="margin-right: 4px; text-decoration: none;">QR code</a>
                                <a href="{{ route('admin.vendeurs.edit', $vendeur) }}" class="bouton bouton-secondaire bouton-petit" style="margin-right: 4px; text-decoration: none;">Modifier</a>
                                <form class="inline" method="POST" action="{{ route('admin.vendeurs.destroy', $vendeur) }}" onsubmit="return confirm('Supprimer ce vendeur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bouton bouton-danger bouton-petit" style="background: var(--couleur-danger); border: none; cursor: pointer;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
                                Aucun vendeur pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection