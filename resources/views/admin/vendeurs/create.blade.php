@extends('layouts.admin')

@section('titre', 'Nouveau vendeur')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
            </div>
            <h1>Nouveau vendeur</h1>
        </div>
    </div>

    <div class="carte">
        <form method="POST" action="{{ route('admin.vendeurs.store') }}">
            @csrf

            <label for="depot_id">Dépôt</label>
            <select name="depot_id" id="depot_id" required>
                <option value="">— Choisir —</option>
                @foreach ($depots as $depot)
                    <option value="{{ $depot->id }}" @selected(old('depot_id') == $depot->id)>{{ $depot->nom }}</option>
                @endforeach
            </select>
            @error('depot_id')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire">Créer (génère le QR)</button>
            <a href="{{ route('admin.vendeurs.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
