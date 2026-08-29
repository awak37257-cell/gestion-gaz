<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>@yield('titre', 'Espace Vendeur')</title>
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
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background:
                radial-gradient(circle at 10% 0%, rgba(139,92,246,0.08), transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(236,72,153,0.06), transparent 45%),
                var(--couleur-fond);
            color: var(--couleur-texte);
            font-variant-numeric: tabular-nums;
        }

        h1, h2, h3 {
            font-family: var(--police-titre);
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .entete {
            background: linear-gradient(135deg, #241F3D 0%, #3B2A5E 55%, #6D2860 100%);
            color: #fff;
            padding: 18px 20px;
            border-bottom: 3px solid;
            border-image: linear-gradient(90deg, #8B5CF6, #EC4899, #F97316) 1;
        }

        .entete-ligne { display: flex; align-items: center; gap: 10px; }
        .entete h1 { margin: 0; font-size: 17px; font-weight: 600; }
        .entete p {
            margin: 5px 0 0;
            font-size: 11px;
            opacity: 0.8;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        main {
            padding: 16px;
            max-width: 480px;
            margin: 0 auto;
        }

        .message {
            padding: 13px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .message-succes { background: #D1FAE5; color: #065F46; border-color: #A7F3D0; }
        .message-erreur { background: #FEE2E2; color: #B91C1C; border-color: #FECACA; }

        .carte {
            background: var(--couleur-carte);
            border: 1px solid var(--couleur-bordure);
            border-radius: var(--rayon);
            padding: 18px;
            margin-bottom: 16px;
            box-shadow: 0 2px 10px rgba(139,92,246,0.07);
            position: relative;
        }

        .carte-accent { padding-left: 23px; }
        .carte-accent::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            border-radius: var(--rayon) 0 0 var(--rayon);
            background: var(--degrade-primaire);
        }

        label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; color: var(--couleur-texte); }

        input, select {
            width: 100%;
            padding: 14px 16px;
            font-size: 16px;
            font-family: inherit;
            border: 2px solid var(--couleur-bordure);
            border-radius: 12px;
            margin-bottom: 18px;
            background: #FCFAFF;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

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

        input[type="checkbox"] {
            width: 22px;
            height: 22px;
            margin-right: 8px;
            vertical-align: middle;
            accent-color: #8B5CF6;
        }

        .bouton {
            display: block;
            width: 100%;
            padding: 15px;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            border: 2px solid transparent;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            min-height: 48px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        .bouton-primaire { background: var(--degrade-primaire); color: #fff; box-shadow: 0 4px 14px rgba(139,92,246,0.35); }
        .bouton-primaire:hover { background: var(--degrade-primaire-hover); transform: translateY(-2px); box-shadow: 0 6px 18px rgba(139,92,246,0.42); }

        .bouton-secondaire { background: #fff; color: var(--couleur-texte); border-color: var(--couleur-bordure); margin-top: 10px; }
        .bouton-secondaire:hover { border-color: #8B5CF6; color: #6D28D9; }

        .bouton-danger { background: transparent; color: var(--couleur-danger); text-decoration: underline; text-transform: none; letter-spacing: normal; border: none; }

        .lien-retour {
            display: block;
            text-align: center;
            margin-top: 14px;
            color: var(--couleur-texte-clair);
            font-size: 13px;
        }

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

        .badge-changement { background: #FCE7F3; color: #9D174D; }

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
                <circle cx="12" cy="12" r="9" stroke="#EC4899" stroke-width="1.8"/>
                <line x1="12" y1="12" x2="16" y2="7" stroke="#EC4899" stroke-width="1.8" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="1.8" fill="#EC4899"/>
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
