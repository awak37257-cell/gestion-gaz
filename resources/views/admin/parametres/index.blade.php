@extends('layouts.admin')

@section('titre', 'Paramètres de la structure')

@section('content')
    <div class="entete-page">
        <h1>Paramètres généraux</h1>
    </div>

    @if(session('success'))
        <div style="background: #DEF7EC; color: #03543F; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <div class="carte" style="margin-bottom: 24px;">
        <form method="POST" action="{{ route('admin.parametres.update') }}">
            @csrf
            @method('PUT')

            <h3 style="margin-top: 0; color: var(--couleur-primaire-fonce);">Informations de l'entreprise</h3>

            <label for="nom_entreprise">Nom de l'entreprise</label>
            <input type="text" name="nom_entreprise" id="nom_entreprise" value="{{ old('nom_entreprise', $client->nom ?? '') }}" required>
            @error('nom_entreprise')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="email_contact">Email de contact professionnel</label>
            <input type="email" name="email_contact" id="email_contact" value="{{ old('email_contact', $client->email_contact ?? '') }}">
            @error('email_contact')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $client->telephone ?? '') }}">
            @error('telephone')<div class="erreur-champ">{{ $message }}</div>@enderror

            <h3 style="margin-top: 24px; color: var(--couleur-primaire-fonce);">Mon compte administrateur</h3>

            <label for="admin_nom">Votre nom</label>
            <input type="text" name="admin_nom" id="admin_nom" value="{{ old('admin_nom', $admin->name ?? '') }}" required>
            @error('admin_nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="admin_email">Votre email de connexion</label>
            <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email', $admin->email ?? '') }}" required>
            @error('admin_email')<div class="erreur-champ">{{ $message }}</div>@enderror

            <div style="margin-top: 24px;">
                <button type="submit" class="bouton bouton-primaire">Enregistrer les modifications</button>
            </div>
        </form>
    </div>

    @if($client)
    <div class="carte carte-accent">
        <h3 style="margin-top: 0; color: var(--couleur-primaire-fonce);">Détails de l'abonnement</h3>
        <p><strong>Périodicité :</strong> {{ ucfirst($client->periode_abonnement) }}</p>
        <p><strong>Montant réglé :</strong> {{ number_format($client->montant_abonnement, 0, ',', ' ') }} FCFA</p>
        <p><strong>Date de début :</strong> {{ $client->date_debut_abonnement }}</p>
        <p><strong>Date d'échéance de fin :</strong> <span style="color: var(--couleur-danger); font-weight: 600;">{{ $client->date_fin_abonnement }}</span></p>
        <p><strong>Statut actuel :</strong> <span class="badge" style="background: #E1EFFE; color: #1E429F; padding: 4px 8px; border-radius: 4px;">{{ ucfirst($client->statut) }}</span></p>
        <p style="font-size: 12px; color: var(--couleur-texte-clair); margin-top: 16px;">Pour toute modification d'abonnement ou renouvellement, veuillez contacter l'éditeur du logiciel.</p>
    </div>
    @endif
@endsection