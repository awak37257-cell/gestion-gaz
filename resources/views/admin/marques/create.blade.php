@extends('layouts.admin')

@section('titre', 'Nouvelle marque')

@section('content')
    <div class="entete-page"><h1>Nouvelle marque</h1></div>

    <div class="carte">
        <form method="POST" action="{{ route('admin.marques.store') }}">
            @csrf
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire">Créer</button>
            <a href="{{ route('admin.marques.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
