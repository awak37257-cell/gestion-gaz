@extends('layouts.vendeur')

@section('titre', "Résultat de l'inventaire")

@section('content')
    <div class="carte">
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
