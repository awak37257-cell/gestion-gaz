@extends('layouts.super-admin')

@section('titre', 'Créer un nouveau client')

@section('content')
    <div class="card" style="max-width: 680px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="card-title">🏢 Inscription d'un nouveau client Dépôt</h3>
        </div>

        <form method="POST" action="{{ route('super-admin.clients.store') }}">
            @csrf

            <h4 style="font-size:0.95rem;color:var(--primary);margin-bottom:1rem;font-weight:700;">1. Entreprise & Dépôt</h4>

            <div class="form-group">
                <label class="form-label" for="nom">Nom de l'entreprise ou du dépôt <span style="color:var(--danger);">*</span></label>
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" placeholder="Ex: Gaz Express Douala" required>
                @error('nom')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="email_contact">Email de contact</label>
                    <input type="email" name="email_contact" id="email_contact" class="form-control" value="{{ old('email_contact') }}" placeholder="contact@depot.com">
                    @error('email_contact')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="telephone">Téléphone / WhatsApp</label>
                    <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="+237 6XX XX XX XX">
                    @error('telephone')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <h4 style="font-size:0.95rem;color:var(--primary);margin:1.5rem 0 1rem;font-weight:700;">2. Formule d'Abonnement</h4>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="periode_abonnement">Périodicité <span style="color:var(--danger);">*</span></label>
                    <select name="periode_abonnement" id="periode_abonnement" class="form-control" required onchange="ajusterMontant(this.value)">
                        <option value="mensuel" @selected(old('periode_abonnement') == 'mensuel')>Mensuel (1 mois)</option>
                        <option value="trimestriel" @selected(old('periode_abonnement', 'trimestriel') == 'trimestriel')>Trimestriel (3 mois)</option>
                        <option value="annuel" @selected(old('periode_abonnement') == 'annuel')>Annuel (1 an)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="montant_abonnement">Tarif facturé (FCFA) <span style="color:var(--danger);">*</span></label>
                    <input type="number" name="montant_abonnement" id="montant_abonnement" class="form-control" value="{{ old('montant_abonnement', 40000) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="date_debut_abonnement">Date de démarrage <span style="color:var(--danger);">*</span></label>
                <input type="date" name="date_debut_abonnement" id="date_debut_abonnement" class="form-control" value="{{ old('date_debut_abonnement', now()->toDateString()) }}" required>
                <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">La date d'échéance sera calculée automatiquement.</div>
            </div>

            <h4 style="font-size:0.95rem;color:var(--primary);margin:1.5rem 0 1rem;font-weight:700;">3. Compte Administrateur Dépôt</h4>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label" for="admin_nom">Nom du gestionnaire <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="admin_nom" id="admin_nom" class="form-control" value="{{ old('admin_nom') }}" placeholder="Jean Dupont" required>
                    @error('admin_nom')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="admin_email">Email de connexion <span style="color:var(--danger);">*</span></label>
                    <input type="email" name="admin_email" id="admin_email" class="form-control" value="{{ old('admin_email') }}" placeholder="admin@depot.com" required>
                    @error('admin_email')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="background:#f8fafc;padding:0.9rem 1.1rem;border-radius:8px;border:1px solid #e2e8f0;margin-bottom:1.5rem;font-size:0.82rem;color:var(--text-muted);">
                🔐 Le mot de passe sera généré automatiquement et vous sera affiché immédiatement après la création pour transmission au client.
            </div>

            <div style="display:flex;gap:0.8rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Créer le client & Générer l'accès</button>
                <a href="{{ route('super-admin.clients.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

    <script>
        function ajusterMontant(periode) {
            const champ = document.getElementById('montant_abonnement');
            if (periode === 'mensuel') champ.value = 15000;
            else if (periode === 'trimestriel') champ.value = 40000;
            else if (periode === 'annuel') champ.value = 150000;
        }
    </script>
@endsection
