@extends('layouts.admin')

@section('titre', 'Modifier le dépôt')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><path d="M1.5 6.5L8 2l6.5 4.5V14h-13V6.5z"/><path d="M6 14V9h4v5"/></svg>
            </div>
            <h1>Modifier le dépôt</h1>
        </div>
    </div>

    <div class="carte" style="max-width: 600px;">
        <form method="POST" action="{{ route('admin.depots.update', $depot) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 16px;">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $depot->nom) }}" required style="max-width: 100%;">
                @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label for="localisation">Localisation</label>
                <input type="text" name="localisation" id="localisation" value="{{ old('localisation', $depot->localisation) }}" style="max-width: 100%;">
                @error('localisation')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" class="bouton bouton-primaire" style="width: auto; padding: 10px 24px; margin-top: 0;">Enregistrer</button>
                <a href="{{ route('admin.depots.index') }}" class="bouton bouton-secondaire" style="width: auto; padding: 10px 20px; margin-top: 0; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
@endsection