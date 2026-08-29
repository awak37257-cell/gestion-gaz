@extends('layouts.vendeur')

@section('titre', 'Inventaire')

@section('content')
    <p style="font-size:13px;color:var(--couleur-texte-clair);">
        Compte physiquement les bouteilles pour chaque couleur. Le stock théorique est indiqué à titre de repère.
    </p>

    <form method="POST" action="{{ route('vendeur.inventaires.store') }}">
        @csrf

        @foreach ($stocks as $stock)
            <div class="carte">
                <strong>{{ $stock->couleur->nomComplet() }}</strong>
                <p style="font-size:12px;color:var(--couleur-texte-clair);margin:4px 0 12px;">
                    Stock théorique : {{ $stock->quantite_pleines }} pleines / {{ $stock->quantite_vides }} vides
                </p>

                <input type="hidden" name="comptes[{{ $loop->index }}][couleur_id]" value="{{ $stock->couleur_id }}">

                <label for="pleines_{{ $stock->couleur_id }}">Bouteilles pleines comptées</label>
                <input
                    type="number"
                    name="comptes[{{ $loop->index }}][quantite_pleines_comptee]"
                    id="pleines_{{ $stock->couleur_id }}"
                    min="0"
                    inputmode="numeric"
                    value="{{ old('comptes.' . $loop->index . '.quantite_pleines_comptee', $stock->quantite_pleines) }}"
                    required
                >

                <label for="vides_{{ $stock->couleur_id }}">Bouteilles vides comptées</label>
                <input
                    type="number"
                    name="comptes[{{ $loop->index }}][quantite_vides_comptee]"
                    id="vides_{{ $stock->couleur_id }}"
                    min="0"
                    inputmode="numeric"
                    value="{{ old('comptes.' . $loop->index . '.quantite_vides_comptee', $stock->quantite_vides) }}"
                    required
                >
            </div>
        @endforeach

        <button type="submit" class="bouton bouton-primaire">Valider l'inventaire</button>
    </form>

    <a href="{{ route('vendeur.dashboard') }}" class="lien-retour">← Retour au tableau de bord</a>
@endsection
