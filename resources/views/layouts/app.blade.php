<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Coursify')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ══════════════════════════════════════════════
           CSS VARIABLES
        ══════════════════════════════════════════════ */
        :root {
            --navy:        #1E3A5F;
            --navy-dark:   #152B48;
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
            --font-serif:  'Instrument Serif', serif;
            --font-sans:   'Inter', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-sans);
            color: var(--text);
            background: linear-gradient(180deg, #EDE5F9 0%, #D8CEEE 50%, #C4B8E8 100%);
            background-attachment: fixed;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            position: relative;
            padding-top: 90px; /* override by JS after promo banner height check */
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 800px 400px at 20% 10%, rgba(255,255,255,0.5), transparent),
                radial-gradient(ellipse 600px 300px at 80% 30%, rgba(255,255,255,0.4), transparent),
                radial-gradient(ellipse 700px 400px at 50% 90%, rgba(255,255,255,0.3), transparent);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        /* ══════════════════════════════════════════════
           PROMO BANNER
        ══════════════════════════════════════════════ */
        .promo-bar {
            background: var(--navy);
            color: white;
            padding: 9px 50px 9px 20px;
            text-align: center;
            position: relative;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            transition: max-height 0.35s ease, opacity 0.35s ease, padding 0.35s ease;
            overflow: hidden;
        }
        .promo-bar.promo-closing {
            max-height: 0 !important;
            opacity: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        .promo-bar a { color: var(--lav-4); font-weight: 700; margin-left: 6px; text-decoration: underline; }
        .promo-bar a:hover { color: white; }
        .promo-code {
            display: inline-block;
            background: rgba(184,175,235,0.25);
            border: 1px solid rgba(184,175,235,0.4);
            color: #D4CCFF;
            padding: 1px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .promo-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            background: var(--lav-4);
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
            animation: pulse 2s infinite;
        }
        .promo-close {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.5);
            cursor: pointer;
            font-size: 20px;
            line-height: 1;
            padding: 5px 7px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .promo-close:hover { color: white; background: rgba(255,255,255,0.12); }

        /* ══════════════════════════════════════════════
           LOGO
        ══════════════════════════════════════════════ */
        .logo-img {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(30,58,95,0.25);
            transition: all 0.3s;
        }
        .logo:hover .logo-img { transform: scale(1.08) rotate(-3deg); }
        .logo-img-sm { width: 26px; height: 26px; border-radius: 6px; }

        /* ══════════════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════════════ */
        .navbar-wrap {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 500;
            animation: slideDown 0.6s ease-out;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }
        .navbar-wrap.navbar-hidden { transform: translateY(-120%); }
        .navbar-wrap.navbar-scrolled .navbar {
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(40px) saturate(180%);
            -webkit-backdrop-filter: blur(40px) saturate(180%);
            box-shadow: 0 10px 40px rgba(30,58,95,0.1);
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .navbar-inner { padding: 10px 20px; }

        .navbar {
            max-width: 960px;
            margin: 0 auto;
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 100px;
            padding: 7px 7px 7px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            box-shadow: 0 8px 30px rgba(30,58,95,0.08);
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            color: var(--text);
            flex-shrink: 0;
        }
        .logo-text { font-size: 17px; font-weight: 700; letter-spacing: -0.02em; }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 2px;
            flex: 1;
            padding: 0 8px;
        }
        .nav-link {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-soft);
            text-decoration: none;
            padding: 7px 13px;
            border-radius: 100px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .nav-link i { font-size: 11px; opacity: 0.65; }
        .nav-link:hover { background: rgba(255,255,255,0.75); color: var(--text); }
        .nav-link.active { background: rgba(123,111,232,0.14); color: var(--purple-dark); }

        /* ══════════════════════════════════════════════
           MEGA NAV TRIGGER BUTTON
        ══════════════════════════════════════════════ */
        .mega-trigger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--navy);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: var(--font-sans);
            transition: background 0.2s, transform 0.15s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .mega-trigger:hover { background: #2D4D7A; }
        .mega-trigger:active { transform: scale(0.97); }
        .mega-chevron {
            width: 14px;
            height: 14px;
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }
        .mega-trigger.active .mega-chevron { transform: rotate(180deg); }

        /* ══════════════════════════════════════════════
           MEGA MENU DROPDOWN
        ══════════════════════════════════════════════ */
        .mega-menu-wrap {
            padding: 0 20px;
            pointer-events: none;
        }
        .mega-menu {
            display: none;
            max-width: 960px;
            margin: 0 auto;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(30,58,95,0.16);
            padding: 28px;
            pointer-events: auto;
            animation: megaFadeIn 0.2s ease;
            margin-top: 8px;
        }
        .mega-menu.open { display: block; }
        @keyframes megaFadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .mega-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
        }
        .mega-col { padding: 0 20px 0 0; }
        .mega-col + .mega-col {
            padding-left: 20px;
            border-left: 1px solid rgba(30,58,95,0.08);
        }
        .mega-col-title {
            font-weight: 700;
            font-size: 13px;
            color: var(--text);
            margin-bottom: 12px;
            letter-spacing: -0.01em;
        }
        .mega-link {
            display: block;
            font-size: 13px;
            color: var(--text-soft);
            text-decoration: none;
            padding: 4px 0;
            line-height: 1.5;
            transition: color 0.2s;
        }
        .mega-link:hover { color: var(--purple); }
        .mega-link-cta {
            color: var(--purple) !important;
            font-weight: 600;
            margin-top: 6px;
        }
        .mega-group-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin: 12px 0 6px;
        }
        .mega-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 4px;
            margin-left: 4px;
            vertical-align: middle;
        }
        .badge-hot  { background: rgba(255,80,80,0.12); color: #B00; }
        .badge-new  { background: rgba(255,138,91,0.15); color: #C84A00; }
        .badge-free { background: rgba(0,200,150,0.12); color: #007A5E; }

        /* Overlay backdrop */
        .mega-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 499;
            background: rgba(26,24,37,0.08);
            backdrop-filter: blur(2px);
        }
        .mega-overlay.open { display: block; }

        /* ══════════════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════════════ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-sans);
            font-weight: 500;
            font-size: 14px;
            padding: 10px 22px;
            border-radius: 100px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }
        .btn:active { transform: scale(0.96); }
        .btn-dark {
            background: #1A1825;
            color: white;
            box-shadow: 0 4px 14px rgba(26,24,37,0.3);
        }
        .btn-dark:hover {
            background: #2A2840;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26,24,37,0.4);
        }
        .btn-light {
            background: rgba(255,255,255,0.7);
            color: var(--text);
            border: 1px solid rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
        }
        .btn-light:hover {
            background: rgba(255,255,255,0.95);
            transform: translateY(-2px);
        }

        /* ══════════════════════════════════════════════
           FLASH MESSAGES
        ══════════════════════════════════════════════ */
        .flash-wrap {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 600;
            max-width: 400px;
        }
        .flash {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 14px;
            padding: 12px 18px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            font-weight: 500;
            box-shadow: 0 10px 40px rgba(30,58,95,0.14);
            animation: slideInRight 0.4s ease-out;
        }
        .flash-success { border-left: 4px solid var(--teal); }
        .flash-error   { border-left: 4px solid var(--orange); }
        .flash-info    { border-left: 4px solid var(--purple); }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ══════════════════════════════════════════════
           USER DROPDOWN
        ══════════════════════════════════════════════ */
        .user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 100px;
            padding: 5px 14px 5px 5px;
            cursor: pointer;
            font-family: var(--font-sans);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text);
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .user-btn:hover { background: rgba(255,255,255,0.95); }
        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--navy), #2D4D7A);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 11px;
        }
        .user-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 18px;
            padding: 8px;
            min-width: 228px;
            box-shadow: 0 20px 50px rgba(30,58,95,0.15);
            z-index: 600;
        }
        .dropdown-header {
            padding: 10px 12px 12px;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            margin-bottom: 6px;
        }
        .dropdown-name  { font-size: 13px; font-weight: 600; }
        .dropdown-email { font-size: 11px; color: var(--muted); margin-top: 2px; }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 12px;
            border-radius: 10px;
            color: var(--text-soft);
            font-size: 13px;
            text-decoration: none;
            transition: all 0.15s;
            background: transparent;
            border: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
            font-family: var(--font-sans);
            font-weight: 500;
        }
        .dropdown-item i { width: 16px; text-align: center; opacity: 0.75; font-size: 12px; }
        .dropdown-item:hover { background: rgba(123,111,232,0.08); color: var(--text); }
        .dropdown-item-danger { color: #D04020; }
        .dropdown-item-danger:hover { background: rgba(255,138,91,0.08); color: #D04020; }

        /* ══════════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════════ */
        .footer-main {
            margin: 40px 20px 20px;
            background: rgba(255,255,255,0.5);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 24px;
            padding: 40px;
            position: relative;
            z-index: 1;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
        }
        .footer-col-title {
            font-family: var(--font-serif);
            font-size: 15px;
            margin-bottom: 14px;
            color: var(--text);
        }
        .footer-links-col { display: flex; flex-direction: column; gap: 10px; }
        .footer-link {
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-link:hover { color: var(--purple); }
        .footer-brand-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
            margin: 12px 0 20px;
        }
        .footer-social { display: flex; gap: 8px; }
        .footer-social a {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(30,58,95,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--text-soft);
            font-size: 14px;
            transition: all 0.2s;
        }
        .footer-social a:hover {
            background: var(--navy);
            color: white;
            transform: translateY(-2px);
        }
        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid rgba(30,58,95,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: var(--muted);
        }

        /* ══════════════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════════════ */
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(1.3); }
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */
        @media (max-width: 768px) {
            .nav-center { display: none; }
            .mega-trigger { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .footer-main { padding: 24px; }
            .mega-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
        }
        @media (max-width: 480px) {
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ══════════════════════════════════════════════════════════ --}}
{{-- NAVBAR WRAP — berisi promo banner + pill nav + mega menu  --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div class="navbar-wrap" id="mainNavbar">

    {{-- ── PROMO BANNER ──────────────────────────────────────── --}}
    <div id="promo-bar" class="promo-bar">
        <span class="promo-dot"></span>
        Mulai belajar hari ini! Dapatkan <strong>30% off</strong> untuk semua kursus premium hingga 31 Mei.
        Gunakan kode <span class="promo-code">BELAJAR30</span>.
        <a href="#pricing">Pelajari lebih lanjut →</a>
        <button class="promo-close" onclick="closePromoBanner()" aria-label="Tutup banner">×</button>
    </div>

    {{-- ── NAVBAR PILL ────────────────────────────────────────── --}}
    <div class="navbar-inner">
        <nav class="navbar">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
                <span class="logo-text">Coursify</span>
            </a>

            {{-- Center: Mega trigger + nav links --}}
            <div class="nav-center">

                {{-- ▸ MEGA NAV TRIGGER --}}
                <button
                    class="mega-trigger"
                    id="mega-btn"
                    onclick="toggleMega()"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-controls="mega-menu"
                >
                    <i class="fa-solid fa-grid-2" style="font-size:11px;"></i>
                    Jelajahi
                    <svg class="mega-chevron" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M3 5L7 9L11 5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                {{-- Regular links --}}
                <a href="{{ route('courses.index') }}"
                   class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Courses
                </a>

                <a href="{{ route('home') }}#how" class="nav-link">
                    <i class="fa-solid fa-circle-info"></i>
                    How It Works
                </a>

                <a href="{{ route('home') }}#pricing" class="nav-link">
                    <i class="fa-solid fa-tag"></i>
                    Pricing
                </a>
            </div>

            {{-- Right: Auth --}}
            @guest
                <a href="{{ route('login') }}" class="btn btn-dark" style="flex-shrink:0;">
                    Get Started
                </a>
            @else
                <div style="position:relative;flex-shrink:0;" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" class="user-btn">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span>{{ Str::limit(auth()->user()->name, 12) }}</span>
                        <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:0.5;"></i>
                    </button>

                    <div x-show="userOpen"
                         @click.away="userOpen = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="user-dropdown">

                        {{-- Header --}}
                        <div class="dropdown-header">
                            <div class="dropdown-name">{{ auth()->user()->name }}</div>
                            <div class="dropdown-email">{{ auth()->user()->email }}</div>
                            <div style="margin-top:8px;">
                                @php
                                    $roleMap = [
                                        'admin'      => ['bg' => 'linear-gradient(135deg,#1E3A5F,#2D4D7A)', 'color' => 'white',   'icon' => 'fa-user-shield',     'label' => 'Administrator'],
                                        'instructor' => ['bg' => 'rgba(0,200,150,0.14)',                   'color' => '#00705A',  'icon' => 'fa-chalkboard-user', 'label' => 'Instructor'],
                                        'student'    => ['bg' => 'rgba(123,111,232,0.14)',                 'color' => '#5B4FD4',  'icon' => 'fa-graduation-cap',  'label' => 'Student'],
                                    ];
                                    $r = $roleMap[auth()->user()->role] ?? $roleMap['student'];
                                @endphp
                                <span style="display:inline-block;padding:3px 10px;background:{{ $r['bg'] }};color:{{ $r['color'] }};border-radius:100px;font-size:10px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;">
                                    <i class="fa-solid {{ $r['icon'] }}"></i> {{ $r['label'] }}
                                </span>
                            </div>
                        </div>

                        {{-- ═══ ADMIN MENU ═══ --}}
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                <i class="fa-solid fa-chart-pie"></i> Dashboard
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-users-gear"></i> Manage Users
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-book-stack"></i> Manage Courses
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-file-shield"></i> Pending Approvals
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-money-bill-transfer"></i> Transactions
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-gears"></i> Settings
                            </a>
                        @endif

                        {{-- ═══ INSTRUCTOR MENU ═══ --}}
                        @if(auth()->user()->role === 'instructor')
                            <a href="{{ route('instructor.dashboard') }}" class="dropdown-item">
                                <i class="fa-solid fa-chart-line"></i> Dashboard
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-chalkboard-user"></i> My Courses
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-users"></i> My Students
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-square-plus"></i> Create Course
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-wallet"></i> Earnings
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fa-solid fa-user-gear"></i> Profile Settings
                            </a>
                        @endif

                        {{-- ═══ STUDENT MENU ═══ --}}
                        @if(auth()->user()->role === 'student')
                            <a href="{{ route('student.index') }}" class="dropdown-item">
                                <i class="fa-solid fa-gauge-high"></i> My Dashboard
                            </a>
                            <a href="{{ route('student.courses') }}" class="dropdown-item">
                                <i class="fa-solid fa-book-open"></i> My Courses
                            </a>
                            <a href="{{ route('student.wishlist') }}" class="dropdown-item">
                                <i class="fa-solid fa-heart"></i> Wishlist
                            </a>
                            <a href="{{ route('student.certificates') }}" class="dropdown-item">
                                <i class="fa-solid fa-award"></i> Certificates
                            </a>
                            <a href="{{ route('student.profile') }}" class="dropdown-item">
                                <i class="fa-solid fa-user-pen"></i> Profile Settings
                            </a>
                        @endif

                        {{-- Logout --}}
                        <div style="border-top:1px solid rgba(0,0,0,0.06);margin-top:6px;padding-top:6px;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item dropdown-item-danger">
                                    <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endguest

        </nav>
    </div>{{-- /.navbar-inner --}}

    {{-- ── MEGA MENU (drops below the pill) ──────────────────── --}}
    <div class="mega-menu-wrap">
        <div class="mega-menu" id="mega-menu" role="dialog" aria-label="Menu navigasi utama">
            <div class="mega-grid">

                {{-- ▸ Kolom 1: Jelajahi Topik --}}
                <div class="mega-col">
                    <div class="mega-col-title">Jelajahi Topik</div>
                    <a href="{{ route('courses.index') }}?category=ai" class="mega-link">
                        Kecerdasan Buatan <span class="mega-badge badge-hot">Populer</span>
                    </a>
                    <a href="{{ route('courses.index') }}?category=programming" class="mega-link">Pemrograman</a>
                    <a href="{{ route('courses.index') }}?category=data-science" class="mega-link">Data Science</a>
                    <a href="{{ route('courses.index') }}?category=design" class="mega-link">Desain UI/UX</a>
                    <a href="{{ route('courses.index') }}?category=business" class="mega-link">Bisnis & Manajemen</a>
                    <a href="{{ route('courses.index') }}?category=cybersecurity" class="mega-link">
                        Keamanan Siber <span class="mega-badge badge-new">Baru</span>
                    </a>
                    <a href="{{ route('courses.index') }}?category=languages" class="mega-link">Bahasa Asing</a>
                    <a href="{{ route('courses.index') }}" class="mega-link mega-link-cta">Lihat semua topik →</a>
                    <div class="mega-group-label">Untuk Pemula</div>
                    <a href="{{ route('courses.index') }}?q=python+pemula" class="mega-link">Python untuk Pemula</a>
                    <a href="{{ route('courses.index') }}?q=excel+pemula" class="mega-link">Excel untuk Pemula</a>
                    <a href="{{ route('courses.index') }}?q=web+dasar" class="mega-link">Web Dev Dasar</a>
                </div>

                {{-- ▸ Kolom 2: Raih Sertifikat --}}
                <div class="mega-col">
                    <div class="mega-col-title">Raih Sertifikat</div>
                    <a href="{{ route('courses.index') }}?type=certificate&topic=ai" class="mega-link">Artificial Intelligence</a>
                    <a href="{{ route('courses.index') }}?type=certificate&topic=data" class="mega-link">Data Analysis & Statistik</a>
                    <a href="{{ route('courses.index') }}?type=certificate&topic=project" class="mega-link">Manajemen Proyek</a>
                    <a href="{{ route('courses.index') }}?type=certificate&topic=finance" class="mega-link">Keuangan & Akuntansi</a>
                    <a href="{{ route('courses.index') }}?type=certificate&topic=marketing" class="mega-link">Digital Marketing</a>
                    <a href="{{ route('courses.index') }}?type=certificate" class="mega-link mega-link-cta">Lihat semua sertifikat →</a>
                    <div class="mega-group-label">Populer</div>
                    <a href="{{ route('courses.index') }}?q=ai+3+bulan" class="mega-link">AI dalam 3 bulan</a>
                    <a href="{{ route('courses.index') }}?q=data+analyst" class="mega-link">Data Analyst Bootcamp</a>
                    <a href="{{ route('courses.index') }}?q=fullstack+laravel" class="mega-link">Fullstack Laravel</a>
                    <a href="{{ route('courses.index') }}?q=ui+ux+figma" class="mega-link">
                        UI/UX dengan Figma <span class="mega-badge badge-free">Free</span>
                    </a>
                </div>

                {{-- ▸ Kolom 3: Program Gelar --}}
                <div class="mega-col">
                    <div class="mega-col-title">Program Gelar</div>
                    <a href="{{ route('courses.index') }}?type=program&level=bachelor" class="mega-link">Program Sarjana (S1)</a>
                    <a href="{{ route('courses.index') }}?type=program&level=master" class="mega-link">Program Magister (S2)</a>
                    <a href="{{ route('courses.index') }}?type=program&level=diploma" class="mega-link">Program Diploma (D3/D4)</a>
                    <a href="{{ route('courses.index') }}?type=program" class="mega-link mega-link-cta">Lihat semua program →</a>
                    <div class="mega-group-label">Populer</div>
                    <a href="{{ route('courses.index') }}?q=mba+online" class="mega-link">MBA Online</a>
                    <a href="{{ route('courses.index') }}?q=master+data+science" class="mega-link">Master Data Science</a>
                    <a href="{{ route('courses.index') }}?q=computer+science+master" class="mega-link">Master Ilmu Komputer</a>
                    <a href="{{ route('courses.index') }}?q=healthcare+master" class="mega-link">Master Kesehatan</a>
                    <a href="{{ route('courses.index') }}?q=teknik+informatika" class="mega-link">S1 Teknik Informatika</a>
                </div>

                {{-- ▸ Kolom 4: Universitas & Karir --}}
                <div class="mega-col">
                    <div class="mega-col-title">Universitas Partner</div>
                    <a href="{{ route('courses.index') }}?university=ui" class="mega-link">Universitas Indonesia</a>
                    <a href="{{ route('courses.index') }}?university=itb" class="mega-link">Institut Teknologi Bandung</a>
                    <a href="{{ route('courses.index') }}?university=ugm" class="mega-link">Universitas Gadjah Mada</a>
                    <a href="{{ route('courses.index') }}?university=its" class="mega-link">ITS Surabaya</a>
                    <a href="{{ route('courses.index') }}?university=unair" class="mega-link">Universitas Airlangga</a>
                    <a href="{{ route('courses.index') }}?university=ipb" class="mega-link">IPB University</a>
                    <a href="#partners" class="mega-link mega-link-cta">Lihat semua universitas →</a>
                    <div class="mega-group-label">Jalur Karir</div>
                    <a href="{{ route('courses.index') }}?career=software-engineer" class="mega-link">Software Engineer</a>
                    <a href="{{ route('courses.index') }}?career=data-scientist" class="mega-link">Data Scientist</a>
                    <a href="{{ route('courses.index') }}?career=ui-ux-designer" class="mega-link">UI/UX Designer</a>
                    <a href="{{ route('courses.index') }}?career=cybersecurity-analyst" class="mega-link">Cybersecurity Analyst</a>
                </div>

            </div>
        </div>
    </div>{{-- /.mega-menu-wrap --}}

</div>{{-- /.navbar-wrap --}}

{{-- Overlay penutup mega menu (di LUAR navbar-wrap) --}}
<div class="mega-overlay" id="mega-overlay" onclick="closeMega()"></div>


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- FLASH MESSAGES                                             --}}
{{-- ══════════════════════════════════════════════════════════ --}}
@if(session('success') || session('error') || session('info'))
    <div class="flash-wrap">
        @if(session('success'))
            <div class="flash flash-success" x-data x-init="setTimeout(() => $el.remove(), 4000)">
                <i class="fa-solid fa-circle-check" style="color:var(--teal);"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash flash-error" x-data x-init="setTimeout(() => $el.remove(), 4000)">
                <i class="fa-solid fa-circle-xmark" style="color:var(--orange);"></i>
                {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="flash flash-info" x-data x-init="setTimeout(() => $el.remove(), 4000)">
                <i class="fa-solid fa-circle-info" style="color:var(--purple);"></i>
                {{ session('info') }}
            </div>
        @endif
    </div>
@endif


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- MAIN CONTENT                                               --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<main style="position:relative;z-index:1;">
    @yield('content')
</main>


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- FOOTER                                                     --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<footer class="footer-main">
    <div class="footer-grid">
        <div>
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img logo-img-sm">
                <span class="logo-text">Coursify</span>
            </a>
            <p class="footer-brand-desc">
                Platform belajar modern yang membantu kamu menguasai skill baru bersama instruktur terbaik dari universitas-universitas terkemuka Indonesia.
            </p>
            <div class="footer-social">
                <a href="#" aria-label="X / Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>

        <div>
            <div class="footer-col-title">Platform</div>
            <div class="footer-links-col">
                <a href="{{ route('courses.index') }}" class="footer-link">Semua Kursus</a>
                <a href="#categories" class="footer-link">Kategori</a>
                <a href="#partners" class="footer-link">Universitas Partner</a>
                <a href="{{ route('home') }}#pricing" class="footer-link">Pricing</a>
            </div>
        </div>

        <div>
            <div class="footer-col-title">Company</div>
            <div class="footer-links-col">
                <a href="#" class="footer-link">Tentang Kami</a>
                <a href="#" class="footer-link">Blog</a>
                <a href="#" class="footer-link">Karir</a>
                <a href="#" class="footer-link">Kontak</a>
            </div>
        </div>

        <div>
            <div class="footer-col-title">Support</div>
            <div class="footer-links-col">
                <a href="#" class="footer-link">Pusat Bantuan</a>
                <a href="#" class="footer-link">Kebijakan Privasi</a>
                <a href="#" class="footer-link">Syarat & Ketentuan</a>
                <a href="#" class="footer-link">Jadi Instruktur</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div>© {{ date('Y') }} Coursify. All Rights Reserved.</div>
        <div style="display:flex;gap:16px;">
            <a href="#" class="footer-link">Privacy</a>
            <a href="#" class="footer-link">Terms</a>
            <a href="#" class="footer-link">Cookies</a>
        </div>
    </div>
</footer>


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- SCRIPTS                                                    --}}
{{-- ══════════════════════════════════════════════════════════ --}}
@stack('scripts')

