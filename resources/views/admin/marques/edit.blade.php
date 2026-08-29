@extends('layouts.admin')

@section('titre', 'Modifier la marque')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><path d="M2 2h5.5L14 8.5 8.5 14 2 7.5V2z"/><circle cx="5" cy="5" r="0.8" fill="#fff" stroke="none"/></svg>
            </div>
            <h1>Modifier la marque</h1>
        </div>
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
                <button type="submit" class="bouton bouton-primaire" style="width: auto; padding: 10px 24px; margin-top: 0;">Enregistrer</button>
                <a href="{{ route('admin.marques.index') }}" class="bouton bouton-secondaire" style="width: auto; padding: 10px 20px; margin-top: 0; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
@endsection