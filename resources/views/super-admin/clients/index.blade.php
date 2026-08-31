@extends('layouts.super-admin')

@section('titre', 'Clients')

@section('content')
    <div class="entete-page">
        <div class="entete-page-titre">
            <div class="icone-badge-petit">
                <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
            </div>
            <h1>Clients</h1>
        </div>
        <a href="{{ route('super-admin.clients.create') }}" class="bouton bouton-primaire">+ Nouveau client</a>
    </div>

    <div style="display:flex;gap:16px;margin-bottom:20px;">
        <div class="carte carte-accent" style="flex:1;">
            <div style="font-size:12px;color:var(--couleur-texte-clair);text-transform:uppercase;letter-spacing:0.05em;">Clients actifs</div>
            <div style="font-size:30px;font-weight:700;color:var(--couleur-primaire);font-family:var(--police-chiffres);">{{ $clientsActifs }} <span style="font-size:15px;color:var(--couleur-texte-clair);font-family:inherit;">/ {{ $clients->count() }}</span></div>
        </div>
        <div class="carte carte-accent" style="flex:1;">
            <div style="font-size:12px;color:var(--couleur-texte-clair);text-transform:uppercase;letter-spacing:0.05em;">Revenu mensuel récurrent</div>
            <div style="font-size:30px;font-weight:700;color:var(--couleur-primaire);font-family:var(--police-chiffres);">{{ number_format($mrr, 0, ',', ' ') }} <span style="font-size:14px;">FCFA</span></div>
        </div>
        <div class="carte" style="flex:1;{{ $expirationProche > 0 ? 'position:relative;padding-left:27px;' : '' }}">
            @if ($expirationProche > 0)
                <div style="position:absolute;left:0;top:0;bottom:0;width:4px;border-radius:var(--rayon) 0 0 var(--rayon);background:var(--degrade-danger);"></div>
            @endif
            <div style="font-size:12px;color:var(--couleur-texte-clair);text-transform:uppercase;letter-spacing:0.05em;">Renouvellement sous 30j</div>
            <div style="font-size:30px;font-weight:700;color:{{ $expirationProche > 0 ? 'var(--couleur-danger)' : 'var(--couleur-primaire)' }};font-family:var(--police-chiffres);">{{ $expirationProche }}</div>
        </div>
        <div class="carte carte-accent" style="flex:1;">
            <div style="font-size:12px;color:var(--couleur-texte-clair);text-transform:uppercase;letter-spacing:0.05em;">Dépôts gérés (tous clients)</div>
            <div style="font-size:30px;font-weight:700;color:var(--couleur-primaire);font-family:var(--police-chiffres);">{{ $totalDepots }}</div>
        </div>
    </div>

    @php $maxRevenu = max(1, $revenusParMois->max('total')); @endphp
    <div class="carte">
        <h3 style="margin-top:0;">Revenus encaissés (6 derniers mois)</h3>
        @if ($revenusParMois->sum('total') > 0)
            <div style="display:flex;align-items:flex-end;gap:14px;height:140px;padding-top:10px;">
                @foreach ($revenusParMois as $mois)
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                        <div style="font-size:10.5px;color:var(--couleur-texte-clair);font-family:var(--police-chiffres);">{{ number_format($mois['total'], 0, ',', ' ') }}</div>
                        <div style="width:100%;max-width:38px;height:{{ max(4, ($mois['total'] / $maxRevenu) * 90) }}px;background:var(--degrade-primaire);border-radius:6px 6px 0 0;"></div>
                        <div style="font-size:11px;color:var(--couleur-texte-clair);text-transform:capitalize;">{{ $mois['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color:var(--couleur-texte-clair);font-size:13px;">Aucun paiement enregistré sur cette période — enregistre les paiements depuis la fiche de chaque client.</p>
        @endif
    </div>

    <div class="carte">
        <form method="GET" action="{{ route('super-admin.clients.index') }}" style="display:flex;gap:12px;align-items:flex-end;">
            <div style="flex:1;">
                <label for="recherche">Rechercher un client</label>
                <input type="text" name="recherche" id="recherche" value="{{ $recherche }}" placeholder="Nom du client..." style="max-width:100%;margin-bottom:0;">
            </div>
            <div>
                <label for="statut">Statut</label>
                <select name="statut" id="statut" style="margin-bottom:0;">
                    <option value="">Tous</option>
                    <option value="actif" @selected($statutFiltre == 'actif')>Actif</option>
                    <option value="suspendu" @selected($statutFiltre == 'suspendu')>Suspendu</option>
                    <option value="expire" @selected($statutFiltre == 'expire')>Expiré</option>
                </select>
            </div>
            <button type="submit" class="bouton bouton-secondaire" style="margin-bottom:18px;">Filtrer</button>
            <a href="{{ route('super-admin.clients.exporter') }}" class="bouton bouton-secondaire" style="margin-bottom:18px;">Exporter (CSV)</a>
        </form>
    </div>

    <div class="carte">
        <table>
            <thead>
                <tr><th>Nom</th><th>Montant</th><th>Fin</th><th>Statut</th><th>Dernière activité</th><th>Ventes ce mois</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td>{{ $client->nom }}</td>
                        <td>{{ number_format($client->montant_abonnement, 0, ',', ' ') }} FCFA</td>
                        <td>
                            {{ $client->date_fin_abonnement->format('d/m/Y') }}
                            @if ($client->statut === 'actif' && $client->date_fin_abonnement->isFuture() && now()->diffInDays($client->date_fin_abonnement) <= 30)
                                <span class="badge badge-suspendu" style="margin-left:6px;">Bientôt</span>
                            @endif
                        </td>
                        <td>
                            @if ($client->statut === 'actif')
                                <span class="badge badge-actif">Actif</span>
                            @elseif ($client->statut === 'suspendu')
                                <span class="badge badge-suspendu">Suspendu</span>
                            @else
                                <span class="badge badge-expire">Expiré</span>
                            @endif
                        </td>
                        <td style="font-size:12px;color:var(--couleur-texte-clair);">
                            {{ $client->derniere_activite ? \Illuminate\Support\Carbon::parse($client->derniere_activite)->format('d/m/Y H:i') : 'Aucune' }}
                        </td>
                        <td>{{ $client->ventes_ce_mois }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('super-admin.clients.show', $client) }}" class="bouton bouton-secondaire bouton-petit">Voir</a>
                            <a href="{{ route('super-admin.clients.edit', $client) }}" class="bouton bouton-secondaire bouton-petit">Modifier</a>
                            <form class="inline" method="POST" action="{{ route('super-admin.clients.renouveler', $client) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bouton bouton-secondaire bouton-petit">Renouveler</button>
                            </form>
                            <form class="inline" method="POST" action="{{ route('super-admin.clients.basculer-statut', $client) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bouton bouton-secondaire bouton-petit">{{ $client->statut === 'actif' ? 'Suspendre' : 'Activer' }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">Aucun client ne correspond.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
