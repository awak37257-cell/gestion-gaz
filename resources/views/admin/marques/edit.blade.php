@extends('layouts.admin')

@section('titre', 'Modifier la marque')

@section('content')
    <div class="entete-page"><h1>Modifier la marque</h1></div>

    <div class="carte">
        <form method="POST" action="{{ route('admin.marques.update', $marque) }}">
            @csrf
            @method('PUT')
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $marque->nom) }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire">Enregistrer</button>
            <a href="{{ route('admin.marques.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
