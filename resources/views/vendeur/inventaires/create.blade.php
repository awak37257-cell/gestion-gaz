@extends('layouts.vendeur')

@section('titre', 'Inventaire')

@section('content')
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
        <div style="width:38px;height:38px;border-radius:50%;background:var(--degrade-primaire);box-shadow:0 2px 6px rgba(122,59,62,0.22);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke="#fff" stroke-width="1.4"><rect x="2.5" y="2" width="11" height="12" rx="0.5"/><path d="M5 6.5l1 1 2-2M5 11l1 1 2-2"/><path d="M10 6.5h3M10 11h3"/></svg>
        </div>
        <h2 style="margin:0;font-size:17px;">Inventaire</h2>
    </div>

    <p style="font-size:13px;color:var(--couleur-texte-clair);margin-bottom:16px;">
        Compte physiquement les bouteilles pour chaque couleur. Le stock théorique est indiqué à titre de repère.
    </p>

    <!-- FILTRES : Marque et Type -->
    <div class="carte" style="margin-bottom: 16px; background: rgba(0,0,0,0.02);">
        <label for="filtre_marque">Filtrer par Marque</label>
        <select id="filtre_marque" style="margin-bottom: 10px;">
            <option value="">— Toutes les marques —</option>
            @foreach ($marques as $marque)
                <option value="{{ $marque->id }}">{{ $marque->nom }}</option>
            @endforeach
        </select>

        <label for="filtre_type">Filtrer par Type</label>
        <select id="filtre_type">
            <option value="">— Choisir d'abord une marque —</option>
        </select>
    </div>

    <form method="POST" action="{{ route('vendeur.inventaires.store') }}">
        @csrf

        <div id="liste-stocks">
            @foreach ($stocks as $stock)
                <div class="carte stock-item" 
                     data-marque-id="{{ $stock->couleur->marque_id ?? '' }}" 
                     data-type="{{ $stock->couleur->type ?? '' }}">
                    
                    <!-- Affichage clair : Marque - Couleur - Type -->
                    <strong style="font-size: 15px; display: block; margin-bottom: 4px;">
                        {{ optional($stock->couleur->marque)->nom ?? 'Marque' }} — {{ $stock->couleur->nom_couleur }} 
                        <span style="font-size: 12px; font-weight: normal; color: var(--couleur-texte-clair);">({{ $stock->couleur->type }})</span>
                    </strong>

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
        </div>

        <button type="submit" class="bouton bouton-primaire" style="margin-top: 10px;">Valider l'inventaire</button>
    </form>

    <a href="{{ route('vendeur.dashboard') }}" class="lien-retour" style="margin-top: 15px; display: inline-block;">← Retour au tableau de bord</a>

    <script>
    // Injection des données des marques et de leurs types respectifs
    const marquesData = @json($marques->mapWithKeys(function ($marque) {
        return [
            $marque->id => $marque->couleurs->pluck('type')->unique()->values()
        ];
    }));

    const selectFiltreMarque = document.getElementById('filtre_marque');
    const selectFiltreType = document.getElementById('filtre_type');
    const stockItems = document.querySelectorAll('.stock-item');

    function mettreAJourTypes() {
        const marqueId = selectFiltreMarque.value;
        selectFiltreType.innerHTML = '<option value="">— Tous les types —</option>';

        if (marqueId && marquesData[marqueId]) {
            marquesData[marqueId].forEach(type => {
                const opt = document.createElement('option');
                opt.value = type;
                opt.textContent = type;
                selectFiltreType.appendChild(opt);
            });
        } else if (!marqueId) {
            selectFiltreType.innerHTML = '<option value="">— Choisir d\'abord une marque —</option>';
        }
        filtrerAffichage();
    }

    function filtrerAffichage() {
        const marqueId = selectFiltreMarque.value;
        const typeSelectionne = selectFiltreType.value;

        stockItems.forEach(item => {
            const itemMarqueId = item.getAttribute('data-marque-id');
            const itemType = item.getAttribute('data-type');

            let correspondMarque = !marqueId || itemMarqueId === marqueId;
            let correspondType = !typeSelectionne || itemType === typeSelectionne;

            if (correspondMarque && correspondType) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    selectFiltreMarque.addEventListener('change', mettreAJourTypes);
    selectFiltreType.addEventListener('change', filtrerAffichage);
    </script>
@endsection