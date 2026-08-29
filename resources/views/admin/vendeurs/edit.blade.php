@extends('layouts.admin')

@section('titre', 'Modifier le vendeur')

@section('content')
    <div class="entete-page">
        <h1>Modifier le vendeur</h1>
    </div>

    <div class="carte" style="max-width: 600px;">
        <form method="POST" action="{{ route('admin.vendeurs.update', $vendeur) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 16px;">
                <label for="depot_id">Dépôt</label>
                <select name="depot_id" id="depot_id" required style="max-width: 100%;">
                    @foreach ($depots as $depot)
                        <option value="{{ $depot->id }}" @selected(old('depot_id', $vendeur->depot_id) == $depot->id)>{{ $depot->nom }}</option>
                    @endforeach
                </select>
                @error('depot_id')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label for="nom">Nom du vendeur</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $vendeur->nom) }}" required style="max-width: 100%;">
                @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            {{-- Champ caché à 0 : si la case n'est pas cochée, le navigateur n'envoie rien pour "actif" --}}
            <input type="hidden" name="actif" value="0">
            <div style="margin-bottom: 24px; background: var(--couleur-fond); padding: 12px 16px; border-radius: 6px; display: flex; align-items: center;">
                <label style="margin-bottom: 0; display: flex; align-items: center; cursor: pointer; font-weight: normal;">
                    <input type="checkbox" name="actif" value="1" style="width: auto; display: inline-block; margin-right: 10px; margin-bottom: 0;" @checked(old('actif', $vendeur->actif))>
                    <span style="font-weight: 500; color: #112719;">Vendeur actif</span>
                </label>
                @error('actif')<div class="erreur-champ">{{ $message }}</div>@enderror
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" class="bouton bouton-primaire" style="width: auto; padding: 10px 24px; margin-top: 0;">Enregistrer</button>
                <a href="{{ route('admin.vendeurs.index') }}" class="bouton bouton-secondaire" style="width: auto; padding: 10px 20px; margin-top: 0; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
@endsection