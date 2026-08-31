<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GazManager — Présentation complète de la plateforme</title>
    <meta name="description" content="Découvrez GazManager, le SaaS complet de gestion de dépôts de gaz. Gérez vos stocks, ventes, vendeurs et approvisionnements en toute simplicité.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #f97316;
            --primary-dark:  #ea580c;
            --primary-light: #fed7aa;
            --accent:        #fbbf24;
            --dark:          #0f172a;
            --dark-card:     #1e293b;
            --dark-border:   #334155;
            --text-muted:    #94a3b8;
            --text-light:    #cbd5e1;
            --success:       #22c55e;
            --danger:        #ef4444;
            --warning:       #f59e0b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: #f8fafc;
            overflow-x: hidden;
        }

        /* ─── NAVBAR ─────────────────────────────────────────── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 2rem;
            background: rgba(15,23,42,0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .navbar-brand {
            display: flex; align-items: center; gap: .6rem;
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem; font-weight: 700;
            color: #fff; text-decoration: none;
        }
        .navbar-brand span { color: var(--primary); }
        .navbar-links { display: flex; gap: 2rem; }
        .navbar-links a {
            color: var(--text-muted); text-decoration: none;
            font-size: .9rem; transition: color .2s;
        }
        .navbar-links a:hover { color: #fff; }
        .navbar-cta { display: flex; gap: .75rem; }
        .btn-outline-sm {
            padding: .45rem 1.1rem;
            border: 1px solid var(--dark-border); border-radius: 8px;
            color: #fff; background: transparent; font-size: .85rem;
            text-decoration: none; transition: all .2s;
        }
        .btn-outline-sm:hover { border-color: var(--primary); color: var(--primary); }
        .btn-primary-sm {
            padding: .45rem 1.1rem;
            background: var(--primary); border: 1px solid var(--primary);
            border-radius: 8px; color: #fff;
            font-size: .85rem; font-weight: 600;
            text-decoration: none; transition: all .2s;
        }
        .btn-primary-sm:hover { background: var(--primary-dark); }

        /* ─── HERO ───────────────────────────────────────────── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center;
            padding: 6rem 2rem 4rem;
            background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(249,115,22,.18) 0%, transparent 70%);
            position: relative;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-content { position: relative; max-width: 820px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(249,115,22,.15);
            border: 1px solid rgba(249,115,22,.4);
            color: var(--primary);
            padding: .35rem 1rem; border-radius: 999px;
            font-size: .8rem; font-weight: 600;
            margin-bottom: 1.5rem; letter-spacing: .05em;
            text-transform: uppercase;
        }
        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 900; line-height: 1.1; margin-bottom: 1.5rem;
        }
        .hero h1 .gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero p {
            font-size: 1.15rem; color: var(--text-light);
            line-height: 1.7; max-width: 600px; margin: 0 auto 2.5rem;
        }
        .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .85rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; border-radius: 12px;
            font-weight: 700; font-size: 1rem; text-decoration: none;
            box-shadow: 0 8px 32px rgba(249,115,22,.35); transition: all .25s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(249,115,22,.5); }
        .btn-ghost {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .85rem 2rem;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff; border-radius: 12px;
            font-weight: 600; font-size: 1rem; text-decoration: none; transition: all .25s;
        }
        .btn-ghost:hover { background: rgba(255,255,255,.1); }
        .hero-stats {
            display: flex; justify-content: center; gap: 3rem;
            margin-top: 4rem; flex-wrap: wrap;
        }
        .stat-item { text-align: center; }
        .stat-number {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem; font-weight: 900; color: var(--primary);
        }
        .stat-label { font-size: .8rem; color: var(--text-muted); margin-top: .2rem; }

        /* ─── SECTIONS ───────────────────────────────────────── */
        section { padding: 5rem 2rem; }
        .container { max-width: 1100px; margin: 0 auto; }
        .section-label {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(249,115,22,.1); border: 1px solid rgba(249,115,22,.25);
            color: var(--primary); padding: .3rem .9rem; border-radius: 999px;
            font-size: .75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .08em; margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800; line-height: 1.2; margin-bottom: .75rem;
        }
        .section-subtitle {
            font-size: 1.05rem; color: var(--text-muted); max-width: 560px; line-height: 1.6;
        }
        .section-header { margin-bottom: 3.5rem; }
        .section-header.center { text-align: center; }
        .section-header.center .section-subtitle { margin: 0 auto; }
        .section-divider { border: none; border-top: 1px solid var(--dark-border); }

        /* ─── MODULE CARDS ───────────────────────────────────── */
        .modules-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 1.5rem;
        }
        .module-card {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 16px; padding: 1.75rem; transition: all .3s;
            position: relative; overflow: hidden;
        }
        .module-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            opacity: 0; transition: opacity .3s;
        }
        .module-card:hover { border-color: rgba(249,115,22,.4); transform: translateY(-4px); }
        .module-card:hover::before { opacity: 1; }
        .module-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 1.1rem;
        }
        .module-card h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: .5rem; color: #fff; }
        .module-card p { font-size: .88rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem; }
        .module-features { list-style: none; }
        .module-features li {
            display: flex; align-items: center; gap: .5rem;
            font-size: .82rem; color: var(--text-light); padding: .3rem 0;
        }
        .module-features li::before {
            content: '✓'; color: var(--success); font-weight: 700; font-size: .8rem; flex-shrink: 0;
        }

        /* ─── ROLES ──────────────────────────────────────────── */
        .roles-layout {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;
        }
        .role-card {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 16px; padding: 2rem; transition: all .3s;
        }
        .role-card:hover { border-color: rgba(249,115,22,.3); }
        .role-avatar {
            width: 64px; height: 64px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin-bottom: 1.2rem;
        }
        .role-avatar.super  { background: rgba(168,85,247,.15); }
        .role-avatar.admin  { background: rgba(249,115,22,.15); }
        .role-avatar.vendeur{ background: rgba(34,197,94,.15); }
        .role-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: .4rem; }
        .role-badge {
            display: inline-block; padding: .2rem .7rem; border-radius: 999px;
            font-size: .72rem; font-weight: 600; margin-bottom: .9rem;
            text-transform: uppercase; letter-spacing: .05em;
        }
        .badge-red    { background: rgba(239,68,68,.15); color: #f87171; }
        .badge-orange { background: rgba(249,115,22,.15); color: var(--primary); }
        .badge-blue   { background: rgba(59,130,246,.15); color: #60a5fa; }
        .role-card p { font-size: .88rem; color: var(--text-muted); line-height: 1.6; }

        /* ─── TECH STACK ─────────────────────────────────────── */
        .tech-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem;
        }
        .tech-card {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 12px; padding: 1.5rem 1rem; text-align: center; transition: all .25s;
        }
        .tech-card:hover { border-color: rgba(249,115,22,.4); transform: translateY(-3px); }
        .tech-logo { font-size: 2.2rem; margin-bottom: .7rem; }
        .tech-name { font-size: .88rem; font-weight: 700; color: #fff; margin-bottom: .25rem; }
        .tech-role { font-size: .75rem; color: var(--text-muted); }
        .tech-tag {
            display: inline-block; margin-top: .6rem; padding: .15rem .6rem;
            background: rgba(249,115,22,.1); border: 1px solid rgba(249,115,22,.2);
            color: var(--primary); border-radius: 999px; font-size: .7rem; font-weight: 600;
        }

        /* ─── PRICING ────────────────────────────────────────── */
        .pricing-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem; align-items: start;
        }
        .pricing-card {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 20px; padding: 2rem; transition: all .3s; position: relative;
        }
        .pricing-card.featured {
            border-color: var(--primary);
            background: linear-gradient(145deg, rgba(249,115,22,.08), var(--dark-card));
        }
        .featured-badge {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; padding: .3rem 1.2rem; border-radius: 999px;
            font-size: .75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .05em; white-space: nowrap;
        }
        .pricing-period {
            font-size: .8rem; color: var(--text-muted); text-transform: uppercase;
            letter-spacing: .08em; font-weight: 600; margin-bottom: .75rem;
        }
        .pricing-price { display: flex; align-items: baseline; gap: .4rem; margin-bottom: .5rem; }
        .price-amount { font-family: 'Outfit', sans-serif; font-size: 3rem; font-weight: 900; color: #fff; }
        .price-currency { font-size: 1.2rem; color: var(--text-muted); }
        .price-suffix { font-size: .85rem; color: var(--text-muted); align-self: flex-end; margin-bottom: .4rem; }
        .pricing-desc { font-size: .88rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.5; }
        .pricing-features { list-style: none; margin-bottom: 2rem; }
        .pricing-features li {
            display: flex; align-items: flex-start; gap: .6rem;
            font-size: .88rem; color: var(--text-light);
            padding: .5rem 0; border-bottom: 1px solid rgba(255,255,255,.04);
        }
        .pricing-features li:last-child { border-bottom: none; }
        .feat-icon { flex-shrink: 0; margin-top: .1rem; }
        .feat-icon.ok { color: var(--success); }
        .feat-icon.no { color: var(--danger); }
        .btn-pricing {
            display: block; width: 100%; padding: .9rem; text-align: center;
            border-radius: 12px; font-weight: 700; font-size: .95rem; text-decoration: none; transition: all .25s;
        }
        .btn-pricing.primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; box-shadow: 0 6px 24px rgba(249,115,22,.3);
        }
        .btn-pricing.primary:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(249,115,22,.5); }
        .btn-pricing.ghost {
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.12); color: #fff;
        }
        .btn-pricing.ghost:hover { background: rgba(255,255,255,.1); }
        .pricing-note { text-align: center; margin-top: 2rem; font-size: .88rem; color: var(--text-muted); }
        .pricing-note a { color: var(--primary); }

        /* ─── CGU ────────────────────────────────────────────── */
        .rules-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        @media (max-width: 700px) { .rules-grid { grid-template-columns: 1fr; } }
        .rules-block {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 16px; padding: 2rem;
        }
        .rules-block.forbidden {
            border-color: rgba(239,68,68,.2);
            background: linear-gradient(145deg, rgba(239,68,68,.04), var(--dark-card));
        }
        .rules-block h3 {
            display: flex; align-items: center; gap: .7rem;
            font-size: 1.05rem; font-weight: 700; margin-bottom: 1.25rem;
        }
        .rules-list { list-style: none; }
        .rules-list li {
            display: flex; align-items: flex-start; gap: .75rem;
            font-size: .88rem; color: var(--text-light);
            padding: .65rem 0; border-bottom: 1px solid rgba(255,255,255,.04); line-height: 1.5;
        }
        .rules-list li:last-child { border-bottom: none; }
        .rule-icon { flex-shrink: 0; font-size: 1rem; margin-top: .1rem; }

        /* ─── CTA & FOOTER ───────────────────────────────────── */
        .cta-section {
            background: radial-gradient(ellipse 70% 70% at 50% 100%, rgba(249,115,22,.15) 0%, transparent 70%);
            border-top: 1px solid rgba(255,255,255,.06);
            text-align: center; padding: 5rem 2rem;
        }
        .cta-section h2 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 800; margin-bottom: 1rem;
        }
        .cta-section p {
            font-size: 1.05rem; color: var(--text-muted); max-width: 500px; margin: 0 auto 2.5rem;
        }
        footer {
            background: #080f1a; border-top: 1px solid rgba(255,255,255,.06);
            padding: 2rem; text-align: center;
            font-size: .82rem; color: var(--text-muted);
        }
        footer a { color: var(--primary); text-decoration: none; }

        /* ─── SCROLL REVEAL ──────────────────────────────────── */
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity .6s ease, transform .6s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }

        /* ─── ICON BG COLORS ─────────────────────────────────── */
        .icon-blue   { background: rgba(59,130,246,.15); }
        .icon-green  { background: rgba(34,197,94,.15); }
        .icon-orange { background: rgba(249,115,22,.15); }
        .icon-purple { background: rgba(168,85,247,.15); }
        .icon-yellow { background: rgba(251,191,36,.15); }
        .icon-cyan   { background: rgba(6,182,212,.15); }

        /* ─── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 768px) {
            .navbar-links { display: none; }
            .hero-stats { gap: 1.5rem; }
            .modules-grid, .pricing-grid { grid-template-columns: 1fr; }
            .tech-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

<!-- ════ NAVBAR ════════════════════════════════════════════ -->
<nav class="navbar">
    <a href="{{ url('/') }}" class="navbar-brand">
        🔥 <span>Gaz</span>Manager
    </a>
    <div class="navbar-links">
        <a href="#modules">Modules</a>
        <a href="#roles">Rôles</a>
        <a href="#stack">Technologies</a>
        <a href="#tarifs">Tarifs</a>
        <a href="#conditions">Conditions</a>
    </div>
    <div class="navbar-cta">
        <a href="{{ route('login') }}" class="btn-outline-sm">Connexion</a>
        <a href="#tarifs" class="btn-primary-sm">S'abonner</a>
    </div>
</nav>

<!-- ════ HERO ════════════════════════════════════════════════ -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">🔥 Plateforme SaaS — Gestion de Gaz</div>
        <h1>
            La solution complète pour gérer<br>
            <span class="gradient">votre dépôt de gaz</span>
        </h1>
        <p>
            GazManager centralise la gestion de vos stocks, ventes, vendeurs et approvisionnements
            en une plateforme cloud sécurisée, accessible 24h/24 depuis n'importe quel appareil.
        </p>
        <div class="hero-actions">
            <a href="#modules" class="btn-primary">🗺️ Explorer la plateforme</a>
            <a href="{{ route('login') }}" class="btn-ghost">🔐 Se connecter</a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-number">∞</div>
                <div class="stat-label">Dépôts gérés</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">360°</div>
                <div class="stat-label">Suivi complet</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">3</div>
                <div class="stat-label">Rôles utilisateurs</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">QR</div>
                <div class="stat-label">Accès vendeurs</div>
            </div>
        </div>
    </div>
</section>

<!-- ════ MODULES ════════════════════════════════════════════ -->
<section id="modules">
    <div class="container">
        <div class="section-header center">
            <div class="section-label reveal">📦 Fonctionnalités</div>
            <h2 class="section-title reveal">Les modules de la plateforme</h2>
            <p class="section-subtitle reveal">Chaque module couvre un aspect précis de la gestion de votre activité gaz.</p>
        </div>
        <div class="modules-grid">

            <div class="module-card reveal">
                <div class="module-icon icon-blue">📊</div>
                <h3>Tableau de bord Admin</h3>
                <p>Vue d'ensemble en temps réel de toute l'activité de votre dépôt : ventes, stocks, demandes et inventaires.</p>
                <ul class="module-features">
                    <li>Statistiques de ventes du jour</li>
                    <li>Alertes de stock faible</li>
                    <li>Demandes en attente de validation</li>
                    <li>Accès rapide aux modules clés</li>
                </ul>
            </div>

            <div class="module-card reveal reveal-delay-1">
                <div class="module-icon icon-orange">🏭</div>
                <h3>Gestion des Dépôts</h3>
                <p>Créez et administrez plusieurs points de distribution de gaz, chacun avec ses stocks et vendeurs propres.</p>
                <ul class="module-features">
                    <li>Création de multiples dépôts</li>
                    <li>Assignation de vendeurs par dépôt</li>
                    <li>Suivi du stock par dépôt</li>
                    <li>Historique complet des opérations</li>
                </ul>
            </div>

            <div class="module-card reveal reveal-delay-2">
                <div class="module-icon icon-green">📦</div>
                <h3>Gestion des Stocks</h3>
                <p>Suivez en temps réel les bouteilles disponibles par marque, couleur et type avec mise à jour automatique.</p>
                <ul class="module-features">
                    <li>Stock par marque (Total, Oryx, Tradex…)</li>
                    <li>Différenciation par couleur de bouteille</li>
                    <li>Mise à jour manuelle des quantités</li>
                    <li>Alertes de rupture de stock</li>
                </ul>
            </div>

            <div class="module-card reveal reveal-delay-3">
                <div class="module-icon icon-purple">💰</div>
                <h3>Enregistrement des Ventes</h3>
                <p>Interface de vente rapide pour les vendeurs terrain avec génération automatique de reçu imprimable.</p>
                <ul class="module-features">
                    <li>Saisie rapide avec sélection produit</li>
                    <li>Choix marque, couleur et quantité</li>
                    <li>Génération de reçu imprimable PDF</li>
                    <li>Déduction automatique du stock</li>
                </ul>
            </div>

            <div class="module-card reveal">
                <div class="module-icon icon-yellow">🚚</div>
                <h3>Demandes d'Approvisionnement</h3>
                <p>Workflow de réapprovisionnement de A à Z : demande du vendeur, validation admin, suivi de livraison.</p>
                <ul class="module-features">
                    <li>Création de demande par le vendeur</li>
                    <li>Validation / rejet par l'admin</li>
                    <li>Statut de livraison en temps réel</li>
                    <li>Historique complet des demandes</li>
                </ul>
            </div>

            <div class="module-card reveal reveal-delay-1">
                <div class="module-icon icon-cyan">📋</div>
                <h3>Inventaires Physiques</h3>
                <p>Réalisez des inventaires terrain et comparez avec le stock théorique pour détecter les écarts.</p>
                <ul class="module-features">
                    <li>Saisie d'inventaire par le vendeur</li>
                    <li>Calcul automatique des écarts</li>
                    <li>Historique des inventaires</li>
                    <li>Détail ligne par ligne</li>
                </ul>
            </div>

            <div class="module-card reveal reveal-delay-2">
                <div class="module-icon icon-orange">👥</div>
                <h3>Gestion des Vendeurs</h3>
                <p>Créez des profils vendeurs avec QR code unique pour un accès ultra-rapide sans mot de passe.</p>
                <ul class="module-features">
                    <li>Création de vendeurs par l'admin</li>
                    <li>QR code unique par vendeur</li>
                    <li>Accès sécurisé sans compte email</li>
                    <li>Déconnexion sécurisée post-session</li>
                </ul>
            </div>

            <div class="module-card reveal reveal-delay-3">
                <div class="module-icon icon-blue">🎨</div>
                <h3>Marques & Couleurs</h3>
                <p>Configurez librement les marques et couleurs de bouteilles que vous commercialisez.</p>
                <ul class="module-features">
                    <li>Création de marques (Total, Oryx…)</li>
                    <li>Gestion des couleurs (jaune, rouge…)</li>
                    <li>Association marque ↔ couleur</li>
                    <li>Personnalisation selon votre catalogue</li>
                </ul>
            </div>

            <div class="module-card reveal">
                <div class="module-icon icon-purple">⚙️</div>
                <h3>Paramètres de l'Entreprise</h3>
                <p>Personnalisez les informations de votre entreprise affichées sur les reçus et toute l'interface.</p>
                <ul class="module-features">
                    <li>Nom et informations de l'entreprise</li>
                    <li>Coordonnées de contact</li>
                    <li>Personnalisation des reçus</li>
                    <li>Configuration générale du compte</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<hr class="section-divider">

<!-- ════ RÔLES ══════════════════════════════════════════════ -->
<section id="roles" style="background: rgba(255,255,255,.015);">
    <div class="container">
        <div class="section-header center">
            <div class="section-label reveal">👤 Utilisateurs</div>
            <h2 class="section-title reveal">3 rôles, chacun à sa place</h2>
            <p class="section-subtitle reveal">La plateforme distingue clairement les responsabilités selon le rôle de chaque utilisateur.</p>
        </div>
        <div class="roles-layout">

            <div class="role-card reveal">
                <div class="role-avatar super">🛡️</div>
                <h3>Super Administrateur</h3>
                <span class="role-badge badge-red">Niveau maximum</span>
                <p>
                    Gère l'ensemble des clients abonnés au SaaS. Crée des comptes, renouvelle les abonnements,
                    suspend les accès, enregistre les paiements et peut se connecter en impersonnation
                    dans n'importe quel compte client pour le support technique.
                </p>
            </div>

            <div class="role-card reveal reveal-delay-1">
                <div class="role-avatar admin">👨‍💼</div>
                <h3>Administrateur Client</h3>
                <span class="role-badge badge-orange">Gestionnaire</span>
                <p>
                    Propriétaire ou responsable d'un dépôt de gaz. Configure les dépôts, marques, couleurs,
                    gère ses vendeurs, valide les demandes d'approvisionnement, suit les stocks en temps réel
                    et consulte toutes les statistiques de son activité.
                </p>
            </div>

            <div class="role-card reveal reveal-delay-2">
                <div class="role-avatar vendeur">🧑‍💼</div>
                <h3>Vendeur</h3>
                <span class="role-badge badge-blue">Opérateur terrain</span>
                <p>
                    Accède à la plateforme via son QR code personnel (sans mot de passe). Enregistre les ventes,
                    soumet des demandes d'approvisionnement, réalise des inventaires physiques
                    et imprime les reçus pour les clients.
                </p>
            </div>

        </div>
    </div>
</section>

<hr class="section-divider">

<!-- ════ STACK TECHNIQUE ════════════════════════════════════ -->
<section id="stack">
    <div class="container">
        <div class="section-header center">
            <div class="section-label reveal">🛠️ Stack technique</div>
            <h2 class="section-title reveal">Construit avec les meilleures technologies</h2>
            <p class="section-subtitle reveal">GazManager repose sur des technologies modernes, éprouvées et sécurisées.</p>
        </div>
        <div class="tech-grid">

            <div class="tech-card reveal">
                <div class="tech-logo">🟥</div>
                <div class="tech-name">Laravel 12</div>
                <div class="tech-role">Framework backend PHP</div>
                <div class="tech-tag">Backend</div>
            </div>

            <div class="tech-card reveal reveal-delay-1">
                <div class="tech-logo">🐘</div>
                <div class="tech-name">PHP 8.3</div>
                <div class="tech-role">Langage serveur</div>
                <div class="tech-tag">Backend</div>
            </div>

            <div class="tech-card reveal reveal-delay-2">
                <div class="tech-logo">🗄️</div>
                <div class="tech-name">MySQL</div>
                <div class="tech-role">Base de données relationnelle</div>
                <div class="tech-tag">Base de données</div>
            </div>

            <div class="tech-card reveal reveal-delay-3">
                <div class="tech-logo">🌊</div>
                <div class="tech-name">Tailwind CSS 4</div>
                <div class="tech-role">Framework CSS utilitaire</div>
                <div class="tech-tag">Frontend</div>
            </div>

            <div class="tech-card reveal">
                <div class="tech-logo">⚡</div>
                <div class="tech-name">Vite.js</div>
                <div class="tech-role">Bundler d'assets ultra-rapide</div>
                <div class="tech-tag">Build</div>
            </div>

            <div class="tech-card reveal reveal-delay-1">
                <div class="tech-logo">🍃</div>
                <div class="tech-name">Blade Templates</div>
                <div class="tech-role">Moteur de templates Laravel</div>
                <div class="tech-tag">Frontend</div>
            </div>

            <div class="tech-card reveal reveal-delay-2">
                <div class="tech-logo">🔐</div>
                <div class="tech-name">Laravel Auth</div>
                <div class="tech-role">Authentification & sessions</div>
                <div class="tech-tag">Sécurité</div>
            </div>

            <div class="tech-card reveal reveal-delay-3">
                <div class="tech-logo">📱</div>
                <div class="tech-name">QR Code</div>
                <div class="tech-role">Accès vendeurs sans mot de passe</div>
                <div class="tech-tag">Fonctionnalité</div>
            </div>

            <div class="tech-card reveal">
                <div class="tech-logo">📨</div>
                <div class="tech-name">Laravel Mailer</div>
                <div class="tech-role">Emails transactionnels</div>
                <div class="tech-tag">Notifications</div>
            </div>

            <div class="tech-card reveal reveal-delay-1">
                <div class="tech-logo">🚀</div>
                <div class="tech-name">Eloquent ORM</div>
                <div class="tech-role">Mapping objet-relationnel</div>
                <div class="tech-tag">Backend</div>
            </div>

        </div>
    </div>
</section>

<hr class="section-divider">

<!-- ════ TARIFS ═════════════════════════════════════════════ -->
<section id="tarifs" style="background: rgba(255,255,255,.015);">
    <div class="container">
        <div class="section-header center">
            <div class="section-label reveal">💳 Abonnements</div>
            <h2 class="section-title reveal">Des tarifs transparents, sans surprise</h2>
            <p class="section-subtitle reveal">Choisissez la formule adaptée à votre activité. Résiliable à la fin de chaque période.</p>
        </div>
        <div class="pricing-grid">

            <!-- Mensuel -->
            <div class="pricing-card reveal">
                <div class="pricing-period">Mensuel</div>
                <div class="pricing-price">
                    <span class="price-currency">XAF</span>
                    <span class="price-amount">15 000</span>
                    <span class="price-suffix">/mois</span>
                </div>
                <p class="pricing-desc">Idéal pour découvrir la plateforme ou pour une utilisation ponctuelle.</p>
                <ul class="pricing-features">
                    <li><span class="feat-icon ok">✓</span> Accès complet à tous les modules</li>
                    <li><span class="feat-icon ok">✓</span> Dépôts et vendeurs illimités</li>
                    <li><span class="feat-icon ok">✓</span> QR Code unique par vendeur</li>
                    <li><span class="feat-icon ok">✓</span> Génération de reçus imprimables</li>
                    <li><span class="feat-icon ok">✓</span> Support par email</li>
                    <li><span class="feat-icon no">✗</span> Remise sur le tarif</li>
                    <li><span class="feat-icon no">✗</span> Support prioritaire</li>
                </ul>
                <a href="{{ route('login') }}" class="btn-pricing ghost">Commencer — Mensuel</a>
            </div>

            <!-- Trimestriel (Featured) -->
            <div class="pricing-card featured reveal reveal-delay-1">
                <div class="featured-badge">🔥 Le plus populaire</div>
                <div class="pricing-period">Trimestriel</div>
                <div class="pricing-price">
                    <span class="price-currency">XAF</span>
                    <span class="price-amount">40 000</span>
                    <span class="price-suffix">/trim.</span>
                </div>
                <p class="pricing-desc">Économisez 11% par rapport au mensuel. Parfait pour une gestion régulière.</p>
                <ul class="pricing-features">
                    <li><span class="feat-icon ok">✓</span> Accès complet à tous les modules</li>
                    <li><span class="feat-icon ok">✓</span> Dépôts et vendeurs illimités</li>
                    <li><span class="feat-icon ok">✓</span> QR Code unique par vendeur</li>
                    <li><span class="feat-icon ok">✓</span> Génération de reçus imprimables</li>
                    <li><span class="feat-icon ok">✓</span> Support par email</li>
                    <li><span class="feat-icon ok">✓</span> Économie de 5 000 FCFA</li>
                    <li><span class="feat-icon no">✗</span> Support prioritaire</li>
                </ul>
                <a href="{{ route('login') }}" class="btn-pricing primary">Commencer — Trimestriel</a>
            </div>

            <!-- Annuel -->
            <div class="pricing-card reveal reveal-delay-2">
                <div class="pricing-period">Annuel</div>
                <div class="pricing-price">
                    <span class="price-currency">XAF</span>
                    <span class="price-amount">150 000</span>
                    <span class="price-suffix">/an</span>
                </div>
                <p class="pricing-desc">La meilleure valeur : 2 mois offerts. Idéal pour les entreprises établies.</p>
                <ul class="pricing-features">
                    <li><span class="feat-icon ok">✓</span> Accès complet à tous les modules</li>
                    <li><span class="feat-icon ok">✓</span> Dépôts et vendeurs illimités</li>
                    <li><span class="feat-icon ok">✓</span> QR Code unique par vendeur</li>
                    <li><span class="feat-icon ok">✓</span> Génération de reçus imprimables</li>
                    <li><span class="feat-icon ok">✓</span> Support par email</li>
                    <li><span class="feat-icon ok">✓</span> 2 mois offerts (valeur 30 000 XAF)</li>
                    <li><span class="feat-icon ok">✓</span> Support prioritaire inclus</li>
                </ul>
                <a href="{{ route('login') }}" class="btn-pricing ghost">Commencer — Annuel</a>
            </div>

        </div>
        <p class="pricing-note reveal">
            💬 Besoin d'un devis personnalisé ?
            <a href="mailto:contact@gazmanager.com">Contactez-nous</a>
            — Paiement Mobile Money ou virement accepté.
        </p>
    </div>
</section>

<hr class="section-divider">

<!-- ════ CONDITIONS D'UTILISATION ═══════════════════════════ -->
<section id="conditions">
    <div class="container">
        <div class="section-header center">
            <div class="section-label reveal">📜 Conditions d'utilisation</div>
            <h2 class="section-title reveal">Ce que vous pouvez faire — et ce qui est interdit</h2>
            <p class="section-subtitle reveal">
                En utilisant GazManager, vous acceptez les conditions ci-dessous.
                Elles protègent vos données et l'intégrité de la plateforme.
            </p>
        </div>

        <div class="rules-grid">

            <div class="rules-block reveal">
                <h3>✅ Ce qui est autorisé</h3>
                <ul class="rules-list">
                    <li>
                        <span class="rule-icon">✅</span>
                        Utiliser la plateforme pour gérer vos dépôts de gaz légaux
                    </li>
                    <li>
                        <span class="rule-icon">✅</span>
                        Créer autant de vendeurs que nécessaire pour votre activité
                    </li>
                    <li>
                        <span class="rule-icon">✅</span>
                        Exporter vos données à des fins de comptabilité interne
                    </li>
                    <li>
                        <span class="rule-icon">✅</span>
                        Partager l'accès admin avec votre équipe de direction
                    </li>
                    <li>
                        <span class="rule-icon">✅</span>
                        Contacter le support pour toute question technique
                    </li>
                    <li>
                        <span class="rule-icon">✅</span>
                        Résilier l'abonnement à la fin de la période en cours
                    </li>
                    <li>
                        <span class="rule-icon">✅</span>
                        Utiliser l'application sur tous vos appareils (PC, tablette, mobile)
                    </li>
                    <li>
                        <span class="rule-icon">✅</span>
                        Imprimer les reçus de vente pour vos clients
                    </li>
                </ul>
            </div>

            <div class="rules-block forbidden reveal reveal-delay-1">
                <h3>🚫 Ce qui est strictement interdit</h3>
                <ul class="rules-list">
                    <li>
                        <span class="rule-icon">🚫</span>
                        Partager vos identifiants avec des tiers non autorisés
                    </li>
                    <li>
                        <span class="rule-icon">🚫</span>
                        Contourner les mécanismes de sécurité ou d'authentification
                    </li>
                    <li>
                        <span class="rule-icon">🚫</span>
                        Utiliser la plateforme pour des activités illicites ou non déclarées
                    </li>
                    <li>
                        <span class="rule-icon">🚫</span>
                        Revendre ou sous-licencier l'accès à d'autres entreprises sans accord
                    </li>
                    <li>
                        <span class="rule-icon">🚫</span>
                        Tenter d'accéder aux données d'autres clients de la plateforme
                    </li>
                    <li>
                        <span class="rule-icon">🚫</span>
                        Injecter des scripts malveillants, spam ou contenu frauduleux
                    </li>
                    <li>
                        <span class="rule-icon">🚫</span>
                        Utiliser des bots ou outils automatisés pour extraire les données
                    </li>
                    <li>
                        <span class="rule-icon">🚫</span>
                        Falsifier des données de vente ou de stock à des fins frauduleuses
                    </li>
                    <li>
                        <span class="rule-icon">🚫</span>
                        Continuer à utiliser le service après expiration ou suspension
                    </li>
                </ul>
            </div>

        </div>

        <div class="reveal" style="margin-top: 2rem; padding: 1.5rem; background: rgba(251,191,36,.06); border: 1px solid rgba(251,191,36,.2); border-radius: 12px; text-align: center;">
            <p style="font-size: .88rem; color: var(--text-light); line-height: 1.7;">
                ⚖️ <strong>Note juridique :</strong>
                En cas de violation des présentes conditions, GazManager se réserve le droit de suspendre
                ou de résilier l'accès sans préavis et sans remboursement de la période en cours.
                Les litiges sont soumis à la juridiction compétente du lieu du siège social de l'éditeur.
            </p>
        </div>
    </div>
</section>

<hr class="section-divider">

<!-- ════ CTA FINAL ══════════════════════════════════════════ -->
<section class="cta-section">
    <div class="container">
        <h2 class="reveal">Prêt à moderniser votre gestion ?</h2>
        <p class="reveal">
            Rejoignez les dépôts de gaz qui font confiance à GazManager.
            Démarrez en quelques minutes, sans engagement.
        </p>
        <div class="hero-actions reveal">
            <a href="#tarifs" class="btn-primary">🚀 Choisir un abonnement</a>
            <a href="{{ route('login') }}" class="btn-ghost">🔐 Connexion</a>
        </div>
    </div>
</section>

<!-- ════ FOOTER ══════════════════════════════════════════════ -->
<footer>
    <p>
        © {{ date('Y') }} GazManager — Tous droits réservés. Plateforme SaaS de gestion de dépôts de gaz.
        | <a href="#">Politique de confidentialité</a>
        | <a href="#conditions">CGU</a>
        | <a href="mailto:contact@gazmanager.com">Contact</a>
    </p>
</footer>

<script>
    // ─ Scroll reveal
    const revealEls = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => observer.observe(el));

    // ─ Active nav link on scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-links a');
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(s => { if (window.scrollY >= s.offsetTop - 200) current = s.id; });
        navLinks.forEach(a => {
            a.style.color = a.getAttribute('href') === '#' + current ? 'var(--primary)' : '';
        });
    });
</script>
</body>
</html>
