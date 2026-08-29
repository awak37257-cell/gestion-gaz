@extends('layouts.admin')

@section('titre', 'Inventaires')

@section('content')
    <div class="entete-page">
        <h1>Inventaires</h1>
    </div>

    @forelse ($inventaires as $inventaire)
        <div class="carte">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                <div>
                    <h3 style="margin: 0; font-size: 16px; color: #112719;">
                        {{ $inventaire->vendeur->nom }} <span style="font-weight: normal; color: var(--couleur-texte-clair);">({{ $inventaire->vendeur->depot->nom }})</span>
                    </h3>
                </div>
                <div>
                    <span style="font-size: 12px; font-weight: 500; background: var(--couleur-fond); padding: 4px 8px; border-radius: 4px; color: var(--couleur-texte-clair);">
                        📅 {{ $inventaire->date_heure->format('d/m/Y à H:i') }}
                    </span>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Couleur</th>
                            <th>Pleines (compté / théo.)</th>
                            <th>Vides (compté / théo.)</th>
                            <th>Écart</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaire->lignes as $ligne)
                            <tr style="transition: background 0.15s;">
                                <td style="font-weight: 500;">{{ $ligne->couleur->nomComplet() }}</td>
                                <td>
                                    <span style="font-weight: 600;">{{ $ligne->quantite_pleines_comptee }}</span> 
                                    <span style="color: var(--couleur-texte-clair); font-size: 12px;">/ {{ $ligne->quantite_pleines_theorique }}</span>
                                </td>
                                <td>
                                    <span style="font-weight: 600;">{{ $ligne->quantite_vides_comptee }}</span> 
                                    <span style="color: var(--couleur-texte-clair); font-size: 12px;">/ {{ $ligne->quantite_vides_theorique }}</span>
                                </td>
                                <td>
                                    @if ($ligne->ecartPleines() !== 0 || $ligne->ecartVides() !== 0)
                                        <span class="badge badge-attente" style="font-weight: 600;">
                                            {{ $ligne->ecartPleines() > 0 ? '+' : '' }}{{ $ligne->ecartPleines() }}P /
                                            {{ $ligne->ecartVides() > 0 ? '+' : '' }}{{ $ligne->ecartVides() }}V
                                        </span>
                                    @else
                                        <span class="badge badge-livree" style="font-weight: 600;">OK</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="carte" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
            Aucun inventaire enregistré pour le moment.
        </div>
    @endforelse
@endsection