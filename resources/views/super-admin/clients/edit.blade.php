@extends('layouts.super-admin')

@section('titre', "Modifier " . $client->nom)

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
            </div>
            <h1>Modifier {{ $client->nom }}</h1>
        </div>
    </div>

    <div class="carte carte-accent">
        <form method="POST" action="{{ route('super-admin.clients.update', $client) }}">
            @csrf
            @method('PUT')

            <label for="nom">Nom de l'entreprise</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $client->nom) }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="email_contact">Email de contact</label>
            <input type="email" name="email_contact" id="email_contact" value="{{ old('email_contact', $client->email_contact) }}">
            @error('email_contact')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $client->telephone) }}">
            @error('telephone')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="periode_abonnement">Périodicité de l'abonnement</label>
            <select name="periode_abonnement" id="periode_abonnement" required>
                <option value="mensuel" @selected(old('periode_abonnement', $client->periode_abonnement) == 'mensuel')>Mensuel</option>
                <option value="trimestriel" @selected(old('periode_abonnement', $client->periode_abonnement) == 'trimestriel')>Trimestriel</option>
                <option value="annuel" @selected(old('periode_abonnement', $client->periode_abonnement) == 'annuel')>Annuel</option>
            </select>
            @error('periode_abonnement')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="montant_abonnement">Montant de l'abonnement (FCFA)</label>
            <input type="number" name="montant_abonnement" id="montant_abonnement" min="0" value="{{ old('montant_abonnement', $client->montant_abonnement) }}" required>
            @error('montant_abonnement')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="date_debut_abonnement">Date de début</label>
            <input type="date" name="date_debut_abonnement" id="date_debut_abonnement" value="{{ old('date_debut_abonnement', $client->date_debut_abonnement->toDateString()) }}" required>
            @error('date_debut_abonnement')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="date_fin_abonnement">Date de fin</label>
            <input type="date" name="date_fin_abonnement" id="date_fin_abonnement" value="{{ old('date_fin_abonnement', $client->date_fin_abonnement->toDateString()) }}" required>
            @error('date_fin_abonnement')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="statut">Statut</label>
            <select name="statut" id="statut" required>
                <option value="actif" @selected(old('statut', $client->statut) == 'actif')>Actif</option>
                <option value="suspendu" @selected(old('statut', $client->statut) == 'suspendu')>Suspendu</option>
                <option value="expire" @selected(old('statut', $client->statut) == 'expire')>Expiré</option>
            </select>
            @error('statut')<div class="erreur-champ">{{ $message }}</div>@enderror

            <button type="submit" class="bouton bouton-primaire">Enregistrer</button>
            <a href="{{ route('super-admin.clients.show', $client) }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
