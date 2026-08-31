<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — GazManager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --dark-bg: #0b1329;
            --dark-card: #131f37;
            --dark-border: #203152;
            --text-main: #ffffff;
            --text-muted: #8295b5;
            --danger: #ef4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Ambient Glow */
        body::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.18) 0%, transparent 70%);
            top: 20%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .login-card {
            position: relative;
            z-index: 10;
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 40px rgba(249, 115, 22, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-logo {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.5rem;
        }

        .brand-logo span { color: var(--primary); }

        .login-subtitle {
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: #cbd5e1;
            margin-bottom: 0.4rem;
        }

        .form-control {
            width: 100%;
            background: #0b1329;
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 0.85rem 1.1rem;
            color: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.25);
            background: #101c3d;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            border-radius: 14px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(249, 115, 22, 0.55);
        }

        .error-message {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 0.35rem;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .login-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        .login-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <a href="{{ url('/') }}" class="brand-logo">
                🔥 <span>Gaz</span>Manager
            </a>
            <p class="login-subtitle">Connexion à votre espace d'administration</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                Identifiants incorrects. Veuillez vérifier votre email et mot de passe.
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="nom@votredepot.com" required autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••••••" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Se connecter
            </button>
        </form>

        <div class="login-footer">
            <p>Pas encore de compte ? <a href="{{ url('/#demande-acces') }}">Demander un accès</a></p>
            <p style="margin-top: 0.5rem;"><a href="{{ url('/') }}">← Retour à l'accueil</a></p>
        </div>
    </div>

</body>
</html>
