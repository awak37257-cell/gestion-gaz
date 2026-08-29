<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Administration')</title>
    <style>
        :root {
            --couleur-primaire: #8B5CF6;
            --couleur-primaire-fonce: #6D28D9;
            --couleur-danger: #EF4444;
            --couleur-fond: #FAF8FC;
            --couleur-carte: #FFFFFF;
            --couleur-texte: #241F3D;
            --couleur-texte-clair: #7A7390;
            --couleur-bordure: #EBE6F5;
            --rayon: 14px;
            --police-titre: Georgia, 'Iowan Old Style', 'Times New Roman', serif;
            --police-chiffres: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            --degrade-primaire: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
            --degrade-primaire-hover: linear-gradient(135deg, #7C3AED 0%, #DB2777 100%);
            --degrade-secondaire: linear-gradient(135deg, #EC4899 0%, #F97316 100%);
            --degrade-tertiaire: linear-gradient(135deg, #06B6D4 0%, #8B5CF6 100%);
            --degrade-danger: linear-gradient(135deg, #FB7185 0%, #EF4444 100%);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background:
                radial-gradient(circle at 8% 0%, rgba(139,92,246,0.09), transparent 40%),
                radial-gradient(circle at 92% 15%, rgba(236,72,153,0.07), transparent 40%),
                radial-gradient(circle at 50% 100%, rgba(249,115,22,0.05), transparent 40%),
                var(--couleur-fond);
            color: var(--couleur-texte);
            display: flex;
            min-height: 100vh;
            font-variant-numeric: tabular-nums;
        }

        h1, h2, h3 {
            font-family: var(--police-titre);
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .barre-laterale {
            width: 230px;
            background: linear-gradient(180deg, #241F3D 0%, #3B2A5E 100%);
            color: #fff;
            padding: 24px 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .barre-laterale h2 {
            font-family: var(--police-titre);
            font-size: 16px;
            font-weight: 600;
            padding: 0 22px 18px;
            margin: 0 12px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.14);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .barre-laterale nav { display: flex; flex-direction: column; gap: 2px; padding: 0 12px; }

        .barre-laterale a {
            display: flex;
            align-items: center;
            gap: 11px;
            color: rgba(255,255,255,0.68);
            text-decoration: none;
            padding: 9px 14px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-radius: 10px;
            transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
        }

        .barre-laterale a svg { flex-shrink: 0; opacity: 0.9; }
        .barre-laterale a:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .barre-laterale a.actif {
            color: #fff;
            background: var(--degrade-primaire);
            box-shadow: 0 4px 12px rgba(139,92,246,0.4);
        }

        .barre-laterale-profil {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.14);
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .profil-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--degrade-primaire);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .profil-details { flex: 1; min-width: 0; }
        .profil-nom {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .profil-role {
            font-size: 10.5px;
            color: rgba(255,255,255,0.55);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .profil-deconnexion {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.85);
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.15s ease;
        }

        .profil-deconnexion:hover { background: rgba(255,255,255,0.2); }

        .contenu { flex: 1; padding: 32px 40px; max-width: 1120px; }

        .entete-page {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--couleur-bordure);
        }

        .entete-page h1 { font-size: 22px; margin: 0; }
        .entete-page-titre { display: flex; align-items: center; gap: 14px; }

        .message {
            padding: 13px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .message-succes { background: #D1FAE5; color: #065F46; border-color: #A7F3D0; }
        .message-erreur { background: #FEE2E2; color: #B91C1C; border-color: #FECACA; }

        .carte {
            background: var(--couleur-carte);
            border: 1px solid var(--couleur-bordure);
            border-radius: var(--rayon);
            padding: 22px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(139,92,246,0.07);
            position: relative;
        }

        .carte-accent, .carte-accent-danger { padding-left: 27px; }

        .carte-accent::before, .carte-accent-danger::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            border-radius: var(--rayon) 0 0 var(--rayon);
        }

        .carte-accent::before { background: var(--degrade-primaire); }
        .carte-accent-danger::before { background: var(--degrade-danger); }

        .carte-stat { display: flex; align-items: center; gap: 16px; }

        .icone-badge {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--degrade-primaire);
            box-shadow: 0 4px 12px rgba(139,92,246,0.32);
        }

        .icone-badge-b { background: var(--degrade-secondaire); box-shadow: 0 4px 12px rgba(236,72,153,0.32); }
        .icone-badge-c { background: var(--degrade-tertiaire); box-shadow: 0 4px 12px rgba(6,182,212,0.32); }
        .icone-badge.danger { background: var(--degrade-danger); box-shadow: 0 4px 12px rgba(239,68,68,0.32); }
        .icone-badge svg { stroke: #fff; }

        .icone-badge-petit {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--degrade-primaire);
            box-shadow: 0 3px 9px rgba(139,92,246,0.3);
        }

        .icone-badge-petit svg { stroke: #fff; }

        table { width: 100%; border-collapse: collapse; }

        tbody tr:nth-child(even) { background: rgba(139,92,246,0.025); }
        tbody tr:hover { background: #F6F2FC; }

        th, td {
            text-align: left;
            padding: 11px 12px;
            border-bottom: 1px solid var(--couleur-bordure);
            font-size: 13.5px;
        }

        th {
            color: var(--couleur-texte-clair);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.06em;
        }

        label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; }

        input, select {
            width: 100%;
            max-width: 380px;
            padding: 13px 16px;
            font-size: 14.5px;
            font-family: inherit;
            border: 2px solid var(--couleur-bordure);
            border-radius: 12px;
            margin-bottom: 18px;
            background: #FCFAFF;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        input:hover, select:hover { border-color: #D9CFF0; }

        input:focus, select:focus {
            outline: none;
            border-color: #8B5CF6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(139,92,246,0.16);
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' fill='none' stroke='%238B5CF6' stroke-width='2'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 42px;
        }

        .bouton {
            display: inline-block;
            padding: 12px 22px;
            font-size: 12.5px;
            font-weight: 700;
            text-align: center;
            border: 2px solid transparent;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        .bouton-primaire { background: var(--degrade-primaire); color: #fff; box-shadow: 0 4px 14px rgba(139,92,246,0.35); }
        .bouton-primaire:hover { background: var(--degrade-primaire-hover); transform: translateY(-2px); box-shadow: 0 6px 18px rgba(139,92,246,0.42); }

        .bouton-secondaire { background: #fff; color: var(--couleur-texte); border-color: var(--couleur-bordure); }
        .bouton-secondaire:hover { border-color: #8B5CF6; background: #FCFAFF; color: #6D28D9; }

        .bouton-danger { background: #fff; color: var(--couleur-danger); border-color: #FECACA; }
        .bouton-danger:hover { background: #FEF2F2; }

        .bouton-petit { padding: 7px 15px; font-size: 11px; }

        .erreur-champ { color: var(--couleur-danger); font-size: 13px; margin-top: -14px; margin-bottom: 16px; }

        .badge {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .badge-attente { background: #FEF3C7; color: #92400E; }
        .badge-validee { background: #DBEAFE; color: #1E40AF; }
        .badge-livree { background: #D1FAE5; color: #065F46; }
        .badge-inactif { background: #F3F0FA; color: #8A80A8; }

        form.inline { display: inline; }

        @media print {
            .no-print, .barre-laterale { display: none !important; }
            body { display: block; }
            .contenu { padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="barre-laterale">
        <h2>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="#EC4899" stroke-width="1.8"/>
                <line x1="12" y1="12" x2="16" y2="7" stroke="#EC4899" stroke-width="1.8" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="1.8" fill="#EC4899"/>
            </svg>
            Gestion Dépôt Gaz
        </h2>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'actif' : '' }}">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><rect x="1.5" y="1.5" width="5.5" height="5.5" rx="0.5"/><rect x="9" y="1.5" width="5.5" height="5.5" rx="0.5"/><rect x="1.5" y="9" width="5.5" height="5.5" rx="0.5"/><rect x="9" y="9" width="5.5" height="5.5" rx="0.5"/></svg>
                Tableau de bord
            </a>
            <a href="{{ route('admin.depots.index') }}" class="{{ request()->routeIs('admin.depots.*') ? 'actif' : '' }}">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M1.5 6.5L8 2l6.5 4.5V14h-13V6.5z"/><path d="M6 14V9h4v5"/></svg>
                Dépôts
            </a>
            <a href="{{ route('admin.marques.index') }}" class="{{ request()->routeIs('admin.marques.*') ? 'actif' : '' }}">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M2 2h5.5L14 8.5 8.5 14 2 7.5V2z"/><circle cx="5" cy="5" r="0.8" fill="currentColor" stroke="none"/></svg>
                Marques
            </a>
            <a href="{{ route('admin.couleurs.index') }}" class="{{ request()->routeIs('admin.couleurs.*') ? 'actif' : '' }}">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="8" cy="8" r="6.2"/><circle cx="8" cy="5.3" r="0.9" fill="currentColor" stroke="none"/><circle cx="5.3" cy="9.5" r="0.9" fill="currentColor" stroke="none"/><circle cx="10.7" cy="9.5" r="0.9" fill="currentColor" stroke="none"/></svg>
                Couleurs
            </a>
            <a href="{{ route('admin.vendeurs.index') }}" class="{{ request()->routeIs('admin.vendeurs.*') ? 'actif' : '' }}">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="8" cy="4.5" r="2.5"/><path d="M2.5 14c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/></svg>
                Vendeurs
            </a>
            <a href="{{ route('admin.stocks.index') }}" class="{{ request()->routeIs('admin.stocks.*') ? 'actif' : '' }}">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><rect x="1.5" y="8.5" width="5.5" height="5.5"/><rect x="9" y="8.5" width="5.5" height="5.5"/><rect x="5.2" y="2" width="5.5" height="5.5"/></svg>
                Stocks
            </a>
            <a href="{{ route('admin.demandes.index') }}" class="{{ request()->routeIs('admin.demandes.*') ? 'actif' : '' }}">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M4 1.5h6l2.5 2.5V14.5h-8.5V1.5z"/><path d="M6 7h4M6 9.5h4M6 12h2.5"/></svg>
                Demandes
            </a>
            <a href="{{ route('admin.inventaires.index') }}" class="{{ request()->routeIs('admin.inventaires.*') ? 'actif' : '' }}">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4"><rect x="2.5" y="2" width="11" height="12" rx="0.5"/><path d="M5 6.5l1 1 2-2M5 11l1 1 2-2"/><path d="M10 6.5h3M10 11h3"/></svg>
                Inventaires
            </a>
        </nav>

        <div class="barre-laterale-profil">
            <div class="profil-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="profil-details">
                <div class="profil-nom">{{ auth()->user()->name }}</div>
                <div class="profil-role">Administrateur</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="profil-deconnexion" title="Déconnexion">
                    <svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2H3.5a1 1 0 00-1 1v10a1 1 0 001 1H6"/><path d="M10.5 11l3-3-3-3"/><path d="M13.5 8h-8"/></svg>
                </button>
            </form>
        </div>
    </div>

    <div class="contenu">
        @if (session('succes'))
            <div class="message message-succes">{{ session('succes') }}</div>
        @endif

        @if (session('erreur'))
            <div class="message message-erreur">{{ session('erreur') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
