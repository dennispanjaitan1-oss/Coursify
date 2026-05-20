<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Wishlist — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

{{-- Font Awesome 6 Free --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer">

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
/* ═══ CSS VARIABLES (Design Tokens) ═══ */
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
    --font-sans: 'Plus Jakarta Sans', sans-serif;

    /* Spacing system */
    --space-1: 4px;
    --space-2: 8px;
    --space-3: 12px;
    --space-4: 16px;
    --space-5: 20px;
    --space-6: 24px;
    --space-8: 32px;
    --space-10: 40px;
    --space-12: 48px;
}

/* ═══ NAVBAR ═══ */
.navbar-wrap {
    position: fixed;
    top: 0; left: 0; right: 0;
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
    width: 28px; height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 12px; flex-shrink: 0;
}
.user-name-nav { white-space: nowrap; }

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
.dropdown-name  { font-size: 13px; font-weight: 600; color: var(--text); }
.dropdown-email { font-size: 11px; color: var(--muted); margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

.dropdown-item {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 12px;
    border-radius: 10px;
    color: var(--text-soft);
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s;
    background: transparent; border: none;
    width: 100%; cursor: pointer;
    text-align: left;
    font-family: var(--font-sans); font-weight: 500;
}
.dropdown-item:hover { background: rgba(123,111,232,0.08); color: var(--text); }
.dropdown-item-danger { color: var(--orange); }
.dropdown-item-danger:hover { background: rgba(255,138,91,0.08); color: var(--orange); }

@media (max-width: 640px) {
    .nav-links { display: none; }
    .user-name-nav { display: none; }
    .user-dropdown { right: -10px; min-width: 220px; }
}

/* ═══ RESET & BASE ═══ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
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

/* ═══ ICON SYSTEM ═══
   Semua icon menggunakan Font Awesome 6.
   Gunakan aria-hidden="true" untuk icon dekoratif.
   Gunakan aria-label pada tombol icon-only.
   ═══ */
.icon { display: inline-flex; align-items: center; justify-content: center; }
.icon-sm  { font-size: 12px; }
.icon-md  { font-size: 16px; }
.icon-lg  { font-size: 20px; }
.icon-xl  { font-size: 24px; }

/* Icon warna semantic */
.icon-pink   { color: var(--pink); }
.icon-teal   { color: var(--teal); }
.icon-gold   { color: var(--gold); }
.icon-purple { color: var(--purple); }
.icon-muted  { color: var(--muted); }

/* ═══ FLASH MESSAGE ═══ */
.flash-wrap {
    position: fixed;
    top: 90px;
    right: var(--space-6);
    z-index: 101;
    max-width: 400px;
    animation: slideInRight 0.4s ease-out;
}

/* ═══ ANIMASI
   Semua animasi dibungkus prefers-reduced-motion
   agar aksesibel untuk pengguna yang sensitif terhadap gerak.
   ═══ */
@media (prefers-reduced-motion: no-preference) {
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(50px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        50%       { transform: scale(1.2); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }

    .animate-heartbeat { animation: heartbeat 1.5s infinite; }
    .animate-fade-in   { animation: fadeInUp 0.5s ease-out both; }

    /* Stagger animation untuk card grid */
    .course-card:nth-child(1)  { animation: fadeInUp 0.4s ease-out 0.05s both; }
    .course-card:nth-child(2)  { animation: fadeInUp 0.4s ease-out 0.10s both; }
    .course-card:nth-child(3)  { animation: fadeInUp 0.4s ease-out 0.15s both; }
    .course-card:nth-child(4)  { animation: fadeInUp 0.4s ease-out 0.20s both; }
    .course-card:nth-child(5)  { animation: fadeInUp 0.4s ease-out 0.25s both; }
    .course-card:nth-child(6)  { animation: fadeInUp 0.4s ease-out 0.30s both; }
    .course-card:nth-child(n+7) { animation: fadeInUp 0.4s ease-out 0.35s both; }
}

/* Fallback — tanpa animasi sama sekali jika reduced-motion aktif */
@media (prefers-reduced-motion: reduce) {
    .animate-heartbeat,
    .animate-fade-in,
    .course-card { animation: none; }
}

/* ═══ FLASH COMPONENT ═══ */
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
.flash-success { border-left: 4px solid var(--teal); }
.flash-error   { border-left: 4px solid var(--orange); }

/* Icon dalam flash */
.flash-success .flash-icon { color: var(--teal); }
.flash-error   .flash-icon { color: var(--orange); }

/* ═══ PAGE HEADER ═══ */
.page-header { text-align: center; padding: var(--space-10) var(--space-5) var(--space-6); position: relative; z-index: 1; }

.page-badge {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
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

.page-title {
    font-family: var(--font-serif);
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 400;
    line-height: 1.05;
    letter-spacing: -0.02em;
    margin-bottom: 12px;
    overflow: visible;
}

.page-title em {
    font-style: italic;
    background: linear-gradient(135deg, #FF9FB5, #FF6B8A);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: var(--pink); /* fallback */
    display: inline-block;
    padding-bottom: 0.15em;
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
    margin: var(--space-8) auto 0;
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
    border-right: 1px solid var(--border);
    padding: 0 var(--space-2);
    min-width: 0;
}
.stat-cell:last-child { border-right: none; }

/* Icon di stats — lebih besar, warna tematik */
.stat-icon-wrap {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: var(--space-2);
}
.stat-icon-pink   { background: var(--pink-light);  color: var(--pink); }
.stat-icon-teal   { background: var(--teal-light);  color: var(--teal); }
.stat-icon-purple { background: var(--lav-1);        color: var(--purple); }
.stat-icon-gold   { background: var(--gold-light);  color: var(--gold); }

.stat-value {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: var(--space-1);
}
.stat-value em { font-style: italic; }
.text-pink   { color: var(--pink); }
.text-teal   { color: var(--teal); }
.text-gold   { color: var(--gold); }
.text-purple { color: var(--purple); }

.stat-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* ═══ MAIN SECTION ═══ */
.main-section { padding: 20px 20px 60px; }

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

/* Sort Dropdown */
.sort-dropdown {
    position: relative;
}
.sort-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 16px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1.5px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
}
.sort-btn:hover {
    background: white;
    border-color: var(--purple);
    color: var(--purple-dark);
}
.sort-menu {
    position: absolute;
    right: 0;
    top: calc(100% + 8px);
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 14px;
    padding: 6px;
    min-width: 200px;
    box-shadow: 0 12px 40px rgba(30,58,95,0.12);
    z-index: 50;
}
.sort-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.15s;
    text-decoration: none;
}
.sort-option:hover {
    background: var(--lav-1);
    color: var(--purple-dark);
}
.sort-option.active {
    background: var(--lav-2);
    color: var(--purple-dark);
    font-weight: 600;
}

/* Search */
.search-wishlist { position: relative; min-width: 260px; }

.search-input {
    width: 100%;
    padding: 10px 40px 10px 42px;
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
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 14px;
    pointer-events: none;
    transition: color 0.2s;
}
.search-wishlist:focus-within .search-icon { color: var(--pink); }

/* Clear search button */
.search-clear {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--muted);
    color: white;
    border: none;
    font-size: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.7;
    transition: all 0.2s;
}
.search-clear:hover { opacity: 1; background: var(--text); }

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
.saved-icon-wrap {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #FF9FB5, #FF6B8A);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    flex-shrink: 0;
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
.saved-value em { font-style: italic; color: var(--pink); }

/* ═══ COURSES GRID ═══ */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.course-card {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border: 1.5px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    overflow: hidden;
    color: var(--text);
    transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 16px rgba(30,58,95,0.04);
    min-width: 0;
    position: relative;
}
.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(30,58,95,0.12);
    border-color: rgba(255,107,138,0.4);
}

/* Thumbnail gradients */
.course-thumb {
    aspect-ratio: 16/10;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 54px;
    overflow: hidden;
    text-decoration: none;
    color: white;
}
.course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
.course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
.course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }
.course-thumb-4 { background: linear-gradient(135deg, #FA709A, #FEE140); }
.course-thumb-5 { background: linear-gradient(135deg, #30CFD0, #330867); }
.course-thumb-6 { background: linear-gradient(135deg, #A8EDEA, #FED6E3); }

/* Thumbnail overlay saat hover */
.course-thumb::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0);
    transition: background 0.3s;
}
.course-card:hover .course-thumb::after { background: rgba(0,0,0,0.08); }

/* Course icon (emoji replacement) */
.course-thumb-icon {
    font-size: 52px;
    position: relative;
    z-index: 1;
    filter: drop-shadow(0 4px 12px rgba(0,0,0,0.2));
    transition: transform 0.3s;
}
.course-card:hover .course-thumb-icon { transform: scale(1.1); }

/* Badge "Saved" */
.badge-saved {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 5px 12px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    background: rgba(255,255,255,0.95);
    color: var(--pink);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    z-index: 2;
    backdrop-filter: blur(10px);
}

/* Tombol Remove — icon-only, aksesibel */
/* Wrapper thumbnail agar btn-remove bisa absolute di atasnya */
.course-thumb-wrap {
    position: relative;
    overflow: hidden;
    border-radius: 20px 20px 0 0;
}

.btn-remove {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255,107,138,0.9);
    backdrop-filter: blur(10px);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 14px;
    color: white;
    transition: all 0.2s;
    z-index: 2;
    box-shadow: 0 4px 12px rgba(255,107,138,0.35);
}
.btn-remove:hover {
    background: #FF4B6E;
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(255,75,110,0.45);
}
.btn-remove:focus-visible {
    outline: 3px solid var(--pink);
    outline-offset: 2px;
}

/* Course body */
.course-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }

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
    color: var(--text);
    transition: color 0.2s;
}
.course-title:hover { color: var(--pink); }

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

/* Meta row — menggunakan FA icons, bukan emoji */
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
.course-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.course-meta-item i {
    font-size: 11px;
    opacity: 0.75;
}

.course-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    gap: 10px;
}

.course-price {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.01em;
    line-height: 1;
    color: var(--text);
}
.course-price.free { color: var(--teal); }

.course-price-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-top: 2px;
}

