<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — Coursify</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --navy:        #153759;
            --lav-1:       #F5F1FC;
            --lav-2:       #E8E1F3;
            --lav-3:       #D4CDF0;
            --lav-4:       #B8AFEB;
            --purple:      #7B6FE8;
            --purple-dark: #5B4FD4;
            --teal:        #00C896;
            --orange:      #FF8A5B;
            --text:        #1A1825;
            --text-soft:   #4A4660;
            --muted:       #8B87A8;
            --border:      rgba(30,58,95,0.1);
            --font-serif:  'Instrument Serif', serif;
            --font-sans:   'Inter', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-sans);
            background: #FEFDFF;
            color: var(--text);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══ LEFT PANEL ═══ */
        .left {
            width: 520px;
            flex-shrink: 0;
            background: white;
            display: flex;
            flex-direction: column;
            padding: 32px 48px;
            min-height: 100vh;
            position: relative;
            z-index: 2;
            overflow-y: auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 28px;
            transition: transform 0.2s;
        }
        .logo:hover { transform: translateY(-1px); }
        .logo-img {
            width: 36px; height: 36px;
            border-radius: 9px; object-fit: cover;
            box-shadow: 0 4px 12px rgba(30,58,95,0.2);
        }
        .logo-text { font-size: 20px; font-weight: 700; letter-spacing: -0.02em; color: var(--text); }

        .form-wrap { flex: 1; display: flex; flex-direction: column; max-width: 420px; }

        h1 {
            font-family: var(--font-serif);
            font-size: 36px; font-weight: 400;
            letter-spacing: -0.02em; line-height: 1.05;
            color: var(--text); margin-bottom: 8px;
        }
        h1 em { font-style: italic; color: var(--purple); }

        .subtitle {
            font-size: 14px; color: var(--muted);
            margin-bottom: 20px; line-height: 1.6;
        }
        .subtitle a { color: var(--purple); font-weight: 600; text-decoration: none; }
        .subtitle a:hover { color: var(--purple-dark); }

        .benefits {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 8px 16px; margin-bottom: 20px;
            padding: 14px 16px;
            background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
            border: 1px solid rgba(123,111,232,0.12);
            border-radius: 14px;
        }
        .benefit-item {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: var(--text-soft); font-weight: 500;
        }
        .check-ic {
            width: 16px; height: 16px; border-radius: 50%;
            background: var(--teal); color: white;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 9px; font-weight: 700;
        }

        .role-section { margin-bottom: 16px; }
        .field-label-top {
            display: block; font-size: 13px; font-weight: 500;
            color: var(--text-soft); margin-bottom: 8px;
        }
        .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .role-card {
            padding: 12px 14px;
            border: 1.5px solid var(--border);
            border-radius: 14px; cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; gap: 10px;
            background: white;
        }
        .role-card:hover { border-color: var(--lav-4); background: var(--lav-1); }
        .role-card.selected {
            border-color: var(--purple);
            background: linear-gradient(135deg, var(--lav-1), rgba(123,111,232,0.05));
            box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
        }
        .role-card input[type=radio] { display: none; }
        .role-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--lav-2);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0; transition: all 0.2s;
            color: var(--purple);
        }
        .role-card.selected .role-icon { background: var(--purple); color: white; transform: scale(1.05); }
        .role-label { font-family: var(--font-serif); font-size: 15px; color: var(--text); letter-spacing: -0.01em; }
        .role-sub { font-size: 11px; color: var(--muted); margin-top: 1px; }

        .field { margin-bottom: 13px; }
        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-soft); margin-bottom: 5px; }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted); font-size: 14px; pointer-events: none;
            width: 16px; text-align: center;
        }
        .input-toggle {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: transparent; border: none;
            color: var(--muted); cursor: pointer;
            padding: 6px; font-size: 13px; transition: color 0.2s;
        }
        .input-toggle:hover { color: var(--purple); }

        input[type=email], input[type=password], input[type=text] {
            width: 100%;
            padding: 11px 16px 11px 42px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 14px; font-family: var(--font-sans);
            color: var(--text); background: #FAFAFB;
            outline: none; transition: all 0.2s;
        }

        /* Sembunyikan toggle password bawaan browser */
        input[type=password]::-ms-reveal,
        input[type=password]::-ms-clear { display: none; }
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button { visibility: hidden; }

        input::placeholder { color: var(--muted); }
        input:focus {
            border-color: var(--purple); background: white;
            box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
        }
        input.error-input { border-color: var(--orange); background: rgba(255,138,91,0.03); }
        input.success-input { border-color: var(--teal); background: rgba(0,200,150,0.03); }

        .error-msg {
            font-size: 12px; color: var(--orange); margin-top: 4px;
            font-weight: 500; display: flex; align-items: center; gap: 4px;
        }

        .strength-bar {
            height: 4px; border-radius: 2px;
            background: #F0EEF5; margin-top: 7px; overflow: hidden;
        }
        .strength-fill { height: 100%; border-radius: 2px; transition: all 0.4s ease; width: 0%; }
        .strength-label { font-size: 11px; margin-top: 4px; color: var(--muted); font-weight: 500; }

        .match-indicator {
            display: flex; align-items: center; gap: 6px;
            font-size: 11px; margin-top: 5px; font-weight: 500;
            transition: all 0.2s; height: 16px;
        }
        .match-indicator.match { color: var(--teal); }
        .match-indicator.no-match { color: var(--orange); }
        .match-indicator.empty { color: transparent; }

        .terms-check {
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 18px; font-size: 13px;
            color: var(--text-soft); line-height: 1.5;
        }
        .terms-check input {
            appearance: none; width: 16px; height: 16px;
            border: 1.5px solid var(--border); border-radius: 4px;
            background: white; cursor: pointer; position: relative;
            transition: all 0.2s; margin-top: 2px; flex-shrink: 0;
            padding: 0;
        }
        .terms-check input:checked { background: var(--purple); border-color: var(--purple); }
        .terms-check input:checked::after {
            content: '✓'; position: absolute;
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            color: white; font-size: 10px; font-weight: 700;
        }
        .terms-check a { color: var(--purple); text-decoration: none; font-weight: 500; }
        .terms-check a:hover { color: var(--purple-dark); text-decoration: underline; }

        .btn-submit {
            width: 100%; padding: 13px; border-radius: 100px;
            border: none; background: #1A1825; color: white;
            font-family: var(--font-sans); font-size: 14px; font-weight: 600;
            cursor: pointer; transition: all 0.25s; margin-bottom: 12px;
            box-shadow: 0 4px 14px rgba(26,24,37,0.3);
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover:not(:disabled) {
            background: #2A2840; transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26,24,37,0.4);
        }
        .btn-submit:active:not(:disabled) { transform: scale(0.98); }
        .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        .btn-spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white; border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-submit.loading .btn-spinner { display: block; }
        .btn-submit.loading .btn-text { opacity: 0.7; }

        .footer-note {
            margin-top: auto; font-size: 11px; color: var(--muted);
            text-align: center; padding-top: 20px; letter-spacing: 0.02em;
        }
        .footer-note strong { color: var(--purple); font-weight: 600; }

        /* ═══════════════════════════════════════════════
           RIGHT PANEL — OVERPOWERED 3D
        ═══════════════════════════════════════════════ */
        .right {
            flex: 1;
            background: linear-gradient(145deg, #1A1232 0%, #2A1F4E 35%, #1E2D5A 70%, #122240 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        /* Orb backgrounds */
        .right::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 500px 400px at 10% 20%, rgba(123,111,232,0.25) 0%, transparent 70%),
                radial-gradient(ellipse 400px 350px at 90% 70%, rgba(0,200,150,0.15) 0%, transparent 70%),
                radial-gradient(ellipse 300px 300px at 50% 100%, rgba(184,175,235,0.2) 0%, transparent 60%);
            pointer-events: none;
            animation: orbShift 10s ease-in-out infinite alternate;
        }

        @keyframes orbShift {
            0%   { opacity: 0.8; transform: scale(1); }
            100% { opacity: 1;   transform: scale(1.05); }
        }

        /* Grid overlay */
        .right::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        /* ─── Home Link ─── */
        .home-link {
            position: absolute; top: 20px; right: 24px;
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 100px;
            padding: 8px 16px;
            font-size: 12px; font-weight: 500;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.25s;
            z-index: 10;
        }
        .home-link:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            border-color: rgba(255,255,255,0.3);
            transform: translateY(-1px);
        }

        /* ─── Right content wrapper ─── */
        .right-content {
            position: relative;
            z-index: 1;
            max-width: 440px;
            width: 100%;
            perspective: 1000px;
        }

        /* ─── Section Label ─── */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(123,111,232,0.2);
            border: 1px solid rgba(123,111,232,0.4);
            border-radius: 100px;
            padding: 6px 14px;
            margin-bottom: 20px;
            font-size: 11px;
            font-weight: 600;
            color: #C4BEFF;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .section-label-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--teal);
            animation: pulse 2s infinite;
            flex-shrink: 0;
        }
        @keyframes pulse {
            0%,100% { opacity:1; transform:scale(1); box-shadow: 0 0 0 0 rgba(0,200,150,0.4); }
            50%      { opacity:0.8; transform:scale(1.2); box-shadow: 0 0 0 4px rgba(0,200,150,0); }
        }

        /* ─── Main Testimonial Card (3D) ─── */
        .tcard-3d-wrapper {
            position: relative;
            transform-style: preserve-3d;
            margin-bottom: 20px;
            animation: cardFloat 6s ease-in-out infinite;
        }
        @keyframes cardFloat {
            0%,100% { transform: translateY(0) rotateX(1deg) rotateY(-1deg); }
            33%      { transform: translateY(-8px) rotateX(-1.5deg) rotateY(1.5deg); }
            66%      { transform: translateY(-4px) rotateX(1deg) rotateY(-0.5deg); }
        }

        /* Glow shadow behind card */
        .tcard-glow {
            position: absolute;
            inset: -2px;
            border-radius: 26px;
            background: linear-gradient(135deg, rgba(123,111,232,0.6), rgba(0,200,150,0.4), rgba(184,175,235,0.5));
            filter: blur(18px);
            opacity: 0.6;
            z-index: -1;
            animation: glowPulse 4s ease-in-out infinite;
        }
        @keyframes glowPulse {
            0%,100% { opacity: 0.5; transform: scale(0.98); }
            50%      { opacity: 0.8; transform: scale(1.02); }
        }

        .testimonial-card {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(40px) saturate(200%);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 24px;
            padding: 28px 28px 24px;
            position: relative;
            overflow: hidden;
        }

        /* Inner top shimmer */
        .testimonial-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        }

        /* Noise texture */
        .testimonial-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 24px;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            background-size: 150px;
            pointer-events: none;
            opacity: 0.4;
        }

        /* Decorative quote mark */
        .quote-deco {
            position: absolute;
            top: 16px; right: 20px;
            font-family: var(--font-serif);
            font-size: 80px;
            line-height: 1;
            color: rgba(123,111,232,0.15);
            font-style: italic;
            pointer-events: none;
            user-select: none;
        }

        .t-tag {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
        }
        .t-tag-icon {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--purple), #9B8FFF);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(123,111,232,0.4);
        }
        .t-tag-text {
            font-size: 11px;
            font-weight: 700;
            color: #C4BEFF;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .t-stars {
            display: flex;
            align-items: center;
            gap: 3px;
            margin-bottom: 14px;
        }
        .t-stars i {
            color: #FFC452;
            font-size: 13px;
            filter: drop-shadow(0 0 4px rgba(255,196,82,0.5));
        }
        .t-stars-count {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            margin-left: 4px;
            font-weight: 500;
        }

        .t-quote {
            font-family: var(--font-serif);
            font-size: 16px;
            line-height: 1.6;
            color: rgba(255,255,255,0.9);
            margin-bottom: 20px;
            letter-spacing: -0.01em;
            position: relative;
            z-index: 1;
        }

        .t-author {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .t-avatar {
            position: relative;
            flex-shrink: 0;
        }
        .t-avatar-ring {
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple), var(--teal));
            z-index: 0;
            animation: ringRotate 4s linear infinite;
        }
        @keyframes ringRotate {
            0%   { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .t-avatar-inner {
            position: relative;
            z-index: 1;
            width: 42px; height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2A1F4E, #3D2E7A);
            border: 2px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700;
            color: rgba(255,255,255,0.9);
        }

        .t-author-info {}
        .t-name {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
        }
        .t-role {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            margin-top: 2px;
        }
        .t-role i { color: var(--teal); font-size: 9px; }

        /* Verified badge */
        .t-verified {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 5px;
            background: rgba(0,200,150,0.15);
            border: 1px solid rgba(0,200,150,0.3);
            border-radius: 100px;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 600;
            color: var(--teal);
        }
        .t-verified i { font-size: 9px; }

        /* ─── Bottom Row: Stats + SDG ─── */
        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* Stats mini card */
        .stats-mini {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 18px;
            padding: 18px 16px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }
        .stats-mini:hover {
            background: rgba(255,255,255,0.09);
            border-color: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        .stats-mini::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }

        .stats-grid-inner {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .stat-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon-wrap {
            width: 28px; height: 28px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            flex-shrink: 0;
        }
        .stat-icon-wrap.purple { background: rgba(123,111,232,0.2); color: #B8AFEB; }
        .stat-icon-wrap.teal   { background: rgba(0,200,150,0.15);  color: var(--teal); }
        .stat-icon-wrap.orange { background: rgba(255,138,91,0.15);  color: var(--orange); }

        .stat-data {}
        .stat-val {
            font-family: var(--font-serif);
            font-size: 18px;
            font-weight: 400;
            color: white;
            letter-spacing: -0.02em;
            line-height: 1;
        }
        .stat-val em { font-style: italic; color: #B8AFEB; }
        .stat-key {
            font-size: 9px;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 500;
        }

        /* SDG card */
        .sdg-mini {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 18px;
            padding: 18px 16px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }
        .sdg-mini:hover {
            background: rgba(255,255,255,0.09);
            border-color: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        .sdg-mini::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }

        .sdg-mini-title {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sdg-mini-title i { color: var(--teal); font-size: 10px; }

        .sdg-pills {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }
        .sdg-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 7px 10px;
            transition: all 0.2s;
        }
        .sdg-pill:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.15);
        }
        .sdg-pill-icon {
            width: 22px; height: 22px;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px;
            flex-shrink: 0;
        }
        .sdg-pill-icon.edu    { background: rgba(0,100,200,0.3); color: #6EB3FF; }
        .sdg-pill-icon.work   { background: rgba(220,140,0,0.3); color: #FFD06E; }
        .sdg-pill-icon.equal  { background: rgba(180,0,120,0.3); color: #FF8FD9; }
        .sdg-pill-label {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255,255,255,0.65);
            line-height: 1.2;
        }
        .sdg-pill-label span {
            display: block;
            font-size: 9px;
            font-weight: 400;
            color: rgba(255,255,255,0.3);
        }

        /* ─── Floating Chips ─── */
        .float-chip {
            position: absolute;
            display: flex;
            align-items: center;
            gap: 7px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 100px;
            padding: 8px 14px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            z-index: 2;
            pointer-events: none;
        }
        .float-chip i { font-size: 11px; }

        .chip-1 {
            top: 40px; left: -10px;
            animation: chipFloat1 7s ease-in-out infinite;
        }
        .chip-2 {
            bottom: 120px; right: -10px;
            animation: chipFloat2 8s ease-in-out infinite 1s;
        }
        .chip-3 {
            top: 50%; left: -20px;
            transform: translateY(-50%);
            animation: chipFloat1 9s ease-in-out infinite 0.5s;
        }

        @keyframes chipFloat1 {
            0%,100% { transform: translateY(0) rotate(-2deg); }
            50%      { transform: translateY(-10px) rotate(1deg); }
        }
        @keyframes chipFloat2 {
            0%,100% { transform: translateY(0) rotate(2deg); }
            50%      { transform: translateY(-12px) rotate(-1deg); }
        }

        .chip-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        .chip-dot.green  { background: var(--teal); }
        .chip-dot.purple { background: var(--purple); }
        .chip-dot.orange { background: var(--orange); }

        @media(max-width: 900px) {
            .right { display: none; }
            .left { width: 100%; padding: 24px 20px; }
            .form-wrap { max-width: 100%; }
            h1 { font-size: 30px; }
            .benefits { grid-template-columns: 1fr; }
            .role-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- LEFT: Form --}}
<div class="left">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
        <span class="logo-text">Coursify</span>
    </a>

    <div class="form-wrap">
        <h1>Buat akun <em>gratis</em></h1>
        <p class="subtitle">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </p>

        {{-- Benefits --}}
        <div class="benefits">
            @foreach([
                ['fa-book-open', 'Ratusan kursus gratis'],
                ['fa-chart-line', 'Progress tersimpan'],
                ['fa-award', 'Sertifikat digital'],
                ['fa-users', 'Komunitas aktif'],
            ] as [$icon, $label])
                <div class="benefit-item">
                    <div class="check-ic">
                        <i class="fa-solid fa-check" style="font-size:8px;"></i>
                    </div>
                    {{ $label }}
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('register') }}"
              id="registerForm"
              x-data="{
                showPass: false,
                showConfirm: false,
                password: '',
                confirm: '',
                get matchState() {
                    if (!this.confirm) return 'empty';
                    return this.password === this.confirm ? 'match' : 'no-match';
                }
              }"
              @submit="handleSubmit($event)">
            @csrf

            {{-- Role Selector --}}
            <div class="role-section">
                <label class="field-label-top">Daftar sebagai</label>
                <div class="role-grid">
                    <label class="role-card {{ old('role','student')==='student' ? 'selected' : '' }}" id="role-student">
                        <input type="radio" name="role" value="student"
                            {{ old('role','student')==='student' ? 'checked' : '' }}
                            onchange="selectRole(this)">
                        <div class="role-icon">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="role-label">Pelajar</div>
                            <div class="role-sub">Ingin belajar</div>
                        </div>
                    </label>
                    <label class="role-card {{ old('role')==='instructor' ? 'selected' : '' }}" id="role-instructor">
                        <input type="radio" name="role" value="instructor"
                            {{ old('role')==='instructor' ? 'checked' : '' }}
                            onchange="selectRole(this)">
                        <div class="role-icon">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <div class="role-label">Instruktur</div>
                            <div class="role-sub">Ingin mengajar</div>
                        </div>
                    </label>
                </div>
                @error('role')
                    <div class="error-msg">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Name --}}
            <div class="field">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required autofocus autocomplete="name"
                        class="{{ $errors->has('name') ? 'error-input' : '' }}">
                </div>
                @error('name')
                    <div class="error-msg">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="field">
                <label for="email">Alamat Email</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        required autocomplete="username"
                        class="{{ $errors->has('email') ? 'error-input' : '' }}">
                </div>
                @error('email')
                    <div class="error-msg">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input
                        id="password" name="password"
                        placeholder="Minimal 8 karakter"
                        required autocomplete="new-password"
                        x-model="password"
                        @input="checkStrength($event.target.value)"
                        class="{{ $errors->has('password') ? 'error-input' : '' }}"
                        type="password">
                    <button type="button" class="input-toggle" onclick="togglePass('password', this)" tabindex="-1">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div class="strength-bar">
                    <div class="strength-fill" id="strengthFill"></div>
                </div>
                <div class="strength-label" id="strengthLabel">Masukkan password</div>
                @error('password')
                    <div class="error-msg">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="field">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input
                        id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password"
                        required autocomplete="new-password"
                        x-model="confirm"
                        :class="matchState === 'match' ? 'success-input' : (matchState === 'no-match' ? 'error-input' : '')"
                        type="password">
                    <button type="button" class="input-toggle" onclick="togglePass('password_confirmation', this)" tabindex="-1">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div class="match-indicator" :class="matchState">
                    <template x-if="matchState === 'match'">
                        <span><i class="fa-solid fa-circle-check"></i> Password cocok</span>
                    </template>
                    <template x-if="matchState === 'no-match'">
                        <span><i class="fa-solid fa-circle-xmark"></i> Password tidak cocok</span>
                    </template>
                    <template x-if="matchState === 'empty'">
                        <span>&nbsp;</span>
                    </template>
                </div>
            </div>

            {{-- Terms --}}
            <div class="terms-check">
                <input type="checkbox" id="terms" name="terms">
                <label for="terms" style="margin:0;cursor:pointer;font-size:13px;color:var(--text-soft);line-height:1.5;">
                    Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan
                    <a href="#">Kebijakan Privasi</a> Coursify
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit" id="submitBtn">
                <div class="btn-spinner" id="btnSpinner"></div>
                <span class="btn-text" id="btnText">
                    Buat Akun Sekarang
                    
                </span>
            </button>
        </form>
    </div>

    <div class="footer-note">
        © {{ date('Y') }} <strong>Coursify</strong> Platform E-Learning
    </div>
