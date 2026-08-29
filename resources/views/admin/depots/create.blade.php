@extends('layouts.admin')

@section('titre', 'Nouveau dépôt')

@section('content')
    <div class="entete-page">
        <h1>Nouveau dépôt</h1>
    </div>

    <div class="carte" style="max-width: 600px;">
        <form method="POST" action="{{ route('admin.depots.store') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" placeholder="ex : Dépôt Central Yopougon" required style="max-width: 100%;">
                @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label for="localisation">Localisation</label>
                <input type="text" name="localisation" id="localisation" value="{{ old('localisation') }}" placeholder="ex : Quartier, Commune..." style="max-width: 100%;">
                @error('localisation')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" class="bouton bouton-primaire" style="width: auto; padding: 10px 24px;">Créer</button>
                <a href="{{ route('admin.depots.index') }}" class="bouton bouton-secondaire" style="width: auto; padding: 10px 20px; margin-top: 0; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
@endsection