<script>
/* ─── Adjust body padding to account for navbar + promo height ─── */
function adjustBodyPadding() {
    var nb = document.getElementById('mainNavbar');
    if (nb) {
        document.body.style.paddingTop = (nb.getBoundingClientRect().height + 4) + 'px';
    }
}
adjustBodyPadding();
window.addEventListener('resize', adjustBodyPadding, { passive: true });

/* ─── Promo Banner close ─── */
(function () {
    if (localStorage.getItem('coursify_promo_closed_v1') === '1') {
        var bar = document.getElementById('promo-bar');
        if (bar) bar.style.display = 'none';
        adjustBodyPadding();
    }
})();

function closePromoBanner() {
    var bar = document.getElementById('promo-bar');
    if (!bar) return;
    bar.classList.add('promo-closing');
    setTimeout(function () {
        bar.style.display = 'none';
        adjustBodyPadding();
    }, 360);
    localStorage.setItem('coursify_promo_closed_v1', '1');
}

/* ─── Mega Nav ─── */
function toggleMega() {
    var menu    = document.getElementById('mega-menu');
    var btn     = document.getElementById('mega-btn');
    var overlay = document.getElementById('mega-overlay');
    var isOpen  = menu.classList.contains('open');
    isOpen ? closeMega() : openMega();
}
function openMega() {
    document.getElementById('mega-menu').classList.add('open');
    document.getElementById('mega-btn').classList.add('active');
    document.getElementById('mega-overlay').classList.add('open');
    document.getElementById('mega-btn').setAttribute('aria-expanded', 'true');
}
function closeMega() {
    document.getElementById('mega-menu').classList.remove('open');
    document.getElementById('mega-btn').classList.remove('active');
    document.getElementById('mega-overlay').classList.remove('open');
    document.getElementById('mega-btn').setAttribute('aria-expanded', 'false');
}
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeMega(); }
});

/* ─── Auto-hide navbar on scroll ─── */
(function () {
    var navbar   = document.getElementById('mainNavbar');
    if (!navbar) return;
    var lastScroll = 0;
    var ticking    = false;
    var threshold  = 80;

    function updateNavbar() {
        var cur = window.pageYOffset;
        navbar.classList.toggle('navbar-scrolled', cur > 20);
        if (cur < threshold) {
            navbar.classList.remove('navbar-hidden');
        } else if (cur > lastScroll + 6) {
            navbar.classList.add('navbar-hidden');
            closeMega();
        } else if (cur < lastScroll - 6) {
            navbar.classList.remove('navbar-hidden');
        }
        lastScroll = cur;
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) { window.requestAnimationFrame(updateNavbar); ticking = true; }
    }, { passive: true });
})();

/* ─── Fix bfcache (back button stale UI) ─── */
window.addEventListener('pageshow', function (e) {
    if (e.persisted) window.location.reload();
});
</script>

</body>
</html>