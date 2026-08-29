@extends('layouts.admin')

@section('titre', 'Modifier la marque')

@section('content')
    <div class="entete-page">
        <h1>Modifier la marque</h1>
    </div>

    <div class="carte" style="max-width: 600px;">
        <form method="POST" action="{{ route('admin.marques.update', $marque) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 24px;">
                <label for="nom">Nom de la marque</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $marque->nom) }}" required style="max-width: 100%;">
                @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" class="bouton bouton-primaire" style="width: auto; padding: 10px 24px;">Mettre à jour</button>
                <a href="{{ route('admin.marques.index') }}" class="bouton bouton-secondaire" style="width: auto; padding: 10px 20px; margin-top: 0; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
@endsection