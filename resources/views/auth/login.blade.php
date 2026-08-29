<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        :root {
            --couleur-primaire: #8B5CF6;
            --couleur-danger: #EF4444;
            --couleur-fond: #FAF8FC;
            --couleur-texte: #241F3D;
            --couleur-texte-clair: #7A7390;
            --couleur-bordure: #EBE6F5;
            --rayon: 16px;
            --police-titre: Georgia, 'Iowan Old Style', 'Times New Roman', serif;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background:
                radial-gradient(circle at 15% 15%, rgba(139,92,246,0.12), transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(236,72,153,0.10), transparent 45%),
                radial-gradient(circle at 85% 15%, rgba(249,115,22,0.06), transparent 40%),
                #FAF8FC;
            color: #241F3D;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .carte-connexion {
            background: #fff;
            border: 1px solid var(--couleur-bordure);
            padding: 36px 32px;
            border-radius: var(--rayon);
            width: 100%;
            max-width: 360px;
        }

        h1 {
            font-family: var(--police-titre);
            font-size: 19px;
            font-weight: 600;
            margin: 0 0 4px;
            text-align: center;
        }

        .sous-titre {
            text-align: center;
            font-size: 12px;
            color: var(--couleur-texte-clair);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 26px;
        }

        label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }

        input {
            width: 100%;
            padding: 13px 16px;
            font-size: 15px;
            font-family: inherit;
            border: 2px solid var(--couleur-bordure);
            border-radius: 12px;
            margin-bottom: 18px;
            background: #FCFAFF;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        input:focus {
            outline: none;
            border-color: #8B5CF6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(139,92,246,0.16);
        }

        .bouton {
            display: block;
            width: 100%;
            padding: 14px;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            box-shadow: 0 4px 14px rgba(139,92,246,0.35);
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .bouton:hover {
            background: linear-gradient(135deg, #7C3AED 0%, #DB2777 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(139,92,246,0.42);
        }

        .erreur {
            color: #B91C1C;
            font-size: 13px;
            margin-bottom: 16px;
            padding: 10px 14px;
            background: #FEE2E2;
            border: 1px solid #FECACA;
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <div class="carte-connexion">
        <h1>Gestion Dépôt Gaz</h1>
        <div class="sous-titre">Espace administrateur</div>

        @if ($errors->any())
            <div class="erreur">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="bouton">Se connecter</button>
        </form>
    </div>
</body>
</html>
