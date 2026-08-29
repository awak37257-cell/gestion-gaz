@extends('layouts.vendeur')

@section('titre', 'Reçu de vente')

@section('content')
    <div class="carte carte-accent" style="text-align:center;">
        <div style="width:44px;height:44px;border-radius:50%;background:var(--degrade-primaire);box-shadow:0 3px 10px rgba(122,59,62,0.25);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><path d="M4 12.5l5 5L20 6"/></svg>
        </div>
        <h2 style="margin-top:0;">Reçu de vente</h2>
        <p style="color:var(--couleur-texte-clair);font-size:13px;">
            {{ $vente->vendeur->depot->nom }} — {{ $vente->date_heure->format('d/m/Y H:i') }}
        </p>

        <table style="width:100%;text-align:left;margin:16px 0;font-family:var(--police-chiffres);">
            <tr>
                <td style="padding:6px 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Produit</td>
                <td style="padding:6px 0;text-align:right;">{{ $vente->couleurVendue->nomComplet() }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Quantité</td>
                <td style="padding:6px 0;text-align:right;">{{ $vente->quantite }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Prix unitaire</td>
                <td style="padding:6px 0;text-align:right;">{{ number_format($vente->prix_unitaire, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr style="border-top:1px solid #ddd;font-weight:700;">
                <td style="padding:10px 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">Total</td>
                <td style="padding:10px 0;text-align:right;">{{ number_format($vente->montantTotal(), 0, ',', ' ') }} FCFA</td>
            </tr>
        </table>

        <p style="font-size:12px;color:var(--couleur-texte-clair);">Vendeur : {{ $vente->vendeur->nom }}</p>
    </div>

    <button type="button" onclick="window.print()" class="bouton bouton-primaire no-print">Imprimer le reçu</button>
    <a href="{{ route('vendeur.dashboard') }}" class="lien-retour no-print">← Retour au tableau de bord</a>
@endsection
