<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Administration')</title>
    <style>
        :root {
            --couleur-primaire: #1e7a4c;
            --couleur-primaire-fonce: #14562f;
            --couleur-primaire-clair: #e3f5ea;
            --couleur-danger: #b3261e;
            --couleur-danger-clair: #fbe9e7;
            --couleur-warning: #f59e0b;
            --couleur-warning-clair: #fff2cc;
            --couleur-info: #3b82f6;
            --couleur-info-clair: #dbe9fb;
            --couleur-fond: #f4f6f5;
            --couleur-carte: #ffffff;
            --couleur-texte: #1a1a1a;
            --couleur-texte-clair: #666666;
            --couleur-bordure: #e2e2e2;
            --rayon: 10px;
            --ombre: 0 2px 6px rgba(0,0,0,0.04);
            --transition: all 0.3s ease;
        }

        * { 
            box-sizing: border-box; 
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: var(--couleur-fond);
            color: var(--couleur-texte);
            display: flex;
            min-height: 100vh;
        }

        /* ===== BARRE LATÉRALE ===== */
        .barre-laterale {
            width: 260px;
            background: #112719;
            color: #fff;
            padding: 24px 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 12px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .barre-laterale::-webkit-scrollbar {
            width: 4px;
        }

        .barre-laterale::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }

        .barre-laterale-haut h2 {
            font-size: 18px;
            padding: 0 20px 18px;
            margin: 0;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: #e2f0e6;
        }

        .barre-laterale nav { 
            display: flex; 
            flex-direction: column; 
            gap: 2px;
            margin-top: 15px; 
            padding: 0 12px;
        }

        .barre-laterale a {
            color: #c2d6cb;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            transition: var(--transition);
        }

        .barre-laterale a:hover { 
            background: rgba(255,255,255,0.08); 
            color: #fff; 
        }

        .barre-laterale a.actif { 
            background: rgba(30, 122, 76, 0.25); 
            color: #fff; 
            font-weight: 500;
            border-left: 3px solid var(--couleur-primaire);
        }

        /* Zone de déconnexion */
        .barre-laterale-bas {
            padding: 0 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 15px;
        }

        .btn-deconnexion {
            background: transparent;
            border: none;
            color: #ff9999;
            width: 100%;
            text-align: left;
            padding: 10px 14px;
            font-size: 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-deconnexion:hover {
            background: rgba(179, 38, 30, 0.2);
            color: #ff6666;
        }

        /* ===== CONTENU PRINCIPAL ===== */
        .contenu { 
            flex: 1; 
            padding: 28px 36px; 
            max-width: 1400px; 
            width: 100%;
            overflow-x: auto;
        }

        .entete-page {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .entete-page h1 { 
            font-size: 26px; 
            margin: 0; 
            color: #112719;
        }

        /* ===== MESSAGES FLASH ===== */
        .message {
            padding: 14px 20px;
            border-radius: var(--rayon);
            margin-bottom: 20px;
            font-size: 14px;
            box-shadow: var(--ombre);
            animation: slideDown 0.3s ease;
        }

        .message-succes { 
            background: var(--couleur-primaire-clair); 
            color: var(--couleur-primaire-fonce); 
            border-left: 4px solid var(--couleur-primaire); 
        }

        .message-erreur { 
            background: var(--couleur-danger-clair); 
            color: var(--couleur-danger); 
            border-left: 4px solid var(--couleur-danger); 
        }

        .message-warning {
            background: var(--couleur-warning-clair);
            color: #8a6d00;
            border-left: 4px solid var(--couleur-warning);
        }

        .message-info {
            background: var(--couleur-info-clair);
            color: #1c4a8a;
            border-left: 4px solid var(--couleur-info);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== CARTES ===== */
        .carte {
            background: var(--couleur-carte);
            border-radius: var(--rayon);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--ombre);
            border: 1px solid rgba(0,0,0,0.03);
            transition: var(--transition);
        }

        .carte:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        /* ===== TABLEAUX ===== */
        table { 
            width: 100%; 
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 12px 16px;
            border-bottom: 1px solid var(--couleur-bordure);
            font-size: 14px;
        }

        th { 
            color: var(--couleur-texte-clair); 
            font-weight: 600; 
            background-color: #fafafa;
        }

        tr:hover td {
            background: #fafbfa;
        }

        /* ===== FORMULAIRES ===== */
        label { 
            display: block; 
            font-size: 14px; 
            font-weight: 600; 
            margin-bottom: 6px; 
            color: #333;
        }

        input, select, textarea {
            width: 100%;
            max-width: 500px;
            padding: 10px 14px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: var(--rayon);
            margin-bottom: 16px;
            background: #fff;
            transition: var(--transition);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--couleur-primaire);
            box-shadow: 0 0 0 3px rgba(30, 122, 76, 0.1);
        }

        input.erreur, select.erreur, textarea.erreur {
            border-color: var(--couleur-danger);
        }

        .erreur-champ { 
            color: var(--couleur-danger); 
            font-size: 13px; 
            margin-top: -12px; 
            margin-bottom: 14px;
        }

        /* ===== BOUTONS ===== */
        .bouton {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: var(--rayon);
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .bouton:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .bouton-primaire { background: var(--couleur-primaire); color: #fff; }
        .bouton-primaire:hover:not(:disabled) { background: var(--couleur-primaire-fonce); }

        .bouton-secondaire { background: #e5e7eb; color: var(--couleur-texte); }
        .bouton-secondaire:hover:not(:disabled) { background: #d1d5db; }

        .bouton-danger { background: var(--couleur-danger); color: #fff; }
        .bouton-danger:hover:not(:disabled) { background: #8f1e18; }

        .bouton-petit { padding: 6px 14px; font-size: 13px; }

        /* ===== BADGES ===== */
        .badge { 
            display: inline-block; 
            padding: 3px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-attente { background: #fff2cc; color: #8a6d00; }
        .badge-validee { background: #dbe9fb; color: #1c4a8a; }
        .badge-livree { background: #e3f5ea; color: var(--couleur-primaire-fonce); }
        .badge-inactif { background: #f0f0f0; color: #888; }
        .badge-actif { background: #e3f5ea; color: var(--couleur-primaire-fonce); }

        /* ===== UTILITAIRES ===== */
        form.inline { display: inline; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-danger { color: var(--couleur-danger); }
        .text-success { color: var(--couleur-primaire); }
        .text-muted { color: var(--couleur-texte-clair); }
        .mt-2 { margin-top: 16px; }
        .mb-2 { margin-bottom: 16px; }
        .flex { display: flex; }
        .flex-center { align-items: center; }
        .gap-2 { gap: 10px; }
        .flex-wrap { flex-wrap: wrap; }
        .w-full { width: 100%; }

        .separateur {
            height: 1px;
            background: var(--couleur-bordure);
            margin: 20px 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .contenu { padding: 20px 24px; }
        }

        @media (max-width: 768px) {
            .barre-laterale {
                position: fixed;
                transform: translateX(-100%);
                width: 280px;
            }

            .barre-laterale.ouverte {
                transform: translateX(0);
            }

            .contenu { 
                padding: 16px; 
            }

            .entete-page h1 { font-size: 20px; }
        }

        @media (max-width: 480px) {
            .contenu { padding: 12px; }
            .entete-page h1 { font-size: 18px; }
            .carte { padding: 16px; }
            th, td { padding: 8px 10px; font-size: 13px; }
        }

        /* ===== IMPRESSION ===== */
        @media print {
            .no-print, .barre-laterale { 
                display: none !important; 
            }
            body { display: block; background: white; }
            .contenu { padding: 0; max-width: 100%; }
            .carte { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
    <div class="barre-laterale no-print">
        <div class="barre-laterale-haut">
            <h2>Gestion Dépôt Gaz</h2>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'actif' : '' }}">Tableau de bord</a>
                <a href="{{ route('admin.depots.index') }}" class="{{ request()->routeIs('admin.depots.*') ? 'actif' : '' }}">Dépôts</a>
                <a href="{{ route('admin.marques.index') }}" class="{{ request()->routeIs('admin.marques.*') ? 'actif' : '' }}">Marques</a>
                <a href="{{ route('admin.couleurs.index') }}" class="{{ request()->routeIs('admin.couleurs.*') ? 'actif' : '' }}">Couleurs</a>
                <a href="{{ route('admin.vendeurs.index') }}" class="{{ request()->routeIs('admin.vendeurs.*') ? 'actif' : '' }}">Vendeurs</a>
                <a href="{{ route('admin.stocks.index') }}" class="{{ request()->routeIs('admin.stocks.*') ? 'actif' : '' }}">Stocks</a>
                <a href="{{ route('admin.demandes.index') }}" class="{{ request()->routeIs('admin.demandes.*') ? 'actif' : '' }}">Demandes</a>
                <a href="{{ route('admin.inventaires.index') }}" class="{{ request()->routeIs('admin.inventaires.*') ? 'actif' : '' }}">Inventaires</a>
            </nav>
        </div>

        <div class="barre-laterale-bas">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-deconnexion">Déconnexion</button>
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