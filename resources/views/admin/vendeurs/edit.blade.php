@extends('layouts.admin')

@section('titre', 'Modifier le vendeur')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
            </div>
            <h1>Modifier le vendeur</h1>
        </div>
    </div>

    <div class="carte">
        <form method="POST" action="{{ route('admin.vendeurs.update', $vendeur) }}">
            @csrf
            @method('PUT')

            <label for="depot_id">Dépôt</label>
            <select name="depot_id" id="depot_id" required>
                @foreach ($depots as $depot)
                    <option value="{{ $depot->id }}" @selected(old('depot_id', $vendeur->depot_id) == $depot->id)>{{ $depot->nom }}</option>
                @endforeach
            </select>
            @error('depot_id')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $vendeur->nom) }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            {{-- Champ caché à 0 : si la case n'est pas cochée, le navigateur n'envoie
                 rien pour "actif", donc cette valeur par défaut est nécessaire. --}}
            <input type="hidden" name="actif" value="0">
            <label>
                <input type="checkbox" name="actif" value="1" style="width:auto;display:inline-block;margin-right:8px;margin-bottom:0;" @checked(old('actif', $vendeur->actif))>
                Vendeur actif
            </label>
            @error('actif')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire" style="margin-top:16px;">Enregistrer</button>
            <a href="{{ route('admin.vendeurs.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
