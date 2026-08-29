@extends('layouts.admin')

@section('titre', 'Nouvelle couleur')

@section('content')
    <div class="entete-page">
        <h1>Nouvelle couleur</h1>
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
                <label for="nom_couleur">Nom de la couleur</label>
                <input type="text" name="nom_couleur" id="nom_couleur" value="{{ old('nom_couleur') }}" placeholder="ex : Rouge, Bleu, Verte..." required style="max-width: 100%;">
                @error('nom_couleur')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="poids">Poids</label>
                <input type="text" name="poids" id="poids" value="{{ old('poids') }}" placeholder="ex : 6kg ou 12,5kg" required style="max-width: 100%;">
                @error('poids')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label for="prix_unitaire">Prix unitaire (FCFA)</label>
                <input type="number" name="prix_unitaire" id="prix_unitaire" min="0" value="{{ old('prix_unitaire', 0) }}" required style="max-width: 100%;">
                @error('prix_unitaire')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" class="bouton bouton-primaire" style="width: auto; padding: 10px 24px;">Enregistrer</button>
                <a href="{{ route('admin.couleurs.index') }}" class="bouton bouton-secondaire" style="width: auto; padding: 10px 20px; margin-top: 0; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
@endsection