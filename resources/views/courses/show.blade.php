<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $course->title ?? 'Fullstack Web Development Laravel 12' }} — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
/* ═══════════════════════════════════════════════════════════ */
/* DESIGN TOKENS                                               */
/* ═══════════════════════════════════════════════════════════ */
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
    --red: #EF4444;
    --red-light: #FEE2E2;
    --text: #1A1825;
    --text-soft: #4A4660;
    --muted: #8B87A8;
    --border: rgba(30,58,95,0.08);
    --font-serif: 'Instrument Serif', serif;
    --font-sans: 'Inter', sans-serif;
}

/* ═══════════════════════════════════════════════════════════ */
/* RESET & GLOBAL                                              */
/* ═══════════════════════════════════════════════════════════ */
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

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

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 1;
}

/* Isolate sections to prevent overlap */
section {
    position: relative;
    z-index: 1;
}

/* ═══════════════════════════════════════════════════════════ */
/* NAVBAR                                                      */
/* ═══════════════════════════════════════════════════════════ */
.navbar-wrap {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 100;
    padding: 20px 20px 0;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.navbar-wrap.navbar-hidden {
    transform: translateY(-120%);
}

.navbar-wrap.navbar-scrolled .navbar {
    background: rgba(255,255,255,0.9);
    box-shadow: 0 10px 40px rgba(30,58,95,0.1);
}

.navbar {
    max-width: 900px;
    margin: 0 auto;
    background: rgba(255,255,255,0.65);
    backdrop-filter: blur(30px) saturate(180%);
    -webkit-backdrop-filter: blur(30px) saturate(180%);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    padding: 8px 8px 8px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 40px rgba(30,58,95,0.08);
    gap: 16px;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: var(--text);
    flex-shrink: 0;
}

.logo-img {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(30,58,95,0.2);
}

.logo-text {
    font-size: 17px;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.nav-links {
    display: flex;
    gap: 2px;
}

.nav-link {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-soft);
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 100px;
    transition: all 0.2s;
    white-space: nowrap;
}

.nav-link:hover {
    background: rgba(255,255,255,0.7);
    color: var(--text);
}

.nav-link.active {
    background: rgba(123,111,232,0.15);
    color: var(--purple-dark);
}

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
    white-space: nowrap;
    flex-shrink: 0;
}

.btn-nav:hover {
    background: #2A2840;
    transform: translateY(-1px);
}

/* ═══════════════════════════════════════════════════════════ */
/* BREADCRUMB                                                  */
/* ═══════════════════════════════════════════════════════════ */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 20px 0 20px;
    flex-wrap: wrap;
}

.breadcrumb a {
    font-size: 12px;
    color: var(--muted);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.breadcrumb a:hover { color: var(--purple); }

.breadcrumb-separator {
    color: var(--muted);
    font-size: 12px;
    opacity: 0.5;
}

.breadcrumb-current {
    font-size: 12px;
    color: var(--text);
    font-weight: 600;
}

/* ═══════════════════════════════════════════════════════════ */
/* HERO LAYOUT                                                 */
/* ═══════════════════════════════════════════════════════════ */
.hero-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 380px;
    gap: 32px;
    margin-bottom: 40px;
    align-items: start;
}

.hero-left {
    min-width: 0;
}

/* Course Badges */
.course-badges {
    display: flex;
    gap: 8px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.03em;
    white-space: nowrap;
}

.badge-bestseller {
    background: rgba(255,196,82,0.95);
    color: #5A3A00;
}

.badge-category {
    background: rgba(123,111,232,0.1);
    color: var(--purple-dark);
    border: 1px solid rgba(123,111,232,0.2);
}

.badge-level {
    background: rgba(255,255,255,0.7);
    color: var(--text-soft);
    border: 1px solid var(--border);
}

/* Course Title */
.course-title {
    font-family: var(--font-serif);
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-bottom: 18px;
    padding-bottom: 0.1em;
    color: var(--text);
    overflow: visible;
    word-wrap: break-word;
}

.course-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
    line-height: 1.2;
    padding-bottom: 0.15em;
    margin-top: 0.05em;
    overflow: visible;
}

.course-tagline {
    font-size: 17px;
    color: var(--text-soft);
    line-height: 1.6;
    margin-bottom: 24px;
    max-width: 640px;
}

/* Quick Stats */
.course-stats {
    display: flex;
    gap: 24px;
    padding: 18px 24px;
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.stat-item-sm {
    display: flex;
    flex-direction: column;
    gap: 3px;
    min-width: 0;
}

.stat-item-sm-val {
    display: flex;
    align-items: center;
    gap: 5px;
    font-family: var(--font-serif);
    font-size: 20px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    line-height: 1.1;
    padding-bottom: 2px;
}

.stat-item-sm-val em {
    font-style: italic;
    color: var(--gold);
    margin-right: 2px;
}

.stat-item-sm-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* Instructor Chip */
.instructor-chip {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 10px 18px 10px 10px;
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
}

.instructor-avatar-lg {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.instructor-info-sm {
    display: flex;
    flex-direction: column;
    gap: 1px;
    min-width: 0;
}

.instructor-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.instructor-name-sm {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text);
}

/* ═══════════════════════════════════════════════════════════ */
/* STICKY ENROLL CARD                                          */
/* ═══════════════════════════════════════════════════════════ */
.enroll-sidebar {
    position: sticky;
    top: 110px;
    min-width: 0;
}

.enroll-card {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(30px) saturate(180%);
    -webkit-backdrop-filter: blur(30px) saturate(180%);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(30,58,95,0.12);
}

.enroll-video {
    aspect-ratio: 16/10;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    position: relative;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.enroll-video::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 50%, rgba(184,175,235,0.2), transparent 70%);
}

.video-play-btn {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: rgba(255,255,255,0.95);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--navy);
    font-size: 22px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    transition: transform 0.3s;
    z-index: 2;
    padding-left: 4px;
}

.enroll-video:hover .video-play-btn {
    transform: scale(1.1);
}

.video-duration {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 4px 10px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 600;
    z-index: 2;
}

.preview-label {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    padding: 5px 12px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    color: var(--purple-dark);
    letter-spacing: 0.05em;
    text-transform: uppercase;
    z-index: 2;
}

.enroll-body {
    padding: 24px;
}

.price-block {
    margin-bottom: 18px;
    padding-bottom: 18px;
    border-bottom: 1px solid var(--border);
}

.price-main {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 8px;
    flex-wrap: wrap;
}

.price-now {
    font-family: var(--font-serif);
    font-size: 40px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
    color: var(--text);
}

.price-now.free { color: var(--teal); }

.price-old {
    font-size: 16px;
    color: var(--muted);
    text-decoration: line-through;
    font-weight: 500;
}

.price-discount {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    background: var(--orange-light);
    color: var(--orange);
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.02em;
}

.price-expiry {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--orange);
    margin-top: 8px;
    font-weight: 500;
}

/* Buttons */
.btn-enroll {
    width: 100%;
    padding: 15px;
    background: #1A1825;
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(26,24,37,0.3);
    margin-bottom: 10px;
    letter-spacing: -0.01em;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-enroll:hover {
    background: #2A2840;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26,24,37,0.4);
}

.btn-wishlist {
    width: 100%;
    padding: 13px;
    background: rgba(255,255,255,0.7);
    color: var(--text);
    border: 1.5px solid var(--border);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-wishlist:hover {
    background: white;
    border-color: var(--purple);
    color: var(--purple);
}

.btn-wishlist.active {
    background: #FFF0F5;
    border-color: #FF6B8A;
    color: #FF6B8A;
}

/* Guarantee */
.guarantee-box {
    padding: 12px 14px;
    background: linear-gradient(135deg, var(--teal-light), rgba(255,255,255,0.5));
    border: 1px solid rgba(0,200,150,0.15);
    border-radius: 12px;
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    align-items: center;
}

.guarantee-icon {
    width: 32px;
    height: 32px;
    background: var(--teal);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    flex-shrink: 0;
    font-weight: 700;
}

.guarantee-text {
    font-size: 11.5px;
    color: var(--text-soft);
    font-weight: 500;
    line-height: 1.45;
    min-width: 0;
}

.guarantee-text strong {
    color: var(--text);
    font-weight: 700;
}

/* Includes */
.includes-title {
    font-size: 11px;
    font-weight: 700;
    color: var(--text-soft);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.includes-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.includes-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: var(--text-soft);
    line-height: 1.4;
}

.includes-icon {
    width: 28px;
    height: 28px;
    background: var(--lav-1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--purple);
    font-size: 14px;
    flex-shrink: 0;
}

.includes-item strong {
    color: var(--text);
    font-weight: 600;
}

/* Share */
.share-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 18px;
    margin-top: 18px;
    border-top: 1px solid var(--border);
}

.share-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}

