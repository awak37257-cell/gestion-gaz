<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Administration')</title>
    <style>
        :root {
            --couleur-primaire: #96692C;
            --couleur-primaire-fonce: #7A5423;
            --couleur-danger: #8C3A2B;
            --couleur-fond: #F3F2EE;
            --couleur-carte: #FFFFFF;
            --couleur-texte: #1B1F1D;
            --couleur-texte-clair: #6E7268;
            --couleur-bordure: #DEDBD2;
            --rayon: 4px;
            --police-titre: Georgia, 'Iowan Old Style', 'Times New Roman', serif;
            --police-chiffres: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            --degrade-primaire: linear-gradient(135deg, #B8863D 0%, #7A3B3E 100%);
            --degrade-primaire-hover: linear-gradient(135deg, #A8763A 0%, #6B2E33 100%);
            --degrade-danger: linear-gradient(135deg, #B14E3D 0%, #7A2A20 100%);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background:
                radial-gradient(circle at 100% 0%, rgba(184,134,61,0.05), transparent 45%),
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
            background: linear-gradient(180deg, #1B1F1D 0%, #262B27 100%);
            color: #fff;
            padding: 24px 0;
            flex-shrink: 0;
        }

        .barre-laterale h2 {
            font-family: var(--police-titre);
            font-size: 16px;
            font-weight: 600;
            padding: 0 24px 18px;
            margin: 0;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .barre-laterale nav { display: flex; flex-direction: column; margin-top: 14px; }

        .barre-laterale a {
            display: flex;
            align-items: center;
            gap: 11px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            padding: 11px 24px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-left: 3px solid transparent;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }

        .barre-laterale a svg { flex-shrink: 0; opacity: 0.85; }

        .barre-laterale a:hover { color: #fff; background: rgba(255,255,255,0.05); }
        .barre-laterale a.actif {
            color: #fff;
            background: linear-gradient(90deg, rgba(184,134,61,0.22), rgba(122,59,62,0.08));
            border-left-color: var(--couleur-primaire);
        }

        .barre-laterale form button {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.18);
            color: rgba(255,255,255,0.85);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            cursor: pointer;
            padding: 9px 14px;
            border-radius: var(--rayon);
            width: 100%;
        }

        .barre-laterale form button:hover { background: rgba(255,255,255,0.16); color: #fff; }

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

        .message {
            padding: 12px 14px;
            border-radius: var(--rayon);
            margin-bottom: 18px;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .message-succes { background: #F1F4EF; color: #3F6B4A; border-color: #D3DFCF; }
        .message-erreur { background: #FBEEEB; color: var(--couleur-danger); border-color: #EAD1CB; }

        .carte {
            background: var(--couleur-carte);
            border: 1px solid var(--couleur-bordure);
            border-radius: var(--rayon);
            padding: 22px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(27,31,29,0.05);
            position: relative;
            transition: box-shadow 0.15s ease;
        }

        .carte-accent, .carte-accent-danger { padding-left: 26px; }

        .carte-accent::before, .carte-accent-danger::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            border-radius: var(--rayon) 0 0 var(--rayon);
        }

        .carte-accent::before { background: var(--degrade-primaire); }
        .carte-accent-danger::before { background: var(--degrade-danger); }

        .carte-stat {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .icone-badge {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--degrade-primaire);
            box-shadow: 0 3px 8px rgba(122,59,62,0.22);
        }

        .icone-badge.danger { background: var(--degrade-danger); box-shadow: 0 3px 8px rgba(122,42,32,0.22); }
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
            box-shadow: 0 2px 6px rgba(122,59,62,0.22);
        }

        .icone-badge-petit svg { stroke: #fff; }

        .entete-page-titre { display: flex; align-items: center; gap: 14px; }

        table { width: 100%; border-collapse: collapse; }

        tbody tr:nth-child(even) { background: rgba(27,31,29,0.015); }
        tbody tr:hover { background: #F7F5F0; }

        th, td {
            text-align: left;
            padding: 11px 12px;
            border-bottom: 1px solid var(--couleur-bordure);
            font-size: 13.5px;
        }

        th {
            color: var(--couleur-texte-clair);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.06em;
        }

        label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }

        input, select {
            width: 100%;
            max-width: 360px;
            padding: 11px 14px;
            font-size: 14px;
            font-family: inherit;
            border: 1.5px solid var(--couleur-bordure);
            border-radius: 6px;
            margin-bottom: 16px;
            background: #FAFAF7;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--couleur-primaire);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(150,105,44,0.14);
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' fill='none' stroke='%236E7268' stroke-width='1.6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        .bouton {
            display: inline-block;
            padding: 10px 18px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            border: 1.5px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, border-color 0.15s ease;
        }

        .bouton-primaire {
            background: var(--degrade-primaire);
            color: #fff;
            box-shadow: 0 2px 8px rgba(122,59,62,0.25);
        }
        .bouton-primaire:hover { background: var(--degrade-primaire-hover); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(122,59,62,0.32); }

        .bouton-secondaire { background: #fff; color: var(--couleur-texte); border-color: var(--couleur-bordure); }
        .bouton-secondaire:hover { border-color: var(--couleur-primaire); background: #FAF7F2; }

        .bouton-danger { background: #fff; color: var(--couleur-danger); border-color: #EAD1CB; }
        .bouton-danger:hover { background: #FBEEEB; }

        .bouton-petit { padding: 6px 12px; font-size: 11px; }

        .erreur-champ { color: var(--couleur-danger); font-size: 13px; margin-top: -12px; margin-bottom: 14px; }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 2px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .badge-attente { background: #F7F1E6; color: #7A5423; border: 1px solid #E8DABF; }
        .badge-validee { background: #EEF1F4; color: #3D5266; border: 1px solid #D6DEE5; }
        .badge-livree { background: #F1F4EF; color: #3F6B4A; border: 1px solid #D3DFCF; }
        .badge-inactif { background: #F1F0EC; color: #8A8D85; border: 1px solid var(--couleur-bordure); }

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
                <circle cx="12" cy="12" r="9" stroke="#96692C" stroke-width="1.6"/>
                <line x1="12" y1="12" x2="16" y2="7" stroke="#96692C" stroke-width="1.6" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="1.6" fill="#96692C"/>
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

        <form method="POST" action="{{ route('logout') }}" style="padding:0 24px;margin-top:24px;">
            @csrf
            <button type="submit">Déconnexion</button>
        </form>
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
