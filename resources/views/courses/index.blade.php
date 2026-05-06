<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Browse Courses — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

.container { max-width: 1280px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 1; }

/* ═══ NAVBAR ═══ */
.navbar-wrap {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 100;
    padding: 20px 20px 0;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
}

.navbar-wrap.navbar-hidden { transform: translateY(-120%); }

.navbar-wrap.navbar-scrolled .navbar {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(40px) saturate(180%);
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
    box-shadow: 0 4px 14px rgba(26,24,37,0.25);
}
.btn-nav:hover { background: #2A2840; transform: translateY(-1px); }

body { padding-top: 90px; }

/* ═══ PAGE HERO ═══ */
.page-hero {
    text-align: center;
    padding: 48px 20px 40px;
    position: relative;
    z-index: 1;
}

.page-hero-badge {
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
    margin-bottom: 20px;
}

.page-hero-badge-dot {
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

.page-hero-title {
    font-family: var(--font-serif);
    font-size: clamp(38px, 6vw, 68px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-bottom: 14px;
    padding-bottom: 0.1em;
    overflow: visible;
    padding-right: 0.1em;
}

.page-hero-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
    padding-bottom: 0.25em;
    line-height: 1.3;
    margin-top: 0.05em;
    padding-right: 0.15em;
}

.page-hero-subtitle {
    font-size: 15px;
    line-height: 1.6;
    color: var(--text-soft);
    max-width: 560px;
    margin: 0 auto 32px;
}

/* ═══ SEARCH BAR ═══ */
.search-wrap {
    max-width: 640px;
    margin: 0 auto;
    position: relative;
}

.search-input {
    width: 100%;
    padding: 16px 60px 16px 52px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(20px);
    border: 1.5px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 15px;
    color: var(--text);
    outline: none;
    transition: all 0.2s;
    box-shadow: 0 10px 40px rgba(30,58,95,0.08);
}

.search-input::placeholder { color: var(--muted); }

.search-input:focus {
    background: white;
    border-color: var(--purple);
    box-shadow: 0 0 0 6px rgba(123,111,232,0.12), 0 10px 40px rgba(30,58,95,0.08);
}

.search-icon-left {
    position: absolute;
    left: 22px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    color: var(--muted);
    pointer-events: none;
}

.search-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    padding: 9px 20px;
    background: #1A1825;
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.search-btn:hover { background: #2A2840; }

/* ═══ POPULAR SEARCHES ═══ */
.popular-searches {
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 20px;
    max-width: 640px;
    margin-left: auto;
    margin-right: auto;
}

.popular-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
    letter-spacing: 0.02em;
    padding-top: 5px;
}

.popular-tag {
    padding: 6px 14px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    font-size: 12px;
    color: var(--text-soft);
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
}

.popular-tag:hover {
    background: white;
    color: var(--purple);
    transform: translateY(-1px);
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
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.stat-item {
    text-align: center;
    border-right: 1px solid rgba(30,58,95,0.08);
}

.stat-item:last-child { border-right: none; }

.stat-value {
    font-family: var(--font-serif);
    font-size: 26px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 4px;
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

/* ═══ MAIN LAYOUT ═══ */
.main-section { padding: 40px 20px 60px; }

.layout-grid {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 24px;
    align-items: start;
}

/* ═══ FILTER SIDEBAR ═══ */
.filter-sidebar {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    padding: 24px;
    position: sticky;
    top: 110px;
    max-height: calc(100vh - 140px);
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(30,58,95,0.05);
}

.filter-sidebar::-webkit-scrollbar { width: 4px; }
.filter-sidebar::-webkit-scrollbar-thumb { background: var(--lav-3); border-radius: 4px; }

.filter-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}

.filter-title {
    font-family: var(--font-serif);
    font-size: 20px;
    font-weight: 400;
    letter-spacing: -0.01em;
}

.filter-clear {
    font-size: 11px;
    color: var(--purple);
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 100px;
    transition: all 0.2s;
}

.filter-clear:hover {
    background: rgba(123,111,232,0.1);
}

.filter-group {
    margin-bottom: 22px;
    padding-bottom: 22px;
    border-bottom: 1px solid var(--border);
}

.filter-group:last-child {
    border-bottom: none;
    padding-bottom: 0;
    margin-bottom: 0;
}

.filter-group-title {
    font-size: 11px;
    font-weight: 700;
    color: var(--text-soft);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.filter-group-count {
    background: var(--lav-1);
    color: var(--purple);
    padding: 2px 7px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0;
}

.filter-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s;
    margin-bottom: 2px;
}

.filter-option:hover {
    background: var(--lav-1);
}

.filter-option-left {
    display: flex;
    align-items: center;
    gap: 9px;
    flex: 1;
    min-width: 0;
}

.filter-checkbox {
    appearance: none;
    width: 16px;
    height: 16px;
    border: 1.5px solid var(--border);
    border-radius: 4px;
    background: white;
    cursor: pointer;
    position: relative;
    flex-shrink: 0;
    transition: all 0.2s;
}

.filter-checkbox:checked {
    background: var(--purple);
    border-color: var(--purple);
}

.filter-checkbox:checked::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 10px;
    font-weight: 700;
}

.filter-option-label {
    font-size: 13px;
    color: var(--text-soft);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
}

.filter-option-count {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}

/* Price Range */
.price-range {
    padding: 8px 0;
}

.price-slider {
    -webkit-appearance: none;
    width: 100%;
    height: 4px;
    background: var(--lav-2);
    border-radius: 100px;
    outline: none;
    margin-bottom: 10px;
}

.price-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px;
    height: 16px;
    background: var(--purple);
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(123,111,232,0.4);
}

.price-range-labels {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}

/* Rating Filter */
.rating-option {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 7px 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s;
    margin-bottom: 2px;
}

.rating-option:hover { background: var(--lav-1); }

.rating-stars {
    color: var(--gold);
    font-size: 14px;
    letter-spacing: 1px;
}

.rating-stars-muted { color: var(--lav-3); }

/* ═══ RESULTS AREA ═══ */
.results-area { min-width: 0; }

.results-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
    padding: 14px 20px;
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: 14px;
}

