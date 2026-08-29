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

    <div class="carte carte-accent" style="text-align:center;max-width:360px;">
        <p style="color:var(--couleur-texte-clair);margin-top:0;">Dépôt : {{ $vendeur->depot->nom }}</p>

        <div style="margin:20px 0;">
            {!! QrCode::size(220)->generate($urlScan) !!}
        </div>

        <p style="font-size:13px;word-break:break-all;color:var(--couleur-texte-clair);">{{ $urlScan }}</p>

        <p style="font-size:13px;color:var(--couleur-texte-clair);" class="no-print">
            Ce QR ouvre directement l'espace personnel du vendeur, sans mot de passe.
            À imprimer et remettre au vendeur, ou à afficher à son poste.
        </p>
    </div>

    <a href="{{ route('admin.vendeurs.index') }}" class="bouton bouton-secondaire no-print">← Retour à la liste</a>
@endsection
