@extends('layouts.vendeur')

@section('titre', 'Tableau de bord')

@section('content')
    <div class="carte carte-accent" style="text-align:center;">
        <div style="width:46px;height:46px;border-radius:50%;background:var(--degrade-primaire);box-shadow:0 3px 10px rgba(122,59,62,0.25);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.6"><path d="M3 17l5-5 4 4 8-9"/><path d="M15 7h5v5"/></svg>
        </div>
        <div style="font-size:12px;color:var(--couleur-texte-clair);text-transform:uppercase;letter-spacing:0.05em;">Ventes aujourd'hui</div>
        <div style="font-size:42px;font-weight:700;color:var(--couleur-primaire);font-family:var(--police-chiffres);">{{ $nombreVentes }}</div>
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
