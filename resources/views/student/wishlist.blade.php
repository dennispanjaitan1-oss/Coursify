<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Wishlist — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
:root {
    --navy: #153759;
    --navy-dark: #0F2744;
    --lav-1: #F5F1FC;
    --lav-2: #E8E1F3;
    --lav-3: #D4CDF0;
    --lav-4: #B8AFEB;
    --purple: #7B6FE8;
    --purple-dark: #5B4FD4;
    --teal: #00C896;
    --teal-light: #E6FBF5;
    --orange: #FF8A5B;
    --orange-light: #FFF0E8;
    --gold: #FFC452;
    --gold-light: #FFF7E0;
    --pink: #FF6B8A;
    --pink-light: #FFE0E9;
    --text: #1A1825;
    --text-soft: #4A4660;
    --muted: #8B87A8;
    --border: rgba(30,58,95,0.08);
    --font-serif: 'Instrument Serif', serif;
    --font-sans: 'Inter', sans-serif;
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
    padding-top: 90px;
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
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 1;
}

/* ═══ NAVBAR ═══ */
.navbar-wrap {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 100;
    padding: 20px 20px 0;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.navbar-wrap.navbar-hidden { transform: translateY(-120%); }
.navbar-wrap.navbar-scrolled .navbar {
    background: rgba(255,255,255,0.9);
    box-shadow: 0 10px 40px rgba(30,58,95,0.1);
}
.navbar {
    max-width: 900px;
    margin: 0 auto;
    background: rgba(255,255,255,0.65);
    backdrop-filter: blur(30px) saturate(180%);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    padding: 8px 8px 8px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 40px rgba(30,58,95,0.08);
}
.logo { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text); }
.logo-img { width: 34px; height: 34px; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 8px rgba(30,58,95,0.2); }
.logo-text { font-size: 17px; font-weight: 700; letter-spacing: -0.02em; }

.nav-links { display: flex; gap: 2px; }
.nav-link {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-soft);
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 100px;
    transition: all 0.2s;
}
.nav-link:hover { background: rgba(255,255,255,0.7); color: var(--text); }
.nav-link.active { background: rgba(123,111,232,0.15); color: var(--purple-dark); }

.btn-nav {
    padding: 9px 18px;
    background: #1A1825;
    color: white;
    border-radius: 100px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-nav:hover { background: #2A2840; transform: translateY(-1px); }

/* ═══ FLASH MESSAGE ═══ */
.flash-wrap {
    position: fixed;
    top: 90px;
    right: 24px;
    z-index: 101;
    max-width: 400px;
    animation: slideInRight 0.4s ease-out;
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(50px); }
    to { opacity: 1; transform: translateX(0); }
}

.flash {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 14px;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: 0 10px 40px rgba(30,58,95,0.15);
}

.flash-success { border-left: 4px solid var(--teal); color: var(--text); }
.flash-error { border-left: 4px solid var(--orange); color: var(--text); }

/* ═══ PAGE HEADER ═══ */
.page-header {
    text-align: center;
    padding: 40px 20px 24px;
    position: relative;
    z-index: 1;
}

.page-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,107,138,0.12);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,107,138,0.3);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    color: var(--pink);
    margin-bottom: 18px;
}

