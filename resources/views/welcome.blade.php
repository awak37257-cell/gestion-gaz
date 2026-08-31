<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GazManager — Gérez votre dépôt de gaz</title>
    <meta name="description" content="GazManager, la plateforme SaaS pour gérer vos dépôts de gaz : stocks, ventes, vendeurs, approvisionnements.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Fond animé */
        .bg-glow {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(249,115,22,.15) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(251,191,36,.08) 0%, transparent 60%);
        }
        .grid-pattern {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Contenu principal */
        .main {
            position: relative; z-index: 1;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center;
            padding: 2rem;
            gap: 0;
        }

        /* Badge */
        .badge {
            display: inline-flex; align-items: center; gap: .45rem;
            background: rgba(249,115,22,.12);
            border: 1px solid rgba(249,115,22,.35);
            color: #f97316;
            padding: .35rem 1rem; border-radius: 999px;
            font-size: .78rem; font-weight: 700;
            letter-spacing: .08em; text-transform: uppercase;
            margin-bottom: 2rem;
            animation: fadeUp .6s ease both;
        }

        /* Logo / titre */
        .logo {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(3rem, 10vw, 7rem);
            font-weight: 900;
            line-height: 1;
            margin-bottom: 1.5rem;
            animation: fadeUp .6s .1s ease both;
        }
        .logo span { color: #f97316; }
        .logo-sub {
            font-size: clamp(.9rem, 2vw, 1.1rem);
            color: #94a3b8;
            letter-spacing: .04em;
            margin-bottom: 2.5rem;
        }

        /* Tagline */
        .tagline {
            font-size: clamp(1.1rem, 3vw, 1.5rem);
            font-weight: 600;
            color: #e2e8f0;
            max-width: 560px;
            line-height: 1.5;
            margin-bottom: 1rem;
            animation: fadeUp .6s .2s ease both;
        }
        .sub {
            font-size: .95rem;
            color: #64748b;
            max-width: 460px;
            line-height: 1.7;
            margin-bottom: 3rem;
            animation: fadeUp .6s .3s ease both;
        }

        /* Boutons */
        .actions {
            display: flex; gap: 1rem; flex-wrap: wrap;
            justify-content: center;
            animation: fadeUp .6s .4s ease both;
            margin-bottom: 4rem;
        }
        .btn-voir {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: 1rem 2.2rem;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: #fff; border-radius: 14px;
            font-weight: 700; font-size: 1.05rem;
            text-decoration: none;
            box-shadow: 0 8px 40px rgba(249,115,22,.4);
            transition: all .25s;
            letter-spacing: .01em;
        }
        .btn-voir:hover { transform: translateY(-3px); box-shadow: 0 14px 50px rgba(249,115,22,.55); }
        .btn-voir:active { transform: translateY(0); }
        .btn-login {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: 1rem 2.2rem;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff; border-radius: 14px;
            font-weight: 600; font-size: 1.05rem;
            text-decoration: none; transition: all .25s;
        }
        .btn-login:hover { background: rgba(255,255,255,.1); }

        /* Features rapides */
        .features {
            display: flex; gap: 2rem; flex-wrap: wrap; justify-content: center;
            animation: fadeUp .6s .5s ease both;
        }
        .feat {
            display: flex; align-items: center; gap: .5rem;
            font-size: .85rem; color: #64748b;
        }
        .feat-dot { width: 6px; height: 6px; border-radius: 50%; background: #f97316; flex-shrink: 0; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .logo { font-size: 3.5rem; }
            .actions { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    <div class="grid-pattern"></div>

    <main class="main">
        <div class="badge">🔥 Plateforme SaaS — Nouvelle génération</div>

        <h1 class="logo">🔥<span>Gaz</span>Manager</h1>
        <p class="logo-sub">Gestion intelligente de dépôts de gaz</p>

        <h2 class="tagline">Gérez votre dépôt de gaz<br>comme jamais auparavant</h2>
        <p class="sub">
            Stocks, ventes, vendeurs, approvisionnements et inventaires —
            tout centralisé dans une seule plateforme cloud sécurisée.
        </p>

        <div class="actions">
            <a href="{{ route('presentation') }}" class="btn-voir" id="btn-voir-plateforme">
                🗺️ Voir la plateforme
            </a>
            @auth
                <a href="{{ url('/admin/dashboard') }}" class="btn-login">📊 Mon dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-login" id="btn-connexion">🔐 Se connecter</a>
            @endauth
        </div>

        <div class="features">
            <div class="feat"><span class="feat-dot"></span> Gestion des stocks temps réel</div>
            <div class="feat"><span class="feat-dot"></span> Accès vendeurs par QR code</div>
            <div class="feat"><span class="feat-dot"></span> Demandes d'approvisionnement</div>
            <div class="feat"><span class="feat-dot"></span> Inventaires physiques</div>
            <div class="feat"><span class="feat-dot"></span> Reçus imprimables</div>
        </div>
    </main>
</body>
</html>
