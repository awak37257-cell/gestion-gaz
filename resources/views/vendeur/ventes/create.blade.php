@extends('layouts.vendeur')

@section('titre', 'Nouvelle vente')

@section('content')
    <form method="POST" action="{{ route('vendeur.ventes.store') }}">
        @csrf

        <label for="couleur_vendue_id">Couleur vendue</label>
        <select name="couleur_vendue_id" id="couleur_vendue_id" required>
            <option value="">— Choisir —</option>
            @foreach ($couleurs as $couleur)
                <option value="{{ $couleur->id }}" @selected(old('couleur_vendue_id') == $couleur->id)>
                    {{ $couleur->nomComplet() }}
                </option>
            @endforeach
        </select>
        @error('couleur_vendue_id')
            <div class="erreur-champ">{{ $message }}</div>
        @enderror

        <label for="quantite">Quantité</label>
        <input type="number" name="quantite" id="quantite" min="1" value="{{ old('quantite', 1) }}" inputmode="numeric" required>
        @error('quantite')
            <div class="erreur-champ">{{ $message }}</div>
        @enderror

        <label>
            <input type="checkbox" name="changement_effectue" id="changement_effectue" value="1" @checked(old('changement_effectue'))>
            Un changement a été effectué ?
        </label>

        <div id="bloc_couleur_demandee" style="display:none;">
            <label for="couleur_demandee_id">Couleur demandée initialement par le client</label>
            <select name="couleur_demandee_id" id="couleur_demandee_id">
                <option value="">— Choisir —</option>
                @foreach ($couleurs as $couleur)
                    <option value="{{ $couleur->id }}" @selected(old('couleur_demandee_id') == $couleur->id)>
                        {{ $couleur->nomComplet() }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('couleur_demandee_id')
            <div class="erreur-champ">{{ $message }}</div>
        @enderror

        <button type="submit" class="bouton bouton-primaire">Valider la vente</button>
    </form>

    <a href="{{ route('vendeur.dashboard') }}" class="lien-retour">← Retour au tableau de bord</a>

    <script>
        const caseChangement = document.getElementById('changement_effectue');
        const blocCouleurDemandee = document.getElementById('bloc_couleur_demandee');

        function actualiserAffichage() {
            blocCouleurDemandee.style.display = caseChangement.checked ? 'block' : 'none';
        }

        caseChangement.addEventListener('change', actualiserAffichage);
        actualiserAffichage();
    </script>
@endsection