</div>

{{-- RIGHT: Overpowered 3D Panel --}}
<div class="right">

    

    <a href="{{ route('home') }}" class="home-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Home
    </a>

    <div class="right-content">

        {{-- 3D Testimonial Card --}}
        <div class="tcard-3d-wrapper">
            <div class="tcard-glow"></div>
            <div class="testimonial-card">
                <div class="quote-deco">"</div>

                <div class="t-tag">
                    <div class="t-tag-icon">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <span class="t-tag-text">Review</span>
                </div>

                <div class="t-stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>

                </div>

                <p class="t-quote">
                    "Coursify benar-benar mengubah karier saya. Dalam 3 bulan belajar Data Science, saya langsung dapat pekerjaan impian sebagai Data Analyst di Tokopedia!"
                </p>

                <div class="t-author">
                    <div class="t-avatar">
                        <div class="t-avatar-ring"></div>
                        <div class="t-avatar-inner">R</div>
                    </div>
                    <div class="t-author-info">
                        <div class="t-name">Rizky Pratama</div>
                        <div class="t-role">
                            <i class="fa-solid fa-circle-check"></i>
                            Data Analyst 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom row --}}
        <div class="bottom-row">

            {{-- Stats mini --}}
            <div class="stats-mini">
                <div class="stats-grid-inner">
                    <div class="stat-row">
                        <div class="stat-icon-wrap purple">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div class="stat-data" style="text-align:right;">
                            <div class="stat-val"><em>900+</em></div>
                            <div class="stat-key">Kursus</div>
                        </div>
                    </div>
                    <div class="stat-row">
                        <div class="stat-icon-wrap teal">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="stat-data" style="text-align:right;">
                            <div class="stat-val"><em>Ribuan</em></div>
                            <div class="stat-key">Pelajar</div>
                        </div>
                    </div>
                    <div class="stat-row">
                        <div class="stat-icon-wrap orange">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="stat-data" style="text-align:right;">
                            <div class="stat-val"><em>95%</em></div>
                            <div class="stat-key">Rating</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SDG mini --}}
            <div class="sdg-mini">
                <div class="sdg-mini-title">
                    <i class="fa-solid fa-earth-asia"></i>
                    SDG Goals
                </div>
                <div class="sdg-pills">
                    <div class="sdg-pill">
                        <div class="sdg-pill-icon edu">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div class="sdg-pill-label">
                            SDG 4
                            <span>Pendidikan</span>
                        </div>
                    </div>
                    <div class="sdg-pill">
                        <div class="sdg-pill-icon work">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div class="sdg-pill-label">
                            SDG 8
                            <span>Pekerjaan</span>
                        </div>
                    </div>
                    <div class="sdg-pill">
                        <div class="sdg-pill-icon equal">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <div class="sdg-pill-label">
                            SDG 10
                            <span>Kesetaraan</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// ─── Password toggle (vanilla, no Alpine) ─────────────────
