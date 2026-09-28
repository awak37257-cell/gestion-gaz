@extends('layouts.vendeur')

@section('titre', 'Nouvelle vente')

@section('content')
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
        <div style="width:38px;height:38px;border-radius:50%;background:var(--degrade-primaire);box-shadow:0 2px 6px rgba(122,59,62,0.22);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.6"><path d="M3 17l5-5 4 4 8-9"/><path d="M15 7h5v5"/></svg>
        </div>
        <h2 style="margin:0;font-size:17px;">Nouvelle vente</h2>
    </div>

    <div class="carte carte-accent">
    <form method="POST" action="{{ route('vendeur.ventes.store', ['tokenQr' => request()->route('tokenQr')]) }}">
        @csrf

        <label for="couleur_vendue_id">Couleur vendue (Type & Couleur)</label>
        <select name="couleur_vendue_id" id="couleur_vendue_id" required>
            <option value="">— Choisir —</option>
            @foreach ($couleurs as $couleur)
                <option value="{{ $couleur->id }}" data-type="{{ $couleur->type }}" @selected(old('couleur_vendue_id') == $couleur->id)>
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

        <label style="margin-top: 15px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
            <input type="checkbox" name="changement_effectue" id="changement_effectue" value="1" @checked(old('changement_effectue'))>
            <span>Un changement a été effectué ? (Le client a ramené une autre couleur/type)</span>
        </label>

        <div id="bloc_couleur_demandee" style="display:none; margin-top: 15px; padding: 12px; background: #f9f9f9; border-radius: 6px; border: 1px dashed #ccc;">
            <label for="couleur_demandee_id">Couleur/Type ramené initialement par le client</label>
            <select name="couleur_demandee_id" id="couleur_demandee_id">
                <option value="">— Choisir la bouteille ramenée —</option>
                @foreach ($couleurs as $couleur)
                    <option value="{{ $couleur->id }}" data-type="{{ $couleur->type }}" @selected(old('couleur_demandee_id') == $couleur->id)>
                        {{ $couleur->nomComplet() }}
                    </option>
                @endforeach
            </select>
            <small style="display: block; margin-top: 5px; color: #666;" id="alerte_type"></small>
        </div>
        @error('couleur_demandee_id')
            <div class="erreur-champ">{{ $message }}</div>
        @enderror

        <button type="submit" class="bouton bouton-primaire" style="margin-top: 20px;">Valider la vente</button>
    </form>
    </div>

    <a href="{{ route('vendeur.dashboard') }}" class="lien-retour">← Retour au tableau de bord</a>

    <script>
        const caseChangement = document.getElementById('changement_effectue');
        const blocCouleurDemandee = document.getElementById('bloc_couleur_demandee');
        const selectVendue = document.getElementById('couleur_vendue_id');
        const selectDemandee = document.getElementById('couleur_demandee_id');
        const alerteType = document.getElementById('alerte_type');

        function actualiserAffichage() {
            if (caseChangement.checked) {
                blocCouleurDemandee.style.display = 'block';
                selectDemandee.setAttribute('required', 'required');
            } else {
                blocCouleurDemandee.style.display = 'none';
                selectDemandee.removeAttribute('required');
                selectDemandee.value = ''; // Réinitialiser si décoché
                alerteType.textContent = '';
            }
        }

        // Vérification optionnelle pour guider le vendeur sur le type
        function verifierCohérenceType() {
            const optionVendue = selectVendue.options[selectVendue.selectedIndex];
            const optionDemandee = selectDemandee.options[selectDemandee.selectedIndex];

            if (optionVendue.value && optionDemandee.value) {
                const typeVendu = optionVendue.getAttribute('data-type');
                const typeDemande = optionDemandee.getAttribute('data-type');

                if (typeVendu !== typeDemande) {
                    alerteType.style.color = '#d9534f';
                    alerteType.textContent = '⚠️ Attention : Le type de la bouteille ramenée (' + typeDemande + ') est différent de la vendue (' + typeVendu + '). Vérifiez s\'il s\'agit bien d\'un échange valide.';
                } else {
                    alerteType.style.color = '#5cb85c';
                    alerteType.textContent = '✓ Les types correspondent (' + typeVendu + ').';
                }
            } else {
                alerteType.textContent = '';
            }
        }

        caseChangement.addEventListener('change', actualiserAffichage);
        selectVendue.addEventListener('change', verifierCohérenceType);
        selectDemandee.addEventListener('change', verifierCohérenceType);

        // Exécuter au chargement au cas où old() est présent
        actualiserAffichage();
        verifierCohérenceType();
    </script>
@endsection