.results-count {
    font-size: 13px;
    color: var(--text-soft);
    font-weight: 500;
}

.results-count strong {
    font-family: var(--font-serif);
    font-size: 20px;
    color: var(--text);
    font-weight: 400;
    margin-right: 4px;
    letter-spacing: -0.01em;
}

.toolbar-right {
    display: flex;
    gap: 10px;
    align-items: center;
}

.view-toggle {
    display: flex;
    background: var(--lav-1);
    border-radius: 10px;
    padding: 3px;
    gap: 2px;
}

.view-btn {
    padding: 6px 10px;
    border: none;
    background: transparent;
    border-radius: 8px;
    cursor: pointer;
    color: var(--muted);
    font-size: 14px;
    transition: all 0.2s;
}

.view-btn.active {
    background: white;
    color: var(--purple);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.sort-select {
    padding: 8px 14px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-family: var(--font-sans);
    font-size: 13px;
    color: var(--text);
    cursor: pointer;
    outline: none;
    transition: all 0.2s;
    font-weight: 500;
}

.sort-select:hover { border-color: var(--purple); }
.sort-select:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(123,111,232,0.1); }

/* ═══ ACTIVE FILTERS ═══ */
.active-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 18px;
    align-items: center;
}

.active-filter-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}

.active-filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    background: rgba(123,111,232,0.1);
    color: var(--purple-dark);
    border: 1px solid rgba(123,111,232,0.2);
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s;
}

.active-filter-tag:hover {
    background: rgba(123,111,232,0.15);
}

.active-filter-remove {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--purple);
    font-size: 13px;
    padding: 0;
    line-height: 1;
    font-weight: 700;
}

/* ═══ COURSE GRID ═══ */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

.course-card {
    background: rgba(255,255,255,0.7);
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

.course-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 4px 10px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    backdrop-filter: blur(10px);
}

.badge-new { background: rgba(255,138,91,0.95); color: white; }
.badge-bestseller { background: rgba(255,200,50,0.95); color: #5A3A00; }
.badge-free { background: rgba(0,200,150,0.95); color: white; }
.badge-premium { background: rgba(123,111,232,0.95); color: white; }

.course-wishlist {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 15px;
    transition: all 0.2s;
}

.course-wishlist:hover {
    background: white;
    transform: scale(1.1);
}

.course-wishlist.active {
    background: #FF6B8A;
    color: white;
}

.course-body {
    padding: 18px;
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
    line-height: 1.25;
    letter-spacing: -0.01em;
    margin-bottom: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 44px;
}

.course-instructor {
    font-size: 12px;
    color: var(--text-soft);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.course-instructor-avatar {
    width: 20px;
    height: 20px;
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
}

.course-price {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.01em;
    line-height: 1;
}

.course-price-old {
    font-size: 12px;
    color: var(--muted);
    text-decoration: line-through;
    margin-left: 6px;
    font-family: var(--font-sans);
}

.course-price-free { color: var(--teal); }

.course-arrow {
    font-size: 18px;
    color: var(--purple);
    transition: transform 0.3s;
}

.course-card:hover .course-arrow {
    transform: translateX(4px);
}

/* ═══ PAGINATION ═══ */
.pagination {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-top: 40px;
    align-items: center;
}

.page-btn {
    min-width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 10px;
}

.page-btn:hover:not(:disabled) {
    background: white;
    border-color: var(--purple);
    color: var(--purple);
}

.page-btn.active {
    background: #1A1825;
    border-color: #1A1825;
    color: white;
}

.page-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.page-dots {
    color: var(--muted);
    padding: 0 4px;
    font-weight: 600;
}

/* ═══ EMPTY STATE ═══ */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: rgba(255,255,255,0.5);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.8);
}

