@extends('layouts.vendeur')

@section('titre', 'Tableau de bord')

@section('content')
    <div class="carte" style="text-align:center;">
        <div style="font-size:13px;color:var(--couleur-texte-clair);">Ventes aujourd'hui</div>
        <div style="font-size:42px;font-weight:700;color:var(--couleur-primaire);">{{ $nombreVentes }}</div>
    </div>

    <a href="{{ route('vendeur.ventes.create') }}" class="bouton bouton-primaire">Nouvelle vente</a>
    <a href="{{ route('vendeur.demandes.create') }}" class="bouton bouton-secondaire">Nouvelle demande d'approvisionnement</a>
    <a href="{{ route('vendeur.inventaires.create') }}" class="bouton bouton-secondaire">Faire l'inventaire</a>

    <div class="carte" style="margin-top:20px;">
        <h3 style="margin-top:0;">Ventes du jour</h3>
        @forelse ($ventesDuJour as $vente)
            <div style="padding:10px 0;border-bottom:1px solid #eee;">
                <strong>{{ $vente->couleurVendue->nomComplet() }}</strong> × {{ $vente->quantite }}
                <div style="font-size:12px;color:var(--couleur-texte-clair);">
                    {{ $vente->date_heure->format('H:i') }}
                    @if ($vente->estSubstitution())
                        <span class="badge badge-changement">Changement</span>
                    @endif
                </div>
            </div>
        @empty
            <p style="color:var(--couleur-texte-clair);">Aucune vente enregistrée pour le moment.</p>
        @endforelse
    </div>

    @if ($changementsEffectues->isNotEmpty())
        <div class="carte">
            <h3 style="margin-top:0;">Changements effectués aujourd'hui</h3>
            @foreach ($changementsEffectues as $changement)
                <div style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;">
                    {{ $changement->couleurDemandee->nomComplet() }} → {{ $changement->couleurVendue->nomComplet() }}
                    <span style="color:var(--couleur-texte-clair);">× {{ $changement->quantite }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="carte">
        <h3 style="margin-top:0;">Demandes en attente</h3>
        @forelse ($demandesEnAttente as $demande)
            <div style="padding:10px 0;border-bottom:1px solid #eee;font-size:14px;">
                {{ $demande->marque->nom }} — {{ $demande->couleur->nom_couleur }} ({{ $demande->couleur->poids }}) × {{ $demande->quantite_demandee }}
            </div>
        @empty
            <p style="color:var(--couleur-texte-clair);">Aucune demande en attente.</p>
        @endforelse
    </div>

    <form method="POST" action="{{ route('vendeur.deconnexion') }}" style="margin-top:10px;">
        @csrf
        <button type="submit" class="bouton bouton-danger">Fin de service</button>
    </form>
@endsection
