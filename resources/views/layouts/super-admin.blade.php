<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Super Admin') — GazManager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --primary-light: #ede9fe;
            --accent: #ec4899;
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
            width: 260px;
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
            padding: 1.5rem 1.4rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .sidebar-logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.35);
        }

        .sidebar-brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1.15rem; font-weight: 800; color: #fff;
            line-height: 1.2;
        }
        .sidebar-brand-badge {
            font-size: 0.68rem;
            color: #a855f7;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .sidebar-nav {
            padding: 1.2rem 0.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 0.6rem 0.8rem 0.3rem;
            margin-top: 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0.9rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.88rem;
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
            box-shadow: 0 4px 14px rgba(139, 92, 246, 0.4);
        }

        .sidebar-link svg {
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--danger);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.15rem 0.55rem;
            border-radius: 999px;
            animation: pulse 2s infinite;
        }

        .sidebar-footer {
            padding: 1.2rem;
            border-top: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(15, 23, 42, 0.6);
        }

        .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; font-weight: 800; font-size: 0.9rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 0.85rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.72rem; color: #94a3b8; }

        .btn-logout {
            background: transparent; border: none; color: #94a3b8;
            cursor: pointer; padding: 6px; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .btn-logout:hover { color: var(--danger); background: rgba(239, 68, 68, 0.1); }

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

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.8rem;
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

        .stat-card.accent-pink::before { background: var(--accent); }
        .stat-card.accent-green::before { background: var(--success); }
        .stat-card.accent-orange::before { background: var(--warning); }
        .stat-card.accent-red::before { background: var(--danger); }

        .stat-icon-wrapper {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: #f1f5f9;
            color: var(--primary);
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-card.accent-pink .stat-icon-wrapper { background: #fdf2f8; color: var(--accent); }
        .stat-card.accent-green .stat-icon-wrapper { background: #ecfdf5; color: var(--success); }
        .stat-card.accent-orange .stat-icon-wrapper { background: #fffbeb; color: var(--warning); }
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
        .badge-purple { background: #f5f3ff; color: #5b21b6; border: 1px solid #ddd6fe; }

        /* ─── BUTTONS ────────────────────────────────────────── */
        .btn {
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
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.45);
        }
        .btn-secondary {
            background: #fff;
            color: var(--text-main);
            border-color: var(--card-border);
        }
        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .btn-sm {
            padding: 0.4rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 6px;
        }
        .btn-danger-outline {
            background: #fff;
            color: var(--danger);
            border-color: #fecaca;
        }
        .btn-danger-outline:hover {
            background: #fef2f2;
            border-color: var(--danger);
        }

        /* ─── FORMS ──────────────────────────────────────────── */
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.4rem;
        }
        .form-control {
            width: 100%;
            max-width: 480px;
            padding: 0.7rem 0.9rem;
            border: 1px solid var(--card-border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-main);
            background: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
        }

        /* ─── ALERTS ─────────────────────────────────────────── */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-info { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

        .key-banner {
            background: #0f172a;
            color: #f8fafc;
            border-radius: var(--radius-md);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(139, 92, 246, 0.3);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .key-code {
            font-family: 'JetBrains Mono', monospace;
            background: #1e293b;
            color: #34d399;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            display: inline-block;
            margin: 0.6rem 0;
            letter-spacing: 0.05em;
            border: 1px solid #334155;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body>

    <!-- ════ SIDEBAR ════════════════════════════════════════════ -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo-icon">⚡</div>
            <div>
                <div class="sidebar-brand-name">GazManager</div>
                <div class="sidebar-brand-badge">Super Admin Panel</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Gestion Globale</div>

            <a href="{{ route('super-admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Tableau de bord
            </a>

            <a href="{{ route('super-admin.demandes.index') }}" class="sidebar-link {{ request()->routeIs('super-admin.demandes.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Demandes d'accès
                @php $nbEnAttente = \App\Models\DemandeAcces::where('statut', 'en_attente')->count(); @endphp
                @if ($nbEnAttente > 0)
                    <span class="nav-badge">{{ $nbEnAttente }}</span>
                @endif
            </a>

            <a href="{{ route('super-admin.clients.index') }}" class="sidebar-link {{ request()->routeIs('super-admin.clients.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Clients & Dépôts
            </a>

            <a href="{{ route('super-admin.paiements.index') }}" class="sidebar-link {{ request()->routeIs('super-admin.paiements.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Paiements & MRR
            </a>

            <div class="nav-section-title">Plateforme</div>
            <a href="{{ url('/') }}" target="_blank" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                Voir site public ↗
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'Super Admin' }}</div>
                <div class="user-role">Éditeur SaaS</div>
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
    <div class="main-wrapper">
        <header class="topbar">
            <h1 class="topbar-title">@yield('titre', 'Super Admin')</h1>
            <div class="topbar-actions">
                
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