<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        :root {
            --couleur-primaire: #96692C;
            --couleur-danger: #8C3A2B;
            --couleur-fond: #F3F2EE;
            --couleur-texte: #1B1F1D;
            --couleur-texte-clair: #6E7268;
            --couleur-bordure: #DEDBD2;
            --rayon: 4px;
            --police-titre: Georgia, 'Iowan Old Style', 'Times New Roman', serif;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background:
                radial-gradient(circle at 15% 15%, rgba(184,134,61,0.10), transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(122,59,62,0.08), transparent 45%),
                var(--couleur-fond);
            color: var(--couleur-texte);
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
            padding: 13px 14px;
            font-size: 15px;
            font-family: inherit;
            border: 1.5px solid var(--couleur-bordure);
            border-radius: 6px;
            margin-bottom: 16px;
            background: #FAFAF7;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--couleur-primaire);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(150,105,44,0.14);
        }

        .bouton {
            display: block;
            width: 100%;
            padding: 13px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background: linear-gradient(135deg, #B8863D 0%, #7A3B3E 100%);
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            box-shadow: 0 3px 10px rgba(122,59,62,0.28);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .bouton:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(122,59,62,0.34);
        }

        .erreur {
            color: var(--couleur-danger);
            font-size: 13px;
            margin-bottom: 16px;
            padding: 10px 12px;
            background: #FBEEEB;
            border: 1px solid #EAD1CB;
            border-radius: var(--rayon);
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