.share-icons {
    display: flex;
    gap: 6px;
}

.share-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--lav-1);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--text-soft);
    font-size: 13px;
    transition: all 0.2s;
    font-family: var(--font-sans);
}

.share-btn:hover {
    background: var(--purple);
    color: white;
    transform: translateY(-2px);
}

/* ═══════════════════════════════════════════════════════════ */
/* CONTENT SECTIONS                                            */
/* ═══════════════════════════════════════════════════════════ */
.content-section {
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    padding: 32px;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.section-title {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 400;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
    line-height: 1.2;
    padding-bottom: 0.05em;
}

.section-title em {
    font-style: italic;
    color: var(--purple);
    padding-bottom: 0.1em;
    display: inline-block;
}

.section-desc {
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 24px;
    line-height: 1.5;
}

/* ═══════════════════════════════════════════════════════════ */
/* WHAT YOU'LL LEARN                                           */
/* ═══════════════════════════════════════════════════════════ */
.learn-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px 20px;
}

.learn-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 14px;
    background: rgba(255,255,255,0.5);
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: all 0.2s;
    min-width: 0;
}

.learn-item:hover {
    background: white;
    border-color: var(--purple);
    transform: translateY(-2px);
}

.learn-check {
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, var(--teal), #00A075);
    border-radius: 50%;
    color: white;
    font-weight: 700;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}

.learn-text {
    font-size: 13.5px;
    color: var(--text-soft);
    line-height: 1.5;
    min-width: 0;
}

/* ═══════════════════════════════════════════════════════════ */
/* RESPONSIVE (Part 1)                                         */
/* ═══════════════════════════════════════════════════════════ */
@media (max-width: 1100px) {
    .hero-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .enroll-sidebar {
        position: static;
    }
}

@media (max-width: 640px) {
    .nav-links { display: none; }
    .course-stats { gap: 16px; padding: 14px 18px; }
    .learn-grid { grid-template-columns: 1fr; }
    .content-section { padding: 22px; }
    .breadcrumb { font-size: 11px; }
    .course-title { font-size: 30px; }
}

/* ═══════════════════════════════════════════════════════════ */
/* STYLES FROM MESSAGE 2                                       */
/* ═══════════════════════════════════════════════════════════ */

/* ═══ TWO COL GRID ═══ */
.two-col-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

/* ═══ CURRICULUM SECTION ═══ */
.curriculum-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
    gap: 20px;
    flex-wrap: wrap;
}

.curriculum-header > div {
    min-width: 0;
}

.btn-toggle-all {
    padding: 9px 18px;
    background: rgba(255,255,255,0.7);
    border: 1.5px solid var(--border);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 12px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
    flex-shrink: 0;
}

.btn-toggle-all:hover {
    border-color: var(--purple);
    color: var(--purple);
    background: white;
}

.curriculum-stats {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 10px;
    margin-bottom: 24px;
    padding: 16px 20px;
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
    border-radius: 14px;
}

.curr-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-width: 0;
    padding: 4px 6px;
    border-right: 1px solid rgba(30,58,95,0.08);
}

.curr-stat:last-child {
    border-right: none;
}

.curr-stat-num {
    font-family: var(--font-serif);
    font-size: 24px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 4px;
}

.curr-stat-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.curriculum-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.curriculum-section {
    background: rgba(255,255,255,0.5);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: border-color 0.2s;
}

.curriculum-section:hover {
    border-color: rgba(123,111,232,0.3);
}

.curriculum-section.expanded {
    border-color: var(--purple);
    background: rgba(255,255,255,0.7);
}

.section-header-btn {
    width: 100%;
    background: transparent;
    border: none;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    cursor: pointer;
    font-family: var(--font-sans);
    text-align: left;
    transition: background 0.2s;
}

.section-header-btn:hover {
    background: rgba(255,255,255,0.5);
}

.section-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex: 1;
    min-width: 0;
}

.section-icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: var(--lav-1);
    color: var(--purple);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 300;
    flex-shrink: 0;
    transition: all 0.3s;
    line-height: 1;
}

.curriculum-section.expanded .section-icon {
    background: var(--purple);
    color: white;
    transform: rotate(45deg);
}

.section-text {
    min-width: 0;
    flex: 1;
    overflow: hidden;
}

.section-number {
    font-size: 10px;
    font-weight: 700;
    color: var(--purple);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 2px;
}

.section-name {
    font-family: var(--font-serif);
    font-size: 17px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
}

.section-header-right {
    display: flex;
    gap: 14px;
    font-size: 12px;
    color: var(--muted);
    flex-shrink: 0;
    align-items: center;
}

.section-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-weight: 500;
    white-space: nowrap;
}

/* Lessons inside expanded section */
.section-lessons {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease;
}

.curriculum-section.expanded .section-lessons {
    max-height: 1000px;
    border-top: 1px solid var(--border);
}

.lesson-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px 12px 48px;
    border-bottom: 1px solid var(--border);
    transition: background 0.2s;
    gap: 12px;
    flex-wrap: wrap;
}

.lesson-item:last-child {
    border-bottom: none;
}

.lesson-item:hover {
    background: rgba(255,255,255,0.5);
}

.lesson-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
}

.lesson-icon {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    flex-shrink: 0;
    font-weight: 700;
    line-height: 1;
}

.lesson-icon-video {
    background: rgba(123,111,232,0.15);
    color: var(--purple);
}

.lesson-icon-article {
    background: var(--teal-light);
    color: #00805F;
}

.lesson-icon-quiz {
    background: var(--orange-light);
    color: var(--orange);
}

.lesson-icon-download {
    background: var(--gold-light);
    color: #8B6914;
}

.lesson-title {
    font-size: 13px;
    color: var(--text-soft);
    font-weight: 500;
    line-height: 1.4;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
}

.lesson-preview-badge {
    font-size: 9px;
    font-weight: 700;
    padding: 2px 8px;
    background: var(--teal-light);
    color: #00805F;
    border-radius: 100px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    flex-shrink: 0;
}

.lesson-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

.lesson-play-btn {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: none;
    background: var(--teal);
    color: white;
    cursor: pointer;
    font-size: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-left: 2px;
    transition: all 0.2s;
}

.lesson-play-btn:hover {
    transform: scale(1.1);
    background: #00A075;
}

.lesson-locked {
    color: var(--muted);
    font-size: 13px;
    opacity: 0.5;
}

.lesson-duration {
    font-size: 11px;
    color: var(--muted);
    font-weight: 600;
    font-family: var(--font-sans);
    min-width: 50px;
    text-align: right;
    white-space: nowrap;
}

/* ═══ REQUIREMENTS ═══ */
.requirements-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 0;
}

.requirement-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    background: rgba(255,255,255,0.5);
    border: 1px solid var(--border);
    border-radius: 12px;
    font-size: 13.5px;
    color: var(--text-soft);
    line-height: 1.5;
    transition: all 0.2s;
    min-width: 0;
}

.requirement-item:hover {
    background: white;
    border-color: var(--purple);
}

.requirement-item strong {
    color: var(--text);
    font-weight: 600;
}

.req-bullet {
    color: var(--purple);
    font-size: 24px;
    line-height: 1;
    flex-shrink: 0;
    font-weight: 900;
    margin-top: -2px;
}

.requirement-item > div:last-child {
    min-width: 0;
    flex: 1;
}

/* ═══ AUDIENCE ═══ */
.audience-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 0;
}

.audience-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: rgba(255,255,255,0.5);
    border: 1px solid var(--border);
    border-radius: 12px;
    font-size: 13.5px;
    color: var(--text-soft);
    line-height: 1.5;
    transition: all 0.2s;
    min-width: 0;
}

.audience-item:hover {
    background: white;
    border-color: var(--purple);
    transform: translateX(4px);
}

.audience-item strong {
    color: var(--text);
    font-weight: 600;
}

.audience-item > div:last-child {
    min-width: 0;
    flex: 1;
}

.aud-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.aud-icon-1 { background: var(--lav-1); }
.aud-icon-2 { background: var(--teal-light); }
.aud-icon-3 { background: var(--orange-light); }
.aud-icon-4 { background: var(--gold-light); }
.aud-icon-5 { background: rgba(245,87,108,0.15); }