/* CTA buttons */
.btn-primary {
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
.btn-primary:hover {
    background: #2A2840;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(26,24,37,0.3);
}
.btn-primary:focus-visible {
    outline: 3px solid var(--purple);
    outline-offset: 2px;
}

.btn-outline {
    padding: 10px 18px;
    background: transparent;
    color: var(--text-soft);
    border: 1.5px solid var(--border);
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
.btn-outline:hover {
    border-color: var(--purple);
    color: var(--purple-dark);
    background: var(--lav-1);
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
.empty-icon-wrap {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: var(--pink-light);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    color: var(--pink);
    margin-bottom: 20px;
}
.empty-title {
    font-family: var(--font-serif);
    font-size: 32px;
    font-weight: 400;
    margin-bottom: 10px;
    letter-spacing: -0.01em;
}
.empty-title em {
    font-style: italic;
    background: linear-gradient(135deg, #FF9FB5, #FF6B8A);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: var(--pink); /* fallback */
}
.empty-desc {
    font-size: 14px;
    color: var(--muted);
    max-width: 440px;
    margin: 0 auto 24px;
    line-height: 1.6;
}

/* ═══ UNDO TOAST ═══ */
.toast-container {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 200;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    pointer-events: none;
}
.toast {
    background: #1A1825;
    color: white;
    padding: 14px 20px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 8px 32px rgba(26,24,37,0.35);
    pointer-events: all;
    animation: toastIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
@media (prefers-reduced-motion: no-preference) {
    @keyframes toastIn {
        from { opacity: 0; transform: translateY(20px) scale(0.9); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes toastOut {
        to { opacity: 0; transform: translateY(10px) scale(0.95); }
    }
}
.toast.removing { animation: toastOut 0.25s ease-in forwards; }
.toast-undo-btn {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 100px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
    font-family: var(--font-sans);
}
.toast-undo-btn:hover { background: rgba(255,255,255,0.35); }

.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: rgba(255,255,255,0.3);
    border-radius: 100px;
    animation: progressBar 5s linear forwards;
}
@media (prefers-reduced-motion: no-preference) {
    @keyframes progressBar {
        from { width: 100%; }
        to   { width: 0%; }
    }
}

/* ═══ MODAL KONFIRMASI (Ganti confirm() browser) ═══ */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(26,24,37,0.5);
    backdrop-filter: blur(8px);
    z-index: 150;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.25s;
}
.modal-overlay.open {
    opacity: 1;
    visibility: visible;
}
.modal {
    background: white;
    border-radius: 24px;
    padding: 32px;
    max-width: 420px;
    width: 100%;
    box-shadow: 0 24px 80px rgba(26,24,37,0.25);
    transform: translateY(20px) scale(0.97);
    transition: all 0.25s cubic-bezier(0.34, 1.2, 0.64, 1);
}
.modal-overlay.open .modal {
    transform: translateY(0) scale(1);
}
.modal-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: var(--pink-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: var(--pink);
    margin: 0 auto 20px;
}
.modal-title {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    text-align: center;
    margin-bottom: 8px;
}
.modal-desc {
    font-size: 14px;
    color: var(--text-soft);
    text-align: center;
    line-height: 1.6;
    margin-bottom: 24px;
}
.modal-course-name {
    font-weight: 600;
    color: var(--text);
}
.modal-actions {
    display: flex;
    gap: 10px;
}
.modal-actions > * { flex: 1; justify-content: center; }
.btn-danger {
    padding: 12px 20px;
    background: var(--pink);
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.btn-danger:hover {
    background: #FF4B6E;
    box-shadow: 0 6px 20px rgba(255,107,138,0.4);
}

/* ═══ CONTAINER ═══ */
.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 1;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 900px) {
    .stats-bar { grid-template-columns: repeat(2, 1fr); }
    .stat-cell:nth-child(2) { border-right: none; }
    .courses-toolbar { flex-direction: column; align-items: stretch; }
    .search-wishlist { min-width: auto; }
    .saved-banner { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 640px) {
    .filter-tabs { overflow-x: auto; flex-wrap: nowrap; -webkit-overflow-scrolling: touch; }
    .courses-grid { grid-template-columns: 1fr; }
    .modal-actions { flex-direction: column; }
    .search-wishlist { min-width: auto; }
}
</style>
</head>

<body>

{{-- ═══ NAVBAR ═══ --}}
@include('partials.navbar')

{{-- ═══ FLASH MESSAGES ═══ --}}
@if(session('success'))
    <div class="flash-wrap" role="status" aria-live="polite"
         x-data x-init="setTimeout(() => { $el.style.opacity='0'; setTimeout(() => $el.remove(), 400); }, 4000)">
        <div class="flash flash-success">
            <i class="fa-solid fa-circle-check flash-icon" aria-hidden="true"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="flash-wrap" role="alert" aria-live="assertive"
         x-data x-init="setTimeout(() => { $el.style.opacity='0'; setTimeout(() => $el.remove(), 400); }, 4000)">
        <div class="flash flash-error">
            <i class="fa-solid fa-circle-exclamation flash-icon" aria-hidden="true"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif


{{-- ═══ PAGE HEADER ═══ --}}
<section class="page-header">
    <div class="container">

        <div class="page-badge" role="status">
            <i class="fa-solid fa-heart animate-heartbeat" aria-hidden="true"></i>
            <span>{{ $stats['total'] }} {{ $stats['total'] == 1 ? 'course' : 'courses' }} saved</span>
        </div>

        <h1 class="page-title">
            My <em>Wishlist</em>
        </h1>

        <p class="page-subtitle">
            Save courses you're interested in and come back anytime to enroll when you're ready.
        </p>

        {{-- Stats Bar --}}
        <div class="stats-bar" role="list" aria-label="Wishlist statistics">
            <div class="stat-cell" role="listitem">
                <div class="stat-icon-wrap stat-icon-pink" aria-hidden="true">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <div class="stat-value text-pink"><em>{{ $stats['total'] }}</em></div>
                <div class="stat-label">Saved Items</div>
            </div>

            <div class="stat-cell" role="listitem">
                <div class="stat-icon-wrap stat-icon-teal" aria-hidden="true">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <div class="stat-value text-teal"><em>{{ $stats['free'] }}</em></div>
                <div class="stat-label">Free Courses</div>
            </div>

            <div class="stat-cell" role="listitem">
                <div class="stat-icon-wrap stat-icon-purple" aria-hidden="true">
                    <i class="fa-solid fa-gem"></i>
                </div>
                <div class="stat-value text-purple"><em>{{ $stats['premium'] }}</em></div>
                <div class="stat-label">Premium</div>
            </div>

            <div class="stat-cell" role="listitem">
                <div class="stat-icon-wrap stat-icon-gold" aria-hidden="true">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div class="stat-value text-gold">
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


{{-- ═══ MAIN CONTENT ═══ --}}
<section class="main-section">
    <div class="container">

        @php $currentFilter = request('filter', 'all'); @endphp

        {{-- Toolbar --}}
        <div class="courses-toolbar">
            {{-- Filter Tabs --}}
            <div class="filter-tabs" role="tablist" aria-label="Filter wishlist">
                <a href="{{ route('student.wishlist') }}"
                   class="filter-tab {{ $currentFilter === 'all' ? 'active' : '' }}"
                   role="tab" aria-selected="{{ $currentFilter === 'all' ? 'true' : 'false' }}">
                    <i class="fa-solid fa-heart" aria-hidden="true"></i>
                    All
                    <span class="filter-tab-count" aria-label="{{ $stats['total'] }} items">
                        {{ $stats['total'] }}
                    </span>
                </a>
                <a href="{{ route('student.wishlist', ['filter' => 'free']) }}"
                   class="filter-tab {{ $currentFilter === 'free' ? 'active' : '' }}"
                   role="tab" aria-selected="{{ $currentFilter === 'free' ? 'true' : 'false' }}">
                    <i class="fa-solid fa-gift" aria-hidden="true"></i>
                    Free
                    <span class="filter-tab-count">{{ $stats['free'] }}</span>
                </a>
                <a href="{{ route('student.wishlist', ['filter' => 'premium']) }}"
                   class="filter-tab {{ $currentFilter === 'premium' ? 'active' : '' }}"
                   role="tab" aria-selected="{{ $currentFilter === 'premium' ? 'true' : 'false' }}">
                    <i class="fa-solid fa-gem" aria-hidden="true"></i>
                    Premium
                    <span class="filter-tab-count">{{ $stats['premium'] }}</span>
                </a>
            </div>

            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                {{-- Sort Dropdown --}}
                <div class="sort-dropdown" x-data="{ open: false }" @click.outside="open = false">
                    <button class="sort-btn" @click="open = !open" aria-haspopup="listbox"
                            :aria-expanded="open" aria-label="Sort wishlist">
                        <i class="fa-solid fa-arrow-up-wide-short" aria-hidden="true"></i>
                        <span>Sort</span>
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"
                           :style="open ? 'transform: rotate(180deg)' : ''"
                           style="font-size:11px; transition: transform 0.2s;"></i>
                    </button>
                    <div class="sort-menu" x-show="open" x-transition role="listbox"
     style="display:none;" @click="open = false">

    <a href="{{ route('student.wishlist', array_merge(array_filter(request()->only(['filter', 'search'])), ['sort' => 'newest'])) }}"
       class="sort-option {{ request('sort', 'newest') === 'newest' ? 'active' : '' }}" role="option">
        <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
        Terbaru ditambahkan
    </a>

    <a href="{{ route('student.wishlist', array_merge(array_filter(request()->only(['filter', 'search'])), ['sort' => 'oldest'])) }}"
       class="sort-option {{ request('sort') === 'oldest' ? 'active' : '' }}" role="option">
        <i class="fa-solid fa-clock" aria-hidden="true"></i>
        Terlama ditambahkan
    </a>

    <a href="{{ route('student.wishlist', array_merge(array_filter(request()->only(['filter', 'search'])), ['sort' => 'price_low'])) }}"
       class="sort-option {{ request('sort') === 'price_low' ? 'active' : '' }}" role="option">
        <i class="fa-solid fa-arrow-up-1-9" aria-hidden="true"></i>
        Harga: Rendah ke Tinggi
    </a>

    <a href="{{ route('student.wishlist', array_merge(array_filter(request()->only(['filter', 'search'])), ['sort' => 'price_high'])) }}"
       class="sort-option {{ request('sort') === 'price_high' ? 'active' : '' }}" role="option">
        <i class="fa-solid fa-arrow-down-9-1" aria-hidden="true"></i>
        Harga: Tinggi ke Rendah
    </a>

    <a href="{{ route('student.wishlist', array_merge(array_filter(request()->only(['filter', 'search'])), ['sort' => 'rating'])) }}"
       class="sort-option {{ request('sort') === 'rating' ? 'active' : '' }}" role="option">
        <i class="fa-solid fa-star" aria-hidden="true"></i>
        Rating tertinggi
    </a>

</div>{{-- /sort-menu --}}
</div>{{-- /sort-dropdown --}}

                {{-- Search --}}
                <form action="{{ route('student.wishlist') }}" method="GET" class="search-wishlist"
                      role="search" aria-label="Search wishlist">
                    <i class="fa-solid fa-magnifying-glass search-icon" aria-hidden="true"></i>
                    <input
                        type="search"
                        name="search"
                        id="wishlist-search"
                        class="search-input"
                        placeholder="Cari wishlist kamu..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                        aria-label="Search courses in wishlist"
                    >
                    @if(request('search'))
                        <button type="button" class="search-clear"
                                onclick="document.getElementById('wishlist-search').value=''; this.closest('form').submit();"
                                aria-label="Clear search">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    @endif
                    @if($currentFilter !== 'all')
                        <input type="hidden" name="filter" value="{{ $currentFilter }}">
                    @endif
                </form>
            </div>
        </div>

        {{-- Saved Value Banner --}}
        @if($stats['saved_value'] > 0)
            <div class="saved-banner" role="complementary" aria-label="Total value in wishlist">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div class="saved-icon-wrap" aria-hidden="true">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <div class="saved-label">Total nilai tersimpan</div>
                        <div class="saved-value">
                            Rp <em>{{ number_format($stats['saved_value'], 0, ',', '.') }}</em>
                            <span style="font-size:13px; color:var(--muted); font-weight:500;">
                                — siap untuk di-unlock
                            </span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('courses.index') }}" class="btn-primary">
                    <i class="fa-solid fa-compass" aria-hidden="true"></i>
                    Browse Lebih Banyak
                </a>
            </div>
        @endif

        {{-- ═══ COURSES GRID ═══ --}}
        {{--
            CATATAN: Tidak ada lagi fallback dummy data di View.
            Data harus selalu dari Controller ($wishlists dari WishlistController@index).
            Jika kosong, tampilkan empty state.
        --}}
        <div class="courses-grid" id="wishlist-grid" role="list" aria-label="Saved courses">

            @forelse($wishlists as $index => $wishlist)
                @php
                    $course         = $wishlist->course;
                    $courseTitle    = $course->title;
                    $courseSlug     = $course->slug;
                    $categoryName   = $course->category->name ?? 'General';
                    $thumb          = ($index % 6) + 1;
                    $instructorName = $course->instructors->first()?->name ?? 'Coursify Team';
                    $initial        = strtoupper(substr($instructorName, 0, 1));
                    $price          = $course->price ?? 0;
                    $isFree         = $price == 0;
                    $rating         = $course->rating ?? 4.8;
                    $totalStudents  = $course->enrollments_count ?? 0;
                    $duration       = $course->duration_text ?? 'N/A';
                    $wishlistId     = $wishlist->id;
                    $courseIcon     = $course->icon ?? '📚';
                @endphp

                <article class="course-card" id="wishlist-card-{{ $wishlistId }}"
                         role="listitem" aria-label="{{ $courseTitle }}">

                    {{-- Thumbnail --}}
                    <div class="course-thumb-wrap" style="position:relative;">
                        <a href="{{ route('courses.show', $courseSlug) }}"
                           class="course-thumb course-thumb-{{ $thumb }}"
                           aria-label="Lihat kursus {{ $courseTitle }}">

                            {{-- Badge Saved --}}
                            <span class="badge-saved">
                                <i class="fa-solid fa-heart" aria-hidden="true"></i>
                                Saved
                            </span>

                            {{-- Course Thumbnail Icon --}}
                            <span class="course-thumb-icon" aria-hidden="true">{{ $courseIcon }}</span>
                        </a>

                        {{-- Tombol Remove — di luar <a>, masih dalam wrapper --}}
                        <button
                            class="btn-remove"
                            data-id="{{ $wishlistId }}"
                            data-delete-url="{{ route('student.wishlist.destroy', $wishlistId) }}"
                            onclick="openRemoveModal({{ $wishlistId }}, '{{ addslashes($courseTitle) }}')"
                            aria-label="Hapus {{ $courseTitle }} dari wishlist"
                            title="Hapus dari wishlist">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>

                    {{-- Card Body --}}
                    <div class="course-body">
                        <div class="course-category">
                            <i class="fa-solid fa-tag icon-sm" aria-hidden="true"></i>
                            {{ $categoryName }}
                        </div>

                        <a href="{{ route('courses.show', $courseSlug) }}" class="course-title">
                            {{ $courseTitle }}
                        </a>

                        <div class="course-instructor">
                            <div class="course-instructor-avatar" aria-hidden="true">{{ $initial }}</div>
                            <span>{{ $instructorName }}</span>
                        </div>

                        {{-- Meta: Rating, Students, Duration — FA icons --}}
                        <div class="course-meta" aria-label="Course details">
                            <span class="course-meta-item" title="Rating">
                                <i class="fa-solid fa-star" style="color: var(--gold);" aria-hidden="true"></i>
                                <span>{{ number_format($rating, 1) }}</span>
                            </span>
                            <span class="course-meta-item" title="Total students">
                                <i class="fa-solid fa-users" aria-hidden="true"></i>
                                <span>
                                    @if($totalStudents >= 1000)
                                        {{ number_format($totalStudents / 1000, 1) }}k
                                    @else
                                        {{ $totalStudents }}
                                    @endif
                                </span>
                            </span>
                            <span class="course-meta-item" title="Duration">
                                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                <span>{{ $duration }}</span>
                            </span>
                        </div>

                        {{-- Footer: Price + CTA --}}
                        <div class="course-footer">
                            <div>
                                <div class="course-price {{ $isFree ? 'free' : '' }}" aria-label="Price">
                                    @if($isFree)
                                        Gratis
                                    @else
                                        Rp {{ number_format($price, 0, ',', '.') }}
                                    @endif
                                </div>
                                <div class="course-price-label">
                                    {{ $isFree ? 'Mulai Sekarang' : 'Sekali Bayar' }}
                                </div>
                            </div>

                            <a href="{{ route('courses.show', $courseSlug) }}"
                               class="btn-primary"
                               aria-label="{{ $isFree ? 'Start' : 'Enroll' }} {{ $courseTitle }}">
                                @if($isFree)
                                    <i class="fa-solid fa-play" aria-hidden="true"></i>
                                    Mulai
                                @else
                                    <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                                    Enroll
                                @endif
                            </a>
                        </div>
                    </div>
                </article>

            @empty
                <div class="empty-state" role="status" aria-live="polite">
                    <div class="empty-icon-wrap" aria-hidden="true">
                        <i class="fa-solid fa-heart-crack"></i>
                    </div>
                    <h2 class="empty-title">Wishlist kamu <em>kosong</em></h2>
                    <p class="empty-desc">
                        Jelajahi katalog kami dan simpan kursus yang kamu minati.
                        Klik ikon <i class="fa-solid fa-heart" style="color:var(--pink);" aria-label="heart"></i>
                        di kursus mana saja untuk menambahkannya ke sini.
                    </p>
                    <a href="{{ route('courses.index') }}" class="btn-primary" style="margin: 0 auto;">
                        <i class="fa-solid fa-compass" aria-hidden="true"></i>
                        Jelajahi Kursus
                    </a>
                </div>
            @endforelse

        </div>

        {{-- Pro Tip --}}
        @if($wishlists->count() > 0)
            <div style="margin-top:48px; padding:24px; background:rgba(255,255,255,0.5);
                        border:1px solid var(--border); border-radius:16px; text-align:center;">
                <div style="font-family:var(--font-serif); font-size:20px; margin-bottom:8px; color:var(--text);">
                    <i class="fa-solid fa-lightbulb" style="color:var(--gold);" aria-hidden="true"></i>
                    <em style="color:var(--pink);">Pro tip</em>
                </div>
                <p style="font-size:13px; color:var(--text-soft); max-width:540px; margin:0 auto; line-height:1.6;">
                    Item wishlist tersimpan sampai kamu menghapusnya sendiri. Aktifkan notifikasi agar
                    mendapat info ketika kursus yang kamu simpan sedang diskon —
                    <a href="#" style="color:var(--pink); font-weight:600; text-decoration:none;">
                        aktifkan notifikasi
                    </a>.
                </p>
            </div>
        @endif

    </div>
</section>

<div style="height:60px;"></div>


{{-- ═══ MODAL KONFIRMASI HAPUS ═══
     Mengganti confirm() bawaan browser yang tidak bisa di-style
     ═══ --}}
<div class="modal-overlay" id="remove-modal" role="dialog" aria-modal="true"
     aria-labelledby="modal-title" aria-describedby="modal-desc">
    <div class="modal">
        <div class="modal-icon" aria-hidden="true">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="modal-title" id="modal-title">Hapus dari Wishlist?</h3>
        <p class="modal-desc" id="modal-desc">
            Kursus <strong class="modal-course-name" id="modal-course-name"></strong>
            akan dihapus dari wishlist kamu.
        </p>
        <div class="modal-actions">
            <button class="btn-outline" onclick="closeRemoveModal()" type="button"
                    aria-label="Batal, jangan hapus">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                Batal
            </button>
            <button class="btn-danger" onclick="confirmRemove()" type="button"
                    id="modal-confirm-btn" aria-label="Ya, hapus dari wishlist">
                <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>


{{-- ═══ UNDO TOAST CONTAINER ═══ --}}
<div class="toast-container" id="toast-container" aria-live="polite" aria-atomic="false"></div>


{{-- ═══ JAVASCRIPT ═══ --}}
<script>
// ──────────────────────────────────────────────
// Prevent bfcache stale content
// ──────────────────────────────────────────────
window.addEventListener('pageshow', (e) => {
    if (e.persisted) window.location.reload();
});

// ──────────────────────────────────────────────
// Navbar scroll behavior
// ──────────────────────────────────────────────
(function () {
    const navbar = document.getElementById('mainNavbar');
    if (!navbar) return;

    let lastScroll = 0, ticking = false;

    function updateNavbar() {
        const current = window.pageYOffset;
        navbar.classList.toggle('navbar-scrolled', current > 20);
        if (current < 100) {
            navbar.classList.remove('navbar-hidden');
        } else if (current > lastScroll + 5) {
            navbar.classList.add('navbar-hidden');
        } else if (current < lastScroll - 5) {
            navbar.classList.remove('navbar-hidden');
        }
        lastScroll = current;
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) { requestAnimationFrame(updateNavbar); ticking = true; }
    }, { passive: true });
})();

// ──────────────────────────────────────────────
// Search — Enter key submit
// ──────────────────────────────────────────────
document.getElementById('wishlist-search')?.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') e.target.closest('form').submit();
});

