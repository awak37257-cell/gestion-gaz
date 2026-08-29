@extends('layouts.vendeur')

@section('titre', "Nouvelle demande")

@section('content')
    <form method="POST" action="{{ route('vendeur.demandes.store') }}">
        @csrf

        <label for="marque_id">Marque</label>
        <select name="marque_id" id="marque_id" required>
            <option value="">— Choisir —</option>
            @foreach ($marques as $marque)
                <option value="{{ $marque->id }}" @selected(old('marque_id') == $marque->id)>{{ $marque->nom }}</option>
            @endforeach
        </select>
        @error('marque_id')
            <div class="erreur-champ">{{ $message }}</div>
        @enderror

        <label for="couleur_id">Couleur</label>
        <select name="couleur_id" id="couleur_id" required>
            <option value="">— Choisir une marque d'abord —</option>
        </select>
        @error('couleur_id')
            <div class="erreur-champ">{{ $message }}</div>
        @enderror

        <label for="quantite_demandee">Quantité demandée</label>
        <input type="number" name="quantite_demandee" id="quantite_demandee" min="1" value="{{ old('quantite_demandee', 1) }}" inputmode="numeric" required>
        @error('quantite_demandee')
            <div class="erreur-champ">{{ $message }}</div>
        @enderror

        <button type="submit" class="bouton bouton-primaire">Envoyer la demande</button>
    </form>

    <a href="{{ route('vendeur.dashboard') }}" class="lien-retour">← Retour au tableau de bord</a>

    <script>
        const couleursParMarque = @json($marques->mapWithKeys(fn ($marque) => [
            $marque->id => $marque->couleurs->map(fn ($couleur) => [
                'id' => $couleur->id,
                'label' => "{$couleur->nom_couleur} ({$couleur->poids})",
            ]),
        ]));

        const selectMarque = document.getElementById('marque_id');
        const selectCouleur = document.getElementById('couleur_id');

        function actualiserCouleurs() {
            const couleurs = couleursParMarque[selectMarque.value] ?? [];
            selectCouleur.innerHTML = '<option value="">— Choisir —</option>';
            couleurs.forEach(function (couleur) {
                const option = document.createElement('option');
                option.value = couleur.id;
                option.textContent = couleur.label;
                selectCouleur.appendChild(option);
            });
        }

        selectMarque.addEventListener('change', actualiserCouleurs);
        if (selectMarque.value) {
            actualiserCouleurs();
        }
    </script>
@endsection