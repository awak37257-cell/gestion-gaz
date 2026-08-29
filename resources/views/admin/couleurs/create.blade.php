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

    <div class="carte">
        <form method="POST" action="{{ route('admin.couleurs.store') }}">
            @csrf

            <label for="marque_id">Marque</label>
            <select name="marque_id" id="marque_id" required>
                <option value="">— Choisir —</option>
                @foreach ($marques as $marque)
                    <option value="{{ $marque->id }}" @selected(old('marque_id') == $marque->id)>{{ $marque->nom }}</option>
                @endforeach
            </select>
            @error('marque_id')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="nom_couleur">Nom de la couleur</label>
            <input type="text" name="nom_couleur" id="nom_couleur" value="{{ old('nom_couleur') }}" required>
            @error('nom_couleur')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="poids">Poids</label>
            <input type="text" name="poids" id="poids" value="{{ old('poids') }}" placeholder="ex : 12,5kg" required>
            @error('poids')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="prix_unitaire">Prix unitaire (FCFA)</label>
            <input type="number" name="prix_unitaire" id="prix_unitaire" min="0" value="{{ old('prix_unitaire', 0) }}" required>
            @error('prix_unitaire')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire">Créer</button>
            <a href="{{ route('admin.couleurs.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
