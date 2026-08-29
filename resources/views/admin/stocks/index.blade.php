@extends('layouts.admin')

@section('titre', 'Stocks')

@section('content')
    <div class="entete-page"><h1>Stocks</h1></div>

    <div class="carte">
        <form method="GET" action="{{ route('admin.stocks.index') }}" style="margin-bottom:16px;">
            <label for="depot_id">Dépôt</label>
            <select name="depot_id" id="depot_id" onchange="this.form.submit()">
                @foreach ($depots as $depot)
                    <option value="{{ $depot->id }}" @selected($depotSelectionne == $depot->id)>{{ $depot->nom }}</option>
                @endforeach
            </select>
        </form>

        <table>
            <thead><tr><th>Couleur</th><th>Pleines</th><th>Vides</th><th></th></tr></thead>
            <tbody>
                @forelse ($stocks as $stock)
                    <tr>
                        <td>{{ $stock->couleur->nomComplet() }}</td>
                        <td>
                            <input type="number" name="quantite_pleines" form="form-stock-{{ $stock->id }}" value="{{ $stock->quantite_pleines }}" min="0" style="max-width:100px;margin-bottom:0;">
                        </td>
                        <td>
                            <input type="number" name="quantite_vides" form="form-stock-{{ $stock->id }}" value="{{ $stock->quantite_vides }}" min="0" style="max-width:100px;margin-bottom:0;">
                        </td>
                        <td>
                            <button type="submit" form="form-stock-{{ $stock->id }}" class="bouton bouton-secondaire bouton-petit">Ajuster</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Aucune couleur en stock pour ce dépôt.</td></tr>
                @endforelse
            </tbody>
        </table>
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
