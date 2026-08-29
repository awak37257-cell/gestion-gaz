@extends('layouts.admin')

@section('titre', 'Modifier la couleur')

@section('content')
    <div class="entete-page"><h1>Modifier la couleur</h1></div>

    <div class="carte">
        <form method="POST" action="{{ route('admin.couleurs.update', $couleur) }}">
            @csrf
            @method('PUT')

            <label for="marque_id">Marque</label>
            <select name="marque_id" id="marque_id" required>
                @foreach ($marques as $marque)
                    <option value="{{ $marque->id }}" @selected(old('marque_id', $couleur->marque_id) == $marque->id)>{{ $marque->nom }}</option>
                @endforeach
            </select>
            @error('marque_id')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="nom_couleur">Nom de la couleur</label>
            <input type="text" name="nom_couleur" id="nom_couleur" value="{{ old('nom_couleur', $couleur->nom_couleur) }}" required>
            @error('nom_couleur')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="poids">Poids</label>
            <input type="text" name="poids" id="poids" value="{{ old('poids', $couleur->poids) }}" required>
            @error('poids')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="prix_unitaire">Prix unitaire (FCFA)</label>
            <input type="number" name="prix_unitaire" id="prix_unitaire" min="0" value="{{ old('prix_unitaire', $couleur->prix_unitaire) }}" required>
            @error('prix_unitaire')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire">Enregistrer</button>
            <a href="{{ route('admin.couleurs.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
