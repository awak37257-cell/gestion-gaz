@extends('layouts.admin')

@section('titre', 'Nouveau dépôt')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><path d="M1.5 6.5L8 2l6.5 4.5V14h-13V6.5z"/><path d="M6 14V9h4v5"/></svg>
            </div>
            <h1>Nouveau dépôt</h1>
        </div>
    </div>

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
