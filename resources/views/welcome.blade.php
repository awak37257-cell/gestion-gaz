<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GazManager — Solution Cloud de Gestion de Dépôts de Gaz</title>
    <meta name="description" content="GazManager est le logiciel tout-en-un pour gérer votre dépôt de gaz : stocks temps réel, ventes rapides, accès vendeurs par QR code, inventaires et réapprovisionnements.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #f97316;
            --primary-dark:  #ea580c;
            --primary-light: #fed7aa;
            --accent:        #fbbf24;
            --dark-bg:       #0b1329;
            --dark-card:     #131f37;
            --dark-border:   #203152;
            --text-main:     #ffffff;
            --text-light:    #cbd5e1;
            --text-muted:    #8295b5;
            --success:       #10b981;
            --danger:        #ef4444;
            --warning:       #f59e0b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-bg);
            color: var(--text-main);
            overflow-x: hidden;
            line-height: 1.5;
        }

        /* ─── NAVBAR ─────────────────────────────────────────── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 2.5rem;
            background: rgba(11, 19, 41, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .navbar-brand {
            display: flex; align-items: center; gap: .6rem;
            font-family: 'Outfit', sans-serif;
            font-size: 1.45rem; font-weight: 800;
            color: #fff; text-decoration: none;
        }
        .navbar-brand span { color: var(--primary); }
        .navbar-links { display: flex; gap: 2rem; }
        .navbar-links a {
            color: var(--text-muted); text-decoration: none;
            font-size: .9rem; font-weight: 600; transition: color .2s;
        }
        .navbar-links a:hover { color: #fff; }
        .navbar-cta { display: flex; gap: .8rem; align-items: center; }
        .btn-nav-login {
            padding: .5rem 1.2rem;
            border: 1px solid var(--dark-border); border-radius: 999px;
            color: #fff; background: rgba(255,255,255,0.04); font-size: .85rem; font-weight: 600;
            text-decoration: none; transition: all .2s;
        }
        .btn-nav-login:hover { border-color: var(--primary); color: var(--primary); background: rgba(249,115,22,0.08); }
        .btn-nav-cta {
            padding: .5rem 1.4rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none; border-radius: 999px; color: #fff;
            font-size: .85rem; font-weight: 700;
            text-decoration: none; transition: all .2s;
            box-shadow: 0 4px 15px rgba(249,115,22,.35);
        }
        .btn-nav-cta:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(249,115,22,.5); }

        /* ─── HERO ───────────────────────────────────────────── */
        .hero {
            min-height: 92vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center;
            padding: 8rem 2rem 5rem;
            background: radial-gradient(ellipse 85% 65% at 50% 0%, rgba(249,115,22,.22) 0%, transparent 70%);
            position: relative;
        }
        .hero::before {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .hero-content { position: relative; max-width: 880px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(249,115,22,.15);
            border: 1px solid rgba(249,115,22,.4);
            color: var(--primary);
            padding: .4rem 1.2rem; border-radius: 999px;
            font-size: .82rem; font-weight: 700;
            margin-bottom: 1.6rem; letter-spacing: .06em;
            text-transform: uppercase;
        }
        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2.5rem, 6vw, 4.4rem);
            font-weight: 900; line-height: 1.12; margin-bottom: 1.5rem;
        }
        .hero h1 .gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero p {
            font-size: 1.18rem; color: var(--text-light);
            line-height: 1.7; max-width: 660px; margin: 0 auto 2.5rem;
        }
        .hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-hero-main {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: 1rem 2.4rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; border-radius: 14px;
            font-weight: 800; font-size: 1.05rem; text-decoration: none;
            box-shadow: 0 10px 35px rgba(249,115,22,.45); transition: all .25s;
        }
        .btn-hero-main:hover { transform: translateY(-2px); box-shadow: 0 15px 45px rgba(249,115,22,.6); }
        .btn-hero-ghost {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: 1rem 2.2rem;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.14);
            color: #fff; border-radius: 14px;
            font-weight: 600; font-size: 1.05rem; text-decoration: none; transition: all .25s;
        }
        .btn-hero-ghost:hover { background: rgba(255,255,255,.1); }

        /* ─── SECTIONS COMMON ────────────────────────────────── */
        section { padding: 6rem 2rem; }
        .container { max-width: 1180px; margin: 0 auto; }
        .section-header { margin-bottom: 4rem; }
        .section-header.center { text-align: center; }
        .section-label {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(249,115,22,.12); border: 1px solid rgba(249,115,22,.3);
            color: var(--primary); padding: .35rem 1rem; border-radius: 999px;
            font-size: .75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .08em; margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2rem, 4.5vw, 3rem);
            font-weight: 800; line-height: 1.2; margin-bottom: .8rem;
        }
        .section-subtitle {
            font-size: 1.1rem; color: var(--text-muted); max-width: 620px; line-height: 1.6;
        }
        .section-header.center .section-subtitle { margin: 0 auto; }
        .section-divider { border: none; border-top: 1px solid var(--dark-border); }

        /* ─── SHOWCASE AVEC PHOTOS & DESCRIPTIONS ────────────── */
        .showcase-row {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 3.5rem;
            align-items: center;
            margin-bottom: 6rem;
        }
        .showcase-row.reverse {
            grid-template-columns: 0.85fr 1.15fr;
        }
        .showcase-row:last-child { margin-bottom: 0; }

        @media (max-width: 960px) {
            .showcase-row, .showcase-row.reverse {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .showcase-row.reverse .showcase-content { order: 1; }
            .showcase-row.reverse .showcase-preview { order: 2; }
        }

        .showcase-content h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.9rem; font-weight: 800; line-height: 1.25;
            color: #fff; margin-bottom: 1rem;
        }
        .showcase-content p {
            font-size: 1.02rem; color: var(--text-light);
            line-height: 1.7; margin-bottom: 1.5rem;
        }
        .showcase-features { list-style: none; margin-bottom: 1.5rem; }
        .showcase-features li {
            display: flex; align-items: flex-start; gap: .75rem;
            font-size: .92rem; color: var(--text-light);
            padding: .45rem 0;
        }
        .showcase-features li span {
            color: var(--success); font-weight: 800; font-size: 1rem; flex-shrink: 0;
        }

        /* ─── UI MOCKUP WINDOWS (PHOTOS DU SITE) ──────────────── */
        .ui-window {
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.6), 0 0 30px rgba(249,115,22,0.08);
            transition: transform 0.3s ease;
        }
        .ui-window:hover { transform: translateY(-4px); }
        .ui-window-bar {
            background: #1e293b;
            padding: 0.75rem 1rem;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #334155;
        }
        .ui-window-dots { display: flex; gap: 6px; }
        .ui-dot { width: 10px; height: 10px; border-radius: 50%; }
        .ui-dot.red { background: #ef4444; }
        .ui-dot.yellow { background: #f59e0b; }
        .ui-dot.green { background: #10b981; }
        .ui-window-title { font-size: 0.75rem; font-weight: 600; color: #94a3b8; font-family:'JetBrains Mono',monospace; }

        .ui-body { padding: 1.2rem; background: #0f172a; font-size: 0.85rem; }

        /* Mockup 1: Dashboard UI */
        .mockup-kpis {
            display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;
        }
        .mockup-kpi-card {
            background: #1e293b; padding: 0.75rem; border-radius: 10px; border: 1px solid #334155;
        }
        .mockup-kpi-title { font-size: 0.68rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; }
        .mockup-kpi-val { font-family: 'Outfit', sans-serif; font-size: 1.3rem; font-weight: 800; color: #fff; margin-top: 2px; }
        .mockup-kpi-val.orange { color: var(--primary); }
        .mockup-kpi-val.green { color: var(--success); }

        .mockup-table {
            width: 100%; border-collapse: collapse; background: #1e293b; border-radius: 10px; overflow: hidden; font-size: 0.78rem;
        }
        .mockup-table th { background: #182338; color: #94a3b8; padding: 6px 10px; text-align: left; font-size: 0.7rem; }
        .mockup-table td { padding: 8px 10px; border-bottom: 1px solid #28374e; color: #cbd5e1; }
        .mockup-table tr:last-child td { border-bottom: none; }

        /* Mockup 2: Stock Bouteilles UI */
        .mockup-bottles-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;
        }
        .mockup-bottle-card {
            background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 0.85rem;
            display: flex; gap: 0.75rem; align-items: center;
        }
        .mockup-bottle-icon {
            width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
        }
        .bg-yellow-gas { background: rgba(251,191,36,0.15); border: 1px solid rgba(251,191,36,0.3); }
        .bg-red-gas    { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); }
        .bg-blue-gas   { background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.3); }
        .bg-green-gas  { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); }
        .mockup-bottle-info { flex: 1; }
        .mockup-bottle-brand { font-weight: 700; color: #fff; font-size: 0.82rem; }
        .mockup-bottle-count { font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #94a3b8; margin-top: 2px; }
        .mockup-bottle-count strong { color: #34d399; }

        /* Mockup 3: Caisse & Reçu */
        .mockup-caisse-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;
        }
        .mockup-ticket {
            background: #fff; color: #0f172a; border-radius: 10px; padding: 0.9rem; font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .mockup-ticket-head { text-align: center; border-bottom: 1px dashed #94a3b8; padding-bottom: 6px; margin-bottom: 6px; font-weight: 700; }
        .mockup-ticket-row { display: flex; justify-content: space-between; margin: 3px 0; }
        .mockup-ticket-total { border-top: 1px dashed #94a3b8; padding-top: 6px; margin-top: 6px; font-weight: 800; font-size: 0.8rem; display: flex; justify-content: space-between; }

        /* Mockup 4: Mobile Vendeur QR */
        .mockup-phone {
            max-width: 290px; margin: 0 auto; background: #0f172a; border: 4px solid #334155; border-radius: 28px; padding: 1rem; box-shadow: 0 20px 40px rgba(0,0,0,0.7);
        }
        .mockup-phone-notch { width: 90px; height: 14px; background: #334155; border-radius: 0 0 10px 10px; margin: -1rem auto 0.8rem; }
        .mockup-qr-box {
            background: #fff; padding: 0.8rem; border-radius: 12px; text-align: center; color: #0f172a; margin-bottom: 0.8rem;
        }
        .mockup-qr-code { font-size: 3rem; line-height: 1; }
        .mockup-qr-label { font-size: 0.7rem; font-weight: 700; margin-top: 4px; color: #0f172a; }

        /* ─── RÔLES CLIENTS (SANS SUPER ADMIN) ────────────────── */
        .roles-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;
        }
        @media (max-width: 768px) { .roles-grid { grid-template-columns: 1fr; } }
        .role-box {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 20px; padding: 2.5rem; transition: all .3s;
        }
        .role-box:hover { border-color: rgba(249,115,22,.4); transform: translateY(-4px); }
        .role-badge {
            display: inline-block; padding: .3rem .9rem; border-radius: 999px;
            font-size: .75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .06em; margin-bottom: 1.2rem;
        }
        .badge-admin-role { background: rgba(249,115,22,.15); color: var(--primary); border: 1px solid rgba(249,115,22,.3); }
        .badge-vendeur-role { background: rgba(59,130,246,.15); color: #60a5fa; border: 1px solid rgba(59,130,246,.3); }
        .role-box h3 { font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 800; margin-bottom: .8rem; }
        .role-box p { font-size: .95rem; color: var(--text-light); line-height: 1.7; margin-bottom: 1.2rem; }

        /* ─── TECH STACK ─────────────────────────────────────── */
        .tech-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 1rem;
        }
        .tech-card {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 14px; padding: 1.6rem 1rem; text-align: center; transition: all .25s;
        }
        .tech-card:hover { border-color: rgba(249,115,22,.4); transform: translateY(-3px); }
        .tech-logo { font-size: 2.2rem; margin-bottom: .6rem; }
        .tech-name { font-size: .9rem; font-weight: 800; color: #fff; margin-bottom: .2rem; }
        .tech-role { font-size: .75rem; color: var(--text-muted); }
        .tech-tag {
            display: inline-block; margin-top: .6rem; padding: .2rem .6rem;
            background: rgba(249,115,22,.1); border: 1px solid rgba(249,115,22,.25);
            color: var(--primary); border-radius: 999px; font-size: .68rem; font-weight: 700;
        }

        /* ─── PRICING ────────────────────────────────────────── */
        .pricing-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 1.8rem; align-items: start;
        }
        .pricing-card {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 22px; padding: 2.2rem; transition: all .3s; position: relative;
        }
        .pricing-card.featured {
            border-color: var(--primary);
            background: linear-gradient(145deg, rgba(249,115,22,.1), var(--dark-card));
            box-shadow: 0 15px 40px rgba(249,115,22,0.18);
        }
        .featured-badge {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; padding: .35rem 1.3rem; border-radius: 999px;
            font-size: .75rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: .06em; white-space: nowrap;
        }
        .pricing-period {
            font-size: .82rem; color: var(--text-muted); text-transform: uppercase;
            letter-spacing: .08em; font-weight: 700; margin-bottom: .8rem;
        }
        .pricing-price { display: flex; align-items: baseline; gap: .4rem; margin-bottom: .6rem; }
        .price-amount { font-family: 'Outfit', sans-serif; font-size: 3rem; font-weight: 900; color: #fff; }
        .price-currency { font-size: 1.15rem; color: var(--text-muted); font-weight: 700; }
        .price-suffix { font-size: .85rem; color: var(--text-muted); align-self: flex-end; margin-bottom: .5rem; }
        .pricing-desc { font-size: .9rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.5; }
        .pricing-features { list-style: none; margin-bottom: 2rem; }
        .pricing-features li {
            display: flex; align-items: flex-start; gap: .65rem;
            font-size: .9rem; color: var(--text-light);
            padding: .5rem 0; border-bottom: 1px solid rgba(255,255,255,.05);
        }
        .pricing-features li:last-child { border-bottom: none; }
        .feat-icon.ok { color: var(--success); font-weight: 800; }
        .feat-icon.no { color: #64748b; }
        .btn-pricing {
            display: block; width: 100%; padding: .95rem; text-align: center;
            border-radius: 12px; font-weight: 800; font-size: .95rem; text-decoration: none; transition: all .25s;
            cursor: pointer; border: none; font-family: inherit;
        }
        .btn-pricing.primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; box-shadow: 0 6px 25px rgba(249,115,22,.35);
        }
        .btn-pricing.primary:hover { transform: translateY(-2px); box-shadow: 0 10px 35px rgba(249,115,22,.55); }
        .btn-pricing.ghost {
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14); color: #fff;
        }
        .btn-pricing.ghost:hover { background: rgba(255,255,255,.12); }

        /* ─── CHARTE & INTERDICTIONS ─────────────────────────── */
        .rules-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        @media (max-width: 768px) { .rules-grid { grid-template-columns: 1fr; } }
        .rules-block {
            background: var(--dark-card); border: 1px solid var(--dark-border);
            border-radius: 18px; padding: 2.2rem;
        }
        .rules-block.forbidden {
            border-color: rgba(239,68,68,.3);
            background: linear-gradient(145deg, rgba(239,68,68,.05), var(--dark-card));
        }
        .rules-block h3 {
            display: flex; align-items: center; gap: .7rem;
            font-size: 1.15rem; font-weight: 800; margin-bottom: 1.4rem;
        }
        .rules-list { list-style: none; }
        .rules-list li {
            display: flex; align-items: flex-start; gap: .75rem;
            font-size: .9rem; color: var(--text-light);
            padding: .65rem 0; border-bottom: 1px solid rgba(255,255,255,.05); line-height: 1.55;
        }
        .rules-list li:last-child { border-bottom: none; }

        /* ─── FORMULAIRE DEMANDE D'ACCÈS ─────────────────────── */
        .request-section {
            background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(249,115,22,.15) 0%, transparent 80%), #080f1e;
            border-top: 1px solid var(--dark-border);
            padding: 6.5rem 2rem;
        }
        .form-card {
            background: var(--dark-card);
            border: 1px solid rgba(249,115,22,.35);
            border-radius: 24px;
            padding: 3.2rem;
            max-width: 740px;
            margin: 0 auto;
            box-shadow: 0 25px 60px rgba(0,0,0,0.6), 0 0 40px rgba(249,115,22,0.12);
        }
        .form-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1.3rem;
        }
        @media (max-width: 620px) {
            .form-card { padding: 2rem 1.4rem; }
            .form-grid { grid-template-columns: 1fr; }
        }
        .form-group { display: flex; flex-direction: column; gap: .45rem; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { font-size: .85rem; font-weight: 700; color: var(--text-light); }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            background: #0b1329;
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: .9rem 1.1rem;
            color: #fff;
            font-family: inherit;
            font-size: .92rem;
            transition: all .2s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(249,115,22,.25);
            background: #101c3d;
        }
        .form-textarea { resize: vertical; min-height: 95px; }
        .form-btn-submit {
            display: flex; align-items: center; justify-content: center; gap: .6rem;
            width: 100%; padding: 1.15rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; border: none; border-radius: 14px;
            font-size: 1.05rem; font-weight: 800;
            cursor: pointer; transition: all .25s;
            box-shadow: 0 8px 30px rgba(249,115,22,.4);
            margin-top: 1rem; font-family: inherit;
        }
        .form-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(249,115,22,.6); }

        .alert-success {
            background: rgba(16,185,129,.15);
            border: 1px solid rgba(16,185,129,.4);
            color: #6ee7b7;
            padding: 1.25rem 1.5rem;
            border-radius: 14px;
            margin-bottom: 2rem;
            font-size: .95rem;
            line-height: 1.6;
        }

        /* ─── FOOTER ─────────────────────────────────────────── */
        footer {
            background: #050a14;
            border-top: 1px solid rgba(255,255,255,.06);
            padding: 3rem 2rem; text-align: center;
            font-size: .85rem; color: var(--text-muted);
        }
        footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<!-- ════ NAVBAR ════════════════════════════════════════════ -->
<nav class="navbar">
    <a href="{{ url('/') }}" class="navbar-brand">
        🔥 <span>Gaz</span>Manager
    </a>
    <div class="navbar-links">
        <a href="#apercu">Aperçu & Modules</a>
        <a href="#roles">Pour qui ?</a>
        <a href="#stack">Technologies</a>
        <a href="#tarifs">Tarifs</a>
        <a href="#charte">Charte d'utilisation</a>
    </div>
    <div class="navbar-cta">
    
        <a href="#demande-acces" class="btn-nav-cta">Obtenir mon compte</a>
    </div>
</nav>

<!-- ════ HERO ════════════════════════════════════════════════ -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">🔥 Plateforme Cloud pour Dépôts de Gaz</div>
        <h1>
            Pilotez votre réseau de dépôts de gaz<br>
            <span class="gradient">avec une clarté absolue</span>
        </h1>
        <p>
            GazManager réunit en un seul endroit vos stocks en direct, vos encaissements rapides,
            l'accès vendeurs par QR code, les réapprovisionnements et les inventaires physiques.
        </p>
        <div class="hero-actions">
            <a href="#demande-acces" class="btn-hero-main">
                🚀 Obtenir mes accès GazManager
            </a>
            <a href="#apercu" class="btn-hero-ghost">
                👀 Découvrir le logiciel en images
            </a>
        </div>
    </div>
</section>

<!-- ════ APERÇU EN IMAGES & DESCRIPTIONS DES MODULES ════════ -->
<section id="apercu">
    <div class="container">
        <div class="section-header center">
            <div class="section-label">📸 Visite guidée du logiciel</div>
            <h2 class="section-title">Les différentes parties de la plateforme</h2>
            <p class="section-subtitle">Découvrez l'interface intuitive et les modules clés conçus sur mesure pour l'activité gazière.</p>
        </div>

        <!-- 1. TABLEAU DE BORD ADMIN -->
        <div class="showcase-row">
            <div class="showcase-preview">
                <div class="ui-window">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots"><div class="ui-dot red"></div><div class="ui-dot yellow"></div><div class="ui-dot green"></div></div>
                        <div class="ui-window-title">admin/dashboard — GazManager</div>
                    </div>
                    <div class="ui-body">
                        <div class="mockup-kpis">
                            <div class="mockup-kpi-card">
                                <div class="mockup-kpi-title">Ventes du Jour</div>
                                <div class="mockup-kpi-val orange">48 btl.</div>
                            </div>
                            <div class="mockup-kpi-card">
                                <div class="mockup-kpi-title">Recettes du Jour</div>
                                <div class="mockup-kpi-val green">312 000 F</div>
                            </div>
                            <div class="mockup-kpi-card">
                                <div class="mockup-kpi-title">Alertes Stock</div>
                                <div class="mockup-kpi-val" style="color:var(--danger);">2 alertes</div>
                            </div>
                        </div>

                        <div style="font-size:0.75rem;font-weight:700;color:#94a3b8;margin-bottom:6px;">RÉPARTITION DES VENTES PAR DÉPÔT</div>
                        <table class="mockup-table">
                            <thead>
                                <tr><th>Dépôt</th><th>Bouteilles vendues</th><th>Montant total</th></tr>
                            </thead>
                            <tbody>
                                <tr><td><strong>Dépôt Central Akwa</strong></td><td>28 btl.</td><td>182 000 FCFA</td></tr>
                                <tr><td><strong>Point Bonabéri</strong></td><td>14 btl.</td><td>91 000 FCFA</td></tr>
                                <tr><td><strong>Kiosque Makepe</strong></td><td>6 btl.</td><td>39 000 FCFA</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="showcase-content">
                <div class="section-label">Module 01</div>
                <h3>Tableau de bord Administrateur</h3>
                <p>
                    Gardez une visibilité totale et instantanée sur l'ensemble de votre commerce.
                    En un coup d'œil, suivez le chiffre d'affaires quotidien, les mouvements de bouteilles par dépôt et les alertes de réapprovisionnement critique.
                </p>
                <ul class="showcase-features">
                    <li><span>✓</span> Statistiques de vente en temps réel pour chaque point de vente</li>
                    <li><span>✓</span> Indicateurs clés de recettes et de volumes écoulés</li>
                    <li><span>✓</span> Notification automatique dès qu'un seuil de stock bas est franchi</li>
                </ul>
            </div>
        </div>

        <!-- 2. GESTION DES STOCKS -->
        <div class="showcase-row reverse">
            <div class="showcase-preview">
                <div class="ui-window">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots"><div class="ui-dot red"></div><div class="ui-dot yellow"></div><div class="ui-dot green"></div></div>
                        <div class="ui-window-title">admin/stocks — Niveaux de Bouteilles</div>
                    </div>
                    <div class="ui-body">
                        <div class="mockup-bottles-grid">
                            <div class="mockup-bottle-card">
                                <div class="mockup-bottle-icon bg-yellow-gas">🛢️</div>
                                <div class="mockup-bottle-info">
                                    <div class="mockup-bottle-brand">TotalGaz 12.5kg (Jaune)</div>
                                    <div class="mockup-bottle-count">Pleines : <strong>64</strong> • Vides : 18</div>
                                </div>
                            </div>
                            <div class="mockup-bottle-card">
                                <div class="mockup-bottle-icon bg-red-gas">🛢️</div>
                                <div class="mockup-bottle-info">
                                    <div class="mockup-bottle-brand">Tradex 12.5kg (Rouge)</div>
                                    <div class="mockup-bottle-count">Pleines : <strong>42</strong> • Vides : 25</div>
                                </div>
                            </div>
                            <div class="mockup-bottle-card">
                                <div class="mockup-bottle-icon bg-blue-gas">🛢️</div>
                                <div class="mockup-bottle-info">
                                    <div class="mockup-bottle-brand">Camgaz 12.5kg (Bleu)</div>
                                    <div class="mockup-bottle-count">Pleines : <strong>19</strong> • Vides : 31</div>
                                </div>
                            </div>
                            <div class="mockup-bottle-card">
                                <div class="mockup-bottle-icon bg-green-gas">🛢️</div>
                                <div class="mockup-bottle-info">
                                    <div class="mockup-bottle-brand">Oryx 6kg (Vert)</div>
                                    <div class="mockup-bottle-count">Pleines : <strong>85</strong> • Vides : 12</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="showcase-content">
                <div class="section-label">Module 02</div>
                <h3>Suivi des Stocks & Bouteilles de Gaz</h3>
                <p>
                    Fini les confusions de stock : chaque marque (Total, Tradex, Camgaz, Oryx, etc.) et chaque format de bouteille (12.5kg, 6kg)
                    possède son décompte séparé de bouteilles pleines et de bouteilles vides par dépôt.
                </p>
                <ul class="showcase-features">
                    <li><span>✓</span> Différenciation claire des bouteilles pleines et bouteilles vides</li>
                    <li><span>✓</span> Mise à jour automatique à chaque vente ou approvisionnement</li>
                    <li><span>✓</span> Gestion multi-marques et personnalisation des couleurs de bouteilles</li>
                </ul>
            </div>
        </div>

        <!-- 3. CAISSE & VENTES RAPIDES -->
        <div class="showcase-row">
            <div class="showcase-preview">
                <div class="ui-window">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots"><div class="ui-dot red"></div><div class="ui-dot yellow"></div><div class="ui-dot green"></div></div>
                        <div class="ui-window-title">vendeur/ventes/creer — Point de Vente & Reçu</div>
                    </div>
                    <div class="ui-body">
                        <div class="mockup-caisse-grid">
                            <div style="background:#1e293b;padding:0.8rem;border-radius:10px;border:1px solid #334155;">
                                <div style="font-size:0.75rem;font-weight:700;color:#94a3b8;margin-bottom:8px;">ENREGISTREMENT VENTE</div>
                                <div style="background:#0f172a;padding:6px;border-radius:6px;margin-bottom:6px;font-size:0.75rem;">
                                    TotalGaz 12.5kg x <strong>2</strong> = 13 000 F
                                </div>
                                <div style="background:#0f172a;padding:6px;border-radius:6px;margin-bottom:8px;font-size:0.75rem;">
                                    Tradex 6kg x <strong>1</strong> = 3 500 F
                                </div>
                                <div style="font-weight:800;color:var(--primary);font-size:0.88rem;text-align:right;">
                                    Total: 16 500 FCFA
                                </div>
                            </div>

                            <div class="mockup-ticket">
                                <div class="mockup-ticket-head">🔥 GAZ EXPRESS DOUALA<br><span style="font-size:0.65rem;font-weight:normal;">Reçu Vente #VT-1048</span></div>
                                <div class="mockup-ticket-row"><span>2x Total 12.5kg</span><span>13 000 F</span></div>
                                <div class="mockup-ticket-row"><span>1x Tradex 6kg</span><span>3 500 F</span></div>
                                <div class="mockup-ticket-total"><span>TOTAL</span><span>16 500 FCFA</span></div>
                                <div style="text-align:center;font-size:0.62rem;color:#64748b;margin-top:6px;">Merci de votre confiance !</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="showcase-content">
                <div class="section-label">Module 03</div>
                <h3>Caisse Rapide & Reçus Imprimables</h3>
                <p>
                    L'interface de vente permet à vos vendeurs d'enregistrer une transaction en moins de 10 secondes depuis n'importe quel smartphone ou tablette,
                    puis d'éditer ou imprimer instantanément un ticket de caisse certifié.
                </p>
                <ul class="showcase-features">
                    <li><span>✓</span> Saisie ultra-rapide avec calcul automatique des montants</li>
                    <li><span>✓</span> Génération de reçu au format ticket thermique ou PDF</li>
                    <li><span>✓</span> Déduction immédiate du stock de bouteilles pleines</li>
                </ul>
            </div>
        </div>

        <!-- 4. VENDEUR QR CODE -->
        <div class="showcase-row reverse">
            <div class="showcase-preview">
                <div class="mockup-phone">
                    <div class="mockup-phone-notch"></div>
                    <div class="mockup-qr-box">
                        <div class="mockup-qr-code">📱</div>
                        <div class="mockup-qr-label">QR Code Vendeur #04</div>
                        <div style="font-size:0.65rem;color:#64748b;">Mamadou — Dépôt Akwa</div>
                    </div>
                    <div style="background:#1e293b;border-radius:10px;padding:0.75rem;color:#cbd5e1;font-size:0.75rem;">
                        <div style="color:#34d399;font-weight:700;margin-bottom:4px;">● Session Vendeur Active</div>
                        <div>Accès direct sans mot de passe requis.</div>
                    </div>
                </div>
            </div>
            <div class="showcase-content">
                <div class="section-label">Module 04</div>
                <h3>Accès Vendeurs par QR Code</h3>
                <p>
                    Chaque vendeur dispose d'un QR code personnel imprimé ou sauvegardé sur son téléphone.
                    Un simple scan ouvre directement son espace de travail sans qu'il ait besoin d'un compte email ou d'un mot de passe complexe à mémoriser.
                </p>
                <ul class="showcase-features">
                    <li><span>✓</span> Connexion 100% sécurisée sans mot de passe</li>
                    <li><span>✓</span> Idéal pour les employés terrain et vendeurs en boutique</li>
                    <li><span>✓</span> Possibilité pour le propriétaire d'activer ou désactiver un vendeur en 1 clic</li>
                </ul>
            </div>
        </div>

        <!-- 5. APPROVISIONNEMENTS & INVENTAIRES -->
        <div class="showcase-row">
            <div class="showcase-preview">
                <div class="ui-window">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots"><div class="ui-dot red"></div><div class="ui-dot yellow"></div><div class="ui-dot green"></div></div>
                        <div class="ui-window-title">admin/inventaires — Calcul d'Écarts</div>
                    </div>
                    <div class="ui-body">
                        <table class="mockup-table">
                            <thead>
                                <tr><th>Marque</th><th>Théorique</th><th>Compté</th><th>Écart</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Total 12.5kg</td><td>50 btl.</td><td>50 btl.</td><td><span style="color:#10b981;font-weight:700;">0 (Parfait)</span></td></tr>
                                <tr><td>Tradex 12.5kg</td><td>35 btl.</td><td>34 btl.</td><td><span style="color:#ef4444;font-weight:700;">-1 Manquant</span></td></tr>
                                <tr><td>Camgaz 12.5kg</td><td>20 btl.</td><td>20 btl.</td><td><span style="color:#10b981;font-weight:700;">0 (Parfait)</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="showcase-content">
                <div class="section-label">Module 05</div>
                <h3>Approvisionnements & Inventaires Physiques</h3>
                <p>
                    Contrôlez les flux d'approvisionnement des camions livreurs et réalisez des inventaires de terrain périodiques.
                    Le système calcule automatiquement les écarts pour éliminer les pertes et les fuites de stock.
                </p>
                <ul class="showcase-features">
                    <li><span>✓</span> Workflow de validation des livraisons de gaz</li>
                    <li><span>✓</span> Inventaires avec calcul automatique des surplus et manques</li>
                    <li><span>✓</span> Historique complet pour la comptabilité et les audits</li>
                </ul>
            </div>
        </div>

    </div>
</section>

<hr class="section-divider">

<!-- ════ POUR QUI EST FAIT GAZMANAGER (2 RÔLES DÉDIÉS) ═════ -->
<section id="roles" style="background: rgba(255,255,255,.015);">
    <div class="container">
        <div class="section-header center">
            <div class="section-label">👥 Espaces Utilisateurs</div>
            <h2 class="section-title">Conçu pour votre entreprise et vos équipes</h2>
            <p class="section-subtitle">Deux interfaces spécialement pensées pour les besoins de chaque collaborateur.</p>
        </div>

        <div class="roles-grid">
            <!-- Propriétaire / Gestionnaire -->
            <div class="role-box">
                <div class="role-badge badge-admin-role">Espace Propriétaire / Gérant</div>
                <h3>👨‍💼 Administrateur de Dépôt</h3>
                <p>
                    Le patron ou gérant contrôle toute l'activité : création des dépôts, configuration des marques et des prix,
                    gestion des vendeurs, validation des demandes d'approvisionnement et analyse financière détaillée.
                </p>
                <ul class="showcase-features">
                    <li><span>✓</span> Vision consolidée de tous vos points de vente</li>
                    <li><span>✓</span> Gestion autonome de vos stocks et de vos prix</li>
                    <li><span>✓</span> Export comptable et historique des opérations</li>
                </ul>
            </div>

            <!-- Vendeur de Terrain -->
            <div class="role-box">
                <div class="role-badge badge-vendeur-role">Espace Terrain & Kiosque</div>
                <h3>🧑‍💼 Vendeur & Opérateur de Caisse</h3>
                <p>
                    L'employé en boutique utilise son smartphone pour scanner son QR code d'accès : il enregistre les ventes au client,
                    génère les reçus, demande du réassort et effectue le comptage d'inventaire en toute simplicité.
                </p>
                <ul class="showcase-features">
                    <li><span>✓</span> Interface mobile simplifiée et ultra-rapide</li>
                    <li><span>✓</span> Connexion instantanée sans identifiants compliqués</li>
                    <li><span>✓</span> Impression de reçu client en quelques secondes</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<hr class="section-divider">

<!-- ════ CE QUI A ÉTÉ UTILISÉ POUR CRÉER LE SITE ═════════════ -->
<section id="stack">
    <div class="container">
        <div class="section-header center">
            <div class="section-label">🛠️ Technologies & Conception</div>
            <h2 class="section-title">Ce qui a été utilisé pour créer le site</h2>
            <p class="section-subtitle">Une pile technologique moderne, éprouvée et sécurisée garantissant rapidité et fiabilité.</p>
        </div>

        <div class="tech-grid">
            <div class="tech-card">
                <div class="tech-logo">🟥</div>
                <div class="tech-name">Laravel 12</div>
                <div class="tech-role">Framework PHP robuste</div>
                <div class="tech-tag">Backend</div>
            </div>

            <div class="tech-card">
                <div class="tech-logo">🐘</div>
                <div class="tech-name">PHP 8.3</div>
                <div class="tech-role">Moteur serveur haute vitesse</div>
                <div class="tech-tag">Serveur</div>
            </div>

            <div class="tech-card">
                <div class="tech-logo">🗄️</div>
                <div class="tech-name">MySQL</div>
                <div class="tech-role">Base de données relationnelle</div>
                <div class="tech-tag">Data</div>
            </div>

            <div class="tech-card">
                <div class="tech-logo">🌊</div>
                <div class="tech-name">Tailwind CSS 4</div>
                <div class="tech-role">Design système responsive</div>
                <div class="tech-tag">UI</div>
            </div>

            <div class="tech-card">
                <div class="tech-logo">⚡</div>
                <div class="tech-name">Vite.js</div>
                <div class="tech-role">Compilateur d'assets</div>
                <div class="tech-tag">Build</div>
            </div>

            <div class="tech-card">
                <div class="tech-logo">🍃</div>
                <div class="tech-name">Blade</div>
                <div class="tech-role">Moteur de templates dynamiques</div>
                <div class="tech-tag">Frontend</div>
            </div>

            <div class="tech-card">
                <div class="tech-logo">🔐</div>
                <div class="tech-name">Laravel Auth</div>
                <div class="tech-role">Isolation multi-tenant sécurisée</div>
                <div class="tech-tag">Sécurité</div>
            </div>

            <div class="tech-card">
                <div class="tech-logo">📱</div>
                <div class="tech-name">QR Engine</div>
                <div class="tech-role">Génération d'accès par QR Code</div>
                <div class="tech-tag">Mobile</div>
            </div>
        </div>
    </div>
</section>

<hr class="section-divider">

<!-- ════ TARIFS & ABONNEMENTS ════════════════════════════════ -->
<section id="tarifs" style="background: rgba(255,255,255,.015);">
    <div class="container">
        <div class="section-header center">
            <div class="section-label">💳 Tarifs & Abonnements</div>
            <h2 class="section-title">Des tarifs accessibles et sans engagement</h2>
            <p class="section-subtitle">Choisissez la formule adaptée à la taille de votre activité.</p>
        </div>

        <div class="pricing-grid">
            <!-- Mensuel -->
            <div class="pricing-card">
                <div class="pricing-period">Formule Mensuelle</div>
                <div class="pricing-price">
                    <span class="price-amount">15 000</span>
                    <span class="price-currency">FCFA</span>
                    <span class="price-suffix">/mois</span>
                </div>
                <p class="pricing-desc">Pour tester ou démarrer sans aucun engagement de durée.</p>
                <ul class="pricing-features">
                    <li><span class="feat-icon ok">✓</span> Accès complet à tous les modules</li>
                    <li><span class="feat-icon ok">✓</span> Dépôts et vendeurs illimités</li>
                    <li><span class="feat-icon ok">✓</span> QR code d'accès par vendeur</li>
                    <li><span class="feat-icon ok">✓</span> Impression des reçus de vente</li>
                    <li><span class="feat-icon ok">✓</span> Support client inclus</li>
                    <li><span class="feat-icon no">✗</span> Réduction tarifaire</li>
                </ul>
                <button type="button" class="btn-pricing ghost" onclick="choisirPlan('mensuel')">
                    Choisir la formule Mensuelle
                </button>
            </div>

            <!-- Trimestriel -->
            <div class="pricing-card featured">
                <div class="featured-badge">🔥 Le plus populaire</div>
                <div class="pricing-period">Formule Trimestrielle</div>
                <div class="pricing-price">
                    <span class="price-amount">40 000</span>
                    <span class="price-currency">FCFA</span>
                    <span class="price-suffix">/trimestre</span>
                </div>
                <p class="pricing-desc">La formule recommandée : économisez 5 000 FCFA par trimestre.</p>
                <ul class="pricing-features">
                    <li><span class="feat-icon ok">✓</span> Accès complet à tous les modules</li>
                    <li><span class="feat-icon ok">✓</span> Dépôts et vendeurs illimités</li>
                    <li><span class="feat-icon ok">✓</span> QR code d'accès par vendeur</li>
                    <li><span class="feat-icon ok">✓</span> Impression des reçus de vente</li>
                    <li><span class="feat-icon ok">✓</span> Support client inclus</li>
                    <li><span class="feat-icon ok">✓</span> <strong>Économie de 5 000 FCFA</strong></li>
                </ul>
                <button type="button" class="btn-pricing primary" onclick="choisirPlan('trimestriel')">
                    Choisir la formule Trimestrielle
                </button>
            </div>

            <!-- Annuel -->
            <div class="pricing-card">
                <div class="pricing-period">Formule Annuelle</div>
                <div class="pricing-price">
                    <span class="price-amount">150 000</span>
                    <span class="price-currency">FCFA</span>
                    <span class="price-suffix">/an</span>
                </div>
                <p class="pricing-desc">2 mois gratuits inclus ! La solution la plus économique.</p>
                <ul class="pricing-features">
                    <li><span class="feat-icon ok">✓</span> Accès complet à tous les modules</li>
                    <li><span class="feat-icon ok">✓</span> Dépôts et vendeurs illimités</li>
                    <li><span class="feat-icon ok">✓</span> QR code d'accès par vendeur</li>
                    <li><span class="feat-icon ok">✓</span> Impression des reçus de vente</li>
                    <li><span class="feat-icon ok">✓</span> Support prioritaire 7j/7</li>
                    <li><span class="feat-icon ok">✓</span> <strong>2 mois offerts (30 000 FCFA)</strong></li>
                </ul>
                <button type="button" class="btn-pricing ghost" onclick="choisirPlan('annuel')">
                    Choisir la formule Annuelle
                </button>
            </div>
        </div>
    </div>
</section>

<hr class="section-divider">

<!-- ════ CHARTE & INTERDICTIONS ═════════════════════════════ -->
<section id="charte">
    <div class="container">
        <div class="section-header center">
            <div class="section-label">📜 Charte d'utilisation</div>
            <h2 class="section-title">Autorisations & Interdictions</h2>
            <p class="section-subtitle">Des règles transparentes pour assurer la fiabilité et la sécurité de tous.</p>
        </div>

        <div class="rules-grid">
            <div class="rules-block">
                <h3><span style="color:var(--success);">✅</span> Ce qui est autorisé</h3>
                <ul class="rules-list">
                    <li><span style="color:var(--success);">✓</span> Utiliser GazManager pour administrer vos points de vente et dépôts légaux</li>
                    <li><span style="color:var(--success);">✓</span> Créer autant de vendeurs et de dépôts que requis par votre activité</li>
                    <li><span style="color:var(--success);">✓</span> Imprimer et remettre les reçus commerciaux à vos clients finaux</li>
                    <li><span style="color:var(--success);">✓</span> Exporter vos états de stock et historiques pour votre comptabilité</li>
                    <li><span style="color:var(--success);">✓</span> Utiliser la plateforme depuis n'importe quel ordinateur, tablette ou smartphone</li>
                </ul>
            </div>

            <div class="rules-block forbidden">
                <h3><span style="color:var(--danger);">🚫</span> Ce qui est strictement interdit</h3>
                <ul class="rules-list">
                    <li><span style="color:var(--danger);">✕</span> Partager vos codes d'accès administrateurs avec des tiers non autorisés</li>
                    <li><span style="color:var(--danger);">✕</span> Utiliser le service pour du commerce illicite ou non déclaré</li>
                    <li><span style="color:var(--danger);">✕</span> Revendre, louer ou sous-licencier l'accès au logiciel à des tiers</li>
                    <li><span style="color:var(--danger);">✕</span> Falsifier intentionnellement les registres de vente ou inventaires</li>
                    <li><span style="color:var(--danger);">✕</span> Tenter de décompiler, pirater ou compromettre l'intégrité de la plateforme</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ════ FORMULAIRE DE DEMANDE D'ACCÈS ═════════════════════ -->
<section id="demande-acces" class="request-section">
    <div class="container">
        <div class="section-header center">
            <div class="section-label">🚀 Démarrage Immédiat</div>
            <h2 class="section-title">Obtenez vos accès à GazManager</h2>
            <p class="section-subtitle">
                Remplissez ce formulaire en 1 minute. Votre espace sera activé et vos identifiants vous seront transmis immédiatement.
            </p>
        </div>

        <div class="form-card">
            @if (session('succes_demande'))
                <div class="alert-success">
                    {{ session('succes_demande') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;padding:1rem;border-radius:12px;margin-bottom:1.5rem;font-size:0.88rem;">
                    <ul style="padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('demande-acces.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="nom_entreprise">Nom de l'entreprise / Dépôt <span style="color:var(--primary);">*</span></label>
                        <input type="text" id="nom_entreprise" name="nom_entreprise" class="form-input" placeholder="Ex: Gaz Express Douala" value="{{ old('nom_entreprise') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nom_contact">Nom & Prénom du gérant <span style="color:var(--primary);">*</span></label>
                        <input type="text" id="nom_contact" name="nom_contact" class="form-input" placeholder="Ex: Jean Dupont" value="{{ old('nom_contact') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email de connexion du dépôt <span style="color:var(--primary);">*</span></label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="contact@votre-depot.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="telephone">Numéro Téléphone / WhatsApp <span style="color:var(--primary);">*</span></label>
                        <input type="tel" id="telephone" name="telephone" class="form-input" placeholder="+237 6XX XX XX XX" value="{{ old('telephone') }}" required>
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="periode_souhaitee">Formule d'abonnement souhaitée <span style="color:var(--primary);">*</span></label>
                        <select id="periode_souhaitee" name="periode_souhaitee" class="form-select" required>
                            <option value="mensuel" @selected(old('periode_souhaitee', 'trimestriel') == 'mensuel')>Formule Mensuelle (15 000 FCFA / mois)</option>
                            <option value="trimestriel" @selected(old('periode_souhaitee', 'trimestriel') == 'trimestriel')>Formule Trimestrielle (40 000 FCFA / trimestre — Populaire)</option>
                            <option value="annuel" @selected(old('periode_souhaitee') == 'annuel')>Formule Annuelle (150 000 FCFA / an — 2 mois offerts)</option>
                        </select>
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="message">Message ou besoins particuliers (Optionnel)</label>
                        <textarea id="message" name="message" class="form-textarea" placeholder="Nombre de dépôts prévus, questions particulières...">{{ old('message') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="form-btn-submit">
                    <span>📨 Envoyer ma demande d'accès</span>
                </button>
            </form>

            <p style="text-align:center;font-size:.82rem;color:var(--text-muted);margin-top:1.5rem;line-height:1.5;">
                🔒 Vos informations restent strictement confidentielles. Dès validation de votre demande, vos identifiants d'accès vous sont transmis pour vous connecter immédiatement.
            </p>
        </div>
    </div>
</section>

<!-- ════ FOOTER ══════════════════════════════════════════════ -->
<footer>
    <div class="container">
        <p>© {{ date('Y') }} <strong>GazManager</strong> — Plateforme de Gestion de Dépôts de Gaz. Tous droits réservés.</p>
        <p style="margin-top:.6rem;">
            <a href="#apercu">Aperçu & Modules</a> • <a href="#tarifs">Tarifs</a> • <a href="#charte">Charte</a> • <a href="{{ route('login') }}">Espace de Connexion Dépôt</a>
        </p>
    </div>
</footer>

<script>
    function choisirPlan(plan) {
        const select = document.getElementById('periode_souhaitee');
        if (select) { select.value = plan; }
        const formSection = document.getElementById('demande-acces');
        if (formSection) {
            formSection.scrollIntoView({ behavior: 'smooth' });
            const inputNom = document.getElementById('nom_entreprise');
            if (inputNom) { setTimeout(() => inputNom.focus(), 600); }
        }
    }
</script>
</body>
</html>
