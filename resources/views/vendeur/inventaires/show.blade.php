@extends('layouts.vendeur')

@section('titre', "Résultat de l'inventaire")

@section('content')
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
        <div style="width:38px;height:38px;border-radius:50%;background:var(--degrade-primaire);box-shadow:0 2px 6px rgba(122,59,62,0.22);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke="#fff" stroke-width="1.4"><rect x="2.5" y="2" width="11" height="12" rx="0.5"/><path d="M5 6.5l1 1 2-2M5 11l1 1 2-2"/><path d="M10 6.5h3M10 11h3"/></svg>
        </div>
        <h2 style="margin:0;font-size:17px;">Résultat de l'inventaire</h2>
    </div>

    <div class="carte carte-accent">
        <p style="color:var(--couleur-texte-clair);font-size:13px;margin-top:0;">
            {{ $inventaire->date_heure->format('d/m/Y H:i') }}
        </p>

        @foreach ($inventaire->lignes as $ligne)
            <div style="padding:10px 0;border-bottom:1px solid #eee;">
                <strong>{{ $ligne->couleur->nomComplet() }}</strong>
                <div style="font-size:13px;color:var(--couleur-texte-clair);">
                    Pleines : {{ $ligne->quantite_pleines_comptee }} compté / {{ $ligne->quantite_pleines_theorique }} théorique
                    @if ($ligne->ecartPleines() !== 0)
                        <span class="badge badge-changement">écart {{ $ligne->ecartPleines() > 0 ? '+' : '' }}{{ $ligne->ecartPleines() }}</span>
                    @endif
                </div>
                <div style="font-size:13px;color:var(--couleur-texte-clair);">
                    Vides : {{ $ligne->quantite_vides_comptee }} compté / {{ $ligne->quantite_vides_theorique }} théorique
                    @if ($ligne->ecartVides() !== 0)
                        <span class="badge badge-changement">écart {{ $ligne->ecartVides() > 0 ? '+' : '' }}{{ $ligne->ecartVides() }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('vendeur.dashboard') }}" class="bouton bouton-primaire">Retour au tableau de bord</a>
@endsection