function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    const show  = input.type === 'password';
    input.type  = show ? 'text' : 'password';
    icon.className = show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
}

// ─── Role selection ───────────────────────────────────────
function selectRole(input) {
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
    input.closest('.role-card').classList.add('selected');
}

// ─── Password strength ────────────────────────────────────
function checkStrength(val) {
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8)          score++;
    if (/[A-Z]/.test(val))        score++;
    if (/[0-9]/.test(val))        score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const configs = [
        { w: '0%',   c: '#9CA3AF', t: 'Masukkan password' },
        { w: '25%',  c: '#C29393', t: 'Lemah' },
        { w: '50%',  c: '#D4AF37', t: 'Cukup' },
        { w: '75%',  c: '#6B728E', t: 'Kuat' },
        { w: '100%', c: '#4D6151', t: 'Sangat kuat' },
    ];
    const cfg = val.length === 0 ? configs[0] : (configs[score] || configs[0]);
    fill.style.width      = cfg.w;
    fill.style.background = cfg.c;
    label.textContent     = cfg.t;
    label.style.color     = cfg.c;
}

// ─── Form submit ──────────────────────────────────────────
function handleSubmit(e) {
    const terms   = document.getElementById('terms');
    const btn     = document.getElementById('submitBtn');
    const spinner = document.getElementById('btnSpinner');
    const btnText = document.getElementById('btnText');

    if (!terms.checked) {
        e.preventDefault();
        terms.style.borderColor = 'var(--orange)';
        terms.style.animation   = 'shake 0.4s ease';
        setTimeout(() => { terms.style.animation = ''; terms.style.borderColor = ''; }, 500);
        terms.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    btn.disabled = true;
    btn.classList.add('loading');
    spinner.style.display = 'block';
    btnText.textContent   = 'Membuat akun...';
}

// ─── 3D tilt on mouse move ────────────────────────────────
const wrapper = document.querySelector('.tcard-3d-wrapper');
if (wrapper) {
    const card = wrapper.querySelector('.testimonial-card');
    wrapper.addEventListener('mousemove', e => {
        const rect = wrapper.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width  - 0.5;
        const y = (e.clientY - rect.top)  / rect.height - 0.5;
        wrapper.style.animation = 'none';
        wrapper.style.transform = `rotateY(${x * 14}deg) rotateX(${-y * 10}deg) translateY(-4px)`;
    });
    wrapper.addEventListener('mouseleave', () => {
        wrapper.style.animation = '';
        wrapper.style.transform = '';
    });
}
</script>

<style>
@keyframes shake {
    0%,100% { transform: translateX(0); }
    20%      { transform: translateX(-4px); }
    40%      { transform: translateX(4px); }
    60%      { transform: translateX(-4px); }
    80%      { transform: translateX(4px); }
}
</style>

</body>
</html>