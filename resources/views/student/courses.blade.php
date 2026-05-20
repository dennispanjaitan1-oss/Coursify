<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>My Courses</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 500;
    color: var(--text-soft);
    margin-bottom: 18px;
}

.page-badge-dot {
    width: 6px;
    height: 6px;
    background: var(--teal);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.3); }
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
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
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
    color: var(--purple);
}

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

/* ═══ FILTER TABS + SEARCH (MINIMALIST & SOFT) ═══ */
.courses-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px; /* Tambah sedikit ruang agar tidak sesak */
    gap: 20px;
    flex-wrap: wrap;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06); /* Garis pembatas di bawah seluruh toolbar */
}

.filter-tabs {
    display: flex;
    gap: 32px; /* Jarak antar teks yang lebih lega agar terasa mewah */
    background: transparent;
    padding: 0;
}

.filter-tab {
    position: relative;
    padding: 12px 0; /* Memberi ruang klik yang nyaman */
    color: var(--text-soft);
    font-size: 14px;
    font-weight: 500;
    background: none !important;
    border: none;
    cursor: pointer;
    transition: color 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.filter-tab:hover {
    color: var(--purple);
}

/* Indikator Garis Bawah untuk Tab Aktif */
.filter-tab.active {
    color: var(--purple-dark);
    font-weight: 600; /* Sedikit tebal agar menonjol */
}

.filter-tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px; /* Tepat di atas border toolbar */
    left: 0;
    right: 0;
    height: 2px;
    background: var(--purple);
    border-radius: 2px;
    animation: slideIn 0.3s ease; /* Animasi masuk yang halus */
}

@keyframes slideIn {
    from { transform: scaleX(0); }
    to { transform: scaleX(1); }
}

/* Badge Count yang Lebih Halus */
.filter-tab-count {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    background: transparent; /* Hilangkan background bulat agar tidak ramai */
    padding: 0;
    min-width: auto;
}

.filter-tab.active .filter-tab-count {
    color: var(--purple); /* Warna count mengikuti tema aktif */
}

/* Search */
.search-mycourses {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 100%;
    padding: 10px 16px 10px 42px;
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
    border-color: var(--purple);
    box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 14px;
    pointer-events: none;
    z-index: 2;
    display: flex;
    align-items: center;
}

/* Penyesuaian Responsif */
@media (max-width: 768px) {
    .courses-toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    .toolbar-search {
        max-width: 100%;
    }
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
    text-decoration: none;
    color: var(--text);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 16px rgba(30,58,95,0.04);
    min-width: 0;
}

.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(30,58,95,0.12);
    border-color: var(--purple);
}

.course-thumb {
    aspect-ratio: 16/10;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 54px;
    overflow: hidden;
}

