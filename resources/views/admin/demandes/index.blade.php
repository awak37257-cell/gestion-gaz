@extends('layouts.admin')

@section('titre', "Demandes d'approvisionnement")

@section('content')
    <div class="entete-page" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div class="entete-page-titre" style="display: flex; align-items: center; gap: 12px;">
            <div class="icone-badge-petit" style="background: var(--couleur-primaire-leger, #e0f2fe); padding: 10px; border-radius: 10px; color: var(--couleur-primaire, #0284c7);">
                <svg width="20" height="20" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 1.5h6l2.5 2.5V14.5h-8.5V1.5z"/><path d="M6 7h4M6 9.5h4M6 12h2.5"/></svg>
            </div>
            <div>
                <h1 style="font-size: 22px; font-weight: 700; margin: 0;">Demandes d'approvisionnement</h1>
                <p style="color: var(--couleur-texte-clair); font-size: 14px; margin: 2px 0 0 0;">Gérez et suivez les demandes de stock des différents dépôts.</p>
            </div>
        </div>
    </div>

    <div class="carte" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #f1f5f9;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="padding: 14px 16px;">Vendeur / Dépôt</th>
                        <th style="padding: 14px 16px;">Marque & Type</th>
                        <th style="padding: 14px 16px;">Quantité</th>
                        <th style="padding: 14px 16px;">Statut</th>
                        <th style="padding: 14px 16px;">Date</th>
                        <th style="padding: 14px 16px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody style="font-size: 14px; color: #1e293b;">
                    @forelse ($demandes as $demande)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 14px 16px;">
                                <div style="font-weight: 600; color: #0f172a;">{{ $demande->vendeur->nom }}</div>
                                <div style="font-size: 12px; color: #64748b;">{{ $demande->vendeur->depot->nom }}</div>
                            </td>
                            <td style="padding: 14px 16px;">
                                <div style="font-weight: 600;">{{ $demande->marque->nom }}</div>
                                <div style="font-size: 12px; color: #64748b;">
                                    {{ $demande->couleur->type ?? '' }} ({{ $demande->couleur->nom_couleur }} - {{ $demande->couleur->poids }})
                                </div>
                            </td>
                            <td style="padding: 14px 16px;">
                                <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-weight: 600;">
                                    {{ $demande->quantite_demandee }}
                                </span>
                            </td>
                            <td style="padding: 14px 16px;">
                                @if ($demande->statut === 'en_attente')
                                    <span class="badge badge-attente" style="background: #fef3c7; color: #d97706; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">En attente</span>
                                @elseif ($demande->statut === 'validee')
                                    <span class="badge badge-validee" style="background: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">Validée</span>
                                @else
                                    <span class="badge badge-livree" style="background: #dcfce7; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">Livrée</span>
                                @endif
                            </td>
                            <td style="padding: 14px 16px; color: #64748b; font-size: 13px;">
                                {{ $demande->date->format('d/m/Y à H:i') }}
                            </td>
                            <td style="padding: 14px 16px; text-align: right; white-space: nowrap;">
                                @if ($demande->statut === 'en_attente')
                                    <form class="inline" method="POST" action="{{ route('admin.demandes.valider', $demande) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bouton bouton-secondaire bouton-petit" style="background: #0284c7; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 500; cursor: pointer;">Valider</button>
                                    </form>
                                @elseif ($demande->statut === 'validee')
                                    <form class="inline" method="POST" action="{{ route('admin.demandes.livrer', $demande) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bouton bouton-primaire bouton-petit" style="background: #16a34a; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 500; cursor: pointer;">Marquer livrée</button>
                                    </form>
                                @else
                                    <span style="color: #cbd5e1;">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 48px 16px;">
                                <div style="font-size: 16px; font-weight: 500; margin-bottom: 4px;">Aucune demande pour le moment</div>
                                <div style="font-size: 13px;">Les nouvelles demandes des vendeurs apparaîtront ici.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection