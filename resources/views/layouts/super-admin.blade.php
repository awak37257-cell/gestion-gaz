<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Super-admin')</title>
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
                var(--couleur-fond);
            color: var(--couleur-texte);
            font-variant-numeric: tabular-nums;
        }

        h1, h2, h3 {
            font-family: var(--police-titre);
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .entete-app {
            background: linear-gradient(135deg, #241F3D 0%, #3B2A5E 100%);
            color: #fff;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .entete-app-logo { display: flex; align-items: center; gap: 10px; font-family: var(--police-titre); font-size: 16px; font-weight: 600; }

        .entete-app-profil { display: flex; align-items: center; gap: 12px; }

        .profil-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--degrade-primaire);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .profil-nom { font-size: 13px; font-weight: 600; }
        .profil-role { font-size: 10.5px; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 0.05em; }

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

        .contenu { padding: 32px 40px; max-width: 1120px; margin: 0 auto; }

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

        .message { padding: 13px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 14px; border: 1px solid transparent; }
        .message-succes { background: #D1FAE5; color: #065F46; border-color: #A7F3D0; }
        .message-erreur { background: #FEE2E2; color: #B91C1C; border-color: #FECACA; }
        .message-info { background: #EDE9FE; color: #5B21B6; border-color: #DDD6FE; }

        .carte {
            background: var(--couleur-carte);
            border: 1px solid var(--couleur-bordure);
            border-radius: var(--rayon);
            padding: 22px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(139,92,246,0.07);
            position: relative;
        }

        .carte-accent { padding-left: 27px; }
        .carte-accent::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            border-radius: var(--rayon) 0 0 var(--rayon);
            background: var(--degrade-primaire);
        }

        .icone-badge-petit {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            background: var(--degrade-primaire);
            box-shadow: 0 3px 9px rgba(139,92,246,0.3);
        }
        .icone-badge-petit svg { stroke: #fff; }

        table { width: 100%; border-collapse: collapse; }
        tbody tr:nth-child(even) { background: rgba(139,92,246,0.025); }
        tbody tr:hover { background: #F6F2FC; }

        th, td { text-align: left; padding: 11px 12px; border-bottom: 1px solid var(--couleur-bordure); font-size: 13.5px; }
        th { color: var(--couleur-texte-clair); font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 0.06em; }

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

        .bouton-petit { padding: 7px 15px; font-size: 11px; }

        .erreur-champ { color: var(--couleur-danger); font-size: 13px; margin-top: -14px; margin-bottom: 16px; }

        .badge { display: inline-block; padding: 3px 11px; border-radius: 999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; }
        .badge-actif { background: #D1FAE5; color: #065F46; }
        .badge-suspendu { background: #FEF3C7; color: #92400E; }
        .badge-expire { background: #FEE2E2; color: #B91C1C; }

        .mot-de-passe-bloc {
            background: #241F3D;
            color: #fff;
            padding: 16px 18px;
            border-radius: 12px;
            font-family: var(--police-chiffres);
            font-size: 16px;
            letter-spacing: 0.05em;
            margin: 12px 0;
        }
    </style>
</head>
<body>
    <div class="entete-app">
        <div class="entete-app-logo">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="#EC4899" stroke-width="1.8"/>
                <line x1="12" y1="12" x2="16" y2="7" stroke="#EC4899" stroke-width="1.8" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="1.8" fill="#EC4899"/>
            </svg>
            Super-admin — Gestion Dépôt Gaz
        </div>

        <div class="entete-app-profil">
            <div class="profil-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="profil-nom">{{ auth()->user()->name }}</div>
                <div class="profil-role">Éditeur du logiciel</div>
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
