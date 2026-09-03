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
    </div>

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
