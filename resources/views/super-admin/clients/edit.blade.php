@extends('layouts.super-admin')

@section('titre', 'Modifier ' . $client->nom)

@section('content')
    <div class="card" style="max-width: 680px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">✏️ Modifier les informations de {{ $client->nom }}</h3>
        </div>

        <form method="POST" action="{{ route('super-admin.clients.update', $client) }}">
            @csrf
            @method('PUT')

            <h4 style="font-size:0.95rem;color:var(--primary);margin-bottom:1rem;font-weight:700;">1. Entreprise & Dépôt</h4>

            <div class="form-group">
                <label class="form-label" for="nom">Nom de l'entreprise ou du dépôt <span style="color:var(--danger);">*</span></label>
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $client->nom) }}" required>
                @error('nom')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="email_contact">Email de contact</label>
                    <input type="email" name="email_contact" id="email_contact" class="form-control" value="{{ old('email_contact', $client->email_contact) }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="telephone">Téléphone / WhatsApp</label>
                    <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $client->telephone) }}">
                </div>
            </div>

            <h4 style="font-size:0.95rem;color:var(--primary);margin:1.5rem 0 1rem;font-weight:700;">2. Abonnement & Statut</h4>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="statut">Statut du compte <span style="color:var(--danger);">*</span></label>
                    <select name="statut" id="statut" class="form-control" required>
                        <option value="actif" @selected(old('statut', $client->statut) == 'actif')>Actif</option>
                        <option value="suspendu" @selected(old('statut', $client->statut) == 'suspendu')>Suspendu</option>
                        <option value="expire" @selected(old('statut', $client->statut) == 'expire')>Expiré</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="periode_abonnement">Périodicité <span style="color:var(--danger);">*</span></label>
                    <select name="periode_abonnement" id="periode_abonnement" class="form-control" required>
                        <option value="mensuel" @selected(old('periode_abonnement', $client->periode_abonnement) == 'mensuel')>Mensuel</option>
                        <option value="trimestriel" @selected(old('periode_abonnement', $client->periode_abonnement) == 'trimestriel')>Trimestriel</option>
                        <option value="annuel" @selected(old('periode_abonnement', $client->periode_abonnement) == 'annuel')>Annuel</option>
                    </select>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="montant_abonnement">Tarif facturé (FCFA) <span style="color:var(--danger);">*</span></label>
                    <input type="number" name="montant_abonnement" id="montant_abonnement" class="form-control" value="{{ old('montant_abonnement', $client->montant_abonnement) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_debut_abonnement">Date de début <span style="color:var(--danger);">*</span></label>
                    <input type="date" name="date_debut_abonnement" id="date_debut_abonnement" class="form-control" value="{{ old('date_debut_abonnement', $client->date_debut_abonnement->toDateString()) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="date_fin_abonnement">Date d'expiration <span style="color:var(--danger);">*</span></label>
                <input type="date" name="date_fin_abonnement" id="date_fin_abonnement" class="form-control" value="{{ old('date_fin_abonnement', $client->date_fin_abonnement->toDateString()) }}" required>
            </div>

            <div style="display:flex;gap:0.8rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Enregistrer les modifications</button>
                <a href="{{ route('super-admin.clients.show', $client) }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
@endsection
