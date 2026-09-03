@extends('layouts.vendeur')

@section('titre', "Nouvelle demande")

@section('content')
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
        <div style="width:38px;height:38px;border-radius:50%;background:var(--degrade-primaire);box-shadow:0 2px 6px rgba(122,59,62,0.22);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.6"><path d="M6 3h9l3 3v14.5H6V3z"/><path d="M9 9h6M9 12.5h6M9 16h4"/></svg>
        </div>
        <h2 style="margin:0;font-size:17px;">Nouvelle demande</h2>
    </div>

    <div class="carte carte-accent">
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
    </div>

    <a href="{{ route('vendeur.dashboard') }}" class="lien-retour">← Retour au tableau de bord</a>

    <script>
    const couleursParMarque = @json($marques->mapWithKeys(function ($marque) {
        return [
            $marque->id => $marque->couleurs->map(function ($couleur) {
                return [
                    'id' => $couleur->id,
                    'label' => $couleur->nom_couleur . ' (' . $couleur->poids . ')',
                ];
            })
        ];
    }));

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

    if (selectMarque) {
        selectMarque.addEventListener('change', actualiserCouleurs);
        if (selectMarque.value) {
            actualiserCouleurs();
        }
    }
</script>
@endsection