// ──────────────────────────────────────────────
// Modal state
// ──────────────────────────────────────────────
let pendingWishlistId   = null;
let pendingCourseTitle  = null;

function openRemoveModal(wishlistId, courseTitle) {
    pendingWishlistId  = wishlistId;
    pendingCourseTitle = courseTitle;

    document.getElementById('modal-course-name').textContent = courseTitle;

    const overlay = document.getElementById('remove-modal');
    overlay.classList.add('open');

    // Focus trap — fokus ke tombol konfirmasi
    setTimeout(() => document.getElementById('modal-confirm-btn').focus(), 50);

    // Tutup dengan Escape
    document.addEventListener('keydown', handleModalEsc);
}

function closeRemoveModal() {
    const overlay = document.getElementById('remove-modal');
    overlay.classList.remove('open');
    document.removeEventListener('keydown', handleModalEsc);
    pendingWishlistId  = null;
    pendingCourseTitle = null;
}

function handleModalEsc(e) {
    if (e.key === 'Escape') closeRemoveModal();
}

// Klik di luar modal menutupnya
document.getElementById('remove-modal').addEventListener('click', function (e) {
    if (e.target === this) closeRemoveModal();
});

// ──────────────────────────────────────────────
// Confirm remove — animasi kartu hilang
// + Undo toast dengan timer 5 detik
// ──────────────────────────────────────────────
function confirmRemove() {
    if (!pendingWishlistId) return;

    const id        = pendingWishlistId;
    const title     = pendingCourseTitle;
    const card      = document.getElementById(`wishlist-card-${id}`);

    closeRemoveModal();

    // Simpan deleteUrl SEBELUM card di-remove dari DOM
    const btn       = card ? card.querySelector(`[data-id="${id}"]`) : null;
    const deleteUrl = btn ? btn.dataset.deleteUrl : null;

    if (!deleteUrl) {
        console.error('deleteUrl tidak ditemukan untuk id:', id);
        return;
    }

    // Simpan HTML kartu untuk fitur Undo
    const cardHTML = card ? card.outerHTML : null;
    const cardNext = card ? card.nextSibling : null;
    const grid     = document.getElementById('wishlist-grid');

    // Animasi hilang
    if (card) {
        card.style.transition = 'all 0.35s cubic-bezier(0.4, 0, 0.2, 1)';
        card.style.opacity    = '0';
        card.style.transform  = 'scale(0.92) translateY(-8px)';
        setTimeout(() => card.remove(), 350);
    }

    // Timer — DELETE request dikirim setelah 5 detik
    let deleteTimer = setTimeout(() => {
        submitDeleteUrl(deleteUrl);
        removeToast(id);
    }, 5000);

    // Tampilkan Undo toast
    showUndoToast(id, title, () => {
        // Callback jika Undo diklik
        clearTimeout(deleteTimer);
        if (cardHTML && grid) {
            const temp = document.createElement('div');
            temp.innerHTML = cardHTML;
            const restoredCard = temp.firstElementChild;
            restoredCard.style.opacity   = '0';
            restoredCard.style.transform = 'scale(0.92)';

            if (cardNext) {
                grid.insertBefore(restoredCard, cardNext);
            } else {
                grid.appendChild(restoredCard);
            }

            // Animate back in
            requestAnimationFrame(() => {
                restoredCard.style.transition = 'all 0.35s cubic-bezier(0.34, 1.2, 0.64, 1)';
                restoredCard.style.opacity    = '1';
                restoredCard.style.transform  = 'scale(1) translateY(0)';
            });
        }
        removeToast(id);
    });
}

