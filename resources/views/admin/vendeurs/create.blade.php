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

    <div class="carte" style="max-width: 600px;">
        <form method="POST" action="{{ route('admin.vendeurs.store') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="depot_id">Dépôt</label>
                <select name="depot_id" id="depot_id" required style="max-width: 100%;">
                    <option value="">— Choisir —</option>
                    @foreach ($depots as $depot)
                        <option value="{{ $depot->id }}" @selected(old('depot_id') == $depot->id)>{{ $depot->nom }}</option>
                    @endforeach
                </select>
                @error('depot_id')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label for="nom">Nom du vendeur</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" placeholder="ex : Jean Dupont" required style="max-width: 100%;">
                @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" class="bouton bouton-primaire" style="width: auto; padding: 10px 24px; margin-top: 0;">Créer (génère le QR)</button>
                <a href="{{ route('admin.vendeurs.index') }}" class="bouton bouton-secondaire" style="width: auto; padding: 10px 20px; margin-top: 0; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
@endsection