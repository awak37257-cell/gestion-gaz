<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>@yield('titre', 'Espace Vendeur')</title>
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
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--couleur-fond);
            color: var(--couleur-texte);
            font-variant-numeric: tabular-nums;
        }

        h1, h2, h3 {
            font-family: var(--police-titre);
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .entete {
            background: linear-gradient(135deg, #1B1F1D 0%, #262B27 55%, #33241F 100%);
            color: #fff;
            padding: 18px 20px;
            border-bottom: 3px solid;
            border-image: linear-gradient(90deg, #B8863D, #7A3B3E) 1;
        }

        .entete-ligne { display: flex; align-items: center; gap: 10px; }
        .entete h1 { margin: 0; font-size: 17px; font-weight: 600; }
        .entete p {
            margin: 5px 0 0;
            font-size: 11px;
            opacity: 0.75;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        main {
            padding: 16px;
            max-width: 480px;
            margin: 0 auto;
        }

        .message {
            padding: 12px 14px;
            border-radius: var(--rayon);
            margin-bottom: 16px;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .message-succes { background: #F1F4EF; color: #3F6B4A; border-color: #D3DFCF; }
        .message-erreur { background: #FBEEEB; color: var(--couleur-danger); border-color: #EAD1CB; }

        .carte {
            background: var(--couleur-carte);
            border: 1px solid var(--couleur-bordure);
            border-radius: var(--rayon);
            padding: 18px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(27,31,29,0.05);
            position: relative;
        }

        .carte-accent { padding-left: 22px; }
        .carte-accent::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            border-radius: var(--rayon) 0 0 var(--rayon);
            background: var(--degrade-primaire);
        }

        label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--couleur-texte); }

        input, select {
            width: 100%;
            padding: 13px 14px;
            font-size: 16px;
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

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            vertical-align: middle;
            accent-color: var(--couleur-primaire);
        }

        .bouton {
            display: block;
            width: 100%;
            padding: 14px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            border: 1.5px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            min-height: 48px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, border-color 0.15s ease;
        }

        .bouton-primaire { background: var(--degrade-primaire); color: #fff; box-shadow: 0 3px 10px rgba(122,59,62,0.28); }
        .bouton-primaire:hover { background: var(--degrade-primaire-hover); transform: translateY(-1px); box-shadow: 0 5px 14px rgba(122,59,62,0.34); }

        .bouton-secondaire { background: #fff; color: var(--couleur-texte); border-color: var(--couleur-bordure); margin-top: 10px; }
        .bouton-secondaire:hover { border-color: var(--couleur-primaire); background: #FAF7F2; }

        .bouton-danger { background: transparent; color: var(--couleur-danger); text-decoration: underline; text-transform: none; letter-spacing: normal; border: none; }

        .lien-retour {
            display: block;
            text-align: center;
            margin-top: 14px;
            color: var(--couleur-texte-clair);
            font-size: 13px;
        }

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

        .badge-changement { background: #F7F1E6; color: #7A5423; border: 1px solid #E8DABF; }

        @media print {
            .no-print, .entete { display: none !important; }
            body { background: #fff; }
            main { max-width: 100%; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="entete">
        <div class="entete-ligne">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="#96692C" stroke-width="1.6"/>
                <line x1="12" y1="12" x2="16" y2="7" stroke="#96692C" stroke-width="1.6" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="1.6" fill="#96692C"/>
            </svg>
            <h1>@yield('titre', 'Espace Vendeur')</h1>
        </div>
        @isset($vendeur)
            <p>{{ $vendeur->nom }} — Dépôt {{ $vendeur->depot->nom }}</p>
        @endisset
    </div>

    <main>
        @if (session('succes'))
            <div class="message message-succes">{{ session('succes') }}</div>
        @endif

        @if (session('erreur'))
            <div class="message message-erreur">{{ session('erreur') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
