@extends('layouts.vendeur')

@section('titre', 'Inventaire')

@section('content')
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
        <div style="width:38px;height:38px;border-radius:50%;background:var(--degrade-primaire);box-shadow:0 2px 6px rgba(122,59,62,0.22);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke="#fff" stroke-width="1.4"><rect x="2.5" y="2" width="11" height="12" rx="0.5"/><path d="M5 6.5l1 1 2-2M5 11l1 1 2-2"/><path d="M10 6.5h3M10 11h3"/></svg>
        </div>
        <h2 style="margin:0;font-size:17px;">Inventaire</h2>
    </div>

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
