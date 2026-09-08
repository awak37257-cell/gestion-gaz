@extends('layouts.super-admin')

@section('titre', 'Créer l\'accès client')

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        
        <!-- En-tête de la page -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main);">
                ✨ Valider et créer l'accès pour : {{ $demande->nom_entreprise }}
            </h2>
            <a href="{{ route('super-admin.dashboard') }}" class="btn btn-secondary btn-sm">Retour</a>
        </div>

        <!-- Encadré : Message & Besoins particuliers du client -->
        @if($demande->message || $demande->besoins_particuliers)
            <div class="card" style="border-left: 4px solid var(--primary); margin-bottom: 20px; background: rgba(139, 92, 246, 0.03);">
                <div class="card-header">
                    <h3 class="card-title" style="color: var(--primary);">
                        💡 Message & Besoins particuliers du client
                    </h3>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <p style="font-style: italic; color: var(--text-main); line-height: 1.6; background: var(--bg-card); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-color); margin: 0;">
                        "{{ $demande->message ?? $demande->besoins_particuliers }}"
                    </p>
                    <small style="display: block; margin-top: 10px; color: var(--text-muted);">
                        👉 Si ce message concerne une demande d'amélioration ou une fonctionnalité spécifique, prenez en compte ces retours pour adapter l'application pour ce client.
                    </small>
                </div>
            </div>
        @endif

        <!-- Formulaire de création de compte -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informations du compte client</h3>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <form method="POST" action="{{ route('super-admin.demandes.valider', $demande) }}">
                    @csrf

                    <!-- Nom de l'entreprise -->
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Nom de l'entreprise</label>
                        <input type="text" name="nom_entreprise" value="{{ old('nom_entreprise', $demande->nom_entreprise) }}" class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid var(--border-color);" required>
                    </div>

                    <!-- Nom du contact -->
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Nom du contact</label>
                        <input type="text" name="nom_contact" value="{{ old('nom_contact', $demande->nom_contact) }}" class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid var(--border-color);" required>
                    </div>

                    <!-- Email -->
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Email</label>
                        <input type="email" name="email" value="{{ old('email', $demande->email) }}" class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid var(--border-color);" required>
                    </div>

                    <!-- Téléphone -->
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $demande->telephone) }}" class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid var(--border-color);" required>
                    </div>

                    <!-- Formule / Période souhaitée -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Formule / Période souhaitée</label>
                        <input type="text" name="periode_souhaitee" value="{{ old('periode_souhaitee', $demande->periode_souhaitee) }}" class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid var(--border-color);" required>
                    </div>

                    <!-- Bouton de validation finale -->
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <a href="{{ route('super-admin.dashboard') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Confirmer la création définitive de l\'accès pour cette entreprise ?')">
                            ✨ Finaliser et créer l'accès
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection