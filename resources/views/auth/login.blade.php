<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Dépôt Gaz</title>
    <style>
        :root {
            --couleur-primaire: #1e7a4c;
            --couleur-primaire-fonce: #14562f;
            --couleur-danger: #b3261e;
            --couleur-fond: #f4f6f5;
            --couleur-carte: #ffffff;
            --couleur-texte: #1a1a1a;
            --couleur-texte-clair: #666666;
            --couleur-bordure: #e2e2e2;
            --rayon: 8px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--couleur-fond);
            color: var(--couleur-texte);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .carte-connexion {
            width: 100%;
            max-width: 400px;
            background: var(--couleur-carte);
            border-radius: var(--rayon);
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            border: 1px solid var(--couleur-bordure);
        }

        h1 { 
            font-size: 22px; 
            margin-top: 0; 
            margin-bottom: 24px; 
            text-align: center; 
            color: var(--couleur-primaire-fonce); 
        }
        
        label { 
            display: block; 
            font-size: 13px; 
            font-weight: 600; 
            margin-bottom: 6px; 
            color: var(--couleur-texte);
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid var(--couleur-bordure);
            border-radius: var(--rayon);
            margin-bottom: 16px;
            background: #fff;
            transition: border-color 0.15s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--couleur-primaire);
        }

        .bouton {
            display: block;
            width: 100%;
            padding: 11px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            border: none;
            border-radius: var(--rayon);
            cursor: pointer;
            background: var(--couleur-primaire);
            color: #fff;
            transition: background 0.15s;
        }

        .bouton:hover { background: var(--couleur-primaire-fonce); }
        
        .erreur-champ { 
            color: var(--couleur-danger); 
            font-size: 12px; 
            margin-top: -12px; 
            margin-bottom: 14px; 
        }
    </style>
</head>
<body>

    <div class="carte-connexion">
        <h1>Gestion Dépôt Gaz</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="erreur-champ">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="erreur-champ">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: normal; display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--couleur-texte-clair);">
                    <input type="checkbox" name="se_souvenir" style="width: auto; margin: 0; accent-color: var(--couleur-primaire);"> Se souvenir de moi
                </label>
            </div>

            <button type="submit" class="bouton">Se connecter</button>
        </form>
    </div>

</body>
</html>