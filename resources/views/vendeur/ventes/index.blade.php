@extends('layouts.vendeur')

@section('titre', 'Historique des ventes')

@section('content')
    <div class="entete-page" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
        <h1 style="font-family:'Outfit',sans-serif; font-size:1.2rem; font-weight:800; margin:0;">📜 Historique complet</h1>
        <a href="{{ route('vendeur.dashboard') }}" class="btn btn-secondary" style="font-size:0.8rem;">← Retour</a>
    </div>

    <div class="carte">
        @forelse ($ventes as $vente)
            <div style="display:flex; align-items:center; justify-content:space-between; padding:0.75rem 0; border-bottom:1px solid #f1f5f9;">
                <div>
                    <div style="font-weight:700; font-size:0.9rem;">{{ $vente->couleurVendue->nomComplet() }}</div>
                    <div style="font-size:0.75rem; color:var(--text-muted);">
                        {{ \Carbon\Carbon::parse($vente->date_heure)->format('d/m/Y à H:i') }}
                        @if ($vente->estSubstitution())
                            • <span style="color:#f59e0b; font-weight:700;">Changement</span>
                        @endif
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="font-family:'JetBrains Mono',monospace; font-weight:800; font-size:1rem; color:var(--primary);">
                        × {{ $vente->quantite }}
                    </div>
                    <a href="{{ route('vendeur.ventes.recu', $vente) }}" style="font-size:0.7rem; color:var(--text-muted); text-decoration:underline;">Reçu</a>
                </div>
            </div>
        @empty
            <p style="color:var(--text-muted); font-size:0.85rem; padding:1.5rem 0; text-align:center;">
                Aucune vente enregistrée pour le moment.
            </p>
        @endforelse

        <!-- Liens de pagination -->
        <div style="margin-top: 1rem;">
            {{ $ventes->links() }}
        </div>
    </div>
@endsection