/* ═══ DESCRIPTION ═══ */
.description-content {
    font-size: 14.5px;
    line-height: 1.75;
    color: var(--text-soft);
}

.description-content p {
    margin-bottom: 16px;
}

.description-content p:last-child {
    margin-bottom: 0;
}

.description-content strong {
    color: var(--text);
    font-weight: 600;
}

.description-content em {
    color: var(--purple);
    font-style: italic;
    font-weight: 500;
}

.desc-subheading {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    margin-top: 28px;
    margin-bottom: 12px;
    padding-bottom: 0.05em;
}

.desc-list {
    list-style: none;
    margin: 12px 0 20px;
    padding-left: 0;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.desc-list li {
    padding: 6px 0;
    color: var(--text-soft);
    font-size: 14px;
}

.desc-quote {
    margin: 28px 0 12px;
    padding: 24px 28px 24px 54px;
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
    border-left: 4px solid var(--purple);
    border-radius: 14px;
    font-family: var(--font-serif);
    font-size: 18px;
    font-style: italic;
    color: var(--text);
    line-height: 1.6;
    position: relative;
}

.quote-mark {
    font-family: var(--font-serif);
    font-size: 72px;
    color: var(--purple);
    line-height: 0;
    position: absolute;
    top: 40px;
    left: 14px;
    opacity: 0.25;
    font-style: normal;
}

.desc-quote cite {
    display: block;
    font-family: var(--font-sans);
    font-size: 13px;
    font-style: normal;
    color: var(--muted);
    font-weight: 600;
    margin-top: 14px;
    letter-spacing: 0.02em;
}

/* ═══ INSTRUCTOR PROFILE ═══ */
.instructor-profile {
    background: rgba(255,255,255,0.5);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 28px;
}

.instructor-header {
    display: flex;
    gap: 24px;
    margin-bottom: 28px;
    flex-wrap: wrap;
    align-items: flex-start;
}

.instructor-avatar-xl {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white;
    font-size: 40px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 10px 30px rgba(30,58,95,0.25);
}

.instructor-main-info {
    flex: 1;
    min-width: 0;
}

.instructor-full-name {
    font-family: var(--font-serif);
    font-size: 32px;
    font-weight: 400;
    letter-spacing: -0.02em;
    margin-bottom: 4px;
    line-height: 1.1;
    padding-bottom: 0.05em;
}

.instructor-headline {
    font-size: 14px;
    color: var(--text-soft);
    font-weight: 500;
    margin-bottom: 14px;
}

.instructor-badges {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.inst-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 11px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.02em;
    white-space: nowrap;
}

.inst-badge-verified {
    background: var(--teal-light);
    color: #00805F;
}

.inst-badge-top {
    background: var(--gold-light);
    color: #8B6914;
}

.inst-badge-exp {
    background: rgba(123,111,232,0.1);
    color: var(--purple-dark);
}

.instructor-social {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}

.inst-social {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: var(--text-soft);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
    white-space: nowrap;
}

.inst-social:hover {
    color: var(--purple);
}

/* Instructor Stats Grid */
.instructor-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 28px;
}

.inst-stat-card {
    text-align: center;
    padding: 18px 14px;
    background: rgba(255,255,255,0.7);
    border: 1px solid var(--border);
    border-radius: 14px;
    transition: all 0.2s;
    min-width: 0;
}

.inst-stat-card:hover {
    transform: translateY(-3px);
    border-color: var(--purple);
    box-shadow: 0 8px 20px rgba(30,58,95,0.08);
}

.inst-stat-icon {
    font-size: 22px;
    margin-bottom: 6px;
    line-height: 1;
}

.inst-stat-val {
    font-family: var(--font-serif);
    font-size: 24px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 4px;
}

.inst-stat-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* Bio */
.instructor-bio {
    background: rgba(255,255,255,0.7);
    border-radius: 14px;
    padding: 24px;
    font-size: 14.5px;
    line-height: 1.75;
    color: var(--text-soft);
    margin-bottom: 20px;
}

.instructor-bio p {
    margin-bottom: 14px;
}

.instructor-bio p:last-child {
    margin-bottom: 0;
}

.instructor-bio strong {
    color: var(--text);
    font-weight: 600;
}

.instructor-bio em {
    color: var(--purple);
    font-style: italic;
    font-weight: 500;
}

.inst-expertise {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}

.inst-expertise-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--text-soft);
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.inst-expertise-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.inst-tag {
    padding: 5px 12px;
    background: var(--lav-1);
    color: var(--purple-dark);
    border-radius: 100px;
    font-size: 11.5px;
    font-weight: 600;
    border: 1px solid rgba(123,111,232,0.15);
    transition: all 0.2s;
    cursor: pointer;
    white-space: nowrap;
}

.inst-tag:hover {
    background: var(--purple);
    color: white;
    transform: translateY(-2px);
}

.btn-view-profile {
    width: 100%;
    padding: 13px;
    background: rgba(255,255,255,0.7);
    border: 1.5px solid var(--border);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-view-profile:hover {
    background: white;
    border-color: var(--purple);
    color: var(--purple);
    transform: translateY(-2px);
}

/* ═══ RESPONSIVE MESSAGE 2 ═══ */
@media (max-width: 900px) {
    .two-col-grid {
        grid-template-columns: 1fr;
    }
    .curriculum-stats {
        grid-template-columns: repeat(3, 1fr);
    }
    .curr-stat:nth-child(3) {
        border-right: none;
    }
    .instructor-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .section-header-right {
        flex-direction: column;
        gap: 4px;
        align-items: flex-end;
    }
}

@media (max-width: 640px) {
    .curriculum-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    .curr-stat:nth-child(2) {
        border-right: none;
    }
    .section-header-right {
        display: none;
    }
    .lesson-item {
        padding: 10px 16px 10px 40px;
    }
    .lesson-duration {
        min-width: auto;
    }
}

/* ═══════════════════════════════════════════════════════════ */
/* STYLES FROM MESSAGE 3 (FINAL)                              */
/* ═══════════════════════════════════════════════════════════ */

/* ═══ REVIEWS SUMMARY ═══ */
.reviews-summary {
    display: grid;
    grid-template-columns: 300px minmax(0, 1fr);
    gap: 32px;
    padding: 28px;
    background: rgba(255,255,255,0.5);
    border: 1px solid var(--border);
    border-radius: 16px;
    margin-bottom: 28px;
    align-items: center;
}

.review-overall {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: linear-gradient(135deg, var(--gold-light), rgba(255,255,255,0.5));
    border-radius: 14px;
    text-align: center;
}

.overall-rating {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}

.rating-value {
    font-family: var(--font-serif);
    font-size: 72px;
    font-weight: 400;
    line-height: 1;
    color: var(--text);
    letter-spacing: -0.03em;
    padding-bottom: 0.05em;
}

.rating-value em {
    font-style: italic;
    color: var(--gold);
}

.rating-stars-big {
    color: var(--gold);
    font-size: 26px;
    letter-spacing: 4px;
    text-shadow: 0 2px 8px rgba(255,196,82,0.3);
    line-height: 1;
}

.rating-total {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
    margin-top: 4px;
}

.rating-distribution {
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
    min-width: 0;
}

.dist-row {
    display: grid;
    grid-template-columns: 30px minmax(0, 1fr) 48px 60px;
    gap: 12px;
    align-items: center;
    font-size: 12px;
}

.dist-label {
    color: var(--gold);
    font-weight: 700;
    font-size: 13px;
    white-space: nowrap;
}

.dist-bar {
    height: 8px;
    background: var(--lav-2);
    border-radius: 100px;
    overflow: hidden;
    min-width: 0;
}

.dist-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--gold), #FFD700);
    border-radius: 100px;
    transition: width 0.8s ease;
}

.dist-percent {
    color: var(--text);
    font-weight: 600;
    text-align: right;
    white-space: nowrap;
}

.dist-count {
    color: var(--muted);
    font-weight: 500;
    text-align: left;
    white-space: nowrap;
}

/* ═══ REVIEWS FILTER ═══ */
.reviews-filter {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    gap: 16px;
    flex-wrap: wrap;
}

