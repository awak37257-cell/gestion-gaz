<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('titre', 'Espace Vendeur') — GazManager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&family=JetBrains+Mono:wght@600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #f97316;
            --primary-dark:  #ea580c;
            --dark-bg:       #0f172a;
            --dark-card:     #1e293b;
            --body-bg:       #f1f5f9;
            --card-bg:       #ffffff;
            --card-border:   #e2e8f0;
            --text-main:     #0f172a;
            --text-muted:    #64748b;
            --success:       #10b981;
            --danger:        #ef4444;
            --radius:        16px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--body-bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 70px;
        }

        /* ─── HEADER VENDEUR ─────────────────────────────────── */
        .vendeur-header {
            background: #0f172a;
            color: #fff;
            padding: 1rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-bottom: 2px solid var(--primary);
        }

        .header-content {
            max-width: 540px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .seller-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .seller-avatar {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; font-weight: 800; font-size: 1.1rem;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 3px 10px rgba(249,115,22,0.4);
        }

        .seller-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
        }

        .depot-badge {
            font-size: 0.72rem;
            color: var(--primary);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-header-logout {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            padding: 0.45rem 0.8rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ─── MAIN APP CONTAINER ─────────────────────────────── */
        main {
            padding: 1.25rem 1rem;
            max-width: 540px;
            width: 100%;
            margin: 0 auto;
            flex: 1;
        }

        /* ─── CARDS & COMPONENTS ─────────────────────────────── */
        .carte, .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 1.25rem;
            margin-bottom: 1.2rem;
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.05);
        }

        .carte-accent {
            border-left: 4px solid var(--primary);
        }

        /* ─── ACTION BUTTONS (MOBILE OPTIMIZED) ──────────────── */
        .btn-action-big {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.2rem 1.4rem;
            background: #ffffff;
            border: 2px solid var(--card-border);
            border-radius: 16px;
            color: var(--text-main);
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .btn-action-big:hover, .btn-action-big:active {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(249,115,22,0.15);
        }

        .btn-action-big.primary-action {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            box-shadow: 0 6px 20px rgba(249,115,22,0.35);
        }

        .btn-action-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            background: #fff7ed;
            color: var(--primary);
            font-size: 1.4rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .btn-action-big.primary-action .btn-action-icon {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        /* ─── BUTTONS ────────────────────────────────────────── */
        .bouton, .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.9rem;
            font-size: 0.95rem;
            font-weight: 800;
            border-radius: 12px;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            font-family: inherit;
            transition: all 0.2s;
        }

        .bouton-primaire, .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            box-shadow: 0 4px 15px rgba(249,115,22,0.35);
        }

        .bouton-secondaire, .btn-secondary {
            background: #fff;
            color: var(--text-main);
            border-color: var(--card-border);
        }

        /* ─── FORMS ──────────────────────────────────────────── */
        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
            color: var(--text-main);
        }

        input, select, textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 2px solid var(--card-border);
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            color: var(--text-main);
            background: #ffffff;
            margin-bottom: 1.1rem;
            transition: all 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(249,115,22,0.15);
        }

        /* ─── ALERTS ─────────────────────────────────────────── */
        .message {
            padding: 0.9rem 1.1rem;
            border-radius: 12px;
            margin-bottom: 1.2rem;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .message-succes { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .message-erreur { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* ─── BOTTOM NAV MOBILE ──────────────────────────────── */
        .bottom-nav {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #ffffff;
            border-top: 1px solid var(--card-border);
            display: flex;
            justify-content: space-around;
            padding: 0.5rem 0.5rem 0.6rem;
            z-index: 50;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.05);
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.3rem 0.6rem;
            border-radius: 8px;
            transition: all 0.15s;
        }

        .bottom-nav-item.active, .bottom-nav-item:hover {
            color: var(--primary);
        }

        .bottom-nav-item svg { width: 20px; height: 20px; }
    </style>
</head>
<body>

    <!-- ════ HEADER VENDEUR ═══════════════════════════════════ -->
    <header class="vendeur-header">
        <div class="header-content">
            <div class="seller-info">
                <div class="seller-avatar">🔥</div>
                <div>
                    <div class="seller-name">{{ session('vendeur_nom', 'Vendeur') }}</div>
                    <div class="depot-badge">
                        <span>🏬</span> {{ session('vendeur_depot_nom', 'Dépôt') }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('vendeur.deconnexion') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-header-logout" onclick="return confirm('Terminer votre session de vente ?')">
                    ✕ Déconnexion
                </button>
            </form>
        </div>
    </header>

    <!-- ════ CONTENU PRINCIPAL ════════════════════════════════ -->
    <main>
        @if (session('succes'))
            <div class="message message-succes">
                <span>✓</span> {{ session('succes') }}
            </div>
        @endif

        @if (session('erreur'))
            <div class="message message-erreur">
                <span>✕</span> {{ session('erreur') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ════ BARRE DE NAVIGATION INFÉRIEURE MOBILE ════════════ -->
    <nav class="bottom-nav">
        <a href="{{ route('vendeur.dashboard') }}" class="bottom-nav-item {{ request()->routeIs('vendeur.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Accueil
        </a>
        <a href="{{ route('vendeur.ventes.create') }}" class="bottom-nav-item {{ request()->routeIs('vendeur.ventes.*') ? 'active' : '' }}" style="color:var(--primary);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            Vente
        </a>
        <a href="{{ route('vendeur.demandes.create') }}" class="bottom-nav-item {{ request()->routeIs('vendeur.demandes.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            Réassort
        </a>
        <a href="{{ route('vendeur.inventaires.create') }}" class="bottom-nav-item {{ request()->routeIs('vendeur.inventaires.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Inventaire
        </a>
    </nav>

</body>
</html>
