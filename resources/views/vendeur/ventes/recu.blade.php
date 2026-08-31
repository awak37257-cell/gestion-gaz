@extends('layouts.vendeur')

@section('titre', 'Reçu de vente #' . $vente->id)

@section('content')
    <style>
        @media print {
            .no-print, .vendeur-header, .bottom-nav { display: none !important; }
            body { background: #fff !important; color: #000 !important; }
            .ticket-card { box-shadow: none !important; border: none !important; width: 100% !important; max-width: 100% !important; }
        }
        .ticket-card {
            background: #ffffff;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 1.5rem;
            max-width: 360px;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            font-family: 'JetBrains Mono', monospace;
        }
        .ticket-header { text-align: center; border-bottom: 2px dashed #e2e8f0; padding-bottom: 1rem; margin-bottom: 1rem; }
        .ticket-title { font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 900; color: #0f172a; }
        .ticket-info { font-size: 0.75rem; color: #64748b; margin-top: 0.25rem; }
        .ticket-line { display: flex; justify-content: space-between; font-size: 0.85rem; padding: 0.35rem 0; }
        .ticket-total { border-top: 2px dashed #0f172a; margin-top: 0.75rem; padding-top: 0.75rem; display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 800; color: #0f172a; }
        .ticket-footer { text-align: center; font-size: 0.72rem; color: #94a3b8; margin-top: 1.25rem; border-top: 1px solid #f1f5f9; padding-top: 0.75rem; }
    </style>

    <div class="ticket-card">
        <div class="ticket-header">
            <div class="ticket-title">🔥 {{ $vente->vendeur->depot->client->nom ?? 'GAZMANAGER' }}</div>
            <div class="ticket-info">Dépôt : {{ $vente->vendeur->depot->nom }}</div>
            <div class="ticket-info">Date : {{ $vente->date_heure->format('d/m/Y H:i') }} • Reçu #{{ $vente->id }}</div>
        </div>

        <div>
            <div class="ticket-line">
                <span>Article :</span>
                <strong>{{ $vente->couleurVendue->nomComplet() }}</strong>
            </div>
            <div class="ticket-line">
                <span>Quantité :</span>
                <strong>× {{ $vente->quantite }}</strong>
            </div>
            <div class="ticket-line">
                <span>Prix unitaire :</span>
                <span>{{ number_format($vente->prix_unitaire, 0, ',', ' ') }} FCFA</span>
            </div>

            <div class="ticket-total">
                <span>NET À PAYER</span>
                <span>{{ number_format($vente->montantTotal(), 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <div class="ticket-footer">
            <div>Servi par : {{ $vente->vendeur->nom }}</div>
            <div style="margin-top:4px;font-weight:700;">Merci de votre fidélité !</div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:0.75rem;" class="no-print">
        <button type="button" onclick="window.print()" class="bouton bouton-primaire">
            🖨️ Imprimer le reçu client
        </button>
        <a href="{{ route('vendeur.ventes.create') }}" class="bouton bouton-secondaire">
            + Nouvelle Vente
        </a>
        <a href="{{ route('vendeur.dashboard') }}" style="text-align:center;color:var(--text-muted);font-size:0.85rem;text-decoration:none;margin-top:0.5rem;">
            ← Retour au tableau de bord
        </a>
    </div>
@endsection
