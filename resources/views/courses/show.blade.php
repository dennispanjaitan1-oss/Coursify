<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $course->title ?? 'Course' }} — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&family=Noto+Sans:wght@400;700&family=Noto+Sans+Arabic:wght@400;700&family=Noto+Sans+Devanagari:wght@400;700&family=Noto+Sans+Telugu:wght@400;700&family=Noto+Sans+SC:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
    --font-sans: 'Inter', 'Noto Sans', 'Noto Sans Arabic', 'Noto Sans Devanagari', 'Noto Sans Telugu', 'Noto Sans SC', sans-serif;
}

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
    line-height: 1.5;
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
section { position: relative; z-index: 1; }

/* ══════════════════════════════════════════════
   NAVBAR — show.blade
   Hierarki: [Logo + Jelajahi] | [Search Dominan] | [Links + Auth]
   Referensi: Coursera, Udemy, Nielsen Norman Group
══════════════════════════════════════════════ */

/* ── Wrap: full-width sticky, bukan floating pill ── */
.navbar-wrap {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 500;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(60px) saturate(200%);
    -webkit-backdrop-filter: blur(60px) saturate(200%);
    border-bottom: 1px solid rgba(30,58,95,0.08);
    box-shadow: 0 1px 0 rgba(30,58,95,0.06);
    transition: box-shadow 0.3s ease, background 0.3s ease, transform 0.35s cubic-bezier(0.4,0,0.2,1);
    will-change: transform;
    animation: slideDown 0.5s ease-out;
}
.navbar-wrap.navbar-hidden  { transform: translateY(-110%); }
.navbar-wrap.navbar-scrolled {
    background: rgba(255,255,255,0.98);
    box-shadow: 0 2px 20px rgba(30,58,95,0.10);
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Inner: tiga kolom — kiri | tengah (flex-grow) | kanan ── */
.navbar {
    display: flex;
    align-items: center;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    height: 64px;
    gap: 0;
}

/* ── KIRI: logo + Jelajahi ── */
.nav-left {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-shrink: 0;
    margin-right: 20px;
}
.logo {
    display: flex;
    align-items: center;
    gap: 9px;
    text-decoration: none;
    color: var(--text);
    flex-shrink: 0;
    padding: 6px 8px 6px 0;
}
.logo-img {
    width: 32px; height: 32px;
    border-radius: 8px; object-fit: cover;
    box-shadow: 0 2px 8px rgba(30,58,95,0.18);
    transition: transform 0.3s;
}
.logo:hover .logo-img { transform: scale(1.06) rotate(-3deg); }
.logo-text { font-size: 16px; font-weight: 700; letter-spacing: -0.02em; white-space: nowrap; }

/* Jelajahi — slim ghost button di kiri, bukan navy pill */
.mega-trigger {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: transparent;
    color: var(--text-soft);
    border: 1.5px solid rgba(30,58,95,0.12);
    padding: 7px 14px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    font-family: var(--font-sans);
    transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
    white-space: nowrap;
    flex-shrink: 0;
    margin-left: 8px;
}
.mega-trigger:hover {
    background: rgba(30,58,95,0.05);
    border-color: rgba(30,58,95,0.22);
    color: var(--navy);
}
.mega-trigger.active {
    background: var(--navy);
    border-color: var(--navy);
    color: white;
}
.mega-chevron {
    width: 13px; height: 13px;
    transition: transform 0.3s ease;
    flex-shrink: 0;
    opacity: 0.6;
}
.mega-trigger.active .mega-chevron { transform: rotate(180deg); opacity: 1; }
.mega-trigger.active .mega-chevron path { stroke: white; }

/* ── TENGAH: Search — dominant, flex-grow ── */
.nav-search-wrap {
    flex: 1;
    max-width: 580px;   /* lebih lebar dari sebelumnya */
    min-width: 0;
    margin: 0 20px;
    position: relative;
}
.nav-search-form {
    display: flex;
    align-items: center;
    background: rgba(245,241,252,0.7);
    border: 1.5px solid rgba(123,111,232,0.18);
    border-radius: 100px;
    padding: 0 6px 0 16px;
    gap: 8px;
    transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
    height: 42px;
}
.nav-search-form:focus-within {
    border-color: var(--purple);
    background: white;
    box-shadow: 0 0 0 3px rgba(123,111,232,0.10);
}
.nav-search-icon { color: var(--muted); font-size: 13px; flex-shrink: 0; }
.nav-search-input {
    flex: 1;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 14px;
    color: var(--text);
    outline: none;
    min-width: 0;
    padding: 0;
}
.nav-search-input::placeholder { color: var(--muted); }
.nav-search-btn {
    flex-shrink: 0;
    background: var(--navy);
    color: white;
    border: none;
    border-radius: 100px;
    padding: 8px 18px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    white-space: nowrap;
    height: 32px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.nav-search-btn:hover { background: #2D4D7A; }
.nav-search-btn:active { transform: scale(0.97); }

/* ── Autocomplete dropdown ── */
.nav-search-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 0; right: 0;
    background: white;
    border: 1px solid rgba(30,58,95,0.10);
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(30,58,95,0.16), 0 2px 8px rgba(30,58,95,0.06);
    overflow: hidden;
    z-index: 600;
    display: none;
    animation: dropFade 0.16s ease;
}
.nav-search-dropdown.open { display: block; }
@keyframes dropFade {
    from { opacity: 0; transform: translateY(-6px) scale(0.99); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.search-drop-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 16px; text-decoration: none; color: var(--text);
    font-size: 13px; transition: background 0.12s;
    cursor: pointer; border: none; background: none;
    width: 100%; text-align: left; font-family: var(--font-sans);
}
.search-drop-item:hover, .search-drop-item.hovered { background: rgba(123,111,232,0.06); }
.search-drop-item-icon {
    width: 36px; height: 36px; border-radius: 8px;
    background: var(--lav-1);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 14px; color: var(--purple-dark);
}
.search-drop-item-img { width: 36px; height: 36px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
.search-drop-meta { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.search-drop-title { font-weight: 600; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.search-drop-sub { font-size: 11px; color: var(--muted); }
.search-drop-section {
    font-size: 10px; font-weight: 700; letter-spacing: 0.09em;
    text-transform: uppercase; color: var(--muted);
    padding: 12px 16px 4px;
}
.search-drop-footer {
    border-top: 1px solid rgba(30,58,95,0.06);
    padding: 10px 16px;
    font-size: 12.5px; color: var(--purple); font-weight: 600;
    display: flex; align-items: center; gap: 6px;
    transition: background 0.12s; text-decoration: none;
}
.search-drop-footer:hover { background: rgba(123,111,232,0.05); }
.search-drop-empty { padding: 20px 16px; font-size: 13px; color: var(--muted); text-align: center; }

/* ── KANAN: secondary nav + auth ── */
.nav-right {
    display: flex;
    align-items: center;
    gap: 2px;
    flex-shrink: 0;
    margin-left: 20px;
}
.nav-link-sm {
    font-size: 13px; font-weight: 500; color: var(--text-soft);
    padding: 8px 12px; border-radius: 8px;
    transition: all 0.18s; text-decoration: none;
    display: flex; align-items: center; gap: 5px;
    white-space: nowrap;
}
.nav-link-sm:hover { background: rgba(30,58,95,0.05); color: var(--navy); }
.nav-link-sm.active { color: var(--purple-dark); font-weight: 600; }
.nav-divider {
    width: 1px; height: 20px;
    background: rgba(30,58,95,0.1);
    margin: 0 8px;
    flex-shrink: 0;
}

/* CTA: Get Started — lebih menonjol */
.btn-cta-nav {
    background: var(--navy); color: white;
    border-radius: 100px; padding: 9px 20px;
    font-family: var(--font-sans); font-size: 13px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
    white-space: nowrap; flex-shrink: 0;
    display: inline-flex; align-items: center; gap: 6px;
    box-shadow: 0 2px 8px rgba(21,55,89,0.2);
    margin-left: 6px;
}
.btn-cta-nav:hover { background: #2D4D7A; box-shadow: 0 4px 16px rgba(21,55,89,0.3); transform: translateY(-1px); }

/* ── User button & dropdown ── */
.user-btn {
    display: flex; align-items: center; gap: 8px;
    background: transparent;
    border: 1.5px solid rgba(30,58,95,0.12);
    border-radius: 100px; padding: 5px 12px 5px 5px;
    cursor: pointer; font-family: var(--font-sans);
    font-size: 13px; font-weight: 500; color: var(--text);
    transition: all 0.2s; flex-shrink: 0;
    margin-left: 6px;
}
.user-btn:hover { background: rgba(30,58,95,0.04); border-color: rgba(30,58,95,0.22); }
.user-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 11px;
}
.user-dropdown {
    position: absolute; right: 0; top: calc(100% + 10px);
    background: white;
    border: 1px solid rgba(30,58,95,0.10);
    border-radius: 16px; padding: 6px; min-width: 224px;
    box-shadow: 0 8px 40px rgba(30,58,95,0.14), 0 2px 8px rgba(30,58,95,0.06);
    z-index: 600;
}
.dropdown-header { padding: 10px 12px 12px; border-bottom: 1px solid rgba(0,0,0,0.06); margin-bottom: 4px; }
.dropdown-name  { font-size: 13px; font-weight: 600; }
.dropdown-email { font-size: 11px; color: var(--muted); margin-top: 2px; }
.dropdown-item {
    display: flex; align-items: center; gap: 9px;
    padding: 8px 12px; border-radius: 8px;
    color: var(--text-soft); font-size: 13px;
    text-decoration: none; transition: background 0.13s;
    background: transparent; border: none; width: 100%;
    cursor: pointer; text-align: left;
    font-family: var(--font-sans); font-weight: 500;
}
.dropdown-item i { width: 16px; text-align: center; opacity: 0.7; font-size: 12px; }
.dropdown-item:hover { background: rgba(123,111,232,0.07); color: var(--text); }
.dropdown-item-danger { color: #C0392B; }
.dropdown-item-danger:hover { background: rgba(192,57,43,0.07); }

/* ── Mega menu ── */
.mega-menu-wrap {
    border-top: 1px solid rgba(30,58,95,0.07);
    background: white;
    pointer-events: none;
}
.mega-menu {
    display: none; max-width: 1280px;
    margin: 0 auto; padding: 32px 40px;
    pointer-events: auto;
    animation: megaFadeIn 0.18s ease;
}
.mega-menu.open { display: block; }
@keyframes megaFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.mega-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 0; column-gap: 32px; }
.mega-col { display: flex; flex-direction: column; }
.mega-col-title { font-weight: 700; font-size: 13px; color: var(--text); margin-bottom: 14px; letter-spacing: -0.01em; }
.mega-link { display: block; font-size: 13px; color: var(--text-soft); text-decoration: none; padding: 6px 0; line-height: 1.5; transition: color 0.15s, padding-left 0.15s; }
.mega-link:hover { color: var(--purple); padding-left: 4px; }
.mega-link-cta { color: var(--purple) !important; font-weight: 600; margin-top: 6px; font-size: 12px; }
.mega-group-label { font-size: 10px; font-weight: 700; letter-spacing: 0.09em; text-transform: uppercase; color: var(--muted); margin-top: 14px; margin-bottom: 6px; }
.mega-empty { font-size: 13px; color: var(--muted); }
.mega-overlay { display: none; position: fixed; inset: 0; z-index: 499; background: rgba(26,24,37,0.12); }
.mega-overlay.open { display: block; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .nav-search-wrap { max-width: 360px; }
    .mega-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 768px) {
    .navbar { height: 56px; padding: 0 16px; }
    .nav-search-wrap { max-width: none; flex: 1; margin: 0 12px; }
    .nav-link-sm, .nav-divider, .mega-trigger { display: none; }
    .logo-text { display: none; }
    .nav-right { margin-left: 0; }
}

/* BREADCRUMB */
.breadcrumb { display: flex; align-items: center; gap: 8px; padding: 20px 0; flex-wrap: wrap; }
.breadcrumb a { font-size: 12px; color: var(--muted); text-decoration: none; font-weight: 500; transition: color 0.2s; }
.breadcrumb a:hover { color: var(--purple); }
.breadcrumb-separator { color: var(--muted); font-size: 12px; opacity: 0.5; }
.breadcrumb-current { font-size: 12px; color: var(--text); font-weight: 600; }

/* HERO LAYOUT */
.hero-grid { display: grid; grid-template-columns: minmax(0,1fr) 380px; gap: 32px; margin-bottom: 40px; align-items: start; }
.hero-left { min-width: 0; }

/* BADGES */
.course-badges { display: flex; gap: 8px; margin-bottom: 18px; flex-wrap: wrap; }
.hero-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; letter-spacing: 0.03em; white-space: nowrap; }
/* .badge-bestseller { background: rgba(255,196,82,0.95); color: #5A3A00; } */
.badge-category { background: rgba(123,111,232,0.1); color: var(--purple-dark); border: 1px solid rgba(123,111,232,0.2); }
.badge-level { background: rgba(255,255,255,0.7); color: var(--text-soft); border: 1px solid var(--border); }

/* COURSE TITLE */
.course-title { font-family: var(--font-serif); font-size: clamp(36px,5vw,56px); font-weight: 400; line-height: 1.1; letter-spacing: -0.02em; margin-bottom: 18px; color: var(--text); word-wrap: break-word; }
.course-title em { font-style: italic; background: linear-gradient(135deg,#9F94F2,#7B6FE8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; display: inline-block; line-height: 1.2; padding-bottom: 0.15em; }
.course-tagline { font-size: 17px; color: var(--text-soft); line-height: 1.6; margin-bottom: 24px; max-width: 640px; }

/* STATS */
.course-stats { display: flex; gap: 24px; padding: 18px 24px; background: rgba(255,255,255,0.6); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.9); border-radius: 16px; margin-bottom: 24px; flex-wrap: wrap; }
.stat-item-sm { display: flex; flex-direction: column; gap: 3px; min-width: 0; }
.stat-item-sm-val { display: flex; align-items: center; gap: 5px; font-family: var(--font-serif); font-size: 20px; font-weight: 400; color: var(--text); letter-spacing: -0.01em; line-height: 1.1; padding-bottom: 2px; }
.stat-item-sm-val em { font-style: italic; color: var(--gold); margin-right: 2px; }
.stat-item-sm-label { font-size: 10px; color: var(--muted); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; }

/* INSTRUCTOR CHIP */
.instructor-chip { display: inline-flex; align-items: center; gap: 12px; padding: 10px 18px 10px 10px; background: rgba(255,255,255,0.6); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.9); border-radius: 100px; }
/* COURSE META GRID */
.course-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; margin-top: 20px; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; background: rgba(255,255,255,0.5); }
.course-meta-item { display: flex; align-items: flex-start; gap: 12px; padding: 14px 18px; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.course-meta-item:nth-child(2) { border-right: none; }
.course-meta-item:nth-child(3) { border-bottom: none; }
.course-meta-item:nth-child(4) { border-right: none; border-bottom: none; }
.course-meta-icon { font-size: 20px; color: var(--navy); margin-top: 2px; flex-shrink: 0; }
.course-meta-val { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.3; }
.course-meta-sub { font-size: 11.5px; color: var(--muted); margin-top: 2px; }
.instructor-avatar-lg { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg,var(--navy),#2D4D7A); color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.instructor-info-sm { display: flex; flex-direction: column; gap: 1px; min-width: 0; }
.instructor-label { font-size: 10px; color: var(--muted); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; }
.instructor-name-sm { font-size: 13.5px; font-weight: 600; color: var(--text); }

/* COURSE DETAILS GRID (Language, Translations, etc.) */
.course-details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; margin-top: 24px; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; background: rgba(255,255,255,0.5); }
.course-detail-item { padding: 16px 20px; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.course-detail-item:nth-child(even) { border-right: none; }
.course-detail-item:nth-last-child(-n+2) { border-bottom: none; }
.course-detail-label { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
.course-detail-label i { font-size: 16px; width: 20px; text-align: center; color: var(--navy); }
.course-detail-value { font-size: 13.5px; color: var(--muted); line-height: 1.5; padding-left: 28px; }

/* ENROLL CARD */
.enroll-sidebar { position: sticky; top: 110px; min-width: 0; }
.enroll-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(30px) saturate(180%); border: 1px solid rgba(255,255,255,0.9); border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(30,58,95,0.12); }
.enroll-video { aspect-ratio: 16/10; background: linear-gradient(135deg,var(--navy),#2D4D7A); position: relative; cursor: pointer; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.enroll-video::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 50% 50%,rgba(184,175,235,0.2),transparent 70%); }
.video-play-btn { width: 64px; height: 64px; border-radius: 50%; background: rgba(255,255,255,0.95); display: flex; align-items: center; justify-content: center; color: var(--navy); font-size: 22px; box-shadow: 0 8px 24px rgba(0,0,0,0.3); transition: transform 0.3s; z-index: 2; padding-left: 4px; }
.enroll-video:hover .video-play-btn { transform: scale(1.1); }
.video-duration { position: absolute; bottom: 12px; right: 12px; background: rgba(0,0,0,0.7); color: white; padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; z-index: 2; }
.preview-label { position: absolute; top: 12px; left: 12px; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 5px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; color: var(--purple-dark); letter-spacing: 0.05em; text-transform: uppercase; z-index: 2; }
.enroll-body { padding: 24px; }

/* PRICE */
.price-block { margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid var(--border); }
.price-main { display: flex; align-items: baseline; gap: 10px; margin-bottom: 8px; flex-wrap: wrap; }
.price-now { font-family: var(--font-serif); font-size: 40px; font-weight: 400; letter-spacing: -0.02em; line-height: 1; color: var(--text); }
.price-now.free { color: var(--teal); }
.price-old { font-size: 16px; color: var(--muted); text-decoration: line-through; font-weight: 500; }

/* BUTTONS */
.btn-enroll { width: 100%; padding: 15px; background: #1A1825; color: white; border: none; border-radius: 100px; font-family: var(--font-sans); font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.25s; box-shadow: 0 4px 14px rgba(26,24,37,0.3); margin-bottom: 10px; letter-spacing: -0.01em; display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-enroll:hover { background: #2A2840; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(26,24,37,0.4); }
.btn-wishlist { width: 100%; padding: 13px; background: rgba(255,255,255,0.7); color: var(--text); border: 1.5px solid var(--border); border-radius: 100px; font-family: var(--font-sans); font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-wishlist:hover { background: white; border-color: var(--purple); color: var(--purple); }
.btn-wishlist.active { background: #FFF0F5; border-color: #FF6B8A; color: #FF6B8A; }

/* GUARANTEE */
.guarantee-box { padding: 12px 14px; background: linear-gradient(135deg,var(--teal-light),rgba(255,255,255,0.5)); border: 1px solid rgba(0,200,150,0.15); border-radius: 12px; margin-bottom: 20px; display: flex; gap: 10px; align-items: center; }
.guarantee-icon { width: 32px; height: 32px; background: var(--teal); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; flex-shrink: 0; font-weight: 700; }
.guarantee-text { font-size: 11.5px; color: var(--text-soft); font-weight: 500; line-height: 1.45; min-width: 0; }
.guarantee-text strong { color: var(--text); font-weight: 700; }

/* INCLUDES */
.includes-title { font-size: 11px; font-weight: 700; color: var(--text-soft); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 12px; }
.includes-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.includes-item { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--text-soft); line-height: 1.4; }
.includes-icon { width: 28px; height: 28px; background: var(--lav-1); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
.includes-item strong { color: var(--text); font-weight: 600; }

/* SHARE */
.share-row { display: flex; justify-content: space-between; align-items: center; padding-top: 18px; margin-top: 18px; border-top: 1px solid var(--border); }
.share-label { font-size: 12px; color: var(--muted); font-weight: 500; }
.share-icons { display: flex; gap: 6px; }
.share-btn { width: 32px; height: 32px; border-radius: 50%; background: var(--lav-1); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-soft); font-size: 13px; transition: all 0.2s; font-family: var(--font-sans); }
.share-btn:hover { background: var(--purple); color: white; transform: translateY(-2px); }

/* CONTENT SECTIONS */
.content-section { background: rgba(255,255,255,0.6); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.9); border-radius: 20px; padding: 32px; margin-bottom: 20px; position: relative; z-index: 1; overflow: hidden; }
.section-title { font-family: var(--font-serif); font-size: 28px; font-weight: 400; letter-spacing: -0.01em; margin-bottom: 6px; line-height: 1.2; }
.section-title em { font-style: italic; color: var(--purple); display: inline-block; }
.section-desc { font-size: 14px; color: var(--muted); margin-bottom: 24px; line-height: 1.5; }

/* LEARN GRID */
.learn-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 14px 20px; }
.learn-item { display: flex; gap: 12px; align-items: flex-start; padding: 14px; background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 12px; transition: all 0.2s; min-width: 0; }
.learn-item:hover { background: white; border-color: var(--purple); transform: translateY(-2px); }
.learn-check { width: 24px; height: 24px; background: linear-gradient(135deg,var(--teal),#00A075); border-radius: 50%; color: white; font-weight: 700; font-size: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
.learn-text { font-size: 13.5px; color: var(--text-soft); line-height: 1.5; min-width: 0; }

/* TWO COL GRID */
.two-col-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 20px; margin-bottom: 20px; }

/* CURRICULUM */
.curriculum-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; gap: 20px; flex-wrap: wrap; }
.btn-toggle-all { padding: 9px 18px; background: rgba(255,255,255,0.7); border: 1.5px solid var(--border); border-radius: 100px; font-family: var(--font-sans); font-size: 12px; font-weight: 600; color: var(--text-soft); cursor: pointer; transition: all 0.2s; white-space: nowrap; flex-shrink: 0; }
.btn-toggle-all:hover { border-color: var(--purple); color: var(--purple); background: white; }
.curriculum-stats { display: grid; grid-template-columns: repeat(5,minmax(0,1fr)); gap: 10px; margin-bottom: 24px; padding: 16px 20px; background: linear-gradient(135deg,var(--lav-1),rgba(255,255,255,0.5)); border-radius: 14px; }
.curr-stat { display: flex; flex-direction: column; align-items: center; text-align: center; min-width: 0; padding: 4px 6px; border-right: 1px solid rgba(30,58,95,0.08); }
.curr-stat:last-child { border-right: none; }
.curr-stat-num { font-family: var(--font-serif); font-size: 24px; font-weight: 400; color: var(--text); letter-spacing: -0.02em; line-height: 1; margin-bottom: 4px; }
.curr-stat-label { font-size: 10px; color: var(--muted); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; white-space: nowrap; }
.curriculum-list { display: flex; flex-direction: column; gap: 8px; }
.curriculum-section { background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; transition: border-color 0.2s; }
.curriculum-section:hover { border-color: rgba(123,111,232,0.3); }
.curriculum-section.expanded { border-color: var(--purple); background: rgba(255,255,255,0.7); }
.section-header-btn { width: 100%; background: transparent; border: none; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; gap: 16px; cursor: pointer; font-family: var(--font-sans); text-align: left; transition: background 0.2s; }
.section-header-btn:hover { background: rgba(255,255,255,0.5); }
.section-header-left { display: flex; align-items: center; gap: 14px; flex: 1; min-width: 0; }
.section-icon { width: 32px; height: 32px; border-radius: 10px; background: var(--lav-1); color: var(--purple); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 300; flex-shrink: 0; transition: all 0.3s; line-height: 1; }
.curriculum-section.expanded .section-icon { background: var(--purple); color: white; transform: rotate(45deg); }
.section-text { min-width: 0; flex: 1; overflow: hidden; }
.section-number { font-size: 10px; font-weight: 700; color: var(--purple); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 2px; }
.section-name { font-family: var(--font-serif); font-size: 17px; font-weight: 400; color: var(--text); letter-spacing: -0.01em; line-height: 1.3; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
.section-header-right { display: flex; gap: 14px; font-size: 12px; color: var(--muted); flex-shrink: 0; align-items: center; }
.section-meta-item { display: inline-flex; align-items: center; gap: 4px; font-weight: 500; white-space: nowrap; }
.section-lessons { max-height: 0; overflow: hidden; transition: max-height 0.5s ease; }
.curriculum-section.expanded .section-lessons { max-height: 1000px; border-top: 1px solid var(--border); }
.lesson-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 20px 12px 48px; border-bottom: 1px solid var(--border); transition: background 0.2s; gap: 12px; flex-wrap: wrap; }
.lesson-item:last-child { border-bottom: none; }
.lesson-item:hover { background: rgba(255,255,255,0.5); }
.lesson-left { display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0; }
.lesson-icon { width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 11px; flex-shrink: 0; font-weight: 700; line-height: 1; }
.lesson-icon-video { background: rgba(123,111,232,0.15); color: var(--purple); }
.lesson-icon-article { background: var(--teal-light); color: #00805F; }
.lesson-icon-quiz { background: var(--orange-light); color: var(--orange); }
.lesson-icon-download { background: var(--gold-light); color: #8B6914; }
.lesson-title { font-size: 13px; color: var(--text-soft); font-weight: 500; line-height: 1.4; min-width: 0; overflow: hidden; text-overflow: ellipsis; }
.lesson-preview-badge { font-size: 9px; font-weight: 700; padding: 2px 8px; background: var(--teal-light); color: #00805F; border-radius: 100px; letter-spacing: 0.05em; text-transform: uppercase; flex-shrink: 0; }
.lesson-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.lesson-play-btn { width: 26px; height: 26px; border-radius: 50%; border: none; background: var(--teal); color: white; cursor: pointer; font-size: 10px; display: flex; align-items: center; justify-content: center; padding-left: 2px; transition: all 0.2s; }
.lesson-play-btn:hover { transform: scale(1.1); background: #00A075; }
.lesson-locked { color: var(--muted); font-size: 13px; opacity: 0.5; }
.lesson-duration { font-size: 11px; color: var(--muted); font-weight: 600; min-width: 50px; text-align: right; white-space: nowrap; }

/* REQUIREMENTS & AUDIENCE */
.requirements-list, .audience-list { list-style: none; display: flex; flex-direction: column; gap: 12px; padding: 0; }
.requirement-item { display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 12px; font-size: 13.5px; color: var(--text-soft); line-height: 1.5; transition: all 0.2s; }
.requirement-item:hover { background: white; border-color: var(--purple); }
.requirement-item strong { color: var(--text); font-weight: 600; }
.req-bullet { color: var(--purple); font-size: 24px; line-height: 1; flex-shrink: 0; font-weight: 900; margin-top: -2px; }
.audience-item { display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 12px; font-size: 13.5px; color: var(--text-soft); line-height: 1.5; transition: all 0.2s; }
.audience-item:hover { background: white; border-color: var(--purple); transform: translateX(4px); }
.audience-item strong { color: var(--text); font-weight: 600; }
.aud-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.aud-icon-1 { background: var(--lav-1); }
.aud-icon-2 { background: var(--teal-light); }
.aud-icon-3 { background: var(--orange-light); }
.aud-icon-4 { background: var(--gold-light); }
.aud-icon-5 { background: rgba(245,87,108,0.15); }

/* DESCRIPTION */
.description-content { font-size: 14.5px; line-height: 1.75; color: var(--text-soft); }
.description-content p { margin-bottom: 16px; }
.description-content strong { color: var(--text); font-weight: 600; }
.description-content em { color: var(--purple); font-style: italic; font-weight: 500; }
.desc-subheading { font-family: var(--font-serif); font-size: 22px; font-weight: 400; color: var(--text); letter-spacing: -0.01em; margin-top: 28px; margin-bottom: 12px; }
.desc-list { list-style: none; margin: 12px 0 20px; padding-left: 0; display: flex; flex-direction: column; gap: 2px; }
.desc-list li { padding: 6px 0; color: var(--text-soft); font-size: 14px; }
.desc-quote { margin: 28px 0 12px; padding: 24px 28px 24px 54px; background: linear-gradient(135deg,var(--lav-1),rgba(255,255,255,0.5)); border-left: 4px solid var(--purple); border-radius: 14px; font-family: var(--font-serif); font-size: 18px; font-style: italic; color: var(--text); line-height: 1.6; position: relative; }
.quote-mark { font-family: var(--font-serif); font-size: 72px; color: var(--purple); line-height: 0; position: absolute; top: 40px; left: 14px; opacity: 0.25; font-style: normal; }
.desc-quote cite { display: block; font-family: var(--font-sans); font-size: 13px; font-style: normal; color: var(--muted); font-weight: 600; margin-top: 14px; }

/* INSTRUCTOR PROFILE */
.instructor-profile { background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 18px; padding: 28px; }
.instructor-header { display: flex; gap: 24px; margin-bottom: 28px; flex-wrap: wrap; align-items: center; }
.instructor-avatar-xl { width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg,var(--navy),#2D4D7A); color: white; font-size: 40px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 10px 30px rgba(30,58,95,0.25); }
.instructor-main-info { flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center; }
.instructor-full-name { font-family: var(--font-serif); font-size: 32px; font-weight: 400; letter-spacing: -0.02em; margin-bottom: 4px; line-height: 1.1; }
.instructor-profession { font-size: 13px; font-weight: 700; color: var(--purple); letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 6px; display: flex; align-items: center; gap: 6px; }
.instructor-profession::before { display: none; }
.instructor-headline { font-size: 14px; color: var(--text-soft); font-weight: 500; margin-bottom: 14px; }
.instructor-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }
.instructor-university-card { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 0; background: transparent; border: none; border-radius: 0; text-align: center; flex-shrink: 0; }
.instructor-university-icon { background: transparent; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.18), 0 2px 6px rgba(0,0,0,0.10); overflow: hidden; flex-shrink: 0; max-width: 140px; max-height: 100px; transform: perspective(300px) rotateY(-8deg) rotateX(4deg); transition: transform 0.3s ease, box-shadow 0.3s ease; }
.instructor-university-icon:hover { transform: perspective(300px) rotateY(0deg) rotateX(0deg); box-shadow: 0 14px 32px rgba(0,0,0,0.22), 0 2px 8px rgba(0,0,0,0.10); }
.instructor-university-icon img { display: block; width: auto; height: auto; max-width: 140px; max-height: 100px; object-fit: contain; border-radius: 0; }
.instructor-university-icon .fa-graduation-cap { color: var(--navy); font-size: 28px; }
.instructor-profile + .instructor-profile { margin-top: 16px; }
.instructor-university-label { font-size: 9.5px; font-weight: 700; color: var(--muted); letter-spacing: 0.07em; text-transform: uppercase; }
.instructor-university-name { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.35; }
@media (max-width: 600px) { .instructor-university-card { min-width: unset; width: 100%; flex-direction: row; text-align: left; } }
.inst-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 11px; border-radius: 100px; font-size: 11px; font-weight: 700; letter-spacing: 0.02em; white-space: nowrap; }
.inst-badge-verified { background: var(--teal-light); color: #00805F; }
.inst-badge-top { background: var(--gold-light); color: #8B6914; }
.inst-badge-exp { background: rgba(123,111,232,0.1); color: var(--purple-dark); }
.instructor-social { display: flex; gap: 14px; flex-wrap: wrap; }
.inst-social { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; color: var(--text-soft); text-decoration: none; font-weight: 600; transition: color 0.2s; white-space: nowrap; }
.inst-social:hover { color: var(--purple); }
.instructor-stats-grid { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 12px; margin-bottom: 28px; }
.inst-stat-card { text-align: center; padding: 18px 14px; background: rgba(255,255,255,0.7); border: 1px solid var(--border); border-radius: 14px; transition: all 0.2s; }
.inst-stat-card:hover { transform: translateY(-3px); border-color: var(--purple); box-shadow: 0 8px 20px rgba(30,58,95,0.08); }
.inst-stat-icon { font-size: 22px; margin-bottom: 6px; line-height: 1; }
.inst-stat-val { font-family: var(--font-serif); font-size: 24px; font-weight: 400; color: var(--text); letter-spacing: -0.02em; line-height: 1; margin-bottom: 4px; }
.inst-stat-label { font-size: 10px; color: var(--muted); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; }
.instructor-bio { background: rgba(255,255,255,0.7); border-radius: 14px; padding: 24px; font-size: 14.5px; line-height: 1.75; color: var(--text-soft); margin-bottom: 20px; }
.instructor-bio p { margin-bottom: 14px; }
.instructor-bio p:last-child { margin-bottom: 0; }
.instructor-bio strong { color: var(--text); font-weight: 600; }
.instructor-bio em { color: var(--purple); font-style: italic; font-weight: 500; }
.inst-expertise { margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border); }
.inst-expertise-label { font-size: 12px; font-weight: 700; color: var(--text-soft); letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 10px; }
.inst-expertise-tags { display: flex; flex-wrap: wrap; gap: 6px; }
.inst-tag { padding: 5px 12px; background: var(--lav-1); color: var(--purple-dark); border-radius: 100px; font-size: 11.5px; font-weight: 600; border: 1px solid rgba(123,111,232,0.15); transition: all 0.2s; cursor: pointer; white-space: nowrap; }
.inst-tag:hover { background: var(--purple); color: white; transform: translateY(-2px); }
.btn-view-profile { width: 100%; padding: 13px; background: rgba(255,255,255,0.7); border: 1.5px solid var(--border); border-radius: 100px; font-family: var(--font-sans); font-size: 13px; font-weight: 600; color: var(--text-soft); cursor: pointer; transition: all 0.2s; }
.btn-view-profile:hover { background: white; border-color: var(--purple); color: var(--purple); transform: translateY(-2px); }

/* REVIEWS */
.reviews-summary { display: grid; grid-template-columns: 300px minmax(0,1fr); gap: 32px; padding: 28px; background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 16px; margin-bottom: 28px; align-items: center; }
.review-overall { display: flex; align-items: center; justify-content: center; padding: 20px; background: linear-gradient(135deg,var(--gold-light),rgba(255,255,255,0.5)); border-radius: 14px; text-align: center; }
.overall-rating { display: flex; flex-direction: column; align-items: center; gap: 6px; }
.rating-value { font-family: var(--font-serif); font-size: 72px; font-weight: 400; line-height: 1; color: var(--text); letter-spacing: -0.03em; }
.rating-value em { font-style: italic; color: var(--gold); }
.rating-stars-big { color: var(--gold); font-size: 26px; letter-spacing: 4px; line-height: 1; }
.rating-total { font-size: 12px; color: var(--muted); font-weight: 500; margin-top: 4px; }
.rating-distribution { display: flex; flex-direction: column; gap: 10px; justify-content: center; min-width: 0; }
.dist-row { display: grid; grid-template-columns: 30px minmax(0,1fr) 48px 60px; gap: 12px; align-items: center; font-size: 12px; }
.dist-label { color: var(--gold); font-weight: 700; font-size: 13px; white-space: nowrap; }
.dist-bar { height: 8px; background: var(--lav-2); border-radius: 100px; overflow: hidden; }
.dist-fill { height: 100%; background: linear-gradient(90deg,var(--gold),#FFD700); border-radius: 100px; transition: width 0.8s ease; }
.dist-percent { color: var(--text); font-weight: 600; text-align: right; white-space: nowrap; }
.dist-count { color: var(--muted); font-weight: 500; text-align: left; white-space: nowrap; }
.reviews-filter { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 16px; flex-wrap: wrap; }
.filter-pills { display: flex; gap: 6px; flex-wrap: wrap; }
.filter-pill { padding: 7px 14px; border: 1.5px solid var(--border); background: rgba(255,255,255,0.6); border-radius: 100px; font-family: var(--font-sans); font-size: 12px; font-weight: 600; color: var(--text-soft); cursor: pointer; transition: all 0.2s; white-space: nowrap; }
.filter-pill:hover { border-color: var(--purple); color: var(--purple); }
.filter-pill.active { background: var(--text); border-color: var(--text); color: white; }
.reviews-sort { padding: 8px 14px; border: 1.5px solid var(--border); background: white; border-radius: 10px; font-family: var(--font-sans); font-size: 12px; font-weight: 500; color: var(--text); cursor: pointer; outline: none; }
.reviews-sort:focus { border-color: var(--purple); }
.reviews-list { display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px; }
.review-card { background: rgba(255,255,255,0.7); border: 1px solid var(--border); border-radius: 16px; padding: 22px; position: relative; transition: all 0.2s; }
.review-card:hover { border-color: rgba(123,111,232,0.3); box-shadow: 0 8px 24px rgba(30,58,95,0.06); }
.review-highlight { border: 2px solid var(--gold); background: linear-gradient(135deg,var(--gold-light),rgba(255,255,255,0.7)); margin-top: 12px; }
.review-badge-pick { position: absolute; top: -10px; left: 20px; background: var(--gold); color: #5A3A00; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; letter-spacing: 0.05em; box-shadow: 0 4px 12px rgba(255,196,82,0.3); z-index: 2; white-space: nowrap; }
.review-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; gap: 16px; flex-wrap: wrap; }
.review-author { display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1; }
.review-avatar { width: 44px; height: 44px; border-radius: 50%; color: white; font-weight: 700; font-size: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.avatar-purple { background: linear-gradient(135deg,var(--purple),var(--purple-dark)); }
.avatar-teal { background: linear-gradient(135deg,var(--teal),#00A075); }
.avatar-orange { background: linear-gradient(135deg,var(--orange),#E66B3A); }
.avatar-gold { background: linear-gradient(135deg,var(--gold),#D19E2E); }
.review-author-info { min-width: 0; flex: 1; }
.review-author-name { font-size: 14px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.verified-badge { display: inline-flex; align-items: center; justify-content: center; width: 16px; height: 16px; background: var(--teal); color: white; border-radius: 50%; font-size: 9px; font-weight: 700; flex-shrink: 0; }
.review-author-role { font-size: 12px; color: var(--muted); margin-top: 2px; overflow: hidden; text-overflow: ellipsis; }
.review-meta { text-align: right; flex-shrink: 0; }
.review-stars { display: flex; gap: 2px; margin-bottom: 4px; justify-content: flex-end; }
.review-stars .star { font-size: 16px; color: var(--lav-3); line-height: 1; }
.review-stars .star.filled { color: var(--gold); }
.review-date { font-size: 11px; color: var(--muted); font-weight: 500; }
.review-comment { font-family: var(--font-serif); font-size: 16px; line-height: 1.6; color: var(--text); margin-bottom: 16px; font-style: italic; }
.review-footer { display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 1px solid var(--border); gap: 10px; flex-wrap: wrap; }
.review-helpful { font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.btn-helpful, .btn-helpful-no { padding: 5px 12px; background: var(--lav-1); border: 1px solid var(--border); border-radius: 100px; font-family: var(--font-sans); font-size: 11px; font-weight: 600; color: var(--text-soft); cursor: pointer; transition: all 0.2s; white-space: nowrap; }
.btn-helpful:hover, .btn-helpful-no:hover { background: var(--lav-2); color: var(--purple); }
.btn-helpful.active { background: var(--teal); border-color: var(--teal); color: white; }
.btn-helpful-no.active { background: var(--orange); border-color: var(--orange); color: white; }
.btn-report { background: none; border: none; font-size: 11px; color: var(--muted); cursor: pointer; font-weight: 500; transition: color 0.2s; padding: 4px 8px; }
.btn-report:hover { color: var(--orange); }
.reviews-load-more { text-align: center; padding-top: 16px; }
.btn-load-more { padding: 12px 32px; background: rgba(255,255,255,0.7); border: 1.5px solid var(--border); border-radius: 100px; font-family: var(--font-sans); font-size: 13px; font-weight: 600; color: var(--text-soft); cursor: pointer; transition: all 0.2s; }
.btn-load-more:hover { background: white; border-color: var(--purple); color: var(--purple); transform: translateY(-2px); }

/* RELATED */
.related-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 16px; }
.related-card { background: rgba(255,255,255,0.7); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; text-decoration: none; color: var(--text); transition: all 0.3s; display: flex; flex-direction: column; min-width: 0; }
.related-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(30,58,95,0.1); border-color: var(--purple); }
.related-thumb { aspect-ratio: 16/10; position: relative; display: flex; align-items: center; justify-content: center; font-size: 48px; }
.course-thumb-1 { background: linear-gradient(135deg,#667EEA,#764BA2); }
.course-thumb-2 { background: linear-gradient(135deg,#F093FB,#F5576C); }
.course-thumb-3 { background: linear-gradient(135deg,#4FACFE,#00F2FE); }
.course-thumb-4 { background: linear-gradient(135deg,#FA709A,#FEE140); }
.course-thumb-5 { background: linear-gradient(135deg,#30CFD0,#330867); }
.course-thumb-6 { background: linear-gradient(135deg,#A8EDEA,#FED6E3); }
.related-badge { position: absolute; top: 10px; left: 10px; padding: 3px 10px; border-radius: 100px; font-size: 10px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; white-space: nowrap; }
/* .related-badge.badge-bestseller { background: rgba(255,196,82,0.95); color: #5A3A00; } */
.related-badge.badge-free { background: rgba(0,200,150,0.95); color: white; }
.related-body { padding: 16px; flex: 1; display: flex; flex-direction: column; min-width: 0; }
.related-category { font-size: 10px; color: var(--muted); font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 6px; }
.related-title { font-family: var(--font-serif); font-size: 16px; font-weight: 400; line-height: 1.3; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 42px; }
.related-instructor { display: flex; align-items: center; gap: 6px; font-size: 11px; color: var(--text-soft); margin-bottom: 10px; overflow: hidden; }
.related-avatar { width: 20px; height: 20px; border-radius: 50%; background: linear-gradient(135deg,var(--navy),#2D4D7A); color: white; font-size: 9px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.related-meta { display: flex; gap: 10px; font-size: 10px; color: var(--muted); margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--border); flex-wrap: wrap; }
.related-footer { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
.related-price { font-family: var(--font-serif); font-size: 18px; font-weight: 400; color: var(--text); line-height: 1; }
.related-price.price-free { color: var(--teal); }
.related-arrow { color: var(--purple); font-size: 16px; transition: transform 0.3s; }
.related-card:hover .related-arrow { transform: translateX(4px); }

/* CTA BANNER */
.cta-banner { background: linear-gradient(135deg,var(--navy) 0%,#1E4A7A 50%,#2D4D7A 100%); border-radius: 32px; padding: 60px 40px; text-align: center; position: relative; overflow: hidden; margin-bottom: 40px; color: white; }
.cta-bg-decoration { position: absolute; inset: 0; background: radial-gradient(circle at 20% 20%,rgba(184,175,235,0.3),transparent 50%),radial-gradient(circle at 80% 80%,rgba(0,200,150,0.2),transparent 50%); pointer-events: none; }
.cta-content { position: relative; z-index: 1; max-width: 640px; margin: 0 auto; }
.cta-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.25); padding: 6px 14px; border-radius: 100px; font-size: 11px; font-weight: 600; color: var(--lav-4); margin-bottom: 18px; letter-spacing: 0.05em; }
.cta-badge-dot { width: 6px; height: 6px; background: var(--orange); border-radius: 50%; animation: pulseCta 1.5s infinite; }
@keyframes pulseCta { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:0.5; transform:scale(1.3); } }
.cta-title { font-family: var(--font-serif); font-size: clamp(32px,4.5vw,48px); font-weight: 400; line-height: 1.15; letter-spacing: -0.02em; margin-bottom: 14px; color: white; }
.cta-title em { font-style: italic; color: var(--lav-4); display: inline-block; }
.cta-subtitle { font-size: 15px; color: rgba(255,255,255,0.75); line-height: 1.6; margin-bottom: 24px; max-width: 480px; margin-left: auto; margin-right: auto; }
.cta-price { display: flex; align-items: center; justify-content: center; gap: 14px; margin-bottom: 28px; flex-wrap: wrap; }
.cta-price-now { font-family: var(--font-serif); font-size: 44px; font-weight: 400; letter-spacing: -0.02em; color: white; line-height: 1; }
.cta-price-old { font-size: 20px; color: rgba(255,255,255,0.5); text-decoration: line-through; font-weight: 500; }
.cta-price-discount { padding: 5px 14px; background: rgba(255,138,91,0.9); color: white; border-radius: 100px; font-size: 12px; font-weight: 700; letter-spacing: 0.05em; white-space: nowrap; }
.cta-buttons { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-bottom: 28px; }
.btn-cta-primary { padding: 15px 32px; background: white; color: var(--navy); border: none; border-radius: 100px; font-family: var(--font-sans); font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.25s; box-shadow: 0 8px 24px rgba(255,255,255,0.2); letter-spacing: -0.01em; white-space: nowrap; }
.btn-cta-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(255,255,255,0.3); }
.btn-cta-ghost { padding: 15px 28px; background: rgba(255,255,255,0.1); color: white; border: 1.5px solid rgba(255,255,255,0.2); border-radius: 100px; font-family: var(--font-sans); font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; backdrop-filter: blur(10px); white-space: nowrap; }
.btn-cta-ghost:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); }
.cta-trust { display: flex; justify-content: center; gap: 24px; flex-wrap: wrap; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.15); }
.cta-trust-item { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; color: rgba(255,255,255,0.8); font-weight: 500; white-space: nowrap; }
.cta-trust-icon { font-size: 16px; }

/* FOOTER */
/* BENEFITS */
.benefits-section { padding: 60px 0 40px; border-top: 1px solid var(--border); margin-top: 20px; }
.benefits-title { font-family: var(--font-serif); font-size: 36px; font-weight: 400; text-align: center; margin-bottom: 40px; color: var(--text); letter-spacing: 0.04em; line-height: 1.2; }
.benefits-title em { color: var(--purple); font-style: italic; letter-spacing: 0.04em; }
.benefits-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; }
.benefit-item { padding: 28px 36px; border-right: 1px solid var(--border); }
.benefit-item:last-child { border-right: none; }
.benefit-icon { font-size: 32px; color: var(--navy); margin-bottom: 16px; }
.benefit-heading { font-family: var(--font-serif); font-size: 28px; font-weight: 400; font-style: italic; color: var(--navy); line-height: 1.2; margin-bottom: 12px; letter-spacing: 0.02em; }
.benefit-desc { font-size: 14px; color: var(--text-soft); line-height: 1.7; }
@media (max-width: 700px) { .benefits-grid { grid-template-columns: 1fr; } .benefit-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.15); } .benefit-item:last-child { border-bottom: none; } }

.course-footer { padding: 30px 0 20px; border-top: 1px solid var(--border); }
.footer-content { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
.footer-links { display: flex; gap: 24px; flex-wrap: wrap; }
.footer-links a { font-size: 12px; color: var(--muted); text-decoration: none; font-weight: 500; transition: color 0.2s; white-space: nowrap; }
.footer-links a:hover { color: var(--purple); }
.footer-copy { font-size: 11px; color: var(--muted); font-weight: 500; white-space: nowrap; }

/* RESPONSIVE */
@media (max-width: 1100px) {
    .hero-grid { grid-template-columns: 1fr; gap: 24px; }
    .enroll-sidebar { position: static; }
}
@media (max-width: 900px) {
    .two-col-grid { grid-template-columns: 1fr; }
    .curriculum-stats { grid-template-columns: repeat(3,1fr); }
    .instructor-stats-grid { grid-template-columns: repeat(2,1fr); }
    .reviews-summary { grid-template-columns: 1fr; gap: 20px; }
    .related-grid { grid-template-columns: repeat(2,minmax(0,1fr)); }
    .section-header-right { flex-direction: column; gap: 4px; align-items: flex-end; }
}
@media (max-width: 640px) {
    .nav-links { display: none; }
    .course-stats { gap: 16px; padding: 14px 18px; }
    .learn-grid { grid-template-columns: 1fr; }
    .content-section { padding: 22px; }
    .course-title { font-size: 30px; }
    .curriculum-stats { grid-template-columns: repeat(2,1fr); }
    .section-header-right { display: none; }
    .lesson-item { padding: 10px 16px 10px 40px; }
    .related-grid { grid-template-columns: 1fr; }
    .cta-banner { padding: 40px 24px; }
    .footer-content { flex-direction: column; align-items: flex-start; }
}
</style>
</head>
<body>

{{-- ══════════════════════════════════════════════════════════
     NAVBAR — show.blade
     Hierarki: [Logo + Jelajahi] | [Search Dominan] | [Courses + Auth]
     Pola: Coursera / Udemy — full-width sticky, search di tengah
══════════════════════════════════════════════════════════ --}}
<div class="navbar-wrap" id="mainNavbar">

    <div class="navbar">

        {{-- ═══ KIRI: Logo + Jelajahi ═══ --}}
        <div class="nav-left">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
                <span class="logo-text">Coursify</span>
            </a>

            {{-- Jelajahi: ghost pill, bukan navy solid --}}
            <button class="mega-trigger" id="mega-btn"
                    onclick="toggleMega()"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-controls="mega-menu">
                <i class="fa-solid fa-grid-2" style="font-size:11px;opacity:0.75;"></i>
                Jelajahi
                <svg class="mega-chevron" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                    <path d="M3 5L7 9L11 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        {{-- ═══ TENGAH: Search bar — dominant ═══ --}}
        <div class="nav-search-wrap" x-data="navSearch()">
            <form class="nav-search-form"
                  action="{{ route('courses.index') }}" method="GET"
                  @submit="open = false"
                  autocomplete="off"
                  role="search"
                  aria-label="Cari kursus">
                <i class="fa-solid fa-magnifying-glass nav-search-icon" aria-hidden="true"></i>
                <input
                    type="search"
                    name="search"
                    class="nav-search-input"
                    placeholder="Cari kursus, topik, instruktur…"
                    value="{{ request('search') }}"
                    @input="onInput($event.target.value)"
                    @focus="if(query.length > 1) open = true"
                    @keydown.escape="open = false"
                    @keydown.arrow-down.prevent="moveFocus(1)"
                    @keydown.arrow-up.prevent="moveFocus(-1)"
                    @keydown.enter.prevent="submitOrGo"
                    x-model="query"
                    aria-label="Cari kursus"
                    aria-autocomplete="list"
                    aria-controls="search-listbox"
                >
                <button type="submit" class="nav-search-btn" aria-label="Cari">
                    Cari
                </button>
            </form>

            {{-- Autocomplete Dropdown --}}
            <div class="nav-search-dropdown"
                 id="search-listbox"
                 role="listbox"
                 :class="{ open: open && (results.length > 0 || loading || query.length > 1) }"
                 @click.outside="open = false">

                {{-- Loading --}}
                <template x-if="loading">
                    <div class="search-drop-empty">
                        <i class="fa-solid fa-circle-notch fa-spin" style="color:var(--purple);margin-right:6px;"></i>
                        Mencari…
                    </div>
                </template>

                {{-- Results --}}
                <template x-if="!loading && results.length > 0">
                    <div>
                        <div class="search-drop-section">Kursus</div>
                        <template x-for="(item, idx) in results" :key="item.id">
                            <a :href="item.url"
                               class="search-drop-item"
                               :class="{ hovered: focusIdx === idx }"
                               role="option"
                               @mouseenter="focusIdx = idx"
                               @mouseleave="focusIdx = -1">
                                <template x-if="item.thumbnail">
                                    <img :src="item.thumbnail" :alt="item.title" class="search-drop-item-img">
                                </template>
                                <template x-if="!item.thumbnail">
                                    <div class="search-drop-item-icon">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                </template>
                                <div class="search-drop-meta">
                                    <span class="search-drop-title" x-text="item.title"></span>
                                    <span class="search-drop-sub" x-text="item.category ?? item.instructor ?? ''"></span>
                                </div>
                            </a>
                        </template>
                        <a :href="`{{ route('courses.index') }}?search=${encodeURIComponent(query)}`"
                           class="search-drop-footer">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Lihat semua hasil untuk "<span x-text="query"></span>"</span>
                        </a>
                    </div>
                </template>

                {{-- No results --}}
                <template x-if="!loading && results.length === 0 && query.length > 1">
                    <div>
                        <div class="search-drop-empty">
                            Tidak ada hasil untuk "<span x-text="query"></span>"
                        </div>
                        <a :href="`{{ route('courses.index') }}?search=${encodeURIComponent(query)}`"
                           class="search-drop-footer">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Cari di semua kursus</span>
                        </a>
                    </div>
                </template>
            </div>
        </div>

        {{-- ═══ KANAN: Secondary nav + Auth ═══ --}}
        <div class="nav-right">

            {{-- Secondary links — hanya yang relevan di halaman show --}}
            <a href="{{ route('courses.index') }}" class="nav-link-sm active">
                Kursus
            </a>

            <div class="nav-divider" aria-hidden="true"></div>

            @guest
                <a href="{{ route('login') }}" class="nav-link-sm">Masuk</a>
                <a href="{{ route('login') }}" class="btn-cta-nav">
                    Mulai Gratis
                </a>
            @else
                <div style="position:relative;flex-shrink:0;" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" class="user-btn" aria-expanded="false" aria-haspopup="true">
                        <div class="user-avatar" aria-hidden="true">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span>{{ Str::limit(auth()->user()->name, 12) }}</span>
                        <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:0.45;" aria-hidden="true"></i>
                    </button>

                    <div x-show="userOpen"
                         @click.away="userOpen = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="user-dropdown"
                         role="menu">

                        <div class="dropdown-header">
                            <div class="dropdown-name">{{ auth()->user()->name }}</div>
                            <div class="dropdown-email">{{ auth()->user()->email }}</div>
                            <div style="margin-top:8px;">
                                @php
                                    $roleMap = [
                                        'admin'      => ['bg' => 'linear-gradient(135deg,#1E3A5F,#2D4D7A)', 'color' => 'white',   'icon' => 'fa-user-shield',     'label' => 'Administrator'],
                                        'instructor' => ['bg' => 'rgba(0,200,150,0.12)',                   'color' => '#00705A',  'icon' => 'fa-chalkboard-user', 'label' => 'Instructor'],
                                        'student'    => ['bg' => 'rgba(123,111,232,0.12)',                 'color' => '#5B4FD4',  'icon' => 'fa-graduation-cap',  'label' => 'Student'],
                                    ];
                                    $r = $roleMap[auth()->user()->role] ?? $roleMap['student'];
                                @endphp
                                <span style="display:inline-block;padding:3px 10px;background:{{ $r['bg'] }};color:{{ $r['color'] }};border-radius:100px;font-size:10px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;">
                                    <i class="fa-solid {{ $r['icon'] }}"></i> {{ $r['label'] }}
                                </span>
                            </div>
                        </div>

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item" role="menuitem"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                            <a href="{{ route('admin.courses.index') }}" class="dropdown-item" role="menuitem"><i class="fa-solid fa-book-open"></i> Manage Courses</a>
                            <a href="#" class="dropdown-item" role="menuitem"><i class="fa-solid fa-users-gear"></i> Manage Users</a>
                        @endif
                        @if(auth()->user()->role === 'instructor')
                            <a href="{{ route('instructor.dashboard') }}" class="dropdown-item" role="menuitem"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                            <a href="#" class="dropdown-item" role="menuitem"><i class="fa-solid fa-chalkboard-user"></i> My Courses</a>
                            <a href="#" class="dropdown-item" role="menuitem"><i class="fa-solid fa-square-plus"></i> Create Course</a>
                        @endif
                        @if(auth()->user()->role === 'student')
                            <a href="{{ route('student.index') }}" class="dropdown-item" role="menuitem"><i class="fa-solid fa-gauge-high"></i> My Dashboard</a>
                            <a href="{{ route('student.courses') }}" class="dropdown-item" role="menuitem"><i class="fa-solid fa-book-open"></i> My Courses</a>
                            <a href="{{ route('student.wishlist') }}" class="dropdown-item" role="menuitem"><i class="fa-solid fa-heart"></i> Wishlist</a>
                            <a href="{{ route('student.certificates') }}" class="dropdown-item" role="menuitem"><i class="fa-solid fa-award"></i> Certificates</a>
                            <a href="{{ route('student.profile') }}" class="dropdown-item" role="menuitem"><i class="fa-solid fa-user-pen"></i> Profile Settings</a>
                        @endif

                        <div style="border-top:1px solid rgba(0,0,0,0.06);margin-top:4px;padding-top:4px;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item dropdown-item-danger" role="menuitem">
                                    <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endguest

        </div>

    </div>{{-- /.navbar --}}

    {{-- ═══ MEGA MENU — drops directly below full-width bar ═══ --}}
    <div class="mega-menu-wrap">
        <div class="mega-menu" id="mega-menu" role="dialog" aria-label="Menu navigasi utama">
            <div class="mega-grid">

                <div class="mega-col">
                    <div class="mega-col-title">Jelajahi Topik</div>
                    @forelse($navBrowseTopics ?? [] as $topic)
                        <a href="{{ route('courses.index') }}?category={{ $topic['slug'] }}" class="mega-link">{{ $topic['name'] }}</a>
                    @empty
                        @foreach([['ai','Kecerdasan Buatan'],['web','Web Development'],['data','Data Science'],['cyber','Cybersecurity'],['design','Desain UI/UX'],['mobile','Mobile Dev'],['business','Bisnis & Manajemen']] as [$slug,$name])
                            <a href="{{ route('courses.index') }}?category={{ $slug }}" class="mega-link">{{ $name }}</a>
                        @endforeach
                    @endforelse
                    <a href="{{ route('courses.index') }}" class="mega-link mega-link-cta">Lihat semua topik →</a>
                </div>

                <div class="mega-col">
                    <div class="mega-col-title">Raih Sertifikat</div>
                    @forelse($navCertificatePrograms ?? [] as $cert)
                        <a href="{{ route('courses.index') }}?q={{ urlencode($cert['name']) }}" class="mega-link">{{ $cert['name'] }}</a>
                    @empty
                        @foreach(['Sertifikat Profesional','MicroMasters','Program Diploma','Executive Education'] as $c)
                            <a href="{{ route('courses.index') }}?type=certificate" class="mega-link">{{ $c }}</a>
                        @endforeach
                    @endforelse
                    <a href="{{ route('courses.index') }}?type=certificate" class="mega-link mega-link-cta">Lihat semua →</a>
                </div>

                <div class="mega-col">
                    <div class="mega-col-title">Program Gelar</div>
                    @forelse($navDegreePrograms ?? [] as $degree)
                        <a href="{{ route('courses.index') }}?q={{ urlencode($degree['name']) }}" class="mega-link">{{ $degree['name'] }}</a>
                    @empty
                        @foreach(['S1 Online','S2 Online','MBA Online','Program Diploma'] as $d)
                            <a href="{{ route('courses.index') }}?type=program" class="mega-link">{{ $d }}</a>
                        @endforeach
                    @endforelse
                    <a href="{{ route('courses.index') }}?type=program" class="mega-link mega-link-cta">Lihat semua →</a>
                </div>

                <div class="mega-col">
                    <div class="mega-col-title">Universitas Partner</div>
                    @forelse($navPartnerInstitutions ?? [] as $inst)
                        <a href="{{ route('universities.show', $inst['slug']) }}" class="mega-link">{{ $inst['name'] }}</a>
                    @empty
                        @foreach(['Harvard University','Stanford University','MIT','Oxford University','Tsinghua University'] as $u)
                            <a href="{{ route('universities') }}" class="mega-link">{{ $u }}</a>
                        @endforeach
                    @endforelse
                    <a href="{{ route('universities') }}" class="mega-link mega-link-cta">Lihat semua universitas →</a>
                </div>

            </div>
        </div>
    </div>

</div>{{-- /.navbar-wrap --}}

<div class="mega-overlay" id="mega-overlay" onclick="closeMega()"></div>



<div class="container">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('courses.index') }}">Courses</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">{{ $course->title ?? 'Course' }}</span>
    </div>

    {{-- HERO GRID --}}
    <div class="hero-grid">

        {{-- LEFT: Course Info --}}
        @php
    $scrapedInstructors = $course->scrapedInstructors;
    $instructors = $scrapedInstructors->isNotEmpty()
        ? $scrapedInstructors
        : $course->instructors;
    $instructor = $instructors->first();
    $totalLessons = $course->sections->flatMap->lessons->count();
    $avgRating = $course->reviews_avg_rating;
    $reviewCount = $course->reviews->count();
    $isEnrolled = auth()->check() && auth()->user()
        ->enrollments()->where('course_id', $course->id)->exists();
@endphp

        <div class="hero-left">
            <div class="course-badges">
                @if($course->category)
                    <span class="hero-badge badge-category">{{ $course->category->name }}</span>
                @endif
                @if($course->difficulty)
                    <span class="hero-badge badge-level">{{ ucfirst($course->difficulty) }}</span>
                @endif
            </div>

            <h1 class="course-title">{{ $course->title }}</h1>

            <p class="course-tagline">
                {{ $course->short_description ?? Str::limit($course->description, 200) }}
            </p>

            <div class="course-stats">
                <div class="stat-item-sm">
                    <div class="stat-item-sm-val">
                        <i class="fa-solid fa-star" style="color:#f59e0b;font-size:11px;"></i> {{ $avgRating ? number_format($avgRating, 1) : '—' }}
                    </div>
                    <div class="stat-item-sm-label">({{ $reviewCount }} reviews)</div>
                </div>
                <div class="stat-item-sm">
                    <div class="stat-item-sm-val"><i class="fa-solid fa-users"></i> {{ $course->enrollments_count ?? 0 }}</div>
                    <div class="stat-item-sm-label">Students</div>
                </div>
                <div class="stat-item-sm">
                    <div class="stat-item-sm-val"><i class="fa-solid fa-book-open"></i> {{ $totalLessons }}</div>
                    <div class="stat-item-sm-label">Lessons</div>
                </div>
                @if($course->language)
                    <div class="stat-item-sm">
                        <div class="stat-item-sm-val"><i class="fa-solid fa-globe"></i> {{ strtoupper($course->language) }}</div>
                        <div class="stat-item-sm-label">Language</div>
                    </div>
                @endif
            </div>

            @if($instructor)
                <div class="instructor-chip">
                    <div class="instructor-avatar-lg" style="{{ $instructor->photo_url ?? false ? 'padding:0;overflow:hidden;' : '' }}">
                        @if($instructor->photo_url ?? false)
                            <img src="{{ $instructor->photo_url }}"
                                 alt="{{ $instructor->name }}"
                                 style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;"
                                 onerror="this.style.display='none';this.parentElement.innerHTML='{{ strtoupper(substr($instructor->name, 0, 1)) }}';">
                        @else
                            {{ strtoupper(substr($instructor->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="instructor-info-sm">
                        <span class="instructor-label">Created by</span>
                        <span class="instructor-name-sm">{{ $instructor->name }}</span>
                    </div>
                </div>
            @endif

            {{-- COURSE META GRID --}}
            <div class="course-meta-grid">
                <div class="course-meta-item">
                    <i class="fa-regular fa-clock course-meta-icon"></i>
                    <div>
                        <div class="course-meta-val">{{ $course->duration_weeks }} {{ $course->duration_weeks > 1 ? 'weeks' : 'week' }}</div>
                        @if($course->hours_per_week)
                            <div class="course-meta-sub">{{ $course->hours_per_week }} hours per week</div>
                        @endif
                    </div>
                </div>
                <div class="course-meta-item">
                    @if($course->start_date)
                        <i class="fa-regular fa-calendar course-meta-icon"></i>
                        <div>
                            <div class="course-meta-val">Starts {{ \Carbon\Carbon::parse($course->start_date)->format('M j, Y') }}</div>
                            @if($course->enroll_deadline)
                                <div class="course-meta-sub">Enroll by {{ \Carbon\Carbon::parse($course->enroll_deadline)->format('M j, Y') }}</div>
                            @endif
                        </div>
                    @else
                        <i class="fa-regular fa-calendar course-meta-icon"></i>
                        <div>
                            <div class="course-meta-val">Self-paced</div>
                            <div class="course-meta-sub">Start anytime</div>
                        </div>
                    @endif
                </div>
                <div class="course-meta-item">
                    <i class="fa-solid fa-users course-meta-icon"></i>
                    <div>
                        @if($course->is_self_paced)
                            <div class="course-meta-val">Self-paced</div>
                            <div class="course-meta-sub">Progress at your own speed</div>
                        @else
                            <div class="course-meta-val">Instructor-paced</div>
                            <div class="course-meta-sub">Scheduled classes</div>
                        @endif
                    </div>
                </div>
                <div class="course-meta-item">
                    <i class="fa-solid fa-award course-meta-icon"></i>
                    <div>
                        @if($course->has_certificate)
                            <div class="course-meta-val">Earn your credentials</div>
                            <div class="course-meta-sub">Receive a certificate or badge</div>
                        @else
                            <div class="course-meta-val">Audit only</div>
                            <div class="course-meta-sub">No certificate</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- LANGUAGE / TRANSLATIONS / TRANSCRIPTS / PREREQUISITES --}}
            <div class="course-details-grid">
                <div class="course-detail-item">
                    <div class="course-detail-label">
                        <i class="fa-solid fa-language"></i> Language
                    </div>
                    <div class="course-detail-value">{{ $course->language ?? 'English' }}</div>
                </div>
                <div class="course-detail-item">
                    <div class="course-detail-label">
                        <i class="fa-solid fa-globe"></i> Translations
                    </div>
                    <div class="course-detail-value">{{ $course->translations ?? 'None' }}</div>
                </div>
                <div class="course-detail-item">
                    <div class="course-detail-label">
                        <i class="fa-regular fa-closed-captioning"></i> Transcripts
                    </div>
                    <div class="course-detail-value">{{ $course->transcripts ?? 'English' }}</div>
                </div>
                <div class="course-detail-item">
                    <div class="course-detail-label">
                        <i class="fa-solid fa-clipboard-check"></i> Prerequisites
                    </div>
                    <div class="course-detail-value">{{ $course->prerequisites ?? 'None' }}</div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Enroll Card --}}
        <aside class="enroll-sidebar">
            <div class="enroll-card">
                <div class="enroll-video">
                    <span class="preview-label">Preview</span>
                    <div class="video-play-btn"><i class="fa-solid fa-play"></i></div>
                    <span class="video-duration">Preview</span>
                </div>

                <div class="enroll-body">
                    @if($isEnrolled)
                        <div style="text-align:center; margin-bottom: 20px;">
                            <div style="font-size: 13px; color: var(--teal); font-weight: 600; margin-bottom: 8px;">
                                <i class="fa-solid fa-circle-check"></i> Kamu sudah terdaftar
                            </div>
                            <a href="{{ route('student.learn', $course->slug) }}" class="btn-enroll" style="text-decoration:none;">
                                <i class="fa-solid fa-play"></i> Continue Learning
                            </a>
                        </div>
                    @else
                        <div class="price-block">
                            <div class="price-main">
                                @if($course->isFree() && !$course->hasCertificatePrice())
                                    <span class="price-now">GRATIS</span>
                                @elseif($course->hasCertificatePrice())
                                    <span class="price-now">Audit gratis</span>
                                @else
                                    <span class="price-now">{{ $course->formatted_price }}</span>
                                @endif
                            </div>
                            <div style="font-size:12px;color:var(--text-soft);line-height:1.6;margin:8px 0 18px;">
                                Pilih jalur belajar: Audit (gratis) atau Verified (sertifikat resmi).
                            </div>
                        </div>

                        @auth
                            <a href="{{ route('courses.choose-path', $course) }}" class="btn-enroll" style="text-decoration:none;">
                                <i class="fa-solid fa-route"></i> Enroll Now
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-enroll" style="text-decoration:none;">
                                Login to Enroll
                            </a>
                        @endauth
                    @endif

                    @php
    $isWishlisted = auth()->check() && auth()->user()
        ->wishlists()->where('course_id', $course->id)->exists();
@endphp

<button class="btn-wishlist {{ $isWishlisted ? 'active' : '' }}"
    onclick="toggleWishlistBtn(this, {{ $course->id }})"
    aria-label="{{ $isWishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist' }}">
    <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart" style="margin-right:6px;"></i>
    {{ $isWishlisted ? 'Tersimpan di Wishlist' : 'Simpan ke Wishlist' }}
</button>

                    <div class="guarantee-box">
                        <div class="guarantee-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="guarantee-text">
                            <strong>30-day money-back guarantee.</strong> Full refund, no questions asked.
                        </div>
                    </div>

                    <div class="includes-title">This course includes</div>
                    <ul class="includes-list">
                        <li class="includes-item">
                            <div class="includes-icon"><i class="fa-solid fa-book-open"></i></div>
                            <span><strong>{{ $totalLessons }}</strong> lessons</span>
                        </li>
                        <li class="includes-item">
                            <div class="includes-icon"><i class="fa-solid fa-mobile-screen"></i></div>
                            <span>Access on <strong>mobile & desktop</strong></span>
                        </li>
                        <li class="includes-item">
                            <div class="includes-icon"><i class="fa-solid fa-infinity"></i></div>
                            <span><strong>Lifetime</strong> access</span>
                        </li>
                        <li class="includes-item">
                            <div class="includes-icon"><i class="fa-solid fa-trophy"></i></div>
                            <span><strong>Certificate</strong> of completion</span>
                        </li>
                    </ul>

                    <div class="share-row">
                        <span class="share-label">Share this course</span>
                        <div class="share-icons">
                            <button class="share-btn" title="Twitter"><i class="fa-brands fa-x-twitter"></i></button>
                            <button class="share-btn" title="Facebook">f</button>
                            <button class="share-btn" title="LinkedIn">in</button>
                            <button class="share-btn" title="Copy link"><i class="fa-solid fa-link"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    {{-- WHAT YOU'LL LEARN --}}
    <section class="content-section">
        <h2 class="section-title">What you'll <em>learn</em></h2>
        <p class="section-desc">Master these skills and apply them to real-world projects.</p>

        @if($course->syllabus->isNotEmpty())
            <div class="learn-grid">
                @foreach($course->syllabus as $item)
                    <div class="learn-item">
                        <div class="learn-check"><i class="fa-solid fa-check"></i></div>
                        <div class="learn-text">{{ $item->item }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: var(--muted); font-size: 14px; padding: 16px 0;">
                Silabus untuk kursus ini belum dibuat.
            </p>
        @endif
    </section>

    {{-- CURRICULUM --}}
    <section class="content-section">
        <div class="curriculum-header">
            <div>
                <h2 class="section-title">Course <em>curriculum</em></h2>
                <p class="section-desc">
                    {{ $course->sections->count() }} sections ·
                    {{ $totalLessons }} lessons
                </p>
            </div>
            <button class="btn-toggle-all" onclick="toggleAllSections()">
                <span id="toggleAllText">Expand all</span>
            </button>
        </div>

        <div class="curriculum-stats">
            <div class="curr-stat">
                <span class="curr-stat-num">{{ $course->sections->count() }}</span>
                <span class="curr-stat-label">Sections</span>
            </div>
            <div class="curr-stat">
                <span class="curr-stat-num">{{ $totalLessons }}</span>
                <span class="curr-stat-label">Lessons</span>
            </div>
            <div class="curr-stat">
                <span class="curr-stat-num">{{ $reviewCount }}</span>
                <span class="curr-stat-label">Reviews</span>
            </div>
            <div class="curr-stat">
                <span class="curr-stat-num">{{ $course->enrollments_count ?? 0 }}</span>
                <span class="curr-stat-label">Students</span>
            </div>
            <div class="curr-stat">
                <span class="curr-stat-num">{{ $avgRating ? number_format($avgRating,1) : '—' }}</span>
                <span class="curr-stat-label">Rating</span>
            </div>
        </div>

        <div class="curriculum-list">
            @foreach($course->sections as $index => $section)
                <div class="curriculum-section {{ $index === 0 ? 'expanded' : '' }}">
                    <button class="section-header-btn" onclick="toggleSection(this)" type="button">
                        <div class="section-header-left">
                            <div class="section-icon">+</div>
                            <div class="section-text">
                                <div class="section-number">Section {{ $index + 1 }}</div>
                                <div class="section-name">{{ $section->title }}</div>
                            </div>
                        </div>
                        <div class="section-header-right">
                            <span class="section-meta-item"><i class="fa-solid fa-book-open"></i> {{ $section->lessons->count() }} lessons</span>
                        </div>
                    </button>

                    <div class="section-lessons">
                        @foreach($section->lessons as $lesson)
                            <div class="lesson-item">
                                <div class="lesson-left">
                                    <div class="lesson-icon {{ $lesson->type === 'quiz' ? 'lesson-icon-quiz' : 'lesson-icon-video' }}">
                                        <i class="fa-solid {{ $lesson->type === 'quiz' ? 'fa-question' : 'fa-play' }}"></i>
                                    </div>
                                    <span class="lesson-title">{{ $lesson->title }}</span>
                                    @if($lesson->type === 'quiz')
                                        <span class="lesson-preview-badge">Quiz</span>
                                    @elseif($lesson->is_free ?? false)
                                        <span class="lesson-preview-badge">Preview</span>
                                    @endif
                                </div>
                                <div class="lesson-right">
                                    @if($lesson->is_free ?? false)
                                        <button class="lesson-play-btn" type="button"><i class="fa-solid fa-play"></i></button>
                                    @else
                                        <span class="lesson-locked"><i class="fa-solid fa-lock"></i></span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- DESCRIPTION --}}
    <section class="content-section">
        <h2 class="section-title">About this <em>course</em></h2>
        <p class="section-desc">Course description</p>
        <div class="description-content">
            <p>{{ $course->description }}</p>
        </div>
    </section>

    {{-- INSTRUCTOR --}}
    @if($instructors->isNotEmpty())
<section class="content-section">
    <h2 class="section-title">Meet your <em>{{ $instructors->count() > 1 ? 'instructors' : 'instructor' }}</em></h2>
    <p class="section-desc">{{ $instructors->count() > 1 ? 'Learn from industry experts' : 'Learn from an industry expert' }}</p>

    @foreach($instructors as $inst)
    <div class="instructor-profile">
        <div class="instructor-header">
            <div class="instructor-avatar-xl" style="{{ $inst->photo_url ? 'padding:0;overflow:hidden;' : '' }}">
                @if($inst->photo_url)
                    <img src="{{ $inst->photo_url }}"
                         alt="Photo of {{ $inst->name }}"
                         style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;"
                         onerror="this.style.display='none';this.parentElement.innerHTML='{{ strtoupper(substr($inst->name, 0, 1)) }}';">
                @else
                    {{ strtoupper(substr($inst->name, 0, 1)) }}
                @endif
            </div>
            <div class="instructor-main-info">
                <h3 class="instructor-full-name">{{ $inst->name }}</h3>
                @php $instTitle = $inst->title ?? ($inst->headline ?? null); @endphp
                @if($instTitle)
                    <div class="instructor-profession">{{ $instTitle }}</div>
                @endif
            </div>
            @if($inst->institution_logo_url ?? false)
                <div class="instructor-university-card">
                    <div class="instructor-university-icon">
                        <img src="{{ $inst->institution_logo_url }}"
                             alt="Institution logo"
                             onerror="this.closest('.instructor-university-card').style.display='none';">
                    </div>
                    <span class="instructor-university-label">Institution</span>
                </div>
            @endif
        </div>
        @if($inst->bio ?? false)
            <div class="instructor-bio"><p>{{ $inst->bio }}</p></div>
        @endif
    </div>
    @endforeach
</section>
@endif

    {{-- REVIEWS --}}
    <section class="content-section">
        <h2 class="section-title">Student <em>reviews</em></h2>
        <p class="section-desc">What learners say about this course</p>

        <div class="reviews-summary">
            <div class="review-overall">
                <div class="overall-rating">
                    <span class="rating-value">
                        <em>{{ $avgRating ? number_format($avgRating, 1) : '—' }}</em>
                    </span>
                    <div class="rating-stars-big"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="rating-total">Based on {{ $reviewCount }} reviews</div>
                </div>
            </div>
            <div class="rating-distribution">
                @php
                    $distribution = [
                        ['stars' => 5, 'count' => $course->reviews->where('rating', 5)->count()],
                        ['stars' => 4, 'count' => $course->reviews->where('rating', 4)->count()],
                        ['stars' => 3, 'count' => $course->reviews->where('rating', 3)->count()],
                        ['stars' => 2, 'count' => $course->reviews->where('rating', 2)->count()],
                        ['stars' => 1, 'count' => $course->reviews->where('rating', 1)->count()],
                    ];
                @endphp
                @foreach($distribution as $row)
                    @php $pct = $reviewCount > 0 ? round($row['count'] / $reviewCount * 100) : 0; @endphp
                    <div class="dist-row">
                        <span class="dist-label">{{ $row['stars'] }} <i class="fa-solid fa-star"></i></span>
                        <div class="dist-bar">
                            <div class="dist-fill" style="width: {{ $pct }}%;"></div>
                        </div>
                        <span class="dist-percent">{{ $pct }}%</span>
                        <span class="dist-count">({{ $row['count'] }})</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="reviews-list">
            @forelse($course->reviews->take(5) as $review)
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-author">
                            <div class="review-avatar avatar-purple">
                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="review-author-info">
                                <div class="review-author-name">
                                    {{ $review->user->name ?? 'Anonymous' }}
                                    <span class="verified-badge" title="Verified"><i class="fa-solid fa-check"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="review-meta">
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review->rating ? 'filled' : '' }}"><i class="fa-solid fa-star"></i></span>
                                @endfor
                            </div>
                            <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="review-comment">"{{ $review->comment }}"</p>
                    @endif
                </div>
            @empty
                <p style="text-align:center; color:var(--muted); padding: 32px;">Belum ada review untuk kursus ini.</p>
            @endforelse
        </div>
    </section>

    {{-- CTA BANNER --}}
    <section class="cta-banner">
        <div class="cta-bg-decoration"></div>
        <div class="cta-content">
            <div class="cta-badge">
                <span class="cta-badge-dot"></span>
                <span>Start learning today</span>
            </div>

            <h2 class="cta-title">
                Ready to start learning <em>{{ $course->title }}</em>?
            </h2>
            <p class="cta-subtitle">
                Join {{ $course->enrollments_count ?? 0 }}+ students already enrolled.
            </p>

            <div class="cta-price">
                @if($course->isFree())
                    <span class="cta-price-now">Free</span>
                @else
                    <span class="cta-price-now">{{ $course->formatted_price }}</span>
                @endif
            </div>

            <div class="cta-buttons">
                @if($isEnrolled)
                    <a href="{{ route('student.learn', $course->slug) }}"
                       class="btn-cta-primary" style="text-decoration:none;">
                        <i class="fa-solid fa-play"></i> Continue Learning
                    </a>
                @elseif(auth()->check())
                    <a href="{{ route('courses.choose-path', $course) }}"
                       class="btn-cta-primary" style="text-decoration:none;">
                        <i class="fa-solid fa-route"></i> Enroll Now <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-cta-primary" style="text-decoration:none;">
                        Login to Enroll <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="cta-trust">
                <div class="cta-trust-item"><span class="cta-trust-icon"><i class="fa-solid fa-shield-halved"></i></span><span>30-day guarantee</span></div>
                <div class="cta-trust-item"><span class="cta-trust-icon"><i class="fa-solid fa-infinity"></i></span><span>Lifetime access</span></div>
                <div class="cta-trust-item"><span class="cta-trust-icon"><i class="fa-solid fa-trophy"></i></span><span>{{ $course->hasCertificatePrice() ? 'Verified certificate available' : 'Free course access' }}</span></div>
            </div>
        </div>
    </section>

    {{-- BENEFITS --}}
    <section class="benefits-section">
        <h2 class="benefits-title">The benefits of <em>Coursify</em> courses</h2>
        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fa-solid fa-circle-dollar-to-slot"></i></div>
                <h3 class="benefit-heading">Pay less, earn more</h3>
                <p class="benefit-desc">Programs dig deeper into your chosen subject and are offered at a special price.</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fa-solid fa-certificate"></i></div>
                <h3 class="benefit-heading">Earn certificates</h3>
                <p class="benefit-desc">When you're done, you'll have multiple certificates to add to your resume.</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fa-solid fa-laptop"></i></div>
                <h3 class="benefit-heading">Learn 100% online</h3>
                <p class="benefit-desc">Learn on your own schedule from anywhere in the world.</p>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="course-footer">
        <div class="footer-content">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
                <span class="logo-text">Coursify</span>
            </a>
            <div class="footer-links">
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('terms') }}">Terms</a>
                <a href="{{ route('privacy') }}">Privacy</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
            <div class="footer-copy">© {{ date('Y') }} Coursify · Supporting SDG 4 <i class="fa-solid fa-globe"></i></div>
        </div>
    </footer>

</div>

<script>
/* ── Adjust body padding ── */
function adjustBodyPadding() {
    var nb = document.getElementById('mainNavbar');
    if (nb) document.body.style.paddingTop = (nb.getBoundingClientRect().height + 4) + 'px';
}
adjustBodyPadding();
window.addEventListener('resize', adjustBodyPadding, { passive: true });

/* ── Mega Nav ── */
function toggleMega() {
    var menu = document.getElementById('mega-menu');
    menu.classList.contains('open') ? closeMega() : openMega();
}
function openMega() {
    document.getElementById('mega-menu').classList.add('open');
    document.getElementById('mega-btn').classList.add('active');
    document.getElementById('mega-overlay').classList.add('open');
    document.getElementById('mega-btn').setAttribute('aria-expanded','true');
}
function closeMega() {
    document.getElementById('mega-menu').classList.remove('open');
    document.getElementById('mega-btn').classList.remove('active');
    document.getElementById('mega-overlay').classList.remove('open');
    document.getElementById('mega-btn').setAttribute('aria-expanded','false');
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMega(); });

/* ── Alpine: navSearch component ── */
document.addEventListener('alpine:init', function() {
    Alpine.data('navSearch', function() {
        return {
            query: '',
            results: [],
            loading: false,
            open: false,
            focusIdx: -1,
            _timer: null,
            onInput(val) {
                this.query = val;
                this.focusIdx = -1;
                clearTimeout(this._timer);
                if (val.length < 2) { this.results = []; this.open = false; return; }
                this.loading = true;
                this.open = true;
                this._timer = setTimeout(() => this.fetchResults(val), 280);
            },
            async fetchResults(q) {
                try {
                    const res = await fetch(`/courses?search=${encodeURIComponent(q)}&format=json&per_page=6`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        // Support both {data:[...]} and plain array
                        const items = Array.isArray(data) ? data : (data.data ?? []);
                        this.results = items.slice(0, 6).map(c => ({
                            id: c.id,
                            title: c.title,
                            category: c.category?.name ?? '',
                            instructor: c.instructors?.[0]?.name ?? '',
                            thumbnail: c.thumbnail ?? null,
                            url: `/courses/${c.slug}`
                        }));
                    } else {
                        this.results = [];
                    }
                } catch(e) {
                    this.results = [];
                } finally {
                    this.loading = false;
                }
            },
            moveFocus(dir) {
                const max = this.results.length;
                if (max === 0) return;
                this.focusIdx = ((this.focusIdx + dir) + max) % max;
            },
            submitOrGo() {
                if (this.focusIdx >= 0 && this.results[this.focusIdx]) {
                    window.location.href = this.results[this.focusIdx].url;
                } else {
                    window.location.href = `/courses?search=${encodeURIComponent(this.query)}`;
                }
                this.open = false;
            }
        };
    });
});

window.addEventListener('pageshow', function(e) { if (e.persisted) window.location.reload(); });

(function() {
    const navbar = document.getElementById('mainNavbar');
    if (!navbar) return;
    let lastScroll = 0, ticking = false;
    function update() {
        const s = window.pageYOffset;
        navbar.classList.toggle('navbar-scrolled', s > 20);
        if (s < 100) { navbar.classList.remove('navbar-hidden'); }
        else if (s > lastScroll + 5) { navbar.classList.add('navbar-hidden'); }
        else if (s < lastScroll - 5) { navbar.classList.remove('navbar-hidden'); }
        lastScroll = s; ticking = false;
    }
    window.addEventListener('scroll', function() { if (!ticking) { requestAnimationFrame(update); ticking = true; } }, { passive: true });
})();

function toggleSection(btn) {
    btn.closest('.curriculum-section').classList.toggle('expanded');
}

function toggleAllSections() {
    const sections = document.querySelectorAll('.curriculum-section');
    const text = document.getElementById('toggleAllText');
    const allExpanded = Array.from(sections).every(s => s.classList.contains('expanded'));
    sections.forEach(s => s.classList.toggle('expanded', !allExpanded));
    text.textContent = allExpanded ? 'Expand all' : 'Collapse all';
}

function toggleWishlistBtn(btn, courseId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) {
        window.location.href = '/login';
        return;
    }

    btn.disabled = true;
    const wasActive = btn.classList.contains('active');

    fetch(`/wishlist/toggle/${courseId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    })
    .then(res => {
        if (res.status === 401) {
            return res.json().then(d => { window.location.href = d.redirect || '/login'; });
        }
        return res.json().then(data => {
            btn.disabled = false;
            const added = data.status === 'added';
            btn.classList.toggle('active', added);
            btn.innerHTML = added
                ? '<i class="fa-solid fa-heart" style="margin-right:6px;"></i> Tersimpan di Wishlist'
                : '<i class="fa-regular fa-heart" style="margin-right:6px;"></i> Simpan ke Wishlist';

            // Feedback singkat
            const orig = btn.innerHTML;
            btn.style.transition = 'transform 0.2s cubic-bezier(0.34,1.2,0.64,1)';
            btn.style.transform = 'scale(1.04)';
            setTimeout(() => { btn.style.transform = 'scale(1)'; }, 200);
        });
    })
    .catch(() => {
        btn.disabled = false;
        btn.classList.toggle('active', wasActive);
    });
}

document.querySelectorAll('.share-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (this.title === 'Copy link') {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const orig = this.textContent;
                this.innerHTML = '<i class="fa-solid fa-check"></i>';
                this.style.background = 'var(--teal)';
                this.style.color = 'white';
                setTimeout(() => { this.textContent = orig; this.style.background = ''; this.style.color = ''; }, 1500);
            });
        }
    });
});
</script>

</body>
</html>