.course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
.course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
.course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }
.course-thumb-4 { background: linear-gradient(135deg, #FA709A, #FEE140); }
.course-thumb-5 { background: linear-gradient(135deg, #30CFD0, #330867); }
.course-thumb-6 { background: linear-gradient(135deg, #A8EDEA, #FED6E3); }

.course-status {
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
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.status-in-progress {
    background: rgba(255,196,82,0.95);
    color: #5A3A00;
}

.status-completed {
    background: rgba(0,200,150,0.95);
    color: white;
}

.status-not-started {
    background: rgba(139,135,168,0.95);
    color: white;
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

/* Progress section */
.course-progress-section {
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border);
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
    margin-bottom: 6px;
}

.progress-label {
    color: var(--text-soft);
    font-weight: 600;
}

.progress-percent {
    font-family: var(--font-serif);
    font-size: 14px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
}

.progress-bar {
    height: 6px;
    background: var(--lav-2);
    border-radius: 100px;
    overflow: hidden;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #9F94F2, #7B6FE8);
    border-radius: 100px;
    transition: width 0.6s ease;
}

.progress-fill.completed {
    background: linear-gradient(90deg, #00C896, #00A075);
}

.progress-fill.not-started {
    background: var(--lav-3);
}

.course-lesson-info {
    font-size: 11px;
    color: var(--muted);
    margin-top: 6px;
}

/* Course footer */
.course-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    gap: 10px;
}

.btn-continue {
    flex: 1;
    padding: 10px;
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
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.btn-continue:hover {
    background: #2A2840;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(26,24,37,0.3);
}

.btn-continue.completed {
    background: var(--teal);
}

.btn-continue.completed:hover {
    background: #00A075;
    box-shadow: 0 8px 20px rgba(0,200,150,0.3);
}

.course-menu {
    position: absolute; /* Ubah dari inline-flex ke absolute */
    top: 12px;
    right: 12px;
    width: 32px; /* Sedikit lebih kecil agar proporsional */
    height: 32px;
    border-radius: 50%;
    border: 1px solid rgba(255, 255, 255, 0.5);
    background: rgba(255, 255, 255, 0.2); /* Semi transparan */
    backdrop-filter: blur(10px);
    color: white; /* Warna putih agar kontras dengan background gradient */
    cursor: pointer;
    font-size: 16px;
    transition: all 0.2s;
    z-index: 10; /* Pastikan di atas thumbnail */
    display: flex;
    align-items: center;
    justify-content: center;
}

.course-menu:hover {
    background: white;
    color: var(--purple);
    border-color: white;
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
    color: var(--purple);
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
    .search-mycourses { min-width: auto; }
}

@media (max-width: 640px) {
    .nav-links { display: none; }
    .filter-tabs {
        overflow-x: auto;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
    }
    .filter-tabs::-webkit-scrollbar { display: none; }
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

/* ═══ COURSE DROPDOWN MENU ═══ */
.course-dropdown-menu {
    position: fixed;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    padding: 6px;
    min-width: 220px;
    box-shadow: 0 16px 48px rgba(30,58,95,0.14), 0 2px 8px rgba(30,58,95,0.06);
    z-index: 9999;
    animation: dropIn 0.18s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-origin: top right;
}

@keyframes dropIn {
    from { opacity: 0; transform: scale(0.88) translateY(-6px); }
    to   { opacity: 1; transform: scale(1)   translateY(0); }
}

.cdm-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.15s;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    font-family: var(--font-sans);
    text-decoration: none;
}

.cdm-item:hover { background: rgba(123,111,232,0.07); color: var(--text); }
.cdm-item:hover .cdm-icon { transform: scale(1.12); }
.cdm-item.danger { color: #E55A3A; }
.cdm-item.danger:hover { background: rgba(255,138,91,0.09); color: #C0411F; }

.cdm-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
    transition: transform 0.15s;
}

.cdm-icon.purple { background: rgba(0,0,0,0.12); color: black;} 
.cdm-icon.teal   { background: rgba(0,0,0,0.12);   color: black;}
/* Tambahkan !important untuk memaksa warna hitam muncul */
.cdm-icon.gold { 
    background: rgba(0, 0, 0, 0.12) !important; 
    color: #000000 !important; 
}
.cdm-icon.red    { background: rgba(255,138,91,0.12);  color: #E55A3A;       }

.cdm-text { display: flex; flex-direction: column; gap: 1px; line-height: 1.2; }
.cdm-sub  { font-size: 11px; font-weight: 400; color: var(--muted); }
.cdm-divider { height: 1px; background: rgba(30,58,95,0.06); margin: 4px 0; }

/* Toast notification */
.cdm-toast {
    position: fixed;
    bottom: 28px;
    left: 50%;
    transform: translateX(-50%) translateY(80px);
    background: #1A1825;
    color: white;
    padding: 10px 20px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), opacity 0.3s;
    opacity: 0;
    pointer-events: none;
    z-index: 99999;
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
}
.cdm-toast.show {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}
</style>
</head>
<body>

@include('partials.navbar')


{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="container">
        </div>

        <h1 class="page-title">
            My <em>Courses</em>
        </h1>

        <p class="page-subtitle" style="max-width: 600px; margin: 0 auto;">
    Lanjutkan perjalanan belajarmu dengan mudah! Di halaman ini, kamu bisa melihat semua kursus yang sedang kamu ikuti agar progres belajarmu tetap terpantau.
</p>

        {{-- Stats Bar --}}
        <div class="stats-bar">
            <div class="stat-cell">
                <div class="stat-value"><em>{{ $stats['total'] }}</em></div>
                <div class="stat-label">Total Courses</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value"><em>{{ $stats['in_progress'] }}</em></div>
                <div class="stat-label">In Progress</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value"><em>{{ $stats['completed'] }}</em></div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value"><em>{{ $stats['not_started'] }}</em></div>
                <div class="stat-label">Not Started</div>
            </div>
        </div>
    </div>
</section>

{{-- MAIN CONTENT --}}
<section class="main-section">
    <div class="container">

        {{-- Toolbar: Filter Tabs + Search --}}
        <div class="courses-toolbar">
            @php
                $currentFilter = request('filter', 'all');
            @endphp

            <div class="filter-tabs">
    {{-- Filter All --}}
    <a href="{{ route('student.courses') }}"
       class="filter-tab {{ $currentFilter === 'all' ? 'active' : '' }}">
        <i class="fa-solid fa-layer-group"></i> All
        <span class="filter-tab-count">{{ $stats['total'] }}</span>
    </a>

    {{-- Filter In Progress --}}
    <a href="{{ route('student.courses', ['filter' => 'in_progress']) }}"
       class="filter-tab {{ $currentFilter === 'in_progress' ? 'active' : '' }}">
        <i class="fa-solid fa-spinner fa-spin-pulse" style="--fa-animation-duration: 2s;"></i> In Progress
        <span class="filter-tab-count">{{ $stats['in_progress'] }}</span>
    </a>

    {{-- Filter Completed --}}
    <a href="{{ route('student.courses', ['filter' => 'completed']) }}"
       class="filter-tab {{ $currentFilter === 'completed' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-check"></i> Completed
        <span class="filter-tab-count">{{ $stats['completed'] }}</span>
    </a>

    {{-- Filter Not Started --}}
    <a href="{{ route('student.courses', ['filter' => 'not_started']) }}"
       class="filter-tab {{ $currentFilter === 'not_started' ? 'active' : '' }}">
        <i class="fa-solid fa-book-bookmark"></i> Not Started
        <span class="filter-tab-count">{{ $stats['not_started'] }}</span>
    </a>
</div>

           <form action="{{ route('student.courses') }}" method="GET" class="search-mycourses">
    <span class="search-icon">
        <i class="fa-solid fa-magnifying-glass"></i>
    </span>
    
    <input
        type="text"
        name="search"
        class="search-input"
        placeholder="Search your courses..."
        value="{{ request('search') }}"
        autocomplete="off"
    >
    {{-- Hidden filter input jika ada --}}
    @if($currentFilter !== 'all')
        <input type="hidden" name="filter" value="{{ $currentFilter }}">
    @endif
</form>
        </div>

        {{-- Courses Grid --}}
        <div class="courses-grid">
            @forelse($enrollments as $enrollment)
                @php
                    // Handle both Eloquent & dummy data
                    $course = $enrollment->course ?? null;
                    if (!$course) {
                        continue;
                    }

                    $progress = $enrollment->progress_percent ?? 0;
                    $status = $enrollment->status ?? 'active';

                    // Determine status display dengan Font Awesome 6
if ($progress >= 100 || $status === 'completed') {
    $statusClass = 'status-completed';
    $statusLabel = '<i class="fa-solid fa-circle-check"></i> Completed';
    $progressClass = 'completed';
    $btnLabel = '<i class="fa-solid fa-award"></i> View Certificate';
    $btnClass = 'completed';
} elseif ($progress == 0) {
    $statusClass = 'status-not-started';
    $statusLabel = '<i class="fa-solid fa-book-bookmark"></i> Not Started';
    $progressClass = 'not-started';
    $btnLabel = '<i class="fa-solid fa-play"></i> Start Learning';
    $btnClass = '';
} else {
    $statusClass = 'status-in-progress';
    $statusLabel = '<i class="fa-solid fa-bolt-lightning"></i> In Progress';
    $progressClass = '';
    $btnLabel = '<i class="fa-solid fa-circle-play"></i> Resume';
    $btnClass = '';
}

                    // Course data
                    $courseTitle = is_object($course) ? ($course->title ?? 'Untitled') : 'Untitled';
                    $courseSlug = is_object($course) ? ($course->slug ?? 'course') : 'course';
                    $categoryName = is_object($course) && isset($course->category) ? ($course->category->name ?? 'General') : 'General';
                    $thumb = $course->thumb ?? (($loop->index % 6) + 1);
                    $icon = $course->icon ?? '📚';
                    $instructorName = $course->instructor_name ?? (isset($course->instructors) && $course->instructors->count() > 0 ? $course->instructors->first()->name : 'Coursify Team');
                    $initial = $course->initial ?? strtoupper(substr($instructorName, 0, 1));
                    $lessonsTotal = $course->lessons()->count();
                    $hasLessons = $lessonsTotal > 0;
                    $lessonsDone = $course->lessons_done ?? 0;
                @endphp

                <div class="course-card">
                    <div class="course-thumb course-thumb-{{ $thumb }}">
                        {{ $icon }}
                    </div>

                    <div class="course-body">
                        <div class="course-category">{{ $categoryName }}</div>
                        <div class="course-title">{{ $courseTitle }}</div>
                        <div class="course-instructor">
                            <div class="course-instructor-avatar">{{ $initial }}</div>
                            <span>{{ $instructorName }}</span>
                        </div>

                        {{-- Progress Section --}}
                        <div class="course-progress-section">
                            <div class="progress-header">
                                <span class="progress-label">Your progress</span>
                                <span class="progress-percent">{{ number_format($progress, 0) }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill {{ $progressClass }}" style="width: {{ $progress }}%;"></div>
                            </div>
                            <div class="course-lesson-info">
                                {{ $lessonsDone }} of {{ $lessonsTotal }} lessons completed
                            </div>
                        </div>

                        {{-- Footer: Continue Button + Menu --}}
<div class="course-footer">

@if($hasLessons)

<a href="{{ $progress >= 100 || $status === 'completed' 
    ? route('student.certificates') 
    : route('student.learn', ['slug' => $courseSlug]) }}"
   class="btn-continue {{ $btnClass }}">
    {!! $btnLabel !!}
</a>

@else

<button class="btn-continue"
        style="background:#B0AEC2; cursor:not-allowed;"
        disabled>
    <i class="fa-solid fa-clock"></i>
    Course Not Ready
</button>

@endif

<button class="course-menu" title="More options"
    onclick="toggleMenu(this, event)"
    data-enrollment-id="{{ $enrollment->id }}"
    data-course-title="{{ $courseTitle }}"
    data-course-slug="{{ $courseSlug }}"
    data-course-url="{{ url('courses/' . $courseSlug) }}">
    ⋯
</button>

</div>

                        {{-- Review Form — hanya tampil kalau sudah selesai --}}
                        @if($progress >= 100 || $status === 'completed')
                            @php
                                $existingReview = auth()->user()->reviews()
                                    ->where('course_id', $course->id)
                                    ->first();
                            @endphp

                            @if($existingReview)
                                <div x-data="{ show: true }" x-show="show" style="margin-top:12px; padding:10px 14px; background:var(--teal-light); border-radius:10px; font-size:12px; color:var(--teal); display:flex; justify-content:space-between; align-items:center;">
    <span>
        <i class="fa-solid fa-circle-check"></i>
        Kamu sudah memberikan review untuk kursus ini.
    </span>
    <button @click="show = false" style="background:none; border:none; cursor:pointer; color:var(--teal); font-size:14px; padding:0 0 0 8px;">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
                            @else
                                <div style="margin-top:12px;" x-data="{ open: false }">
                                    <button @click="open = !open"
                                            style="width:100%; padding:10px; background:var(--lav-2); border:none; border-radius:100px; font-size:12px; font-weight:600; color:var(--purple-dark); cursor:pointer;">
                                        <i class="fa-solid fa-star"></i>
                                        Berikan Review
                                    </button>

                                    <div x-show="open" x-transition style="margin-top:10px; padding:14px; background:var(--lav-1); border-radius:12px;">
                                        <form action="{{ route('student.course.review.submit', $course) }}" method="POST">
                                            @csrf
                                            <div style="margin-bottom:10px;">
                                                <label style="font-size:12px; font-weight:600; display:block; margin-bottom:4px;">Rating</label>
                                                <select name="rating" required style="width:100%; padding:8px; border-radius:8px; border:1px solid var(--lav-3); font-size:13px;">
                                                    <option value="">Pilih rating...</option>
                                                    <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                                    <option value="4">⭐⭐⭐⭐ Good</option>
                                                    <option value="3">⭐⭐⭐ Average</option>
                                                    <option value="2">⭐⭐ Poor</option>
                                                    <option value="1">⭐ Very Poor</option>
                                                </select>
                                            </div>
                                            <div style="margin-bottom:10px;">
                                                <label style="font-size:12px; font-weight:600; display:block; margin-bottom:4px;">Komentar (opsional)</label>
                                                <textarea name="comment" rows="3" placeholder="Tulis pendapatmu..." style="width:100%; padding:8px; border-radius:8px; border:1px solid var(--lav-3); font-size:13px; resize:none;"></textarea>
                                            </div>
                                            <button type="submit" style="width:100%; padding:10px; background:var(--purple); color:white; border:none; border-radius:100px; font-size:12px; font-weight:600; cursor:pointer;">
                                                Kirim Review
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

            @empty
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon">🎓</div>
                    <h3 class="empty-title">No <em>courses</em> yet</h3>
                    <p class="empty-desc">
                        You haven't enrolled in any courses yet. Browse our catalog and start your learning journey today.
                    </p>
                    <a href="{{ route('courses.index') }}" class="btn-browse">
                        🔍 Browse Courses
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</section>


<div style="height: 60px;"></div>

{{-- JAVASCRIPT --}}
<script>
    // ═══ COURSE DROPDOWN MENU ═══
let _activeDropdown = null;

function toggleMenu(btn, event) {
    event.preventDefault();
    event.stopPropagation();

    // Tutup dropdown yang sedang buka
    if (_activeDropdown) {
        _activeDropdown.remove();
        _activeDropdown = null;
        if (_activeDropdown === null && btn.classList.contains('menu-open')) {
            btn.classList.remove('menu-open');
            return;
        }
    }

    const enrollmentId  = btn.dataset.enrollmentId;
    const courseTitle   = btn.dataset.courseTitle;
    const courseSlug    = btn.dataset.courseSlug;   // tambahkan data-course-slug di blade
    const courseUrl     = btn.dataset.courseUrl;    // tambahkan data-course-url di blade

    // Buat dropdown
    const menu = document.createElement('div');
    menu.className = 'course-dropdown-menu';

    menu.innerHTML = `
      <button class="cdm-item" onclick="cdmAction('resume','${courseSlug}',this)">
        <span class="cdm-icon purple"><i class="fa-solid fa-circle-play"></i></span>
        <span class="cdm-text">
          <span>Resume Course</span>
          <span class="cdm-sub">Lanjutkan dari terakhir</span>
        </span>
      </button>

      <button class="cdm-item" onclick="cdmAction('download','${enrollmentId}',this)">
        <span class="cdm-icon teal"><i class="fa-solid fa-download"></i></span>
        <span class="cdm-text">
          <span>Download Materials</span>
          <span class="cdm-sub">Materi & slide tersedia</span>
        </span>
      </button>

      <button class="cdm-item" onclick="cdmAction('favorite','${enrollmentId}',this)">
        <span class="cdm-icon gold"><i class="fa-solid fa-star"></i></span>
        <span class="cdm-text">
          <span>Mark as Favorite</span>
          <span class="cdm-sub">Simpan ke favoritmu</span>
        </span>
      </button>

      <button class="cdm-item" onclick="cdmAction('share','${courseUrl || window.location.origin + '/courses/' + courseSlug}',this)">
        <span class="cdm-icon gold" style="background:rgba(255,196,82,0.15);color:#C88A00;"><i class="fa-solid fa-share-nodes"></i></span>
        <span class="cdm-text">
          <span>Share with Friends</span>
          <span class="cdm-sub">Salin link kursus</span>
        </span>
      </button>

      <div class="cdm-divider"></div>

      <button class="cdm-item danger" onclick="cdmAction('unenroll','${enrollmentId}',this,'${courseTitle.replace(/'/g,"\\'")}')">
        <span class="cdm-icon red"><i class="fa-solid fa-right-from-bracket"></i></span>
        <span class="cdm-text">
          <span>Unenroll</span>
          <span class="cdm-sub">Hapus dari daftar kursus</span>
        </span>
      </button>
    `;

    document.body.appendChild(menu);
    _activeDropdown = menu;

    // Posisi dropdown mengikuti tombol
    const rect = btn.getBoundingClientRect();
    const menuW = 230;
    let left = rect.right - menuW;
    let top  = rect.bottom + 8;
    if (left < 8) left = 8;
    if (top + 280 > window.innerHeight) top = rect.top - 280;

    menu.style.left = left + 'px';
    menu.style.top  = top  + 'px';

    btn.classList.add('menu-open');
}

function cdmAction(type, value, el, title) {
    // Tutup menu
    if (_activeDropdown) { _activeDropdown.remove(); _activeDropdown = null; }

    if (type === 'unenroll') {
        if (!confirm(`Unenroll dari "${title}"?\n\nProgress kamu akan hilang permanen.`)) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/enrollments/${value}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
        return;
    }

    if (type === 'resume') {
    // Gunakan window.location.origin agar URL absolut dan tidak error saat di sub-folder
    window.location.href = window.location.origin + "/dashboard/learn/" + value;
    return;
}

    if (type === 'share') {
        navigator.clipboard.writeText(value).then(() => {
            showCdmToast('<i class="fa-solid fa-check"></i> Link disalin ke clipboard!');
        }).catch(() => {
            showCdmToast('<i class="fa-solid fa-link"></i> ' + value);
        });
        return;
    }

    if (type === 'download') {
        showCdmToast('<i class="fa-solid fa-clock"></i> Fitur download segera hadir!');
        return;
    }

    if (type === 'favorite') {
        showCdmToast('<i class="fa-solid fa-star"></i> Fitur favorit segera hadir!');
        return;
    }
}

function showCdmToast(msg) {
    let t = document.getElementById('cdmToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'cdmToast';
        t.className = 'cdm-toast';
        document.body.appendChild(t);
    }
    t.innerHTML = msg;
    t.classList.add('show');
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.classList.remove('show'), 2600);
}

// Tutup dropdown klik di luar
document.addEventListener('click', function(e) {
    if (_activeDropdown && !e.target.closest('.course-dropdown-menu') && !e.target.closest('.course-menu')) {
        _activeDropdown.remove();
        _activeDropdown = null;
    }
});
</script>

</body>
</html>