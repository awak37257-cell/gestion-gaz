@extends('layouts.admin')

@section('titre', 'Nouveau dépôt')

@section('content')
    <div class="entete-page"><h1>Nouveau dépôt</h1></div>

    <div class="carte">
        <form method="POST" action="{{ route('admin.depots.store') }}">
            @csrf

            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="localisation">Localisation</label>
            <input type="text" name="localisation" id="localisation" value="{{ old('localisation') }}">
            @error('localisation')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire">Créer</button>
            <a href="{{ route('admin.depots.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