.filter-pills {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.filter-pill {
    padding: 7px 14px;
    border: 1.5px solid var(--border);
    background: rgba(255,255,255,0.6);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 12px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.filter-pill:hover {
    border-color: var(--purple);
    color: var(--purple);
}

.filter-pill.active {
    background: var(--text);
    border-color: var(--text);
    color: white;
}

.reviews-sort {
    padding: 8px 14px;
    border: 1.5px solid var(--border);
    background: white;
    border-radius: 10px;
    font-family: var(--font-sans);
    font-size: 12px;
    font-weight: 500;
    color: var(--text);
    cursor: pointer;
    outline: none;
    min-width: 0;
}

.reviews-sort:focus {
    border-color: var(--purple);
}

/* ═══ REVIEW CARDS ═══ */
.reviews-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 20px;
}

.review-card {
    background: rgba(255,255,255,0.7);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 22px;
    position: relative;
    transition: all 0.2s;
}

.review-card:hover {
    border-color: rgba(123,111,232,0.3);
    box-shadow: 0 8px 24px rgba(30,58,95,0.06);
}

.review-highlight {
    border: 2px solid var(--gold);
    background: linear-gradient(135deg, var(--gold-light), rgba(255,255,255,0.7));
    margin-top: 12px;
}

.review-badge-pick {
    position: absolute;
    top: -10px;
    left: 20px;
    background: var(--gold);
    color: #5A3A00;
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 12px rgba(255,196,82,0.3);
    z-index: 2;
    white-space: nowrap;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 14px;
    gap: 16px;
    flex-wrap: wrap;
}

.review-author {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
    flex: 1;
}

.review-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    color: white;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.avatar-purple { background: linear-gradient(135deg, var(--purple), var(--purple-dark)); }
.avatar-teal { background: linear-gradient(135deg, var(--teal), #00A075); }
.avatar-orange { background: linear-gradient(135deg, var(--orange), #E66B3A); }
.avatar-gold { background: linear-gradient(135deg, var(--gold), #D19E2E); }

.review-author-info {
    min-width: 0;
    flex: 1;
}

.review-author-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.verified-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 16px;
    height: 16px;
    background: var(--teal);
    color: white;
    border-radius: 50%;
    font-size: 9px;
    font-weight: 700;
    flex-shrink: 0;
}

.review-author-role {
    font-size: 12px;
    color: var(--muted);
    margin-top: 2px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.review-meta {
    text-align: right;
    flex-shrink: 0;
}

.review-stars {
    display: flex;
    gap: 2px;
    margin-bottom: 4px;
    justify-content: flex-end;
}

.review-stars .star {
    font-size: 16px;
    color: var(--lav-3);
    line-height: 1;
}

.review-stars .star.filled {
    color: var(--gold);
}

.review-date {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}

.review-comment {
    font-family: var(--font-serif);
    font-size: 16px;
    line-height: 1.6;
    color: var(--text);
    margin-bottom: 16px;
    letter-spacing: -0.005em;
    font-style: italic;
}

.review-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 14px;
    border-top: 1px solid var(--border);
    gap: 10px;
    flex-wrap: wrap;
}

.review-helpful {
    font-size: 12px;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-helpful, .btn-helpful-no {
    padding: 5px 12px;
    background: var(--lav-1);
    border: 1px solid var(--border);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 11px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-helpful:hover, .btn-helpful-no:hover {
    background: var(--lav-2);
    color: var(--purple);
}

.btn-helpful.active {
    background: var(--teal);
    border-color: var(--teal);
    color: white;
}

.btn-helpful-no.active {
    background: var(--orange);
    border-color: var(--orange);
    color: white;
}

.btn-report {
    background: none;
    border: none;
    font-size: 11px;
    color: var(--muted);
    cursor: pointer;
    font-weight: 500;
    transition: color 0.2s;
    padding: 4px 8px;
}

.btn-report:hover { color: var(--orange); }

.reviews-load-more {
    text-align: center;
    padding-top: 16px;
}

.btn-load-more {
    padding: 12px 32px;
    background: rgba(255,255,255,0.7);
    border: 1.5px solid var(--border);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-load-more:hover {
    background: white;
    border-color: var(--purple);
    color: var(--purple);
    transform: translateY(-2px);
}

/* ═══ RELATED COURSES ═══ */
.related-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}

.related-card {
    background: rgba(255,255,255,0.7);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    text-decoration: none;
    color: var(--text);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.related-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(30,58,95,0.1);
    border-color: var(--purple);
}

.related-thumb {
    aspect-ratio: 16/10;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
}

.course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
.course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
.course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }
.course-thumb-4 { background: linear-gradient(135deg, #FA709A, #FEE140); }
.course-thumb-5 { background: linear-gradient(135deg, #30CFD0, #330867); }
.course-thumb-6 { background: linear-gradient(135deg, #A8EDEA, #FED6E3); }

.related-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 3px 10px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    white-space: nowrap;
}

.related-badge.badge-bestseller { background: rgba(255,196,82,0.95); color: #5A3A00; }
.related-badge.badge-free { background: rgba(0,200,150,0.95); color: white; }

.related-body {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.related-category {
    font-size: 10px;
    color: var(--muted);
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.related-title {
    font-family: var(--font-serif);
    font-size: 16px;
    font-weight: 400;
    line-height: 1.3;
    letter-spacing: -0.01em;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 42px;
}

.related-instructor {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: var(--text-soft);
    margin-bottom: 10px;
    overflow: hidden;
}

.related-avatar {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white;
    font-size: 9px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.related-meta {
    display: flex;
    gap: 10px;
    font-size: 10px;
    color: var(--muted);
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
    flex-wrap: wrap;
}

.related-meta span {
    white-space: nowrap;
}

.related-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.related-price {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    letter-spacing: -0.01em;
    color: var(--text);
    line-height: 1;
}

.related-price.price-free { color: var(--teal); }

.related-arrow {
    color: var(--purple);
    font-size: 16px;
    transition: transform 0.3s;
}

.related-card:hover .related-arrow {
    transform: translateX(4px);
}

/* ═══ CTA BANNER ═══ */
.cta-banner {
    background: linear-gradient(135deg, var(--navy) 0%, #1E4A7A 50%, #2D4D7A 100%);
    border-radius: 32px;
    padding: 60px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
    margin-bottom: 40px;
    color: white;
}

.cta-bg-decoration {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 20% 20%, rgba(184,175,235,0.3), transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(0,200,150,0.2), transparent 50%);
    pointer-events: none;
}

.cta-content {
    position: relative;
    z-index: 1;
    max-width: 640px;
    margin: 0 auto;
}

.cta-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.25);
    padding: 6px 14px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 600;
    color: var(--lav-4);
    margin-bottom: 18px;
    letter-spacing: 0.05em;
}

.cta-badge-dot {
    width: 6px;
    height: 6px;
    background: var(--orange);
    border-radius: 50%;
    animation: pulseCta 1.5s infinite;
}

@keyframes pulseCta {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.3); }
}

.cta-title {
    font-family: var(--font-serif);
    font-size: clamp(32px, 4.5vw, 48px);
    font-weight: 400;
    line-height: 1.15;
    letter-spacing: -0.02em;
    margin-bottom: 14px;
    color: white;
    padding-bottom: 0.1em;
    overflow: visible;
}

.cta-title em {
    font-style: italic;
    color: var(--lav-4);
    padding-bottom: 0.15em;
    display: inline-block;
    margin-top: 0.05em;
    overflow: visible;
}

.cta-subtitle {
    font-size: 15px;
    color: rgba(255,255,255,0.75);
    line-height: 1.6;
    margin-bottom: 24px;
    max-width: 480px;
    margin-left: auto;
    margin-right: auto;
}

.cta-price {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.cta-price-now {
    font-family: var(--font-serif);
    font-size: 44px;
    font-weight: 400;
    letter-spacing: -0.02em;
    color: white;
    line-height: 1;
}

.cta-price-old {
    font-size: 20px;
    color: rgba(255,255,255,0.5);
    text-decoration: line-through;
    font-weight: 500;
}

.cta-price-discount {
    padding: 5px 14px;
    background: rgba(255,138,91,0.9);
    color: white;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.05em;
    white-space: nowrap;
}

.cta-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 28px;
}

.btn-cta-primary {
    padding: 15px 32px;
    background: white;
    color: var(--navy);
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 8px 24px rgba(255,255,255,0.2);
    letter-spacing: -0.01em;
    white-space: nowrap;
}

.btn-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(255,255,255,0.3);
}

.btn-cta-ghost {
    padding: 15px 28px;
    background: rgba(255,255,255,0.1);
    color: white;
    border: 1.5px solid rgba(255,255,255,0.2);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    backdrop-filter: blur(10px);
    white-space: nowrap;
}

.btn-cta-ghost:hover {
    background: rgba(255,255,255,0.2);
    transform: translateY(-2px);
}

.cta-trust {
    display: flex;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.15);
}

.cta-trust-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: rgba(255,255,255,0.8);
    font-weight: 500;
    white-space: nowrap;
}

.cta-trust-icon {
    font-size: 16px;
}

/* ═══ FOOTER ═══ */
.course-footer {
    padding: 30px 0 20px;
    border-top: 1px solid var(--border);
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.footer-content .logo {
    gap: 8px;
}

.footer-content .logo-img {
    width: 28px;
    height: 28px;
}

.footer-content .logo-text {
    font-size: 15px;
}

.footer-links {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
}

.footer-links a {
    font-size: 12px;
    color: var(--muted);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
    white-space: nowrap;
}

.footer-links a:hover { color: var(--purple); }

.footer-copy {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
    white-space: nowrap;
}

/* ═══ RESPONSIVE MESSAGE 3 ═══ */
@media (max-width: 900px) {
    .reviews-summary {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .related-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .review-meta {
        text-align: left;
    }
    .review-stars {
        justify-content: flex-start;
    }
}

@media (max-width: 640px) {
    .related-grid {
        grid-template-columns: 1fr;
    }
    .cta-banner {
        padding: 40px 24px;
    }
    .footer-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .dist-row {
        grid-template-columns: 24px minmax(0, 1fr) 38px 50px;
        gap: 8px;
        font-size: 11px;
    }
    .rating-value {
        font-size: 56px;
    }
    .cta-price-now {
        font-size: 36px;
    }
    .cta-trust {
        gap: 16px;
    }
}
</style>
</head>
<body>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- NAVBAR                                                      --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<nav class="navbar-wrap" id="mainNavbar">
    <div class="navbar">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
            <span class="logo-text">Coursify</span>
        </a>
        <div class="nav-links">
            <a href="{{ route('courses.index') }}" class="nav-link active">Courses</a>
            <a href="{{ route('home') }}#how" class="nav-link">How It Works</a>
            <a href="{{ route('home') }}#pricing" class="nav-link">Pricing</a>
        </div>
        @guest
            <a href="{{ route('login') }}" class="btn-nav">Get Started</a>
        @else
            <a href="{{ route('student.index') }}" class="btn-nav">Dashboard</a>
        @endguest
    </div>
</nav>

<div class="container">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('courses.index') }}">Courses</a>
        <span class="breadcrumb-separator">/</span>
        <a href="#">Programming</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Laravel Fullstack</span>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- HERO GRID                                                   --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="hero-grid">

        {{-- LEFT: Course Info --}}
        <div class="hero-left">
            <div class="course-badges">
                <span class="hero-badge badge-bestseller">⭐ Bestseller</span>
                <span class="hero-badge badge-category">💻 Programming</span>
                <span class="hero-badge badge-level">🔥 Intermediate</span>
            </div>

            <h1 class="course-title">
                Fullstack Web Development with <em>Laravel 12</em>
            </h1>

            <p class="course-tagline">
                Master modern web development using Laravel 12, MySQL, and TailwindCSS. Build real-world applications from scratch with industry best practices.
            </p>

            <div class="course-stats">
                <div class="stat-item-sm">
                    <div class="stat-item-sm-val">
                        <em>⭐</em> 4.9
                    </div>
                    <div class="stat-item-sm-label">(1,284 reviews)</div>
                </div>
                <div class="stat-item-sm">
                    <div class="stat-item-sm-val">👥 12,301</div>
                    <div class="stat-item-sm-label">Students</div>
                </div>
                <div class="stat-item-sm">
                    <div class="stat-item-sm-val">🕐 40 hrs</div>
                    <div class="stat-item-sm-label">Total Hours</div>
                </div>
                <div class="stat-item-sm">
                    <div class="stat-item-sm-val">📚 124</div>
                    <div class="stat-item-sm-label">Lessons</div>
                </div>
                <div class="stat-item-sm">
                    <div class="stat-item-sm-val">🌍 ID</div>
                    <div class="stat-item-sm-label">Language</div>
                </div>
            </div>

            <div class="instructor-chip">
                <div class="instructor-avatar-lg">B</div>
                <div class="instructor-info-sm">
                    <span class="instructor-label">Created by</span>
                    <span class="instructor-name-sm">Budi Santoso · Senior Dev @ Tokopedia</span>
                </div>
            </div>
        </div>

        {{-- RIGHT: Sticky Enroll Card --}}
        <aside class="enroll-sidebar">
            <div class="enroll-card">
                <div class="enroll-video">
                    <span class="preview-label">Preview</span>
                    <div class="video-play-btn">▶</div>
                    <span class="video-duration">3:42</span>
                </div>

                <div class="enroll-body">
                    <div class="price-block">
                        <div class="price-main">
                            <span class="price-now">Rp 299K</span>
                            <span class="price-old">Rp 599K</span>
                        </div>
                        <div>
                            <span class="price-discount">🔥 50% OFF</span>
                        </div>
                        <div class="price-expiry">
                            ⏰ Offer ends in 2 days
                        </div>
                    </div>

                    <button class="btn-enroll">
                        Enroll Now
                    </button>
                    <button class="btn-wishlist" onclick="toggleWishlistBtn(this)">
                        🤍 Add to Wishlist
                    </button>

                    <div class="guarantee-box">
                        <div class="guarantee-icon">✓</div>
                        <div class="guarantee-text">
                            <strong>30-day money-back guarantee.</strong> Full refund, no questions asked.
                        </div>
                    </div>

                    <div class="includes-title">This course includes</div>
                    <ul class="includes-list">
                        <li class="includes-item">
                            <div class="includes-icon">🎬</div>
                            <span><strong>40 hours</strong> on-demand video</span>
                        </li>
                        <li class="includes-item">
                            <div class="includes-icon">📝</div>
                            <span><strong>24 articles</strong> and resources</span>
                        </li>
                        <li class="includes-item">
                            <div class="includes-icon">💾</div>
                            <span><strong>18 downloadable</strong> files</span>
                        </li>
                        <li class="includes-item">
                            <div class="includes-icon">📱</div>
                            <span>Access on <strong>mobile & TV</strong></span>
                        </li>
                        <li class="includes-item">
                            <div class="includes-icon">♾️</div>
                            <span><strong>Lifetime</strong> access</span>
                        </li>
                        <li class="includes-item">
                            <div class="includes-icon">🏆</div>
                            <span><strong>Certificate</strong> of completion</span>
                        </li>
                    </ul>

                    <div class="share-row">
                        <span class="share-label">Share this course</span>
                        <div class="share-icons">
                            <button class="share-btn" title="Twitter">𝕏</button>
                            <button class="share-btn" title="Facebook">f</button>
                            <button class="share-btn" title="LinkedIn">in</button>
                            <button class="share-btn" title="Copy link">🔗</button>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- WHAT YOU'LL LEARN                                           --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="content-section">
        <h2 class="section-title">What you'll <em>learn</em></h2>
        <p class="section-desc">Master these skills and apply them to real-world projects.</p>

        <div class="learn-grid">
            @php
                $learnItems = [
                    'Build production-ready web applications with Laravel 12',
                    'Master MVC architecture and RESTful API design',
                    'Implement authentication, authorization, and user roles',
                    'Design databases with migrations and Eloquent ORM',
                    'Create responsive UIs with Blade templates and TailwindCSS',
                    'Deploy applications to production servers (VPS, Railway)',
                    'Write clean, testable code with modern PHP 8.2+ features',
                    'Integrate payment gateways (Midtrans, Stripe)',
                    'Build real-time features with Livewire and Alpine.js',
                    'Optimize performance with caching and queues',
                ];
            @endphp

            @foreach($learnItems as $item)
                <div class="learn-item">
                    <div class="learn-check">✓</div>
                    <div class="learn-text">{{ $item }}</div>
                </div>
            @endforeach
        </div>
    </section>

    
    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- CURRICULUM                                                  --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="content-section">
        <div class="curriculum-header">
            <div>
                <h2 class="section-title">Course <em>curriculum</em></h2>
                <p class="section-desc">12 sections · 124 lessons · 40h total length</p>
            </div>
            <button class="btn-toggle-all" onclick="toggleAllSections()">
                <span id="toggleAllText">Expand all</span>
            </button>
        </div>

        <div class="curriculum-stats">
            <div class="curr-stat">
                <span class="curr-stat-num">12</span>
                <span class="curr-stat-label">Sections</span>
            </div>
            <div class="curr-stat">
                <span class="curr-stat-num">124</span>
                <span class="curr-stat-label">Lessons</span>
            </div>
            <div class="curr-stat">
                <span class="curr-stat-num">40h</span>
                <span class="curr-stat-label">Duration</span>
            </div>
            <div class="curr-stat">
                <span class="curr-stat-num">8</span>
                <span class="curr-stat-label">Quizzes</span>
            </div>
            <div class="curr-stat">
                <span class="curr-stat-num">5</span>
                <span class="curr-stat-label">Projects</span>
            </div>
        </div>

        <div class="curriculum-list">
            @php
                $sections = [
                    [
                        'title' => 'Getting Started with Laravel 12',
                        'lessons' => 8, 'duration' => '2h 15m', 'expanded' => true,
                        'items' => [
                            ['type' => 'video', 'title' => 'Welcome & Course Introduction', 'duration' => '5:32', 'free' => true],
                            ['type' => 'video', 'title' => 'What\'s New in Laravel 12', 'duration' => '12:14', 'free' => true],
                            ['type' => 'video', 'title' => 'Setting Up Development Environment', 'duration' => '18:45', 'free' => false],
                            ['type' => 'article', 'title' => 'Project Structure Deep Dive', 'duration' => '10 min', 'free' => false],
                            ['type' => 'video', 'title' => 'Your First Laravel Application', 'duration' => '22:30', 'free' => false],
                            ['type' => 'video', 'title' => 'Understanding Artisan CLI', 'duration' => '15:20', 'free' => false],
                            ['type' => 'quiz', 'title' => 'Section 1 Quiz', 'duration' => '10 Q', 'free' => false],
                            ['type' => 'download', 'title' => 'Starter Files & Resources', 'duration' => 'ZIP', 'free' => false],
                        ]
                    ],
                    ['title' => 'Routing, Controllers & Middleware', 'lessons' => 12, 'duration' => '3h 45m'],
                    ['title' => 'Database Design & Eloquent ORM', 'lessons' => 15, 'duration' => '5h 20m'],
                    ['title' => 'Authentication & Authorization', 'lessons' => 10, 'duration' => '3h 30m'],
                    ['title' => 'Building RESTful APIs', 'lessons' => 14, 'duration' => '4h 50m'],
                    ['title' => 'Frontend with Blade & TailwindCSS', 'lessons' => 16, 'duration' => '5h 10m'],
                    ['title' => 'Advanced: Queues, Events & Jobs', 'lessons' => 9, 'duration' => '3h 20m'],
                    ['title' => 'Testing Your Application', 'lessons' => 11, 'duration' => '3h 45m'],
                    ['title' => 'Deployment & DevOps', 'lessons' => 13, 'duration' => '4h 35m'],
                    ['title' => 'Final Project: E-Commerce Platform', 'lessons' => 16, 'duration' => '4h 50m'],
                ];
            @endphp

            @foreach($sections as $index => $section)
                <div class="curriculum-section {{ ($section['expanded'] ?? false) ? 'expanded' : '' }}">
                    <button class="section-header-btn" onclick="toggleSection(this)" type="button">
                        <div class="section-header-left">
                            <div class="section-icon">+</div>
                            <div class="section-text">
                                <div class="section-number">Section {{ $index + 1 }}</div>
                                <div class="section-name">{{ $section['title'] }}</div>
                            </div>
                        </div>
                        <div class="section-header-right">
                            <span class="section-meta-item">📚 {{ $section['lessons'] }} lessons</span>
                            <span class="section-meta-item">⏱ {{ $section['duration'] }}</span>
                        </div>
                    </button>

                    @if(!empty($section['items']))
                        <div class="section-lessons">
                            @foreach($section['items'] as $lesson)
                                <div class="lesson-item">
                                    <div class="lesson-left">
                                        <div class="lesson-icon lesson-icon-{{ $lesson['type'] }}">
                                            @if($lesson['type'] === 'video') ▶
                                            @elseif($lesson['type'] === 'article') 📄
                                            @elseif($lesson['type'] === 'quiz') 📝
                                            @elseif($lesson['type'] === 'download') ⬇
                                            @endif
                                        </div>
                                        <span class="lesson-title">{{ $lesson['title'] }}</span>
                                        @if($lesson['free'])
                                            <span class="lesson-preview-badge">Preview</span>
                                        @endif
                                    </div>
                                    <div class="lesson-right">
                                        @if($lesson['free'])
                                            <button class="lesson-play-btn" title="Watch preview" type="button">▶</button>
                                        @else
                                            <span class="lesson-locked">🔒</span>
                                        @endif
                                        <span class="lesson-duration">{{ $lesson['duration'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- REQUIREMENTS + AUDIENCE (2 COL)                             --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="two-col-grid">
        <section class="content-section">
            <h2 class="section-title">Requirements</h2>
            <p class="section-desc">What you need to know before starting</p>

            <ul class="requirements-list">
                <li class="requirement-item">
                    <div class="req-bullet">•</div>
                    <div>
                        <strong>Basic PHP knowledge</strong> — variables, functions, and object-oriented programming basics
                    </div>
                </li>
                <li class="requirement-item">
                    <div class="req-bullet">•</div>
                    <div>
                        <strong>HTML, CSS, and JavaScript</strong> — you should be comfortable with the fundamentals
                    </div>
                </li>
                <li class="requirement-item">
                    <div class="req-bullet">•</div>
                    <div>
                        <strong>Familiarity with command line</strong> — we'll use Artisan CLI extensively
                    </div>
                </li>
                <li class="requirement-item">
                    <div class="req-bullet">•</div>
                    <div>
                        <strong>Code editor installed</strong> — we recommend VS Code (free) or PhpStorm
                    </div>
                </li>
                <li class="requirement-item">
                    <div class="req-bullet">•</div>
                    <div>
                        <strong>Computer with 8GB+ RAM</strong> — Windows, Mac, or Linux all work
                    </div>
                </li>
            </ul>
        </section>

        <section class="content-section">
            <h2 class="section-title">Who is this <em>for</em>?</h2>
            <p class="section-desc">This course is perfect for:</p>

            <ul class="audience-list">
                <li class="audience-item">
                    <div class="aud-icon aud-icon-1">🎯</div>
                    <div>
                        <strong>Beginner developers</strong> who want to learn modern web development with Laravel
                    </div>
                </li>
                <li class="audience-item">
                    <div class="aud-icon aud-icon-2">💼</div>
                    <div>
                        <strong>Career switchers</strong> looking to transition into full-stack development
                    </div>
                </li>
                <li class="audience-item">
                    <div class="aud-icon aud-icon-3">🚀</div>
                    <div>
                        <strong>Freelancers</strong> wanting to offer web development services
                    </div>
                </li>
                <li class="audience-item">
                    <div class="aud-icon aud-icon-4">📈</div>
                    <div>
                        <strong>PHP developers</strong> upgrading their skills to Laravel 12
                    </div>
                </li>
                <li class="audience-item">
                    <div class="aud-icon aud-icon-5">🎓</div>
                    <div>
                        <strong>Students & learners</strong> who want real-world project experience
                    </div>
                </li>
            </ul>
        </section>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- COURSE DESCRIPTION                                          --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="content-section">
        <h2 class="section-title">About this <em>course</em></h2>
        <p class="section-desc">Detailed course description</p>

        <div class="description-content">
            <p>
                <strong>Ready to become a professional Laravel developer?</strong> This comprehensive bootcamp takes you from zero to production-ready in just 40 hours of focused learning.
            </p>
            <p>
                Whether you're a complete beginner to Laravel or an experienced developer looking to upgrade your skills to Laravel 12, this course has something for you. We start with the absolute fundamentals and progressively build up to advanced topics like real-time features, queues, and deployment.
            </p>

            <h3 class="desc-subheading">Why this course?</h3>
            <p>
                Unlike other courses that just teach syntax, we focus on <em>real-world application</em>. You'll build actual projects you can add to your portfolio — including a full e-commerce platform as the final project.
            </p>

            <h3 class="desc-subheading">What makes it different?</h3>
            <p>Every single lesson includes:</p>
            <ul class="desc-list">
                <li>📹 Video explanation (HD quality)</li>
                <li>💻 Downloadable source code</li>
                <li>📝 Written notes &amp; cheat sheets</li>
                <li>🎯 Practice exercises</li>
                <li>💬 Community discussion thread</li>
            </ul>

            <h3 class="desc-subheading">By the end, you will have:</h3>
            <ul class="desc-list">
                <li>✅ Built 5 complete Laravel applications from scratch</li>
                <li>✅ Deployed real applications to production servers</li>
                <li>✅ Mastered modern development workflow (Git, testing, CI/CD)</li>
                <li>✅ Created a polished portfolio ready for job applications</li>
                <li>✅ Earned an industry-recognized certificate</li>
            </ul>

            <blockquote class="desc-quote">
                <span class="quote-mark">"</span>
                This course genuinely changed my career. Went from zero Laravel knowledge to landing a full-stack dev job in 4 months. The projects are legit and the instructor is amazing.
                <cite>— Ahmad Rizky, Software Engineer @ Tokopedia (Alumni 2024)</cite>
            </blockquote>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- INSTRUCTOR FULL PROFILE                                     --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="content-section">
        <h2 class="section-title">Meet your <em>instructor</em></h2>
        <p class="section-desc">Learn from a senior industry expert</p>

        <div class="instructor-profile">
            <div class="instructor-header">
                <div class="instructor-avatar-xl">B</div>
                <div class="instructor-main-info">
                    <h3 class="instructor-full-name">Budi Santoso</h3>
                    <div class="instructor-headline">Senior Full-Stack Developer at Tokopedia</div>

                    <div class="instructor-badges">
                        <span class="inst-badge inst-badge-verified">✓ Verified Instructor</span>
                        <span class="inst-badge inst-badge-top">⭐ Top Rated</span>
                        <span class="inst-badge inst-badge-exp">🎯 10+ years experience</span>
                    </div>

                    <div class="instructor-social">
                        <a href="#" class="inst-social">🌐 Website</a>
                        <a href="#" class="inst-social">in LinkedIn</a>
                        <a href="#" class="inst-social">𝕏 Twitter</a>
                        <a href="#" class="inst-social">💻 GitHub</a>
                    </div>
                </div>
            </div>

            <div class="instructor-stats-grid">
                <div class="inst-stat-card">
                    <div class="inst-stat-icon">⭐</div>
                    <div class="inst-stat-val">4.9</div>
                    <div class="inst-stat-label">Rating</div>
                </div>
                <div class="inst-stat-card">
                    <div class="inst-stat-icon">👥</div>
                    <div class="inst-stat-val">120K+</div>
                    <div class="inst-stat-label">Students</div>
                </div>
                <div class="inst-stat-card">
                    <div class="inst-stat-icon">💬</div>
                    <div class="inst-stat-val">8,420</div>
                    <div class="inst-stat-label">Reviews</div>
                </div>
                <div class="inst-stat-card">
                    <div class="inst-stat-icon">📚</div>
                    <div class="inst-stat-val">45</div>
                    <div class="inst-stat-label">Courses</div>
                </div>
            </div>

            <div class="instructor-bio">
                <p>
                    Hi, I'm <strong>Budi</strong> 👋 — a passionate Senior Full-Stack Developer with over 10 years of experience building scalable web applications. Currently working at <strong>Tokopedia</strong>, where I lead the backend infrastructure team.
                </p>
                <p>
                    My journey with Laravel started in 2015 with version 5.1, and I've been obsessed with the framework ever since. I've built everything from small SaaS products to enterprise applications serving millions of users.
                </p>
                <p>
                    What I love most is <em>teaching</em>. There's nothing more rewarding than seeing a student go from "Hello World" to shipping real-world products. I focus on <strong>practical, hands-on learning</strong> — no fluff, no filler, just the skills you actually need.
                </p>

                <div class="inst-expertise">
                    <div class="inst-expertise-label">Expertise</div>
                    <div class="inst-expertise-tags">
                        <span class="inst-tag">Laravel</span>
                        <span class="inst-tag">PHP 8.2+</span>
                        <span class="inst-tag">React.js</span>
                        <span class="inst-tag">Vue.js</span>
                        <span class="inst-tag">MySQL</span>
                        <span class="inst-tag">PostgreSQL</span>
                        <span class="inst-tag">Redis</span>
                        <span class="inst-tag">Docker</span>
                        <span class="inst-tag">AWS</span>
                        <span class="inst-tag">Microservices</span>
                    </div>
                </div>
            </div>

            <button class="btn-view-profile" type="button">
                View instructor profile →
            </button>
        </div>
    </section>

    
    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- STUDENT REVIEWS                                             --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="content-section">
        <h2 class="section-title">Student <em>reviews</em></h2>
        <p class="section-desc">What learners say about this course</p>

        {{-- Summary --}}
        <div class="reviews-summary">
            <div class="review-overall">
                <div class="overall-rating">
                    <span class="rating-value"><em>4.9</em></span>
                    <div class="rating-stars-big">★★★★★</div>
                    <div class="rating-total">Based on 1,284 reviews</div>
                </div>
            </div>

            <div class="rating-distribution">
                @php
                    $distribution = [
                        ['stars' => 5, 'count' => 1024, 'percent' => 80],
                        ['stars' => 4, 'count' => 192, 'percent' => 15],
                        ['stars' => 3, 'count' => 45, 'percent' => 3.5],
                        ['stars' => 2, 'count' => 15, 'percent' => 1.2],
                        ['stars' => 1, 'count' => 8, 'percent' => 0.6],
                    ];
                @endphp

                @foreach($distribution as $row)
                    <div class="dist-row">
                        <span class="dist-label">{{ $row['stars'] }}★</span>
                        <div class="dist-bar">
                            <div class="dist-fill" style="width: {{ $row['percent'] }}%;"></div>
                        </div>
                        <span class="dist-percent">{{ $row['percent'] }}%</span>
                        <span class="dist-count">({{ number_format($row['count']) }})</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Filters --}}
        <div class="reviews-filter">
            <div class="filter-pills">
                <button class="filter-pill active" type="button">All reviews</button>
                <button class="filter-pill" type="button">5 stars</button>
                <button class="filter-pill" type="button">4 stars</button>
                <button class="filter-pill" type="button">With comments</button>
                <button class="filter-pill" type="button">Most helpful</button>
            </div>

            <select class="reviews-sort">
                <option>Most recent</option>
                <option>Highest rated</option>
                <option>Most helpful</option>
                <option>Critical first</option>
            </select>
        </div>

        {{-- Review Cards --}}
        <div class="reviews-list">
            @php
                $reviews = [
                    [
                        'avatar' => 'A', 'name' => 'Ahmad Rizky', 'role' => 'Software Engineer @ Tokopedia',
                        'rating' => 5, 'verified' => true, 'date' => '2 weeks ago', 'helpful' => 47,
                        'comment' => 'This course genuinely changed my career. Pak Budi explains everything in a way that\'s easy to understand even for complete beginners. The real-world projects are amazing — I used one as my portfolio and landed my job at Tokopedia within 2 months!',
                        'color' => 'purple', 'highlight' => true,
                    ],
                    [
                        'avatar' => 'S', 'name' => 'Sari Dewi', 'role' => 'Freelance Developer',
                        'rating' => 5, 'verified' => true, 'date' => '1 month ago', 'helpful' => 32,
                        'comment' => 'Best Laravel course I\'ve taken — and I\'ve tried many. Very comprehensive, well-structured, and the instructor is super responsive to questions. The e-commerce final project alone is worth the price.',
                        'color' => 'teal', 'highlight' => false,
                    ],
                    [
                        'avatar' => 'R', 'name' => 'Rio Ahmad', 'role' => 'Career Switcher',
                        'rating' => 5, 'verified' => true, 'date' => '1 month ago', 'helpful' => 28,
                        'comment' => 'I came from a marketing background with zero coding experience. This course is perfectly paced for beginners. Now I\'m working as a junior developer. Terima kasih banyak Pak Budi!',
                        'color' => 'orange', 'highlight' => false,
                    ],
                    [
                        'avatar' => 'M', 'name' => 'Maya Putri', 'role' => 'Computer Science Student',
                        'rating' => 4, 'verified' => true, 'date' => '2 months ago', 'helpful' => 19,
                        'comment' => 'Great course overall! The content is top-notch and very relevant to current industry standards. Would love to see more advanced topics like microservices architecture in future updates.',
                        'color' => 'gold', 'highlight' => false,
                    ],
                ];
            @endphp

            @foreach($reviews as $review)
                <div class="review-card {{ $review['highlight'] ? 'review-highlight' : '' }}">
                    @if($review['highlight'])
                        <div class="review-badge-pick">🏆 Top review</div>
                    @endif

                    <div class="review-header">
                        <div class="review-author">
                            <div class="review-avatar avatar-{{ $review['color'] }}">
                                {{ $review['avatar'] }}
                            </div>
                            <div class="review-author-info">
                                <div class="review-author-name">
                                    {{ $review['name'] }}
                                    @if($review['verified'])
                                        <span class="verified-badge" title="Verified purchase">✓</span>
                                    @endif
                                </div>
                                <div class="review-author-role">{{ $review['role'] }}</div>
                            </div>
                        </div>

                        <div class="review-meta">
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review['rating'] ? 'filled' : '' }}">★</span>
                                @endfor
                            </div>
                            <div class="review-date">{{ $review['date'] }}</div>
                        </div>
                    </div>

                    <p class="review-comment">"{{ $review['comment'] }}"</p>

                    <div class="review-footer">
                        <div class="review-helpful">
                            <span>Was this helpful?</span>
                            <button class="btn-helpful" onclick="toggleHelpful(this)" type="button">
                                👍 Yes ({{ $review['helpful'] }})
                            </button>
                            <button class="btn-helpful-no" onclick="toggleNotHelpful(this)" type="button">
                                👎
                            </button>
                        </div>
                        <button class="btn-report" type="button">Report</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="reviews-load-more">
            <button class="btn-load-more" type="button">
                Show more reviews (1,280 remaining)
            </button>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- RELATED COURSES                                             --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="content-section">
        <h2 class="section-title">You might also <em>like</em></h2>
        <p class="section-desc">Students who took this course also enrolled in</p>

        <div class="related-grid">
            @php
                $relatedCourses = [
                    ['thumb' => 2, 'icon' => '⚛️', 'category' => 'Programming', 'title' => 'React.js from Zero to Hero', 'instructor' => 'Budi Santoso', 'initial' => 'B', 'rating' => '4.8', 'students' => '9.2k', 'duration' => '30h', 'price' => 'Rp 249k', 'badge' => 'bestseller'],
                    ['thumb' => 3, 'icon' => '📊', 'category' => 'Data Science', 'title' => 'Python for Data Analysis', 'instructor' => 'Rio Ahmad', 'initial' => 'R', 'rating' => '4.9', 'students' => '15.7k', 'duration' => '20h', 'price' => 'Free', 'badge' => 'free'],
                    ['thumb' => 5, 'icon' => '🐳', 'category' => 'DevOps', 'title' => 'Docker & Kubernetes Fundamentals', 'instructor' => 'Budi Santoso', 'initial' => 'B', 'rating' => '4.8', 'students' => '6.3k', 'duration' => '22h', 'price' => 'Rp 399k', 'badge' => null],
                ];
            @endphp

            @foreach($relatedCourses as $rel)
                <a href="#" class="related-card">
                    <div class="related-thumb course-thumb-{{ $rel['thumb'] }}">
                        @if($rel['badge'])
                            <span class="related-badge badge-{{ $rel['badge'] }}">
                                @if($rel['badge'] === 'bestseller') ⭐ Bestseller
                                @elseif($rel['badge'] === 'free') Free
                                @endif
                            </span>
                        @endif
                        <span>{{ $rel['icon'] }}</span>
                    </div>
                    <div class="related-body">
                        <div class="related-category">{{ $rel['category'] }}</div>
                        <div class="related-title">{{ $rel['title'] }}</div>
                        <div class="related-instructor">
                            <div class="related-avatar">{{ $rel['initial'] }}</div>
                            <span>{{ $rel['instructor'] }}</span>
                        </div>
                        <div class="related-meta">
                            <span>⭐ {{ $rel['rating'] }}</span>
                            <span>👥 {{ $rel['students'] }}</span>
                            <span>🕐 {{ $rel['duration'] }}</span>
                        </div>
                        <div class="related-footer">
                            <div class="related-price {{ $rel['price'] === 'Free' ? 'price-free' : '' }}">
                                {{ $rel['price'] }}
                            </div>
                            <div class="related-arrow">→</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- FINAL CTA BANNER                                            --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <section class="cta-banner">
        <div class="cta-bg-decoration"></div>

        <div class="cta-content">
            <div class="cta-badge">
                <span class="cta-badge-dot"></span>
                <span>Limited time offer</span>
            </div>

            <h2 class="cta-title">
                Ready to start your <em>Laravel journey</em>?
            </h2>
            <p class="cta-subtitle">
                Join 12,300+ students already learning. Enroll today and get 50% off — this offer ends in 2 days.
            </p>

            <div class="cta-price">
                <span class="cta-price-now">Rp 299K</span>
                <span class="cta-price-old">Rp 599K</span>
                <span class="cta-price-discount">🔥 Save 50%</span>
            </div>

            <div class="cta-buttons">
                <button class="btn-cta-primary" type="button">
                    Enroll Now →
                </button>
                <button class="btn-cta-ghost" type="button">
                    ▶ Watch Preview
                </button>
            </div>

            <div class="cta-trust">
                <div class="cta-trust-item">
                    <span class="cta-trust-icon">🛡️</span>
                    <span>30-day guarantee</span>
                </div>
                <div class="cta-trust-item">
                    <span class="cta-trust-icon">♾️</span>
                    <span>Lifetime access</span>
                </div>
                <div class="cta-trust-item">
                    <span class="cta-trust-icon">🏆</span>
                    <span>Certificate included</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- FOOTER                                                      --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <footer class="course-footer">
        <div class="footer-content">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
                <span class="logo-text">Coursify</span>
            </a>
            <div class="footer-links">
                <a href="#">Help Center</a>
                <a href="#">Terms</a>
                <a href="#">Privacy</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-copy">
                © {{ date('Y') }} Coursify · Supporting SDG 4 🌍
            </div>
        </div>
    </footer>

</div> {{-- end .container --}}

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- JAVASCRIPT (ALL FUNCTIONALITY)                              --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<script>
    // ═══ Fix browser bfcache (back button stale UI) ═══
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });

    // ═══ Auto hide/show navbar on scroll ═══
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

    // ═══ Curriculum: Toggle single section ═══
    function toggleSection(btn) {
        const section = btn.closest('.curriculum-section');
        if (section) {
            section.classList.toggle('expanded');
        }
    }

    // ═══ Curriculum: Toggle all sections ═══
    function toggleAllSections() {
        const sections = document.querySelectorAll('.curriculum-section');
        const toggleText = document.getElementById('toggleAllText');
        if (!sections.length || !toggleText) return;

        const allExpanded = Array.from(sections).every(s => s.classList.contains('expanded'));

        if (allExpanded) {
            sections.forEach(s => s.classList.remove('expanded'));
            toggleText.textContent = 'Expand all';
        } else {
            sections.forEach(s => s.classList.add('expanded'));
            toggleText.textContent = 'Collapse all';
        }
    }

    // ═══ Wishlist sidebar button ═══
function toggleWishlistBtn(btn) {
    btn.classList.toggle('active');
    
    if (btn.classList.contains('active')) {
        // Menggunakan ikon hati solid (merah bisa diatur via CSS)
        btn.innerHTML = '<i class="fa-solid fa-heart"></i> Added to Wishlist';
    } else {
        // Menggunakan ikon hati regular (hanya garis luar)
        btn.innerHTML = '<i class="fa-regular fa-heart"></i> Add to Wishlist';
    }
}

    // ═══ Review helpful toggle ═══
    function toggleHelpful(btn) {
        const isActive = btn.classList.contains('active');
        btn.classList.toggle('active');

        const match = btn.textContent.trim().match(/\$(\d+)\$/);
        if (match) {
            const count = parseInt(match[1]);
            const newCount = isActive ? count - 1 : count + 1;
            btn.textContent = `👍 Yes (${newCount})`;
        }
    }

    function toggleNotHelpful(btn) {
        btn.classList.toggle('active');
    }

    // ═══ Reviews filter pills ═══
    document.querySelectorAll('.filter-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ═══ Share buttons (copy link) ═══
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const title = this.getAttribute('title');
            if (title === 'Copy link') {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    const originalText = this.textContent;
                    this.textContent = '✓';
                    this.style.background = 'var(--teal)';
                    this.style.color = 'white';
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.background = '';
                        this.style.color = '';
                    }, 1500);
                });
            }
        });
    });

    // ═══ Smooth scroll for anchor links ═══
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href.length <= 1) return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>

</body>
</html>