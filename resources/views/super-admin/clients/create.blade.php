@extends('layouts.super-admin')

@section('titre', 'Nouveau client')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
            </div>
            <h1>Nouveau client</h1>
        </div>
    </div>

    <div class="carte carte-accent">
        <form method="POST" action="{{ route('super-admin.clients.store') }}">
            @csrf

            <h3 style="margin-top:0;">Informations client</h3>

            <label for="nom">Nom de l'entreprise</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="email_contact">Email de contact</label>
            <input type="email" name="email_contact" id="email_contact" value="{{ old('email_contact') }}">
            @error('email_contact')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}">
            @error('telephone')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="periode_abonnement">Périodicité de l'abonnement</label>
            <select name="periode_abonnement" id="periode_abonnement" required>
                <option value="mensuel" @selected(old('periode_abonnement') == 'mensuel')>Mensuel</option>
                <option value="trimestriel" @selected(old('periode_abonnement') == 'trimestriel')>Trimestriel</option>
                <option value="annuel" @selected(old('periode_abonnement') == 'annuel')>Annuel</option>
            </select>
            @error('periode_abonnement')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="montant_abonnement">Montant de l'abonnement (FCFA)</label>
            <input type="number" name="montant_abonnement" id="montant_abonnement" min="0" value="{{ old('montant_abonnement', 0) }}" required>
            @error('montant_abonnement')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="date_debut_abonnement">Date de début</label>
            <input type="date" name="date_debut_abonnement" id="date_debut_abonnement" value="{{ old('date_debut_abonnement', now()->toDateString()) }}" required>
            @error('date_debut_abonnement')<div class="erreur-champ">{{ $message }}</div>@enderror
            <p style="font-size:12px;color:var(--couleur-texte-clair);margin-top:-12px;">La date de fin est calculée automatiquement selon la périodicité choisie.</p>

            <h3>Compte administrateur du client</h3>

            <label for="admin_nom">Nom de l'administrateur</label>
            <input type="text" name="admin_nom" id="admin_nom" value="{{ old('admin_nom') }}" required>
            @error('admin_nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="admin_email">Email de connexion</label>
            <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}" required>
            @error('admin_email')<div class="erreur-champ">{{ $message }}</div>@enderror
            <p style="font-size:12px;color:var(--couleur-texte-clair);margin-top:-12px;">Un mot de passe sera généré automatiquement et affiché une seule fois après la création.</p>

            <button type="submit" class="bouton bouton-primaire">Créer le client</button>
            <a href="{{ route('super-admin.clients.index') }}" class="bouton bouton-secondaire">Annuler</a>
        </form>
    </div>
@endsection
