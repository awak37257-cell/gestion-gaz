<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Administration') — GazManager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fed7aa;
            --accent: #fbbf24;
            --sidebar-bg: #0f172a;
            --sidebar-border: #1e293b;
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --radius-md: 14px;
            --radius-sm: 8px;
            --shadow-card: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--body-bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* ─── SIDEBAR ────────────────────────────────────────── */
        .sidebar {
            width: 255px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 50;
        }

        .sidebar-header {
            padding: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .sidebar-logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35);
        }

        .sidebar-brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1.15rem; font-weight: 800; color: #fff;
            line-height: 1.1;
        }
        .sidebar-client-name {
            font-size: 0.72rem;
            color: var(--primary);
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
            margin-top: 2px;
        }

        .sidebar-nav {
            padding: 1.2rem 0.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 0.6rem 0.8rem 0.25rem;
            margin-top: 0.4rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.86rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.35);
        }

        .sidebar-link svg {
            flex-shrink: 0;
            opacity: 0.9;
        }

        .sidebar-footer {
            padding: 1.1rem 1.2rem;
            border-top: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(15, 23, 42, 0.6);
        }

        .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; font-weight: 800; font-size: 0.9rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 0.82rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.7rem; color: #94a3b8; }

        .btn-logout {
            background: transparent; border: none; color: #94a3b8;
            cursor: pointer; padding: 6px; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .btn-logout:hover { color: var(--danger); background: rgba(239, 68, 68, 0.1); }

        /* ─── IMPERSONATION BANNER ───────────────────────────── */
        .impersonation-bar {
            background: linear-gradient(90deg, #8b5cf6, #ec4899);
            color: #fff;
            padding: 0.5rem 1.5rem;
            font-size: 0.82rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-exit-impersonation {
            background: #fff;
            color: #8b5cf6;
            border: none;
            padding: 0.25rem 0.8rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 800;
            cursor: pointer;
        }

        /* ─── MAIN CONTENT ───────────────────────────────────── */
        .main-wrapper {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid var(--card-border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .topbar-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .content-area {
            padding: 2rem;
            max-width: 1250px;
            width: 100%;
            margin: 0 auto;
        }

        /* ─── CARDS & COMPONENTS ─────────────────────────────── */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-card);
        }

        .card-accent {
            position: relative;
            padding-left: 1.75rem;
        }
        .card-accent::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0; width: 4px;
            border-radius: var(--radius-md) 0 0 var(--radius-md);
            background: var(--primary);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .entete-page {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }
        .entete-page h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
        }

        /* ─── STATS GRID ─────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: var(--radius-md);
            padding: 1.3rem;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0; width: 4px;
            background: var(--primary);
        }
        .stat-card.accent-green::before { background: var(--success); }
        .stat-card.accent-yellow::before { background: var(--warning); }
        .stat-card.accent-red::before { background: var(--danger); }

        .stat-icon-wrapper {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: #fff7ed;
            color: var(--primary);
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .stat-card.accent-green .stat-icon-wrapper { background: #ecfdf5; color: var(--success); }
        .stat-card.accent-yellow .stat-icon-wrapper { background: #fffbeb; color: var(--warning); }
        .stat-card.accent-red .stat-icon-wrapper { background: #fef2f2; color: var(--danger); }

        .stat-content { flex: 1; }
        .stat-label { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-value { font-family: 'JetBrains Mono', monospace; font-size: 1.7rem; font-weight: 800; color: var(--text-main); line-height: 1.1; margin-top: 0.2rem; }

        /* ─── TABLES ─────────────────────────────────────────── */
        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--card-border);
        }
        td {
            padding: 0.9rem 1rem;
            font-size: 0.88rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }

        /* ─── BADGES ─────────────────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.25rem 0.65rem; border-radius: 999px;
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .badge-actif { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-suspendu { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .badge-expire { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* ─── BUTTONS ────────────────────────────────────────── */
        .bouton, .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.65rem 1.15rem;
            font-size: 0.82rem;
            font-weight: 700;
            border-radius: var(--radius-sm);
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s;
            font-family: inherit;
        }
        .bouton-primaire, .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.3);
        }
        .bouton-primaire:hover, .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.45);
        }
        .bouton-secondaire, .btn-secondary {
            background: #fff;
            color: var(--text-main);
            border-color: var(--card-border);
        }
        .bouton-secondaire:hover, .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .bouton-petit, .btn-sm {
            padding: 0.4rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 6px;
        }

        /* ─── FORMS ──────────────────────────────────────────── */
        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.4rem;
        }
        input, select, textarea {
            width: 100%;
            max-width: 480px;
            padding: 0.7rem 0.9rem;
            border: 1px solid var(--card-border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-main);
            background: #ffffff;
            margin-bottom: 1.1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

        /* ─── ALERTS ─────────────────────────────────────────── */
        .message, .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .message-succes, .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .message-erreur, .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .message-info, .alert-info { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
    </style>
</head>
<body>

    @if (session('impersonation_super_admin_id'))
        <div class="impersonation-bar" style="position:fixed;top:0;left:0;right:0;z-index:999;">
            <span>🛡️ Vous êtes connecté en tant que Super Admin sur le compte de ce client</span>
            <form method="POST" action="{{ route('impersonation.quitter') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-exit-impersonation">Quitter l'accès client</button>
            </form>
        </div>
    @endif

    <!-- ════ SIDEBAR ════════════════════════════════════════════ -->
    <aside class="sidebar" style="{{ session('impersonation_super_admin_id') ? 'padding-top: 36px;' : '' }}">
        <div class="sidebar-header">
            <div class="sidebar-logo-icon">🔥</div>
            <div>
                <div class="sidebar-brand-name">GazManager</div>
                <div class="sidebar-client-name">{{ auth()->user()->client?->nom ?? 'Mon Dépôt' }}</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Principal</div>

            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Tableau de bord
            </a>

            <div class="nav-section-title">Exploitation</div>

            <a href="{{ route('admin.stocks.index') }}" class="sidebar-link {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                Gestion des stocks
            </a>

            <a href="{{ route('admin.demandes.index') }}" class="sidebar-link {{ request()->routeIs('admin.demandes.*') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                Approvisionnements
            </a>

            <a href="{{ route('admin.inventaires.index') }}" class="sidebar-link {{ request()->routeIs('admin.inventaires.*') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Inventaires
            </a>

            <div class="nav-section-title">Structure & Équipes</div>

            <a href="{{ route('admin.depots.index') }}" class="sidebar-link {{ request()->routeIs('admin.depots.*') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Dépôts de gaz
            </a>

            <a href="{{ route('admin.vendeurs.index') }}" class="sidebar-link {{ request()->routeIs('admin.vendeurs.*') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Vendeurs & QR Code
            </a>

            <a href="{{ route('admin.marques.index') }}" class="sidebar-link {{ request()->routeIs('admin.marques.*') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Marques de gaz
            </a>

            <a href="{{ route('admin.couleurs.index') }}" class="sidebar-link {{ request()->routeIs('admin.couleurs.*') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/></svg>
                Formats & Couleurs
            </a>

            <div class="nav-section-title">Configuration</div>

            <a href="{{ route('admin.parametres.index') }}" class="sidebar-link {{ request()->routeIs('admin.parametres.*') ? 'active' : '' }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Paramètres entreprise
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'Administrateur' }}</div>
                <div class="user-role">Gérant Dépôt</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout" title="Déconnexion">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- ════ MAIN WRAPPER ════════════════════════════════════════ -->
    <div class="main-wrapper" style="{{ session('impersonation_super_admin_id') ? 'padding-top: 36px;' : '' }}">
        <header class="topbar">
            <h1 class="topbar-title">@yield('titre', 'Administration')</h1>
            <div style="font-size:0.82rem;color:var(--text-muted);">
                Abonnement : <span class="badge badge-actif">{{ ucfirst(auth()->user()->client?->periode_abonnement ?? 'Actif') }}</span>
            </div>
        </header>

        <main class="content-area">
            @if (session('succes'))
                <div class="alert alert-success">
                    <span>✓</span> {{ session('succes') }}
                </div>
            @endif

            @if (session('erreur'))
                <div class="alert alert-danger">
                    <span>✕</span> {{ session('erreur') }}
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info">
                    <span>ℹ</span> {{ session('info') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>