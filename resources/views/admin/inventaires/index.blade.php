@extends('layouts.admin')

@section('titre', 'Inventaires')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><rect x="2.5" y="2" width="11" height="12" rx="0.5"/><path d="M5 6.5l1 1 2-2M5 11l1 1 2-2"/><path d="M10 6.5h3M10 11h3"/></svg>
            </div>
            <h1>Inventaires</h1>
        </div>
    </div>

    @forelse ($inventaires as $inventaire)
        <div class="carte">
            <h3 style="margin-top:0;">{{ $inventaire->vendeur->nom }} — {{ $inventaire->vendeur->depot->nom }}</h3>
            <p style="font-size:13px;color:var(--couleur-texte-clair);">{{ $inventaire->date_heure->format('d/m/Y H:i') }}</p>

            <table>
                <thead>
                    <tr><th>Couleur</th><th>Pleines (compté / théo.)</th><th>Vides (compté / théo.)</th><th>Écart</th></tr>
                </thead>
                <tbody>
                    @foreach ($inventaire->lignes as $ligne)
                        <tr>
                            <td>{{ $ligne->couleur->nomComplet() }}</td>
                            <td>{{ $ligne->quantite_pleines_comptee }} / {{ $ligne->quantite_pleines_theorique }}</td>
                            <td>{{ $ligne->quantite_vides_comptee }} / {{ $ligne->quantite_vides_theorique }}</td>
                            <td>
                                @if ($ligne->ecartPleines() !== 0 || $ligne->ecartVides() !== 0)
                                    <span class="badge badge-attente">
                                        {{ $ligne->ecartPleines() > 0 ? '+' : '' }}{{ $ligne->ecartPleines() }}P /
                                        {{ $ligne->ecartVides() > 0 ? '+' : '' }}{{ $ligne->ecartVides() }}V
                                    </span>
                                @else
                                    <span class="badge badge-livree">OK</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div class="carte">Aucun inventaire enregistré pour le moment.</div>
    @endforelse
@endsection