.empty-icon {
    font-size: 56px;
    margin-bottom: 16px;
}

.empty-title {
    font-family: var(--font-serif);
    font-size: 24px;
    font-weight: 400;
    margin-bottom: 8px;
    letter-spacing: -0.01em;
}

.empty-desc {
    font-size: 13px;
    color: var(--muted);
    max-width: 380px;
    margin: 0 auto 20px;
    line-height: 1.6;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 1100px) {
    .layout-grid { grid-template-columns: 240px 1fr; }
    .courses-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    .layout-grid {
        grid-template-columns: 1fr;
    }
    .filter-sidebar {
        position: static;
        max-height: none;
    }
    .stats-bar {
        grid-template-columns: repeat(2, 1fr);
        padding: 16px 20px;
    }
    .stat-item:nth-child(2) { border-right: none; }
    .stat-item {
        padding: 6px 0;
    }
}

@media (max-width: 640px) {
    .courses-grid { grid-template-columns: 1fr; }
    .results-toolbar { flex-direction: column; align-items: flex-start; }
    .nav-links { display: none; }
    .search-input { padding: 14px 50px 14px 46px; font-size: 14px; }
    .search-btn { display: none; }
}
</style>
</head>
<body>

{{-- NAVBAR --}}
{{-- Tambahkan ini di <head> jika belum ada: --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> --}}