// ──────────────────────────────────────────────
// Submit DELETE ke server (pakai fetch, bukan form submit)
// ──────────────────────────────────────────────
function submitDeleteUrl(url) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken || !url) {
        console.error('CSRF token atau URL tidak ditemukan');
        return;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-HTTP-Method-Override': 'DELETE',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ _method: 'DELETE' }),
    })
    .then(res => {
        if (!res.ok) console.error('Gagal hapus wishlist, status:', res.status);
    })
    .catch(err => console.error('Network error saat hapus wishlist:', err));
}

// ──────────────────────────────────────────────
// Undo Toast — muncul di bawah layar
// ──────────────────────────────────────────────
const activeToasts = {};

function showUndoToast(id, title, onUndo) {
    const container = document.getElementById('toast-container');

    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.id = `toast-${id}`;
    toast.setAttribute('role', 'status');
    toast.innerHTML = `
        <i class="fa-solid fa-trash-can" style="opacity:0.6;" aria-hidden="true"></i>
        <span><strong>${escapeHtml(title)}</strong> dihapus dari wishlist</span>
        <button class="toast-undo-btn" onclick="undoRemove(${id})" aria-label="Undo hapus ${escapeHtml(title)}">
            <i class="fa-solid fa-rotate-left" style="margin-right:4px;" aria-hidden="true"></i>
            Undo
        </button>
        <div class="toast-progress"></div>
    `;

    container.appendChild(toast);
    activeToasts[id] = { element: toast, onUndo };
}

function undoRemove(id) {
    const entry = activeToasts[id];
    if (entry && entry.onUndo) entry.onUndo();
}

function removeToast(id) {
    const entry = activeToasts[id];
    if (!entry) return;
    const toast = entry.element;
    toast.classList.add('removing');
    setTimeout(() => { toast.remove(); delete activeToasts[id]; }, 300);
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}
</script>

</body>
</html>