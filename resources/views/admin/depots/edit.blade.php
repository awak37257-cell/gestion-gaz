@extends('layouts.admin')

@section('titre', 'Modifier le dépôt')

@section('content')
    <div class="entete-page"><h1>Modifier le dépôt</h1></div>

    <div class="carte">
        <form method="POST" action="{{ route('admin.depots.update', $depot) }}">
            @csrf
            @method('PUT')

            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $depot->nom) }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="localisation">Localisation</label>
            <input type="text" name="localisation" id="localisation" value="{{ old('localisation', $depot->localisation) }}">
            @error('localisation')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire">Enregistrer</button>
            <a href="{{ route('admin.depots.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