<nav class="navbar-wrap" id="mainNavbar" x-data="{ userOpen: false }">
    <div class="navbar">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
            <span class="logo-text">Coursify</span>
        </a>

        {{-- Nav Links --}}
        <div class="nav-links">
            <a href="{{ route('courses.index') }}" class="nav-link active">
                <i class="fa-solid fa-graduation-cap" style="margin-right:5px;"></i>Courses
            </a>
            <a href="{{ route('home') }}#how" class="nav-link">
                <i class="fa-solid fa-circle-info" style="margin-right:5px;"></i>How It Works
            </a>
            <a href="{{ route('home') }}#pricing" class="nav-link">
                <i class="fa-solid fa-tag" style="margin-right:5px;"></i>Pricing
            </a>
        </div>

        {{-- Auth --}}
        @guest
            <a href="{{ route('login') }}" class="btn-nav">
                <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right:6px;"></i>Get Started
            </a>
        @else
            <div style="position:relative;">

                {{-- Avatar Button --}}
                <button
                    @click="userOpen = !userOpen"
                    style="
                        display:flex;align-items:center;gap:8px;
                        background:white;border:none;
                        padding:4px 10px 4px 4px;
                        border-radius:100px;cursor:pointer;
                        box-shadow:0 2px 10px rgba(30,58,95,0.1);
                        transition:all 0.2s;
                    "
                    onmouseover="this.style.boxShadow='0 4px 16px rgba(30,58,95,0.15)'"
                    onmouseout="this.style.boxShadow='0 2px 10px rgba(30,58,95,0.1)'"
                >
                    <div style="
                        width:28px;height:28px;border-radius:50%;
                        background:#153759;color:white;
                        font-size:12px;font-weight:700;
                        display:flex;align-items:center;justify-content:center;
                        flex-shrink:0;
                    ">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#1A1825;">
                        {{ Str::limit(auth()->user()->name, 10) }}
                    </span>
                    <i class="fa-solid fa-chevron-down" style="font-size:10px;color:#8B87A8;margin-left:2px;"></i>
                </button>

                {{-- Dropdown --}}
                <div
                    x-show="userOpen"
                    @click.away="userOpen = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    style="
                        display:none;
                        position:absolute;top:calc(100% + 12px);right:0;
                        background:white;border-radius:20px;
                        box-shadow:0 20px 60px rgba(30,58,95,0.15);
                        padding:16px;min-width:240px;
                        border:1px solid rgba(30,58,95,0.08);
                        z-index:200;
                    "
                    x-cloak
                >
                    {{-- User Info --}}
                    <div style="padding:4px 8px 14px;border-bottom:1px solid rgba(30,58,95,0.08);margin-bottom:8px;">
                        <div style="font-size:15px;font-weight:700;color:#1A1825;margin-bottom:2px;">
                            {{ auth()->user()->name }}
                        </div>
                        <div style="font-size:12px;color:#8B87A8;margin-bottom:10px;">
                            {{ auth()->user()->email }}
                        </div>
                        <span style="
                            display:inline-flex;align-items:center;gap:6px;
                            background:rgba(123,111,232,0.12);color:#5B4FD4;
                            font-size:11px;font-weight:700;letter-spacing:0.08em;
                            text-transform:uppercase;padding:4px 12px;border-radius:100px;
                        ">
                            <i class="fa-solid fa-user-graduate" style="font-size:10px;"></i>
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>

                    {{-- Admin Panel (jika admin) --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;" onmouseover="this.style.background='#F5F1FC'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-screwdriver-wrench" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span>Admin Panel</span>
                        </a>
                    @endif

                    {{-- Instructor Dashboard (jika instructor) --}}
                    @if(auth()->user()->role === 'instructor')
                        <a href="{{ route('instructor.dashboard') }}" style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;" onmouseover="this.style.background='#F5F1FC'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-chalkboard-user" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span>Instructor Dashboard</span>
                        </a>
                    @endif

                    {{-- Menu Items --}}
                    @php
                        $menuItems = [
                            [
                                'icon'  => 'fa-gauge-high',
                                'label' => 'My Dashboard',
                                'route' => 'student.index',
                            ],
                            [
                                'icon'  => 'fa-book-open',
                                'label' => 'My Courses',
                                'route' => 'student.courses',
                            ],
                            [
                                'icon'  => 'fa-heart',
                                'label' => 'Wishlist',
                                'route' => 'student.wishlist',
                            ],
                            [
                                'icon'  => 'fa-trophy',
                                'label' => 'Certificates',
                                'route' => 'student.certificates',
                            ],
                        ];
                    @endphp

                    @foreach($menuItems as $item)
                        <a href="{{ route($item['route']) }}"
                            style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;"
                            onmouseover="this.style.background='#F5F1FC'"
                            onmouseout="this.style.background='transparent'"
                        >
                            <i class="fa-solid {{ $item['icon'] }}" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach

                    {{-- Profile Settings --}}
                    <a href="#"
                        style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;"
                        onmouseover="this.style.background='#F5F1FC'"
                        onmouseout="this.style.background='transparent'"
                    >
                        <i class="fa-solid fa-user-pen" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                        <span>Profile Settings</span>
                    </a>

                    {{-- Sign Out --}}
                    <div style="border-top:1px solid rgba(30,58,95,0.08);margin-top:8px;padding-top:8px;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                style="display:flex;align-items:center;gap:12px;width:100%;padding:10px 8px;border-radius:10px;background:none;border:none;color:#FF6B35;font-size:14px;font-weight:600;cursor:pointer;transition:background 0.2s;"
                                onmouseover="this.style.background='#FFF0E8'"
                                onmouseout="this.style.background='transparent'"
                            >
                                <i class="fa-solid fa-right-from-bracket" style="width:16px;text-align:center;font-size:13px;"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endguest
    </div>
</nav>

{{-- PAGE HERO --}}
<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title">
            Find your perfect <em>course</em>
        </h1>

        <p class="page-hero-subtitle">
            Browse our curated collection of courses from world-class instructors. Filter, compare, and start learning today.
        </p>

        {{-- Search --}}
        <form action="{{ route('courses.index') }}" method="GET" class="search-wrap">
            <span class="search-icon-left">🔍</span>
            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Search for courses, instructors, or topics..."
                value="{{ request('search') }}"
                autocomplete="off"
            >
            <button type="submit" class="search-btn">Search</button>
        </form>

        {{-- Popular Searches --}}
        <div class="popular-searches">
            <span class="popular-label">Popular:</span>
            <a href="?search=laravel" class="popular-tag">Laravel</a>
            <a href="?search=react" class="popular-tag">React.js</a>
            <a href="?search=python" class="popular-tag">Python</a>
            <a href="?search=design" class="popular-tag">UI/UX Design</a>
            <a href="?search=data" class="popular-tag">Data Science</a>
        </div>

        {{-- Stats Bar --}}
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value"><em>500+</em></div>
                <div class="stat-label">Courses</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>120+</em></div>
                <div class="stat-label">Instructors</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>50K+</em></div>
                <div class="stat-label">Students</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>98%</em></div>
                <div class="stat-label">Satisfaction</div>
            </div>
        </div>
    </div>
</section>


{{-- MAIN CONTENT --}}
<section class="main-section">
    <div class="container">
        <div class="layout-grid">

            {{-- ═══════════════════════════════════════════════ --}}
            {{-- FILTER SIDEBAR                                   --}}
            {{-- ═══════════════════════════════════════════════ --}}
            <aside class="filter-sidebar">
                <div class="filter-header">
                    <h3 class="filter-title">Filters</h3>
                    <button class="filter-clear" onclick="clearAllFilters()">Clear all</button>
                </div>

                {{-- Categories --}}
                <div class="filter-group">
                    <div class="filter-group-title">
                        <span>Category</span>
                        <span class="filter-group-count">8</span>
                    </div>
                    @php
                        $filterCategories = [
                            ['icon' => '💻', 'name' => 'Programming', 'count' => 124, 'slug' => 'programming'],
                            ['icon' => '🎨', 'name' => 'Design', 'count' => 87, 'slug' => 'design'],
                            ['icon' => '📊', 'name' => 'Business', 'count' => 96, 'slug' => 'business'],
                            ['icon' => '📈', 'name' => 'Marketing', 'count' => 54, 'slug' => 'marketing'],
                            ['icon' => '🔬', 'name' => 'Data Science', 'count' => 67, 'slug' => 'data-science'],
                            ['icon' => '🎬', 'name' => 'Video', 'count' => 38, 'slug' => 'video'],
                            ['icon' => '🌍', 'name' => 'Languages', 'count' => 42, 'slug' => 'languages'],
                            ['icon' => '🎵', 'name' => 'Music', 'count' => 29, 'slug' => 'music'],
                        ];
                    @endphp

                    @foreach($filterCategories as $cat)
                        <label class="filter-option">
                            <div class="filter-option-left">
                                <input type="checkbox" class="filter-checkbox" value="{{ $cat['slug'] }}">
                                <span class="filter-option-label">
                                    <span>{{ $cat['icon'] }}</span>
                                    <span>{{ $cat['name'] }}</span>
                                </span>
                            </div>
                            <span class="filter-option-count">{{ $cat['count'] }}</span>
                        </label>
                    @endforeach
                </div>

                {{-- Difficulty Level --}}
                <div class="filter-group">
                    <div class="filter-group-title">
                        <span>Level</span>
                    </div>
                    @php
                        $levels = [
                            ['name' => 'Beginner', 'count' => 245, 'slug' => 'beginner'],
                            ['name' => 'Intermediate', 'count' => 180, 'slug' => 'intermediate'],
                            ['name' => 'Advanced', 'count' => 75, 'slug' => 'advanced'],
                        ];
                    @endphp

                    @foreach($levels as $level)
                        <label class="filter-option">
                            <div class="filter-option-left">
                                <input type="checkbox" class="filter-checkbox" value="{{ $level['slug'] }}">
                                <span class="filter-option-label">{{ $level['name'] }}</span>
                            </div>
                            <span class="filter-option-count">{{ $level['count'] }}</span>
                        </label>
                    @endforeach
                </div>

                {{-- Price Filter --}}
                <div class="filter-group">
                    <div class="filter-group-title">
                        <span>Price</span>
                    </div>
                    <label class="filter-option">
                        <div class="filter-option-left">
                            <input type="checkbox" class="filter-checkbox" value="free">
                            <span class="filter-option-label">🆓 Free courses</span>
                        </div>
                        <span class="filter-option-count">124</span>
                    </label>
                    <label class="filter-option">
                        <div class="filter-option-left">
                            <input type="checkbox" class="filter-checkbox" value="paid">
                            <span class="filter-option-label">💎 Premium</span>
                        </div>
                        <span class="filter-option-count">376</span>
                    </label>

                    <div class="price-range" style="margin-top:10px;">
                        <input type="range" min="0" max="500000" value="250000" step="50000" class="price-slider" id="priceSlider" oninput="updatePriceDisplay(this.value)">
                        <div class="price-range-labels">
                            <span>Rp 0</span>
                            <span id="priceDisplay">Rp 250.000</span>
                            <span>Rp 500K+</span>
                        </div>
                    </div>
                </div>

                {{-- Rating Filter --}}
                <div class="filter-group">
                    <div class="filter-group-title">
                        <span>Rating</span>
                    </div>
                    @foreach([['stars' => 5, 'count' => 89], ['stars' => 4, 'count' => 214], ['stars' => 3, 'count' => 58]] as $r)
                        <label class="rating-option">
                            <input type="checkbox" class="filter-checkbox">
                            <span class="rating-stars">
                                {{ str_repeat('★', $r['stars']) }}<span class="rating-stars-muted">{{ str_repeat('★', 5 - $r['stars']) }}</span>
                            </span>
                            <span class="filter-option-label" style="font-size:12px;">& up</span>
                            <span class="filter-option-count" style="margin-left:auto;">{{ $r['count'] }}</span>
                        </label>
                    @endforeach
                </div>

                {{-- Duration --}}
                <div class="filter-group">
                    <div class="filter-group-title">
                        <span>Duration</span>
                    </div>
                    @foreach([['name' => '0-3 hours', 'count' => 45], ['name' => '3-10 hours', 'count' => 128], ['name' => '10-20 hours', 'count' => 187], ['name' => '20+ hours', 'count' => 140]] as $dur)
                        <label class="filter-option">
                            <div class="filter-option-left">
                                <input type="checkbox" class="filter-checkbox">
                                <span class="filter-option-label">{{ $dur['name'] }}</span>
                            </div>
                            <span class="filter-option-count">{{ $dur['count'] }}</span>
                        </label>
                    @endforeach
                </div>

                {{-- Language --}}
                <div class="filter-group">
                    <div class="filter-group-title">
                        <span>Language</span>
                    </div>
                    <label class="filter-option">
                        <div class="filter-option-left">
                            <input type="checkbox" class="filter-checkbox" checked>
                            <span class="filter-option-label">🇮🇩 Indonesia</span>
                        </div>
                        <span class="filter-option-count">420</span>
                    </label>
                    <label class="filter-option">
                        <div class="filter-option-left">
                            <input type="checkbox" class="filter-checkbox">
                            <span class="filter-option-label">🇬🇧 English</span>
                        </div>
                        <span class="filter-option-count">80</span>
                    </label>
                </div>
            </aside>

            {{-- ═══════════════════════════════════════════════ --}}
            {{-- RESULTS AREA                                     --}}
            {{-- ═══════════════════════════════════════════════ --}}
            <div class="results-area">

                {{-- Toolbar --}}
                <div class="results-toolbar">
                    <div class="results-count">
                        <strong>500</strong>
                        courses found
                        @if(request('search'))
                            for "<span style="color:var(--purple);font-weight:600;">{{ request('search') }}</span>"
                        @endif
                    </div>

                    <div class="toolbar-right">
                        <div class="view-toggle">
                            <button class="view-btn active" title="Grid view" onclick="switchView('grid')">▦</button>
                            <button class="view-btn" title="List view" onclick="switchView('list')">☰</button>
                        </div>

                        <select class="sort-select" name="sort">
                            <option>Most Popular</option>
                            <option>Newest First</option>
                            <option>Highest Rated</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                {{-- Active Filters --}}
                <div class="active-filters">
                    <span class="active-filter-label">Active:</span>
                    <span class="active-filter-tag">
                        Programming
                        <button class="active-filter-remove">✕</button>
                    </span>
                    <span class="active-filter-tag">
                        Beginner
                        <button class="active-filter-remove">✕</button>
                    </span>
                    <span class="active-filter-tag">
                        🇮🇩 Indonesia
                        <button class="active-filter-remove">✕</button>
                    </span>
                </div>

                {{-- Course Grid --}}
                <div class="courses-grid" id="coursesGrid">
                    @php
                        $defaultCourses = [
    [
        'slug' => 'fullstack-web-development-with-laravel-12',
        'thumb' => 1, 'icon' => '💻',
        'category' => 'Programming',
        'title' => 'Fullstack Web Development with Laravel 12',
        'instructor' => 'Budi Santoso', 'initial' => 'B',
        'rating' => '4.9', 'students' => '12.3k', 'duration' => '40h',
        'price' => 'Rp 299k', 'oldPrice' => null,
        'badge' => 'bestseller', 'isFree' => false,
    ],
    [
        'slug' => 'ui-ux-design-fundamentals-for-beginners',
        'thumb' => 2, 'icon' => '🎨',
        'category' => 'Design',
        'title' => 'UI/UX Design Fundamentals for Beginners',
        'instructor' => 'Sari Dewi', 'initial' => 'S',
        'rating' => '4.8', 'students' => '8.1k', 'duration' => '25h',
        'price' => 'Rp 199k', 'oldPrice' => 'Rp 299k',
        'badge' => 'new', 'isFree' => false,
    ],
    [
        'slug' => 'python-for-data-analysis-visualization',
        'thumb' => 3, 'icon' => '📊',
        'category' => 'Data Science',
        'title' => 'Python for Data Analysis & Visualization',
        'instructor' => 'Rio Ahmad', 'initial' => 'R',
        'rating' => '4.9', 'students' => '15.7k', 'duration' => '20h',
        'price' => 'Free', 'oldPrice' => null,
        'badge' => 'free', 'isFree' => true,
    ],
    [
        'slug' => 'reactjs-from-zero-to-hero',
        'thumb' => 4, 'icon' => '⚛️',
        'category' => 'Programming',
        'title' => 'React.js from Zero to Hero',
        'instructor' => 'Budi Santoso', 'initial' => 'B',
        'rating' => '4.8', 'students' => '9.2k', 'duration' => '30h',
        'price' => 'Rp 249k', 'oldPrice' => null,
        'badge' => 'bestseller', 'isFree' => false,
    ],
    [
        'slug' => 'startup-fundamentals-idea-to-launch',
        'thumb' => 5, 'icon' => '🚀',
        'category' => 'Business',
        'title' => 'Startup Fundamentals: Idea to Launch',
        'instructor' => 'Maya Putri', 'initial' => 'M',
        'rating' => '4.7', 'students' => '5.2k', 'duration' => '18h',
        'price' => 'Rp 349k', 'oldPrice' => null,
        'badge' => 'new', 'isFree' => false,
    ],
    [
        'slug' => 'digital-marketing-mastery-2025',
        'thumb' => 6, 'icon' => '📈',
        'category' => 'Marketing',
        'title' => 'Digital Marketing Mastery 2025',
        'instructor' => 'Maya Putri', 'initial' => 'M',
        'rating' => '4.7', 'students' => '9.8k', 'duration' => '30h',
        'price' => 'Rp 249k', 'oldPrice' => 'Rp 349k',
        'badge' => 'premium', 'isFree' => false,
    ],
    [
        'slug' => 'master-your-time-productivity',
        'thumb' => 2, 'icon' => '✏️',
        'category' => 'Productivity',
        'title' => 'Master Your Time: Productivity for Beginners',
        'instructor' => 'Dimas Wijaya', 'initial' => 'D',
        'rating' => '4.9', 'students' => '22k', 'duration' => '8h',
        'price' => 'Free', 'oldPrice' => null,
        'badge' => 'free', 'isFree' => true,
    ],
    [
        'slug' => 'docker-kubernetes-fundamentals',
        'thumb' => 5, 'icon' => '🐳',
        'category' => 'DevOps',
        'title' => 'Docker & Kubernetes Fundamentals',
        'instructor' => 'Budi Santoso', 'initial' => 'B',
        'rating' => '4.8', 'students' => '6.3k', 'duration' => '22h',
        'price' => 'Rp 399k', 'oldPrice' => null,
        'badge' => null, 'isFree' => false,
    ],
    [
        'slug' => 'music-production-fl-studio-21',
        'thumb' => 6, 'icon' => '🎵',
        'category' => 'Music',
        'title' => 'Music Production with FL Studio 21',
        'instructor' => 'Dimas Wijaya', 'initial' => 'D',
        'rating' => '4.6', 'students' => '3.1k', 'duration' => '15h',
        'price' => 'Rp 179k', 'oldPrice' => null,
        'badge' => null, 'isFree' => false,
    ],
];
                        $coursesData = $courses ?? $defaultCourses;
                    @endphp

                   @forelse($coursesData as $course)
    @php
        // Handle baik array maupun Eloquent object
        if (is_array($course)) {
            $courseSlug = $course['slug'] ?? Str::slug($course['title'] ?? 'course-' . $loop->index);
            $c = $course;
        } else {
            $courseSlug = $course->slug ?? 'course-' . $loop->index;
            $c = [
                'thumb'      => ($loop->index % 6) + 1,
                'icon'       => '📚',
                'category'   => optional($course->category)->name ?? 'General',
                'title'      => $course->title ?? 'Untitled Course',
                'instructor' => optional($course->instructors->first())->name ?? 'Coursify Team',
                'initial'    => strtoupper(substr(optional($course->instructors->first())->name ?? 'C', 0, 1)),
                'rating'     => number_format($course->average_rating ?? 4.8, 1),
                'students'   => number_format($course->enrollments_count ?? 0),
                'duration'   => ($course->duration_weeks ?? 4) . 'w',
                'price'      => $course->price == 0 ? 'Free' : 'Rp ' . number_format($course->price, 0, ',', '.'),
                'oldPrice'   => null,
                'badge'      => $course->price == 0 ? 'free' : null,
                'isFree'     => $course->price == 0,
            ];
        }
    @endphp

    {{-- 🔗 LINK KE COURSE DETAIL --}}
    <a href="{{ route('courses.show', $courseSlug) }}" class="course-card">
        <div class="course-thumb course-thumb-{{ $c['thumb'] }}">
            @if(!empty($c['badge']))
                <span class="course-badge badge-{{ $c['badge'] }}">
                    @if($c['badge'] === 'bestseller') ⭐ Bestseller
                    @elseif($c['badge'] === 'new') 🆕 New
                    @elseif($c['badge'] === 'free') Free
                    @elseif($c['badge'] === 'premium') 💎 Premium
                    @endif
                </span>
            @endif

            <button class="course-wishlist" onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist(this);" title="Add to wishlist">
                🤍
            </button>

            {{ $c['icon'] }}
        </div>

        <div class="course-body">
            <div class="course-category">{{ $c['category'] }}</div>
            <div class="course-title">{{ $c['title'] }}</div>
            <div class="course-instructor">
                <div class="course-instructor-avatar">{{ $c['initial'] }}</div>
                <span>{{ $c['instructor'] }}</span>
            </div>
            <div class="course-meta">
                <span>⭐ {{ $c['rating'] }}</span>
                <span>👥 {{ $c['students'] }}</span>
                <span>🕐 {{ $c['duration'] }}</span>
            </div>
            <div class="course-footer">
                <div>
                    <span class="course-price {{ $c['isFree'] ? 'course-price-free' : '' }}">
                        {{ $c['price'] }}
                    </span>
                    @if(!empty($c['oldPrice']))
                        <span class="course-price-old">{{ $c['oldPrice'] }}</span>
                    @endif
                </div>
                <div class="course-arrow">→</div>
            </div>
        </div>
    </a>
@empty
    {{-- Empty State --}}
    <div class="empty-state" style="grid-column: 1 / -1;">
        <div class="empty-icon">🔍</div>
        <div class="empty-title">No courses found</div>
        <p class="empty-desc">Try adjusting your filters or search terms. We have 500+ courses waiting for you!</p>
        <a href="{{ route('courses.index') }}" class="btn-nav" style="display:inline-block;">
            Clear filters & browse all
        </a>
    </div>
@endforelse
                </div>

                {{-- Pagination --}}
                @if(count($coursesData) > 0)
                    <div class="pagination">
                        <button class="page-btn" disabled title="Previous">
                             Prev
                        </button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <span class="page-dots">...</span>
                        <button class="page-btn">24</button>
                        <button class="page-btn" title="Next">
                            Next 
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Spacer --}}
<div style="height: 60px;"></div>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- JAVASCRIPT                                           --}}
{{-- ═══════════════════════════════════════════════════ --}}
<script>
    // Prevent browser bfcache (back button stale UI)
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

    // Wishlist toggle
    function toggleWishlist(btn) {
        btn.classList.toggle('active');
        if (btn.classList.contains('active')) {
            btn.textContent = '❤️';
        } else {
            btn.textContent = '🤍';
        }
    }

    // Price display update
    function updatePriceDisplay(value) {
        const display = document.getElementById('priceDisplay');
        if (!display) return;
        const num = parseInt(value);
        if (num >= 500000) {
            display.textContent = 'Rp 500K+';
        } else if (num >= 1000) {
            display.textContent = 'Rp ' + (num / 1000).toFixed(0) + 'K';
        } else {
            display.textContent = 'Rp ' + num;
        }
    }

    // View toggle (grid/list)
    function switchView(view) {
        document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
        event.target.classList.add('active');

        const grid = document.getElementById('coursesGrid');
        if (view === 'list') {
            grid.style.gridTemplateColumns = '1fr';
        } else {
            grid.style.gridTemplateColumns = '';
        }
    }

    // Clear all filters
    function clearAllFilters() {
        document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.active-filter-tag').forEach(tag => tag.remove());
    }

    // Active filter removal
    document.querySelectorAll('.active-filter-remove').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.closest('.active-filter-tag').remove();
        });
    });
</script>

</body>
</html>