@extends('layouts.admin')

@section('titre', 'Nouvelle couleur')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="8" r="6.2"/><circle cx="8" cy="5.3" r="0.9" fill="#fff" stroke="none"/><circle cx="5.3" cy="9.5" r="0.9" fill="#fff" stroke="none"/><circle cx="10.7" cy="9.5" r="0.9" fill="#fff" stroke="none"/></svg>
            </div>
            <h1>Nouvelle couleur</h1>
        </div>
    </div>

    <div class="carte" style="max-width: 600px;">
        <form method="POST" action="{{ route('admin.couleurs.store') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="marque_id">Marque</label>
                <select name="marque_id" id="marque_id" required style="max-width: 100%;">
                    <option value="">— Choisir —</option>
                    @foreach ($marques as $marque)
                        <option value="{{ $marque->id }}" @selected(old('marque_id') == $marque->id)>{{ $marque->nom }}</option>
                    @endforeach
                </select>
                @error('marque_id')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="type">Type (ex : B6, B12)</label>
                <input type="text" name="type" id="type" value="{{ old('type') }}" placeholder="ex : B6" required style="max-width: 100%;">
                @error('type')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="nom_couleur">Nom de la couleur</label>
                <input type="text" name="nom_couleur" id="nom_couleur" value="{{ old('nom_couleur') }}" required style="max-width: 100%;">
                @error('nom_couleur')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="poids">Poids</label>
                <input type="text" name="poids" id="poids" value="{{ old('poids') }}" placeholder="ex : 12,5kg" required style="max-width: 100%;">
                @error('poids')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="prix_unitaire">Prix unitaire (FCFA)</label>
                <input type="number" name="prix_unitaire" id="prix_unitaire" min="0" value="{{ old('prix_unitaire', 0) }}" required style="max-width: 100%;">
                @error('prix_unitaire')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

            <h3 style="margin-bottom: 12px; font-size: 1rem;">Stock initial</h3>

            <div style="margin-bottom: 16px;">
                <label for="depot_id">Dépôt de stockage initial</label>
                <select name="depot_id" id="depot_id" required style="max-width: 100%;">
                    <option value="">— Choisir un dépôt —</option>
                    @foreach ($depots as $depot)
                        <option value="{{ $depot->id }}" @selected(old('depot_id') == $depot->id)>{{ $depot->nom }}</option>
                    @endforeach
                </select>
                @error('depot_id')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div>
                    <label for="quantite_pleines">Bouteilles pleines</label>
                    <input type="number" name="quantite_pleines" id="quantite_pleines" min="0" value="{{ old('quantite_pleines', 0) }}" required style="max-width: 100%;">
                    @error('quantite_pleines')<div class="erreur-champ">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="quantite_vides">Bouteilles vides</label>
                    <input type="number" name="quantite_vides" id="quantite_vides" min="0" value="{{ old('quantite_vides', 0) }}" required style="max-width: 100%;">
                    @error('quantite_vides')<div class="erreur-champ">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" class="bouton bouton-primaire" style="width: auto; padding: 10px 24px; margin-top: 0;">Créer</button>
                <a href="{{ route('admin.couleurs.index') }}" class="bouton bouton-secondaire" style="width: auto; padding: 10px 20px; margin-top: 0; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
@endsection