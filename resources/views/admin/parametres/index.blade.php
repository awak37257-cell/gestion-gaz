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

            <label for="nom">Nom de l'entreprise</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $client->nom ?? '') }}" required>
            @error('nom')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="email">Email de connexion</label>
            <input type="email" name="email" id="email" value="{{ old('email', $client->email ?? '') }}" required>
            @error('email')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $client->telephone ?? '') }}">
            @error('telephone')<div class="erreur-champ">{{ $message }}</div>@enderror

            <h3 style="margin-top: 32px; color: var(--couleur-primaire-fonce); border-top: 1px solid #E5E7EB; padding-top: 20px;">Sécurité / Mot de passe</h3>
            <p style="font-size: 13px; color: var(--couleur-texte-clair); margin-bottom: 16px;">Laissez ces champs vides si vous ne souhaitez pas modifier votre mot de passe actuel.</p>

            <label for="current_password">Mot de passe actuel</label>
            <input type="password" name="current_password" id="current_password">
            @error('current_password')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" id="password">
            @error('password')<div class="erreur-champ">{{ $message }}</div>@enderror

            <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation">

            <div style="margin-top: 24px;">
                <button type="submit" class="bouton bouton-primaire">Enregistrer les modifications</button>
            </div>
        </form>
    </div>

    @if($client)
<div class="carte carte-accent" style="margin-top: 24px; padding: 24px; background: #fdfdfd; border: 1px solid #e5e7eb; border-radius: 8px;">
    
    <!-- En-tête de la carte avec le statut -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
        <h3 style="margin: 0; color: var(--couleur-primaire-fonce); font-size: 1.1rem;">Détails de l'abonnement</h3>
        <span class="badge" style="background: #E1EFFE; color: #1E429F; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">
            {{ ucfirst($client->statut) }}
        </span>
    </div>

    <!-- Grille des informations -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 20px;">
        
        <div style="background: #ffffff; padding: 14px 16px; border-radius: 6px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
            <span style="display: block; font-size: 12px; color: var(--couleur-texte-clair); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Périodicité</span>
            <strong style="color: #111827; font-size: 1rem;">{{ ucfirst($client->periode_abonnement) }}</strong>
        </div>

        <div style="background: #ffffff; padding: 14px 16px; border-radius: 6px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
            <span style="display: block; font-size: 12px; color: var(--couleur-texte-clair); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Montant réglé</span>
            <strong style="color: #111827; font-size: 1rem;">{{ number_format($client->montant_abonnement, 0, ',', ' ') }} FCFA</strong>
        </div>

        <div style="background: #ffffff; padding: 14px 16px; border-radius: 6px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
            <span style="display: block; font-size: 12px; color: var(--couleur-texte-clair); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Date de début</span>
            <strong style="color: #111827; font-size: 1rem;">{{ $client->date_debut_abonnement ? $client->date_debut_abonnement->format('d/m/Y') : '-' }}</strong>
        </div>

        <div style="background: #ffffff; padding: 14px 16px; border-radius: 6px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
            <span style="display: block; font-size: 12px; color: var(--couleur-texte-clair); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Date d'échéance (Fin)</span>
            <strong style="color: var(--couleur-danger); font-size: 1rem;">{{ $client->date_fin_abonnement ? $client->date_fin_abonnement->format('d/m/Y') : '-' }}</strong>
        </div>

    </div>

    <!-- Note de bas de page -->
    <p style="font-size: 12px; color: var(--couleur-texte-clair); margin: 0; text-align: center; border-top: 1px dashed #e5e7eb; padding-top: 12px;">
        Pour toute modification d'abonnement ou renouvellement, veuillez contacter l'éditeur du logiciel.
    </p>

</div>
@endif
@endsection