.page-badge-heart {
    font-size: 14px;
    animation: heartbeat 1.5s infinite;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.page-title {
    font-family: var(--font-serif);
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 400;
    line-height: 1.05;
    letter-spacing: -0.02em;
    margin-bottom: 12px;
    padding-bottom: 0.1em;
    overflow: visible;
}

.page-title em {
    font-style: italic;
    background: linear-gradient(135deg, #FF9FB5, #FF6B8A);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
    padding-bottom: 0.15em;
    margin-top: 0.05em;
    overflow: visible;
}

.page-subtitle {
    font-size: 15px;
    line-height: 1.6;
    color: var(--text-soft);
    max-width: 500px;
    margin: 0 auto;
}

/* ═══ STATS BAR ═══ */
.stats-bar {
    max-width: 880px;
    margin: 32px auto 0;
    background: rgba(255,255,255,0.5);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: 20px;
    padding: 20px 32px;
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
}

.stat-cell {
    text-align: center;
    border-right: 1px solid rgba(30,58,95,0.08);
    padding: 0 8px;
    min-width: 0;
}

.stat-cell:last-child { border-right: none; }

.stat-icon {
    font-size: 20px;
    margin-bottom: 4px;
    display: inline-block;
}

.stat-value {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 4px;
    padding-bottom: 2px;
}

.stat-value em {
    font-style: italic;
    color: var(--pink);
}

.stat-value.value-teal em { color: var(--teal); }
.stat-value.value-gold em { color: var(--gold); }
.stat-value.value-purple em { color: var(--purple); }

.stat-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* ═══ MAIN SECTION ═══ */
.main-section {
    padding: 20px 20px 60px;
}

/* ═══ TOOLBAR ═══ */
.courses-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    gap: 16px;
    flex-wrap: wrap;
}

.filter-tabs {
    display: flex;
    gap: 4px;
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    padding: 4px;
}

.filter-tab {
    padding: 8px 16px;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-soft);
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.filter-tab:hover { color: var(--pink); }

.filter-tab.active {
    background: linear-gradient(135deg, #FF9FB5, #FF6B8A);
    color: white;
    box-shadow: 0 4px 12px rgba(255,107,138,0.35);
}

.filter-tab-count {
    background: rgba(255,255,255,0.25);
    color: inherit;
    padding: 2px 7px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    min-width: 18px;
    text-align: center;
}

.filter-tab:not(.active) .filter-tab-count {
    background: var(--pink-light);
    color: var(--pink);
}

/* Search */
.search-wishlist {
    position: relative;
    min-width: 260px;
}

.search-input {
    width: 100%;
    padding: 10px 16px 10px 40px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1.5px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    color: var(--text);
    outline: none;
    transition: all 0.2s;
}

.search-input::placeholder { color: var(--muted); }

.search-input:focus {
    background: white;
    border-color: var(--pink);
    box-shadow: 0 0 0 4px rgba(255,107,138,0.12);
}

.search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 14px;
    pointer-events: none;
}

/* ═══ SAVED VALUE BANNER ═══ */
.saved-banner {
    background: linear-gradient(135deg, rgba(255,107,138,0.08), rgba(255,159,181,0.04));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,107,138,0.15);
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

.saved-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.saved-icon {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #FF9FB5, #FF6B8A);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.saved-text {
    min-width: 0;
}

.saved-label {
    font-size: 11px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 3px;
}

.saved-value {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.01em;
    line-height: 1.1;
}

.saved-value em {
    font-style: italic;
    color: var(--pink);
}

.saved-action {
    padding: 10px 20px;
    background: #1A1825;
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.saved-action:hover {
    background: #2A2840;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(26,24,37,0.3);
}

/* ═══ COURSES GRID ═══ */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.course-card {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    overflow: hidden;
    color: var(--text);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 16px rgba(30,58,95,0.04);
    min-width: 0;
    position: relative;
}

.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(30,58,95,0.12);
    border-color: var(--pink);
}

.course-thumb {
    aspect-ratio: 16/10;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 54px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
}

.course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
.course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
.course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }
.course-thumb-4 { background: linear-gradient(135deg, #FA709A, #FEE140); }
.course-thumb-5 { background: linear-gradient(135deg, #30CFD0, #330867); }
.course-thumb-6 { background: linear-gradient(135deg, #A8EDEA, #FED6E3); }

/* Added Badge */
.course-badge-added {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 5px 12px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.95);
    color: var(--text-soft);
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Remove from wishlist button */
.btn-remove-wishlist {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,107,138,0.95);
    backdrop-filter: blur(10px);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    color: white;
    transition: all 0.2s;
    z-index: 2;
    box-shadow: 0 4px 12px rgba(255,107,138,0.3);
}

.btn-remove-wishlist:hover {
    background: #FF4B6E;
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(255,75,110,0.4);
}

.course-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.course-category {
    font-size: 10px;
    color: var(--muted);
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.course-title {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    line-height: 1.3;
    letter-spacing: -0.01em;
    margin-bottom: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 46px;
    text-decoration: none;
    color: inherit;
}

.course-title:hover {
    color: var(--pink);
}

.course-instructor {
    font-size: 12px;
    color: var(--text-soft);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.course-instructor-avatar {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white;
    font-size: 10px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.course-meta {
    display: flex;
    gap: 12px;
    font-size: 11px;
    color: var(--muted);
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border);
    flex-wrap: wrap;
}

.course-meta span {
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.course-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    gap: 10px;
}

.course-price-section {
    display: flex;
    flex-direction: column;
}

.course-price {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.01em;
    line-height: 1;
    color: var(--text);
}

.course-price.free {
    color: var(--teal);
}

.course-price-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-top: 2px;
}

.btn-enroll-now {
    padding: 10px 18px;
    background: #1A1825;
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.btn-enroll-now:hover {
    background: #2A2840;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(26,24,37,0.3);
}

/* ═══ EMPTY STATE ═══ */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    background: rgba(255,255,255,0.5);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,0.8);
}

.empty-icon {
    font-size: 72px;
    margin-bottom: 20px;
    animation: heartbeat 2s infinite;
}

.empty-title {
    font-family: var(--font-serif);
    font-size: 32px;
    font-weight: 400;
    margin-bottom: 10px;
    letter-spacing: -0.01em;
    padding-bottom: 0.05em;
}

.empty-title em {
    font-style: italic;
    background: linear-gradient(135deg, #FF9FB5, #FF6B8A);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.empty-desc {
    font-size: 14px;
    color: var(--muted);
    max-width: 440px;
    margin: 0 auto 24px;
    line-height: 1.6;
}

.btn-browse {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 12px 24px;
    background: #1A1825;
    color: white;
    text-decoration: none;
    border-radius: 100px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(26,24,37,0.3);
}

.btn-browse:hover {
    background: #2A2840;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26,24,37,0.4);
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 900px) {
    .stats-bar {
        grid-template-columns: repeat(2, 1fr);
    }
    .stat-cell:nth-child(2) { border-right: none; }
    .courses-toolbar { flex-direction: column; align-items: stretch; }
    .search-wishlist { min-width: auto; }
    .saved-banner { flex-direction: column; align-items: flex-start; }
}

@media (max-width: 640px) {
    .nav-links { display: none; }
    .filter-tabs {
        overflow-x: auto;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
    }
    .courses-grid { grid-template-columns: 1fr; }
}

/* ═══ USER DROPDOWN NAVBAR ═══ */
.user-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    padding: 6px 14px 6px 6px;
    cursor: pointer;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 500;
    color: var(--text);
    transition: all 0.2s;
}

.user-btn:hover {
    background: rgba(255,255,255,0.95);
    box-shadow: 0 4px 12px rgba(30,58,95,0.08);
}

.user-avatar-nav {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 12px;
    flex-shrink: 0;
}

.user-name-nav {
    white-space: nowrap;
}

.user-dropdown {
    position: absolute;
    right: 0;
    top: calc(100% + 12px);
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    padding: 8px;
    min-width: 240px;
    box-shadow: 0 20px 50px rgba(30,58,95,0.15);
    z-index: 100;
}

.dropdown-header {
    padding: 10px 12px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    margin-bottom: 6px;
}

.dropdown-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
}

.dropdown-email {
    font-size: 11px;
    color: var(--muted);
    margin-top: 2px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 12px;
    border-radius: 10px;
    color: var(--text-soft);
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s;
    background: transparent;
    border: none;
    width: 100%;
    cursor: pointer;
    text-align: left;
    font-family: var(--font-sans);
    font-weight: 500;
}

.dropdown-item:hover {
    background: rgba(123,111,232,0.08);
    color: var(--text);
}

.dropdown-item-danger {
    color: var(--orange);
}

.dropdown-item-danger:hover {
    background: rgba(255,138,91,0.08);
    color: var(--orange);
}

@media (max-width: 640px) {
    .user-name-nav { display: none; }
    .user-dropdown {
        right: -10px;
        min-width: 220px;
    }
}
</style>
</head>
<body>

@include('partials.navbar')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="flash-wrap" x-data x-init="setTimeout(() => $el.remove(), 4000)">
        <div class="flash flash-success">
            ✓ {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="flash-wrap" x-data x-init="setTimeout(() => $el.remove(), 4000)">
        <div class="flash flash-error">
            ✕ {{ session('error') }}
        </div>
    </div>
@endif


{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="container">
        <div class="page-badge">
            <span class="page-badge-heart">❤️</span>
            <span>{{ $stats['total'] }} {{ $stats['total'] == 1 ? 'course' : 'courses' }} saved</span>
        </div>

        <h1 class="page-title">
            My <em>Wishlist</em>
        </h1>

        <p class="page-subtitle">
            Save courses you're interested in and come back anytime to enroll when you're ready.
        </p>

        {{-- Stats Bar --}}
        <div class="stats-bar">
            <div class="stat-cell">
                <div class="stat-icon">❤️</div>
                <div class="stat-value"><em>{{ $stats['total'] }}</em></div>
                <div class="stat-label">Saved Items</div>
            </div>
            <div class="stat-cell">
                <div class="stat-icon">🆓</div>
                <div class="stat-value value-teal"><em>{{ $stats['free'] }}</em></div>
                <div class="stat-label">Free Courses</div>
            </div>
            <div class="stat-cell">
                <div class="stat-icon">💎</div>
                <div class="stat-value value-purple"><em>{{ $stats['premium'] }}</em></div>
                <div class="stat-label">Premium</div>
            </div>
            <div class="stat-cell">
                <div class="stat-icon">💰</div>
                <div class="stat-value value-gold">
                    <em>
                        @if($stats['saved_value'] >= 1000000)
                            {{ number_format($stats['saved_value'] / 1000000, 1) }}M
                        @elseif($stats['saved_value'] >= 1000)
                            {{ number_format($stats['saved_value'] / 1000, 0) }}K
                        @else
                            {{ number_format($stats['saved_value']) }}
                        @endif
                    </em>
                </div>
                <div class="stat-label">Total Value (IDR)</div>
            </div>
        </div>
    </div>
</section>

{{-- MAIN CONTENT --}}
<section class="main-section">
    <div class="container">

        @php
            $currentFilter = request('filter', 'all');
        @endphp

        {{-- Toolbar: Filter Tabs + Search --}}
        <div class="courses-toolbar">
            <div class="filter-tabs">
                <a href="{{ route('student.wishlist') }}"
                   class="filter-tab {{ $currentFilter === 'all' ? 'active' : '' }}">
                    ❤️ All
                    <span class="filter-tab-count">{{ $stats['total'] }}</span>
                </a>
                <a href="{{ route('student.wishlist', ['filter' => 'free']) }}"
                   class="filter-tab {{ $currentFilter === 'free' ? 'active' : '' }}">
                    🆓 Free
                    <span class="filter-tab-count">{{ $stats['free'] }}</span>
                </a>
                <a href="{{ route('student.wishlist', ['filter' => 'premium']) }}"
                   class="filter-tab {{ $currentFilter === 'premium' ? 'active' : '' }}">
                    💎 Premium
                    <span class="filter-tab-count">{{ $stats['premium'] }}</span>
                </a>
            </div>

            <form action="{{ route('student.wishlist') }}" method="GET" class="search-wishlist">
                <span class="search-icon">🔍</span>
                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Search your wishlist..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
                @if($currentFilter !== 'all')
                    <input type="hidden" name="filter" value="{{ $currentFilter }}">
                @endif
            </form>
        </div>

        {{-- Saved Value Banner (Only if have saved value) --}}
        @if($stats['saved_value'] > 0)
            <div class="saved-banner">
                <div class="saved-left">
                    <div class="saved-icon">💰</div>
                    <div class="saved-text">
                        <div class="saved-label">Total value saved</div>
                        <div class="saved-value">
                            Rp <em>{{ number_format($stats['saved_value'], 0, ',', '.') }}</em>
                            <span style="font-size:13px;color:var(--muted);font-weight:500;">— ready to unlock</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('courses.index') }}" class="saved-action">
                    📚 Browse More
                </a>
            </div>
        @endif

        {{-- Courses Grid --}}
        <div class="courses-grid">

            @php
                // Fallback dummy data kalau belum ada wishlist
                $defaultWishlists = collect([
                    (object)[
                        'id' => 1,
                        'course' => (object)[
                            'id' => 1,
                            'title' => 'Fullstack Web Development with Laravel 12',
                            'slug' => 'fullstack-web-development-with-laravel-12',
                            'thumb' => 1,
                            'icon' => '💻',
                            'category' => (object)['name' => 'Programming'],
                            'instructor_name' => 'Budi Santoso',
                            'initial' => 'B',
                            'price' => 299000,
                            'rating' => 4.9,
                            'students' => '12.3k',
                            'duration' => '40h',
                        ]
                    ],
                    (object)[
                        'id' => 2,
                        'course' => (object)[
                            'id' => 2,
                            'title' => 'React.js from Zero to Hero',
                            'slug' => 'reactjs-from-zero-to-hero',
                            'thumb' => 4,
                            'icon' => '⚛️',
                            'category' => (object)['name' => 'Programming'],
                            'instructor_name' => 'Budi Santoso',
                            'initial' => 'B',
                            'price' => 249000,
                            'rating' => 4.8,
                            'students' => '9.2k',
                            'duration' => '30h',
                        ]
                    ],
                    (object)[
                        'id' => 3,
                        'course' => (object)[
                            'id' => 3,
                            'title' => 'Python for Data Analysis',
                            'slug' => 'python-for-data-analysis',
                            'thumb' => 3,
                            'icon' => '📊',
                            'category' => (object)['name' => 'Data Science'],
                            'instructor_name' => 'Rio Ahmad',
                            'initial' => 'R',
                            'price' => 0,
                            'rating' => 4.9,
                            'students' => '15.7k',
                            'duration' => '20h',
                        ]
                    ],
                    (object)[
                        'id' => 4,
                        'course' => (object)[
                            'id' => 4,
                            'title' => 'UI/UX Design Fundamentals',
                            'slug' => 'ui-ux-design-fundamentals',
                            'thumb' => 2,
                            'icon' => '🎨',
                            'category' => (object)['name' => 'Design'],
                            'instructor_name' => 'Sari Dewi',
                            'initial' => 'S',
                            'price' => 199000,
                            'rating' => 4.8,
                            'students' => '8.1k',
                            'duration' => '25h',
                        ]
                    ],
                    (object)[
                        'id' => 5,
                        'course' => (object)[
                            'id' => 5,
                            'title' => 'Digital Marketing Mastery 2025',
                            'slug' => 'digital-marketing-mastery-2025',
                            'thumb' => 6,
                            'icon' => '📈',
                            'category' => (object)['name' => 'Marketing'],
                            'instructor_name' => 'Maya Putri',
                            'initial' => 'M',
                            'price' => 249000,
                            'rating' => 4.7,
                            'students' => '9.8k',
                            'duration' => '30h',
                        ]
                    ],
                ]);

                $displayWishlists = ($wishlists->count() > 0) ? $wishlists : $defaultWishlists;
            @endphp

            @forelse($displayWishlists as $index => $wishlist)
                @php
                    $course = $wishlist->course ?? null;
                    if (!$course) continue;

                    // Extract data safely
                    $courseTitle = is_object($course) ? ($course->title ?? 'Untitled') : 'Untitled';
                    $courseSlug = is_object($course) ? ($course->slug ?? 'course') : 'course';
                    $categoryName = is_object($course) && isset($course->category)
                        ? ($course->category->name ?? 'General')
                        : 'General';
                    $thumb = $course->thumb ?? (($index % 6) + 1);
                    $icon = $course->icon ?? '📚';
                    $instructorName = $course->instructor_name
                        ?? (isset($course->instructors) && $course->instructors->count() > 0
                            ? $course->instructors->first()->name
                            : 'Coursify Team');
                    $initial = $course->initial ?? strtoupper(substr($instructorName, 0, 1));
                    $price = $course->price ?? 0;
                    $isFree = $price == 0;
                    $rating = $course->rating ?? 4.8;
                    $students = $course->students ?? '0';
                    $duration = $course->duration ?? 'N/A';
                    $wishlistId = $wishlist->id ?? $index;
                @endphp

                <div class="course-card" id="wishlist-card-{{ $wishlistId }}">
                    <a href="{{ route('courses.show', $courseSlug) }}" class="course-thumb course-thumb-{{ $thumb }}">
                        <span class="course-badge-added">
                            ❤️ Saved
                        </span>

                        {{-- Remove button --}}
                        <button class="btn-remove-wishlist"
                                onclick="event.preventDefault(); removeFromWishlist({{ $wishlistId }}, '{{ $courseTitle }}')"
                                title="Remove from wishlist">
                            ✕
                        </button>

                        {{ $icon }}
                    </a>

                    <div class="course-body">
                        <div class="course-category">{{ $categoryName }}</div>

                        <a href="{{ route('courses.show', $courseSlug) }}" class="course-title">
                            {{ $courseTitle }}
                        </a>

                        <div class="course-instructor">
                            <div class="course-instructor-avatar">{{ $initial }}</div>
                            <span>{{ $instructorName }}</span>
                        </div>

                        <div class="course-meta">
                            <span>⭐ {{ number_format($rating, 1) }}</span>
                            <span>👥 {{ $students }}</span>
                            <span>🕐 {{ $duration }}</span>
                        </div>

                        <div class="course-footer">
                            <div class="course-price-section">
                                <span class="course-price {{ $isFree ? 'free' : '' }}">
                                    @if($isFree)
                                        Free
                                    @else
                                        Rp {{ number_format($price, 0, ',', '.') }}
                                    @endif
                                </span>
                                <span class="course-price-label">
                                    {{ $isFree ? 'Start Now' : 'One-time' }}
                                </span>
                            </div>

                            <a href="{{ route('courses.show', $courseSlug) }}" class="btn-enroll-now">
                                @if($isFree)
                                    ▶ Start
                                @else
                                    🛒 Enroll
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon">💔</div>
                    <h3 class="empty-title">Your <em>wishlist</em> is empty</h3>
                    <p class="empty-desc">
                        Start exploring our catalog and save courses you're interested in. Click the ❤️ heart icon on any course to add it here.
                    </p>
                    <a href="{{ route('courses.index') }}" class="btn-browse">
                        🔍 Browse Courses
                    </a>
                </div>
            @endforelse

        </div>

        {{-- Helpful Tips Section --}}
        @if($displayWishlists->count() > 0)
            <div style="margin-top: 48px; padding: 24px; background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 16px; text-align: center;">
                <div style="font-family: var(--font-serif); font-size: 22px; margin-bottom: 8px;">
                    💡 <em style="color: var(--pink);">Pro tip</em>
                </div>
                <p style="font-size: 13px; color: var(--text-soft); max-width: 540px; margin: 0 auto; line-height: 1.6;">
                    Wishlist items remain saved until you remove them. Get notified when your saved courses go on sale — <a href="#" style="color: var(--pink); font-weight: 600; text-decoration: none;">enable notifications</a>.
                </p>
            </div>
        @endif

    </div>
</section>

<div style="height: 60px;"></div>

{{-- JAVASCRIPT --}}
<script>
    // Prevent browser bfcache
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });

    // Auto hide/show navbar on scroll
    (function() {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;

        let lastScroll = 0;
        let ticking = false;
        const scrollThreshold = 100;

        function updateNavbar() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 20) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }

            if (currentScroll < scrollThreshold) {
                navbar.classList.remove('navbar-hidden');
                lastScroll = currentScroll;
                ticking = false;
                return;
            }

            if (currentScroll > lastScroll + 5) {
                navbar.classList.add('navbar-hidden');
            } else if (currentScroll < lastScroll - 5) {
                navbar.classList.remove('navbar-hidden');
            }

            lastScroll = currentScroll;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(updateNavbar);
                ticking = true;
            }
        }, { passive: true });
    })();

    // Remove from wishlist with confirmation
    function removeFromWishlist(wishlistId, courseTitle) {
        if (!confirm(`Remove "${courseTitle}" from wishlist?`)) {
            return;
        }

        const card = document.getElementById(`wishlist-card-${wishlistId}`);

        // Animate fade out
        if (card) {
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
        }

        // Submit DELETE request via form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/wishlist/${wishlistId}`;
        form.style.display = 'none';

        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // DELETE method spoofing
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);

        setTimeout(() => {
            form.submit();
        }, 300);
    }

    // Search form auto-submit on enter
    document.querySelector('.search-wishlist input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.closest('form').submit();
        }
    });
</script>

</body>
</html>