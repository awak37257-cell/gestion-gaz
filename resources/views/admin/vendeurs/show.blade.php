@extends('layouts.admin')

@section('titre', 'Vendeur : ' . $vendeur->nom)

@section('content')
    <div class="entete-page no-print">
        <h1>{{ $vendeur->nom }}</h1>
        <button type="button" onclick="window.print()" class="bouton bouton-primaire">Imprimer</button>
    </div>

    <div class="carte" style="text-align: center; max-width: 400px; margin: 0 auto 24px auto;">
        <div style="font-size: 14px; color: var(--couleur-texte-clair); margin-bottom: 16px;">
            Dépôt : <span style="font-weight: 600; color: #112719;">{{ $vendeur->depot->nom }}</span>
        </div>

        <div style="background: white; padding: 16px; border-radius: 8px; display: inline-block; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 16px;">
            {!! QrCode::size(220)->generate($urlScan) !!}
        </div>

        <p style="font-size: 12px; word-break: break-all; color: var(--couleur-texte-clair); background: var(--couleur-fond); padding: 8px 12px; border-radius: 4px; margin-bottom: 16px;">
            {{ $urlScan }}
        </p>

        <p style="font-size: 13px; color: var(--couleur-texte-clair); line-height: 1.4; margin-bottom: 0;" class="no-print">
            Ce QR code ouvre directement l'espace personnel du vendeur, sans mot de passe. À imprimer et à remettre au vendeur, ou à afficher à son poste.
        </p>
    </div>

    <div style="text-align: center;" class="no-print">
        <a href="{{ route('admin.vendeurs.index') }}" class="bouton bouton-secondaire" style="text-decoration: none; display: inline-block;">← Retour à la liste des vendeurs</a>
    </div>
@endsection