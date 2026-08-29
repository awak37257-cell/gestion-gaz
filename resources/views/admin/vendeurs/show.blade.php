@extends('layouts.admin')

@section('titre', 'Vendeur : ' . $vendeur->nom)

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
            </div>
            <h1>{{ $vendeur->nom }}</h1>
        </div>
        <button type="button" onclick="window.print()" class="bouton bouton-primaire no-print">Imprimer</button>
    </div>

    <div class="carte" style="text-align: center; max-width: 400px; margin: 0 auto 24px auto;">
        <h3 style="margin-top: 0; margin-bottom: 6px; color: var(--couleur-primaire-fonce); font-size: 18px;">{{ $vendeur->nom }}</h3>
        <p style="color: var(--couleur-texte-clair); margin-top: 0; margin-bottom: 20px; font-weight: 500;">Dépôt : {{ $vendeur->depot->nom }}</p>

        <div style="margin: 20px auto; padding: 16px; background: #fff; display: inline-block; border-radius: 8px; border: 1px solid var(--couleur-bordure, #e2e8f0);">
            {!! QrCode::size(220)->generate($urlScan) !!}
        </div>

        <p style="font-size: 12px; word-break: break-all; color: var(--couleur-texte-clair); margin-bottom: 20px; padding: 0 10px;">
            {{ $urlScan }}
        </p>

        <p style="font-size: 13px; color: var(--couleur-texte-clair); line-height: 1.5; margin-bottom: 0;" class="no-print">
            Ce QR code ouvre directement l'espace personnel du vendeur, sans mot de passe.<br>À imprimer et à lui remettre ou à afficher à son poste.
        </p>
    </div>

    <div style="text-align: center;" class="no-print">
        <a href="{{ route('admin.vendeurs.index') }}" class="bouton bouton-secondaire" style="text-decoration: none; display: inline-block;">← Retour à la liste</a>
    </div>
@endsection