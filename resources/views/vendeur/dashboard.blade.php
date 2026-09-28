@extends('layouts.vendeur')

@section('titre', 'Tableau de bord Vendeur')

@section('content')
    <!-- KPI Séparés : Ventes du jour et Ventes du mois -->
    <div style="display:flex;gap:0.75rem;margin-bottom:1.25rem;">
        <!-- Ventes du jour -->
        <div class="carte" style="flex:1;text-align:center;background:linear-gradient(135deg, #1e293b, #0f172a);color:#fff;border:1px solid #334155;margin-bottom:0;padding:1rem;">
            <div style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;font-weight:700;margin-bottom:0.2rem;">
                Aujourd'hui
            </div>
            <div style="font-size:2.5rem;font-weight:900;color:var(--primary);font-family:'Outfit',sans-serif;line-height:1;">
                {{ $nombreVentesJour ?? 0 }}
            </div>
            <div style="font-size:0.75rem;color:#94a3b8;margin-top:0.2rem;">
                Bouteille(s)
            </div>
        </div>

        <!-- Ventes du mois -->
        <div class="carte" style="flex:1;text-align:center;background:linear-gradient(135deg, #1e293b, #0f172a);color:#fff;border:1px solid #334155;margin-bottom:0;padding:1rem;">
            <div style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;font-weight:700;margin-bottom:0.2rem;">
                Ce mois-ci
            </div>
            <div style="font-size:2.5rem;font-weight:900;color:var(--primary);font-family:'Outfit',sans-serif;line-height:1;">
                {{ $nombreVentesMois ?? 0 }}
            </div>
            <div style="font-size:0.75rem;color:#94a3b8;margin-top:0.2rem;">
                Bouteille(s)
            </div>
        </div>
    </div>

    <!-- Actions Rapides Tactiles -->
    <a href="{{ route('vendeur.ventes.create') }}" class="btn-action-big primary-action">
        <div class="btn-action-icon">⚡</div>
        <div style="flex:1;">
            <div style="font-size:1.1rem;font-weight:800;">+ Nouvelle Vente</div>
            <div style="font-size:0.75rem;opacity:0.9;">Encaisser et imprimer un reçu</div>
        </div>
        <div>➔</div>
    </a>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1.25rem;">
        <a href="{{ route('vendeur.demandes.create') }}" class="btn-action-big" style="margin-bottom:0;padding:1rem;flex-direction:column;align-items:flex-start;gap:0.5rem;">
            <div class="btn-action-icon" style="width:36px;height:36px;font-size:1.1rem;">🚚</div>
            <div>
                <div style="font-size:0.88rem;font-weight:800;">Réassort</div>
                <div style="font-size:0.72rem;color:var(--text-muted);">Demander du stock</div>
            </div>
        </a>

        <a href="{{ route('vendeur.inventaires.create') }}" class="btn-action-big" style="margin-bottom:0;padding:1rem;flex-direction:column;align-items:flex-start;gap:0.5rem;">
            <div class="btn-action-icon" style="width:36px;height:36px;font-size:1.1rem;">📋</div>
            <div>
                <div style="font-size:0.88rem;font-weight:800;">Inventaire</div>
                <div style="font-size:0.72rem;color:var(--text-muted);">Compter les bouteilles</div>
            </div>
        </a>
    </div>

    <!-- Ventes du jour avec bouton Consulter -->
    <div class="carte">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.75rem;">
            <h3 style="font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;margin:0;color:var(--text-main);">
                📜 Dernières ventes du jour
            </h3>
            <!-- Assure-toi que la route 'vendeur.ventes.index' existe pour l'historique complet -->
            <a href="{{ route('vendeur.ventes.index') }}" style="font-size:0.8rem;font-weight:700;color:var(--primary);text-decoration:none;">
                Consulter tout ➔
            </a>
        </div>

        @forelse ($ventesDuJour as $vente)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem 0;border-bottom:1px solid #f1f5f9;">
                <div>
                    <div style="font-weight:700;font-size:0.9rem;">{{ $vente->couleurVendue->nomComplet() }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">
                        Heure : {{ $vente->date_heure->format('H:i') }}
                        @if ($vente->estSubstitution())
                            • <span style="color:#f59e0b;font-weight:700;">Changement</span>
                        @endif
                    </div>
                </div>
                <div style="font-family:'JetBrains Mono',monospace;font-weight:800;font-size:1rem;color:var(--primary);">
                    × {{ $vente->quantite }}
                </div>
            </div>
        @empty
            <p style="color:var(--text-muted);font-size:0.85rem;padding:0.5rem 0;text-align:center;">
                Aucune vente enregistrée pour le moment aujourd'hui.
            </p>
        @endforelse
    </div>

    <!-- Demandes en attente -->
    <div class="carte">
        <h3 style="font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;margin-bottom:0.75rem;color:var(--text-main);">
            🚚 Vos demandes d'approvisionnement
        </h3>
        @forelse ($demandesEnAttente as $demande)
            <div style="padding:0.6rem 0;border-bottom:1px solid #f1f5f9;font-size:0.85rem;display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <strong>{{ $demande->marque->nom }}</strong> — {{ $demande->couleur->nom_couleur }}
                </div>
                <div style="font-family:'JetBrains Mono',monospace;font-weight:700;color:var(--primary);">
                    × {{ $demande->quantite_demandee }}
                </div>
            </div>
        @empty
            <p style="color:var(--text-muted);font-size:0.85rem;padding:0.5rem 0;text-align:center;">
                Aucune demande en cours.
            </p>
        @endforelse
        
    </div>
    <!-- Alerte Stocks en Manque -->
    @if(isset($stocksEnManque) && $stocksEnManque->isNotEmpty())
        <div class="carte" style="border-left: 4px solid #ef4444; background: #fef2f2; margin-bottom: 1.25rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                <h3 style="font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;margin:0;color:#991b1b;">
                    ⚠️ Alertes : Stocks en manque / épuisés
                </h3>
            </div>
            <p style="font-size:0.78rem; color:#7f1d1d; margin-bottom:0.75rem;">
                Les bouteilles suivantes nécessitent un réassort rapide :
            </p>
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                @foreach ($stocksEnManque as $stock)
                    <div style="display:flex; justify-content:space-between; align-items:center; background:#fff; padding:0.5rem 0.75rem; border-radius:6px; border:1px solid #fecaca; font-size:0.85rem;">
                        <div>
                            <strong>{{ $stock->couleur->nomComplet() }}</strong>
                        </div>
                        <div style="font-family:'JetBrains Mono',monospace; font-weight:800; color: {{ $stock->quantite_pleines == 0 ? '#ef4444' : '#d97706' }};">
                            {{ $stock->quantite_pleines }} en stock
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 0.75rem; text-align: right;">
                <a href="{{ route('vendeur.demandes.create') }}" style="font-size:0.8rem; font-weight:700; color:#dc2626; text-decoration:none;">
                    Faire un réassort maintenant ➔
                </a>
            </div>
        </div>
    @endif
@endsection