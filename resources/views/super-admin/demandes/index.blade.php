@extends('layouts.super-admin')

@section('titre', 'Demandes d\'accès')

@section('content')
    <!-- Statistiques rapides -->
    <div class="stats-grid">
        <div class="stat-card {{ $totalEnAttente > 0 ? 'accent-red' : 'accent-orange' }}">
            <div class="stat-icon-wrapper">⏳</div>
            <div class="stat-content">
                <div class="stat-label">En attente de traitement</div>
                <div class="stat-value" style="{{ $totalEnAttente > 0 ? 'color:var(--danger);' : '' }}">{{ $totalEnAttente }}</div>
            </div>
        </div>

        <div class="stat-card accent-green">
            <div class="stat-icon-wrapper">✅</div>
            <div class="stat-content">
                <div class="stat-label">Demandes validées</div>
                <div class="stat-value" style="color:var(--success);">{{ $totalValidees }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper">🚫</div>
            <div class="stat-content">
                <div class="stat-label">Demandes rejetées</div>
                <div class="stat-value" style="color:var(--text-muted);">{{ $totalRejetees }}</div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card">
        <form method="GET" action="{{ route('super-admin.demandes.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            <div style="min-width:220px;">
                <label class="form-label" for="statut">Filtrer par statut</label>
                <select name="statut" id="statut" class="form-control" style="margin-bottom:0;" onchange="this.form.submit()">
                    <option value="">Toutes les demandes</option>
                    <option value="en_attente" @selected($statutFiltre == 'en_attente')>En attente ({{ $totalEnAttente }})</option>
                    <option value="validee" @selected($statutFiltre == 'validee')>Validées ({{ $totalValidees }})</option>
                    <option value="rejetee" @selected($statutFiltre == 'rejetee')>Rejetées ({{ $totalRejetees }})</option>
                </select>
            </div>
            @if ($statutFiltre)
                <a href="{{ route('super-admin.demandes.index') }}" class="btn btn-secondary">Réinitialiser le filtre</a>
            @endif
        </form>
    </div>

    <!-- Tableau des demandes -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📩 Demandes d'accès reçues depuis le site public</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Entreprise / Dépôt</th>
                        <th>Contact</th>
                        <th>Formule</th>
                        <th>Message / Besoins</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($demandes as $demande)
                        <tr style="{{ $demande->statut === 'en_attente' ? 'background: #fff8f8;' : '' }}">
                            <td style="font-family:'JetBrains Mono',monospace;font-size:0.8rem;white-space:nowrap;">
                                {{ $demande->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <div style="font-weight:800;color:var(--text-main);font-size:0.92rem;">
                                    {{ $demande->nom_entreprise }}
                                </div>
                                @if ($demande->client)
                                    <div style="font-size:11px;color:var(--success);margin-top:2px;">
                                        Compte client lié : <a href="{{ route('super-admin.clients.show', $demande->client) }}" style="color:var(--success);font-weight:700;">{{ $demande->client->nom }}</a>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ $demande->nom_contact }}</div>
                                <div style="font-size:0.8rem;color:var(--text-muted);">
                                    <a href="mailto:{{ $demande->email }}" style="color:inherit;">{{ $demande->email }}</a>
                                    @if ($demande->telephone)
                                        • <a href="tel:{{ $demande->telephone }}" style="color:inherit;font-weight:600;">{{ $demande->telephone }}</a>
                                    @endif
                                </div>
                            </td>
                      <td>
    <span class="badge badge-purple">
        {{ ucfirst($demande->periode_souhaitee) }}
    </span>
    
    <!-- Affichage du nombre de jours restants (arrondi en entier) -->
    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">
        @if($demande->client && $demande->client->date_fin_abonnement)
            @php
                $finAbonnement = \Carbon\Carbon::parse($demande->client->date_fin_abonnement);
                $maintenant = \Carbon\Carbon::today(); // Utilise la date du jour sans les heures/minutes
                $joursRestants = (int) $maintenant->diffInDays($finAbonnement->copy()->startOfDay(), false);
            @endphp

            @if($joursRestants < 0)
                <span style="color: #e53e3e; font-weight: bold;">⚠️ Expiré (il y a {{ abs($joursRestants) }} jours)</span>
            @elseif($joursRestants == 0)
                <span style="color: #d97706; font-weight: bold;">⚠️ Expire aujourd'hui</span>
            @else
                ⏳ Reste <strong>{{ $joursRestants }} jour(s)</strong>
                <br><small>({{ $finAbonnement->format('d/m/Y') }})</small>
            @endif
        @else
            <span style="color: #cbd5e1;">Non défini</span>
        @endif
    </div>
</td>
                            <td style="font-size:0.82rem;color:var(--text-muted);max-width:240px;">
                                {{ $demande->message ? Str::limit($demande->message, 80) : '—' }}
                            </td>
                            <td>
                                @if ($demande->statut === 'en_attente')
                                    <span class="badge badge-expire">En attente</span>
                                @elseif ($demande->statut === 'validee')
                                    <span class="badge badge-actif">Validée</span>
                                @else
                                    <span class="badge badge-suspendu">Rejetée</span>
                                @endif
                            </td>
                        <td style="white-space:nowrap;">
    @if ($demande->statut === 'en_attente')
        {{-- Lien vers le formulaire de création/validation --}}
        <a href="{{ url('/super-admin/demandes/' . $demande->id . '/creer') }}" class="btn btn-primary btn-sm">
            ✨ Créer l'accès
        </a>

        <form method="POST" action="{{ route('super-admin.demandes.rejeter', $demande) }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger-outline btn-sm" onclick="return confirm('Rejeter cette demande ?')">
                Rejeter
            </button>
        </form>

    @elseif ($demande->statut === 'validee' && $demande->client)
        {{-- Bouton symbole de lien qui redirige vers le formulaire de configuration --}}
        <a href="{{ route('super-admin.demandes.formulaire-lien', $demande) }}" class="btn btn-sm btn-info" title="Configurer le lien et envoyer les accès">
            🔗 Configurer & Envoyer
        </a>

        <a href="{{ route('super-admin.clients.show', $demande->client) }}" class="btn btn-secondary btn-sm" style="margin-left: 4px;">
            Voir client ➔
        </a>

    @else
        <form method="POST" action="{{ route('super-admin.demandes.destroy', $demande) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Supprimer définitivement cette demande ?')">
                Supprimer
            </button>
        </form>
    @endif
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3rem;color:var(--text-muted);">
                                Aucune demande d'accès trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
