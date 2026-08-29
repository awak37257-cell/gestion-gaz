<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>@yield('titre', 'Espace Vendeur')</title>
    <style>
        :root {
            --couleur-primaire: #1e7a4c;
            --couleur-primaire-fonce: #14562f;
            --couleur-danger: #b3261e;
            --couleur-fond: #f4f6f5;
            --couleur-carte: #ffffff;
            --couleur-texte: #1a1a1a;
            --couleur-texte-clair: #666666;
            --couleur-bordure: #d1d5db;
            --rayon: 12px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--couleur-fond);
            color: var(--couleur-texte);
        }

        .entete {
            background: var(--couleur-primaire);
            color: #fff;
            padding: 18px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .entete h1 { margin: 0; font-size: 19px; font-weight: 600; }
        .entete p { margin: 5px 0 0; font-size: 13px; opacity: 0.95; }

        main {
            padding: 20px 16px;
            max-width: 480px;
            margin: 0 auto;
        }

        .message {
            padding: 14px 16px;
            border-radius: var(--rayon);
            margin-bottom: 20px;
            font-size: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .message-succes { background: #e3f5ea; color: var(--couleur-primaire-fonce); border-left: 4px solid var(--couleur-primaire); }
        .message-erreur { background: #fbe9e7; color: var(--couleur-danger); border-left: 4px solid var(--couleur-danger); }

        .carte {
            background: var(--couleur-carte);
            border-radius: var(--rayon);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.02);
        }

        label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #333; }

        input, select {
            width: 100%;
            padding: 12px 14px;
            font-size: 16px;
            border: 1px solid var(--couleur-bordure);
            border-radius: var(--rayon);
            margin-bottom: 16px;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--couleur-primaire);
            box-shadow: 0 0 0 3px rgba(30, 122, 76, 0.15);
        }

        input[type="checkbox"] {
            width: 22px;
            height: 22px;
            margin-right: 10px;
            vertical-align: middle;
            accent-color: var(--couleur-primaire);
        }

        .bouton {
            display: block;
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            border: none;
            border-radius: var(--rayon);
            cursor: pointer;
            text-decoration: none;
            min-height: 48px;
            transition: background 0.2s;
        }

        .bouton-primaire { background: var(--couleur-primaire); color: #fff; }
        .bouton-primaire:hover { background: var(--couleur-primaire-fonce); }
        
        .bouton-secondaire { background: #e5e7eb; color: var(--couleur-texte); margin-top: 10px; }
        .bouton-secondaire:hover { background: #d1d5db; }
        
        .bouton-danger { background: transparent; color: var(--couleur-danger); text-decoration: underline; border: none; }

        .lien-retour {
            display: block;
            text-align: center;
            margin-top: 16px;
            color: var(--couleur-texte-clair);
            font-size: 14px;
            text-decoration: none;
        }
        .lien-retour:hover { text-decoration: underline; }

        .erreur-champ { color: var(--couleur-danger); font-size: 13px; margin-top: -10px; margin-bottom: 14px; font-weight: 500; }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-changement { background: #fff2cc; color: #8a6d00; }

        @media print {
            .no-print, .entete { display: none !important; }
            body { background: #fff; }
            main { max-width: 100%; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="entete">
        <h1>@yield('titre', 'Espace Vendeur')</h1>
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