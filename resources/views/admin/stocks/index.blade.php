@extends('layouts.admin')

@section('titre', 'Stocks')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><rect x="1.5" y="8.5" width="5.5" height="5.5"/><rect x="9" y="8.5" width="5.5" height="5.5"/><rect x="5.2" y="2" width="5.5" height="5.5"/></svg>
            </div>
            <h1>Stocks</h1>
        </div>
    </div>

    <div class="carte">
        <form method="GET" action="{{ route('admin.stocks.index') }}" style="margin-bottom: 20px; max-width: 400px;">
            <label for="depot_id" style="font-weight: 500; margin-bottom: 6px; display: block;">Filtrer par dépôt</label>
            <select name="depot_id" id="depot_id" onchange="this.form.submit()" style="max-width: 100%;">
                @foreach ($depots as $depot)
                    <option value="{{ $depot->id }}" @selected($depotSelectionne == $depot->id)>{{ $depot->nom }}</option>
                @endforeach
            </select>
        </form>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Type / Couleur</th>
                        <th>Pleines</th>
                        <th>Vides</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocks as $stock)
                        <tr style="transition: background 0.15s;">
                            <td style="font-weight: 500;">{{ $stock->couleur->nomComplet() }}</td>
                            <td>
                                <input type="number" name="quantite_pleines" form="form-stock-{{ $stock->id }}" value="{{ $stock->quantite_pleines }}" min="0" style="max-width: 110px; margin-bottom: 0;">
                            </td>
                            <td>
                                <input type="number" name="quantite_vides" form="form-stock-{{ $stock->id }}" value="{{ $stock->quantite_vides }}" min="0" style="max-width: 110px; margin-bottom: 0;">
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

    {{-- Un <form> par ligne, déclaré hors du tableau et relié via l'attribut
         form="..." sur les champs : un <form> ne peut pas être enfant direct
         d'un <tr>, sinon le navigateur le déplace hors du tableau. --}}
    @foreach ($stocks as $stock)
        <form id="form-stock-{{ $stock->id }}" method="POST" action="{{ route('admin.stocks.update', $stock) }}">
            @csrf
            @method('PATCH')
        </form>
    @endforeach
@endsection