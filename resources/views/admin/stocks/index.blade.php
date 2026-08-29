@extends('layouts.admin')

@section('titre', 'Stocks')

@section('content')
    <div class="entete-page">
        <h1>Stocks</h1>
    </div>

    <div class="carte">
        {{-- Formulaire de filtre par dépôt --}}
        <form method="GET" action="{{ route('admin.stocks.index') }}" style="margin-bottom: 24px; background: var(--couleur-fond); padding: 16px; border-radius: 6px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <label for="depot_id" style="margin-bottom: 0; font-weight: 600;">Filtrer par dépôt :</label>
            <select name="depot_id" id="depot_id" onchange="this.form.submit()" style="max-width: 300px; margin-bottom: 0;">
                @foreach ($depots as $depot)
                    <option value="{{ $depot->id }}" @selected($depotSelectionne == $depot->id)>{{ $depot->nom }}</option>
                @endforeach
            </select>
        </form>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Couleur</th>
                        <th>Pleines</th>
                        <th>Vides</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocks as $stock)
                        <tr style="transition: background 0.15s;">
                            <td style="font-weight: 500;">{{ $stock->couleur->nomComplet() }}</td>
                            <td>
                                <input type="number" name="quantite_pleines" form="form-stock-{{ $stock->id }}" value="{{ $stock->quantite_pleines }}" min="0" style="max-width: 110px; margin-bottom: 0; padding: 6px 10px;">
                            </td>
                            <td>
                                <input type="number" name="quantite_vides" form="form-stock-{{ $stock->id }}" value="{{ $stock->quantite_vides }}" min="0" style="max-width: 110px; margin-bottom: 0; padding: 6px 10px;">
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <button type="submit" form="form-stock-{{ $stock->id }}" class="bouton bouton-secondaire bouton-petit" style="cursor: pointer;">Ajuster</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--couleur-texte-clair); padding: 32px;">
                                Aucune couleur en stock pour ce dépôt.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Un <form> par ligne, relié via l'attribut form="..." sur les champs --}}
    @foreach ($stocks as $stock)
        <form id="form-stock-{{ $stock->id }}" method="POST" action="{{ route('admin.stocks.update', $stock) }}">
            @csrf
            @method('PATCH')
        </form>
    @endforeach
@endsection