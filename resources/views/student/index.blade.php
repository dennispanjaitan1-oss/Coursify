<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<!-- Font Awesome 6.x (Versi Terbaru) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    --bg: #FAF8FD;
    --font-serif: 'Instrument Serif', serif;
    --font-sans: 'Inter', sans-serif;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: var(--font-sans);
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
    display: flex;
}

/* ═══ SIDEBAR ═══ */
.sidebar {
    width: 240px;
    background: white;
    border-right: 1px solid var(--border);
    padding: 24px 16px;
    position: fixed;
    height: 100vh;
    display: flex;
    flex-direction: column;
    z-index: 50;
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 8px 24px;
    text-decoration: none;
    color: var(--text);
    border-bottom: 1px solid var(--border);
    margin-bottom: 20px;
}

.sidebar-logo-img {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    box-shadow: 0 2px 8px rgba(30,58,95,0.2);
    object-fit: cover;
}

.sidebar-logo-text {
    font-size: 18px;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.sidebar-section {
    font-size: 10px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    padding: 12px 12px 6px;
}

.sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: 2px;
    margin-bottom: 16px;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-soft);
    font-size: 13.5px;
    font-weight: 500;
    transition: all 0.2s;
    position: relative;
}

.sidebar-link:hover {
    background: var(--lav-1);
    color: var(--text);
}

.sidebar-link.active {
    background: linear-gradient(135deg, var(--purple), var(--purple-dark));
    color: white;
    box-shadow: 0 4px 12px rgba(123,111,232,0.3);
}

.sidebar-link-icon {
    width: 18px;
    font-size: 16px;
    text-align: center;
    flex-shrink: 0;
}

.sidebar-badge {
    margin-left: auto;
    background: var(--orange);
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 100px;
}

.sidebar-link.active .sidebar-badge {
    background: white;
    color: var(--purple);
}

/* Sidebar user card */
.sidebar-user {
    margin-top: auto;
    padding: 12px;
    background: linear-gradient(135deg, var(--lav-1), white);
    border: 1px solid rgba(123,111,232,0.15);
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.sidebar-user:hover {
    border-color: var(--purple);
    box-shadow: 0 4px 12px rgba(123,111,232,0.1);
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.user-info {
    flex: 1;
    min-width: 0;
}

.user-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-role {
    font-size: 10px;
    color: var(--purple);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* ═══ MAIN CONTENT ═══ */
.main {
    flex: 1;
    margin-left: 240px;
    padding: 24px 32px;
    min-height: 100vh;
}

/* Top Bar */
.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 16px;
}

.topbar-search {
    flex: 1;
    max-width: 420px;
    position: relative;
}

.search-input {
    width: 100%;
    padding: 11px 16px 11px 42px;
    background: white;
    border: 1.5px solid var(--border);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    color: var(--text);
    outline: none;
    transition: all 0.2s;
}

.search-input::placeholder { color: var(--muted); }

.search-input:focus {
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
}

.topbar-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.icon-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: var(--text-soft);
    font-size: 16px;
    position: relative;
}

.icon-btn:hover {
    background: var(--lav-1);
    border-color: var(--purple);
    color: var(--purple);
}

.icon-btn-dot {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 8px;
    height: 8px;
    background: var(--orange);
    border-radius: 50%;
    border: 2px solid white;
}

/* ═══ WELCOME HERO ═══ */
.welcome-card {
    background: linear-gradient(135deg, var(--navy) 0%, #1E4A7A 50%, #2D4D7A 100%);
    border-radius: 24px;
    padding: 32px;
    color: white;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 24px;
    align-items: center;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(184,175,235,0.25), transparent 70%);
    pointer-events: none;
}

.welcome-card::after {
    content: '';
    position: absolute;
    bottom: -50px;
    left: 40%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(0,200,150,0.15), transparent 70%);
    pointer-events: none;
}

.welcome-content {
    position: relative;
    z-index: 1;
}

.welcome-greeting {
    font-size: 13px;
    color: var(--lav-4);
    margin-bottom: 8px;
    font-weight: 500;
    letter-spacing: 0.02em;
}

.welcome-title {
    font-family: var(--font-serif);
    font-size: 36px;
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-bottom: 12px;
}

.welcome-title em {
    font-style: italic;
    color: var(--lav-4);
}

.welcome-subtitle {
    font-size: 14px;
    color: rgba(255,255,255,0.75);
    line-height: 1.6;
    max-width: 420px;
    margin-bottom: 18px;
}

.welcome-actions {
    display: flex;
    gap: 10px;
}

.btn-welcome {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-welcome-primary {
    background: white;
    color: var(--navy);
}

.btn-welcome-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.btn-welcome-ghost {
    background: rgba(255,255,255,0.15);
    color: white;
    border: 1px solid rgba(255,255,255,0.25);
}

.btn-welcome-ghost:hover {
    background: rgba(255,255,255,0.25);
}

.welcome-visual {
    position: relative;
    z-index: 1;
}

.welcome-img {
    width: 140px;
    height: 140px;
    border-radius: 20px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 64px;
}

/* ═══ STATS GRID ═══ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}

.stat-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 20px;
    transition: all 0.2s;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(30,58,95,0.08);
    border-color: var(--purple);
}

.stat-icon-wrap {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 14px;
}

.stat-icon-purple { background: rgba(123,111,232,0.12); }
.stat-icon-teal { background: var(--teal-light); }
.stat-icon-orange { background: var(--orange-light); }
.stat-icon-gold { background: var(--gold-light); }

.stat-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
    margin-bottom: 4px;
}

.stat-value {
    font-family: var(--font-serif);
    font-size: 32px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 6px;
}

.stat-trend {
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.stat-trend-up { color: var(--teal); }
.stat-trend-down { color: var(--orange); }
.stat-trend-neutral { color: var(--muted); }

/* ═══ SECTION HEADER ═══ */
.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.section-title {
    font-family: var(--font-serif);
    font-size: 24px;
    font-weight: 400;
    letter-spacing: -0.01em;
    color: var(--text);
}

.section-title em {
    font-style: italic;
    color: var(--purple);
}

.section-link {
    font-size: 13px;
    color: var(--purple);
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s;
}

.section-link:hover {
    color: var(--purple-dark);
    gap: 8px;
}

/* ═══ CONTINUE LEARNING ═══ */
.continue-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 28px;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 24px;
    align-items: center;
    transition: all 0.2s;
}

.continue-card:hover {
    border-color: var(--purple);
    box-shadow: 0 12px 30px rgba(30,58,95,0.08);
}

.continue-thumb {
    width: 120px;
    height: 80px;
    border-radius: 14px;
    background: linear-gradient(135deg, #667EEA, #764BA2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    position: relative;
    flex-shrink: 0;
}

.continue-thumb-play {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 28px;
    height: 28px;
    background: rgba(255,255,255,0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--navy);
    font-size: 11px;
}

.continue-info {
    flex: 1;
    min-width: 0;
}

.continue-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--purple);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 6px;
}

.continue-title {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
    line-height: 1.2;
}

.continue-meta {
    font-size: 12px;
    color: var(--muted);
    margin-bottom: 12px;
}

.continue-progress {
    height: 6px;
    background: var(--lav-2);
    border-radius: 100px;
    overflow: hidden;
    margin-bottom: 4px;
}

.continue-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--purple), var(--lav-4));
    border-radius: 100px;
    transition: width 0.6s ease;
}

.continue-progress-label {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}

.btn-continue {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 11px 20px;
    background: #1A1825;
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    flex-shrink: 0;
}

.btn-continue:hover {
    background: #2A2840;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(26,24,37,0.3);
}

/* Responsive */
@media (max-width: 1100px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .continue-card {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .continue-thumb { width: 100%; height: 140px; }
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
    }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0; padding: 16px; }
    .welcome-card {
        grid-template-columns: 1fr;
        padding: 24px;
    }
    .welcome-title { font-size: 28px; }
    .welcome-visual { display: none; }
    .topbar-search { max-width: 100%; }
}
</style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="sidebar-logo-img">
        <span class="sidebar-logo-text">Coursify</span>
    </a>

    <div class="sidebar-section">Menu</div>
    <nav class="sidebar-nav">
        <a href="{{ route('student.index') }}" class="sidebar-link {{ request()->routeIs('student.index') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high sidebar-link-icon"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('student.courses') }}" class="sidebar-link {{ request()->routeIs('student.courses') ? 'active' : '' }}">
            <i class="fa-solid fa-book-open sidebar-link-icon"></i>
            <span>My Courses</span>
        </a>
        <a href="{{ route('courses.index') }}" class="sidebar-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
            <i class="fa-solid fa-magnifying-glass sidebar-link-icon"></i>
            <span>Browse</span>
        </a>
        <a href="{{ route('student.wishlist') }}" class="sidebar-link {{ request()->routeIs('student.wishlist') ? 'active' : '' }}">
            <i class="fa-solid fa-heart sidebar-link-icon"></i>
            <span>Wishlist</span>
        </a>
        <a href="{{ route('student.certificates') }}" class="sidebar-link {{ request()->routeIs('student.certificates') ? 'active' : '' }}">
            <i class="fa-solid fa-trophy sidebar-link-icon"></i>
            <span>Certificates</span>
        </a>
    </nav>

    <div class="sidebar-section">Account</div>
    <nav class="sidebar-nav">
        <a href="{{ route('student.profile') }}" class="sidebar-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
            <i class="fa-solid fa-user-pen sidebar-link-icon"></i>
            <span>Profile</span>
        </a>

    </nav>

    {{-- User Card --}}
<div class="sidebar-user">
    <div class="user-avatar">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </div>
    <div class="user-info">
        <div class="user-name">{{ auth()->user()->name }}</div>
        <div class="user-role">{{ auth()->user()->role }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;" title="Logout">
            <i class="fa-solid fa-right-from-bracket"></i>
        </button>
    </form>
</div>
</aside>

{{-- MAIN CONTENT --}}
<main class="main">

    {{-- TOP BAR --}}
<div class="topbar">
    <div class="topbar-search">
        <span class="search-icon">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
            <input type="text" class="search-input" placeholder="Search courses, lessons, instructors...">
        </div>

        <div class="topbar-actions">
    {{-- Notifications --}}
    <button class="icon-btn" title="Notifications">
        <i class="fa-solid fa-bell"></i>
        <span class="icon-btn-dot"></span>
    </button>

    {{-- Messages --}}
    <button class="icon-btn" title="Messages">
        <i class="fa-solid fa-envelope"></i>
    </button>

    {{-- Help --}}
    <button class="icon-btn" title="Help">
        <i class="fa-solid fa-circle-question"></i>
    </button>
</div>
    </div>

    {{-- WELCOME HERO --}}
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="welcome-greeting">
                {{ now()->format('l, d F Y') }} <br> Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}
            </div>
            <h1 class="welcome-title">
                Welcome back, <em>{{ explode(' ', auth()->user()->name)[0] }}</em>
            </h1>
            <p class="welcome-subtitle">
                Continue your learning journey. You're just a few lessons away from completing your next milestone.
            </p>
            <div class="welcome-actions">
                <a href="#" class="btn-welcome btn-welcome-primary">
                    ▶ Continue Learning
                </a>
                <a href="{{ route('courses.index') }}" class="btn-welcome btn-welcome-ghost">
                    Browse Courses
                </a>
            </div>
        </div>

        <div class="welcome-visual">
    <div class="welcome-img">
        <i class="fa-solid fa-graduation-cap"></i>
    </div>
</div>
    </div>

    {{-- STATS GRID --}}
<div class="stats-grid">
    {{-- Enrolled Courses --}}
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-purple">
            <i class="fa-solid fa-book"></i>
        </div>
        <div class="stat-label">Enrolled Courses</div>
        <div class="stat-value">{{ $enrolledCount ?? 3 }}</div>
        <div class="stat-trend stat-trend-up">
            <i class="fa-solid fa-arrow-up"></i> 1 this month
        </div>
    </div>

    {{-- Completed --}}
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-teal">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-label">Completed</div>
        <div class="stat-value">{{ $completedCount ?? 1 }}</div>
        <div class="stat-trend stat-trend-neutral">
            <i class="fa-solid fa-minus"></i>
        </div>
    </div>

    {{-- Study Time --}}
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-orange">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div class="stat-label">Study Time</div>
        <div class="stat-value">{{ $studyHours ?? 24 }}<span style="font-size:16px;color:var(--muted);">h</span></div>
        <div class="stat-trend stat-trend-up">
            <i class="fa-solid fa-arrow-up"></i> 5h this week
        </div>
    </div>

    {{-- Certificates --}}
    <div class="stat-card">
        <div class="stat-icon-wrap stat-icon-gold">
            <i class="fa-solid fa-trophy"></i>
        </div>
        <div class="stat-label">Certificates</div>
        <div class="stat-value">{{ $certificatesCount ?? 1 }}</div>
        <div class="stat-trend stat-trend-up">
            <i class="fa-solid fa-star"></i> Ready to claim
        </div>
    </div>
</div>

    {{-- CONTINUE LEARNING --}}
    <div class="section-header">
        <h2 class="section-title">Continue <em>learning</em></h2>
        <a href="{{ route('student.courses') }}" class="section-link">
            View all courses →
        </a>
    </div>

    <div class="continue-card">
        <div class="continue-thumb">
    <i class="fa-solid fa-laptop-code" style="color: white; font-size: 40px;"></i>
    <div class="continue-thumb-play">
        <i class="fa-solid fa-play" style="font-size: 10px;"></i>
    </div>
</div>

        <div class="continue-info">
            <div class="continue-label">In Progress</div>
            <div class="continue-title">Fullstack Web Development with Laravel 12</div>
            <div class="continue-meta">
                Lesson 12 of 40 · Building Authentication · ⏱ 12:45
            </div>
            <div class="continue-progress">
                <div class="continue-progress-fill" style="width: 30%;"></div>
            </div>
            <div class="continue-progress-label">30% complete · 28 lessons left</div>
        </div>

        <a href="#" class="btn-continue">
            ▶ Resume
        </a>
    </div>

    
    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- MY COURSES GRID                                     --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="section-header">
        <h2 class="section-title">My <em>courses</em></h2>
        <a href="{{ route('student.courses') }}" class="section-link">
            View all →
        </a>
    </div>

    <div class="courses-grid">
        @php
            $myCourses = [
    [
        'thumb' => 'programming-bg.jpg', // Nama file gambar asli
        'icon' => 'fa-solid fa-laptop-code', 
        'category' => 'Programming',
        'title' => 'Fullstack Web Development with Laravel 12',
        'instructor' => 'Budi Santoso',
        'progress' => 30, 'lessons_done' => 12, 'lessons_total' => 40,
        'duration' => '40h', 'status' => 'in_progress',
    ],
    [
        'thumb' => 'design-uiux.jpeg.jpg', // Nama file gambar asli
        'icon' => 'fa-solid fa-palette', 
        'category' => 'Design',
        'title' => 'UI/UX Design Fundamentals for Beginners',
        'instructor' => 'Sari Dewi',
        'progress' => 75, 'lessons_done' => 18, 'lessons_total' => 24,
        'duration' => '25h', 'status' => 'in_progress',
    ],
    [
        'thumb' => 'data-science.jpeg', // Nama file gambar asli
        'icon' => 'fa-solid fa-chart-pie', 
        'category' => 'Data Science',
        'title' => 'Python for Data Analysis',
        'instructor' => 'Rio Ahmad',
        'progress' => 100, 'lessons_done' => 20, 'lessons_total' => 20,
        'duration' => '20h', 'status' => 'completed',
    ],
];
        @endphp

        @foreach($myCourses as $course)
    <a href="#" class="course-card">
        <div class="course-thumb">
            {{-- Menampilkan gambar asli sebagai background atau img tag --}}
            <img src="{{ asset('images/' . $course['thumb']) }}" 
                 alt="{{ $course['title'] }}" 
                 style="width: 100%; height: 100%; object-fit: cover;">
            
            {{-- Overlay ikon kecil di pojok agar tetap ada identitas kategori (Opsional) --}}
            <div class="course-category-icon" style="position: absolute; left: 12px; bottom: 12px; background: rgba(255,255,255,0.9); padding: 5px; border-radius: 8px; font-size: 14px;">
                <i class="{{ $course['icon'] }}"></i>
            </div>

            @if($course['status'] === 'completed')
                <div class="course-badge-status completed">
                    <i class="fa-solid fa-check"></i> Completed
                </div>
            @else
                <div class="course-badge-status in-progress">
                    In Progress
                </div>
            @endif
        </div>
                <div class="course-card-body">
                    <div class="course-card-category">{{ $course['category'] }}</div>
                    <div class="course-card-title">{{ $course['title'] }}</div>
                    <div class="course-card-instructor">👨‍🏫 {{ $course['instructor'] }}</div>

                    <div class="course-progress">
                        <div class="course-progress-header">
                            <span>{{ $course['progress'] }}% complete</span>
                            <span>{{ $course['lessons_done'] }}/{{ $course['lessons_total'] }} lessons</span>
                        </div>
                        <div class="course-progress-bar">
                            <div class="course-progress-fill
                                {{ $course['status'] === 'completed' ? 'completed' : '' }}"
                                style="width: {{ $course['progress'] }}%;"></div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- TWO COLUMN: ACTIVITY + UPCOMING                      --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="two-col-grid">

        {{-- LEFT: Weekly Activity Chart --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Weekly <em>activity</em></h3>
                <div class="card-tabs">
                    <button class="card-tab active">Week</button>
                    <button class="card-tab">Month</button>
                </div>
            </div>

            <div class="activity-summary">
                <div>
                    <div class="activity-hours">5.2<span>h</span></div>
                    <div class="activity-label">Total this week</div>
                </div>
                <div class="activity-trend">
                    <span class="stat-trend stat-trend-up">↑ 24% vs last week</span>
                </div>
            </div>

            <div class="chart-container">
                @php
                    $activity = [
                        ['day' => 'Mon', 'value' => 45, 'hours' => '0.8h'],
                        ['day' => 'Tue', 'value' => 70, 'hours' => '1.2h'],
                        ['day' => 'Wed', 'value' => 30, 'hours' => '0.5h'],
                        ['day' => 'Thu', 'value' => 90, 'hours' => '1.5h'],
                        ['day' => 'Fri', 'value' => 55, 'hours' => '0.9h'],
                        ['day' => 'Sat', 'value' => 20, 'hours' => '0.3h'],
                        ['day' => 'Sun', 'value' => 0, 'hours' => '0h'],
                    ];
                @endphp

                @foreach($activity as $day)
                    <div class="chart-bar-wrap">
                        <div class="chart-tooltip">{{ $day['hours'] }}</div>
                        <div class="chart-bar" style="height: {{ max($day['value'], 5) }}%;">
                            @if($day['value'] > 0)
                                <div class="chart-bar-fill"></div>
                            @endif
                        </div>
                        <div class="chart-label">{{ $day['day'] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="activity-meta">
                <div class="meta-item">
                    <span class="meta-dot meta-purple"></span>
                    <span>Video lessons · 3.5h</span>
                </div>
                <div class="meta-item">
                    <span class="meta-dot meta-teal"></span>
                    <span>Exercises · 1.2h</span>
                </div>
                <div class="meta-item">
                    <span class="meta-dot meta-orange"></span>
                    <span>Reading · 0.5h</span>
                </div>
            </div>
        </div>

        {{-- RIGHT: Upcoming Schedule --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Up <em>next</em></h3>
                <a href="#" class="section-link">Schedule →</a>
            </div>

            @php
                $upcoming = [
                    ['day' => 'Today', 'time' => '15:00', 'title' => 'Building Authentication', 'course' => 'Laravel 12', 'type' => 'video', 'duration' => '12m'],
                    ['day' => 'Today', 'time' => '19:30', 'title' => 'Design Principles Quiz', 'course' => 'UI/UX Design', 'type' => 'quiz', 'duration' => '15m'],
                    ['day' => 'Tomorrow', 'time' => '10:00', 'title' => 'React Hooks Deep Dive', 'course' => 'React.js', 'type' => 'video', 'duration' => '24m'],
                    ['day' => 'Fri, 19 Jan', 'time' => '14:00', 'title' => 'Final Project Review', 'course' => 'Laravel 12', 'type' => 'project', 'duration' => '45m'],
                ];
            @endphp

            <div class="upcoming-list">
                @foreach($upcoming as $item)
                    <div class="upcoming-item">
                        <div class="upcoming-time">
                            <div class="upcoming-day">{{ $item['day'] }}</div>
                            <div class="upcoming-clock">{{ $item['time'] }}</div>
                        </div>
                        <div class="upcoming-icon
                            {{ $item['type'] === 'quiz' ? 'upcoming-icon-orange' : '' }}
                            {{ $item['type'] === 'project' ? 'upcoming-icon-teal' : '' }}">
                            @if($item['type'] === 'video') <i class="fa-solid fa-video"></i>
                            @elseif($item['type'] === 'quiz') <i class="fa-solid fa-file-alt"></i>
                            @else <i class="fa-solid fa-box"></i>
                            @endif
                        </div>
                        <div class="upcoming-info">
                            <div class="upcoming-title">{{ $item['title'] }}</div>
                            <div class="upcoming-meta">{{ $item['course'] }} · {{ $item['duration'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- ACHIEVEMENTS                                         --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="section-header">
        <h2 class="section-title">Recent <em>achievements</em></h2>
        <a href="#" class="section-link">All badges →</a>
    </div>

    @php
    $achievements = [
        [
            'icon' => 'fa-solid fa-bullseye', 
            'title' => 'First Lesson', 
            'desc' => 'Completed your first lesson', 
            'date' => 'Unlocked · 2 weeks ago', 
            'bg' => 'purple'
        ],
        [
            'icon' => 'fa-solid fa-fire', 
            'title' => '7-Day Streak', 
            'desc' => 'Study 7 consecutive days', 
            'date' => 'Unlocked · yesterday', 
            'bg' => 'orange'
        ],
        [
            'icon' => 'fa-solid fa-trophy', 
            'title' => 'Course Complete', 
            'desc' => 'Finished Python for Data', 
            'date' => 'Unlocked · 3 days ago', 
            'bg' => 'gold'
        ],
        [
            'icon' => 'fa-solid fa-star', 
            'title' => 'Top Reviewer', 
            'desc' => 'Gave 5 thoughtful reviews', 
            'date' => 'Unlocked · today', 
            'bg' => 'teal'
        ],
    ];
@endphp
    <div class="achievements-grid">
        @foreach($achievements as $ach)
            <div class="achievement-card">
                <div class="achievement-icon achievement-{{ $ach['bg'] }}">
                    <i class="{{ $ach['icon'] }}"></i>
                </div>
                <div class="achievement-title">{{ $ach['title'] }}</div>
                <div class="achievement-desc">{{ $ach['desc'] }}</div>
                <div class="achievement-date">{{ $ach['date'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- RECOMMENDED COURSES                                  --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="section-header">
        <h2 class="section-title">Recommended <em>for you</em></h2>
        <a href="{{ route('courses.index') }}" class="section-link">Browse all →</a>
    </div>

    <div class="recommended-grid">
        @php
            $recommended = [
                ['thumb' => 4, 'icon' => '⚛️', 'category' => 'Programming', 'title' => 'React.js from Zero to Hero', 'instructor' => 'Budi Santoso', 'rating' => '4.9', 'students' => '12.3k', 'price' => 'Rp 249k'],
                ['thumb' => 5, 'icon' => '🚀', 'category' => 'Business', 'title' => 'Startup Fundamentals: Idea to Launch', 'instructor' => 'Maya Putri', 'rating' => '4.8', 'students' => '5.2k', 'price' => 'Rp 349k'],
                ['thumb' => 6, 'icon' => '🎵', 'category' => 'Music', 'title' => 'Music Production with FL Studio', 'instructor' => 'Dimas Wijaya', 'rating' => '4.7', 'students' => '3.1k', 'price' => 'Free'],
            ];
        @endphp

        @foreach($recommended as $rec)
            <a href="#" class="recommend-card">
                <div class="recommend-thumb course-thumb-{{ $rec['thumb'] }}">
                    <span>{{ $rec['icon'] }}</span>
                </div>
                <div class="recommend-body">
                    <div class="course-card-category">{{ $rec['category'] }}</div>
                    <div class="recommend-title">{{ $rec['title'] }}</div>
                    <div class="recommend-instructor">{{ $rec['instructor'] }}</div>
                    <div class="recommend-meta">
                        <span>⭐ {{ $rec['rating'] }}</span>
                        <span>👥 {{ $rec['students'] }}</span>
                    </div>
                    <div class="recommend-footer">
                        <div class="recommend-price {{ $rec['price'] === 'Free' ? 'price-free' : '' }}">
                            {{ $rec['price'] }}
                        </div>
                        <span class="recommend-arrow">→</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Footer spacer --}}
    <div style="height: 40px;"></div>

</main>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- ADDITIONAL STYLES (LANJUTAN)                          --}}
{{-- ═══════════════════════════════════════════════════ --}}
<style>
/* ═══ COURSES GRID ═══ */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}

.course-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none;
    color: var(--text);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    cursor: pointer;
}

.course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(30,58,95,0.1);
    border-color: var(--purple);
}

.course-thumb {
    aspect-ratio: 16/9;
    position: relative;
    overflow: hidden; /* Memastikan gambar tidak keluar dari radius kartu */
    background: #eee; /* Warna cadangan jika gambar gagal load */
}

/* Pastikan gambar mengisi seluruh area */
.course-thumb img {
    transition: transform 0.5s ease;
}

.course-card:hover .course-thumb img {
    transform: scale(1.1); /* Efek zoom saat kartu di-hover */
}

.course-badge-status {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    padding: 4px 10px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.course-badge-status.completed {
    background: var(--teal);
    color: white;
}

.course-badge-status.in-progress {
    background: rgba(255,255,255,0.95);
    color: var(--purple);
}

.course-card-body {
    padding: 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.course-card-category {
    font-size: 10px;
    font-weight: 700;
    color: var(--muted);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.course-card-title {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    line-height: 1.25;
    letter-spacing: -0.01em;
    margin-bottom: 8px;
}

.course-card-instructor {
    font-size: 12px;
    color: var(--text-soft);
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}

.course-progress {
    margin-top: auto;
}

.course-progress-header {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
    margin-bottom: 6px;
}

.course-progress-bar {
    height: 5px;
    background: var(--lav-2);
    border-radius: 100px;
    overflow: hidden;
}

.course-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--purple), var(--lav-4));
    border-radius: 100px;
    transition: width 0.6s ease;
}

.course-progress-fill.completed {
    background: linear-gradient(90deg, var(--teal), #00E5A8);
}

/* ═══ TWO COL GRID ═══ */
.two-col-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 16px;
    margin-bottom: 32px;
}

.card-wrap {
    background: white;
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 24px;
}

.card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.card-title {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.01em;
}

.card-title em { font-style: italic; color: var(--purple); }

.card-tabs {
    display: flex;
    gap: 4px;
    background: var(--lav-1);
    border-radius: 100px;
    padding: 3px;
}

.card-tab {
    padding: 5px 12px;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.2s;
}

.card-tab.active {
    background: white;
    color: var(--text);
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

/* Activity Chart */
.activity-summary {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 20px;
}

.activity-hours {
    font-family: var(--font-serif);
    font-size: 40px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
    color: var(--text);
}

.activity-hours span {
    font-size: 20px;
    color: var(--muted);
    margin-left: 2px;
}

.activity-label {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
    margin-top: 4px;
}

.chart-container {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 140px;
    padding: 12px 0;
    margin-bottom: 16px;
}

.chart-bar-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    position: relative;
    height: 100%;
    justify-content: flex-end;
}

.chart-tooltip {
    position: absolute;
    top: -28px;
    background: var(--text);
    color: white;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 600;
    opacity: 0;
    transition: opacity 0.2s;
    white-space: nowrap;
    pointer-events: none;
}

.chart-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 4px solid transparent;
    border-top-color: var(--text);
}

.chart-bar-wrap:hover .chart-tooltip { opacity: 1; }

.chart-bar {
    width: 100%;
    max-width: 32px;
    background: var(--lav-2);
    border-radius: 8px 8px 0 0;
    overflow: hidden;
    position: relative;
    transition: all 0.3s;
    cursor: pointer;
}

.chart-bar-wrap:hover .chart-bar {
    transform: translateY(-2px);
}

.chart-bar-fill {
    width: 100%;
    height: 100%;
    background: linear-gradient(180deg, var(--purple), var(--purple-dark));
    border-radius: 8px 8px 0 0;
    animation: growBar 1s ease-out;
}

@keyframes growBar {
    from { transform: scaleY(0); transform-origin: bottom; }
    to { transform: scaleY(1); }
}

.chart-label {
    font-size: 10px;
    font-weight: 600;
    color: var(--muted);
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.activity-meta {
    display: flex;
    gap: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: var(--text-soft);
    font-weight: 500;
}

.meta-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.meta-purple { background: var(--purple); }
.meta-teal { background: var(--teal); }
.meta-orange { background: var(--orange); }

/* Upcoming List */
.upcoming-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.upcoming-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    transition: all 0.2s;
    cursor: pointer;
}

.upcoming-item:hover {
    background: var(--lav-1);
}

.upcoming-time {
    text-align: center;
    min-width: 52px;
    flex-shrink: 0;
}

.upcoming-day {
    font-size: 10px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 2px;
}

.upcoming-clock {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
}

.upcoming-icon {
    width: 40px;
    height: 40px;
    background: rgba(123,111,232,0.12);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.upcoming-icon-orange { background: var(--orange-light); }
.upcoming-icon-teal { background: var(--teal-light); }

.upcoming-info {
    flex: 1;
    min-width: 0;
}

.upcoming-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 2px;
    line-height: 1.3;
}

.upcoming-meta {
    font-size: 11px;
    color: var(--muted);
}

/* ═══ ACHIEVEMENTS ═══ */
.achievements-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}

.achievement-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s;
    cursor: pointer;
}

.achievement-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(30,58,95,0.08);
    border-color: var(--purple);
}

.achievement-icon {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    margin: 0 auto 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    transition: transform 0.3s;
}

.achievement-card:hover .achievement-icon {
    transform: scale(1.08) rotate(-5deg);
}

.achievement-purple { background: linear-gradient(135deg, rgba(123,111,232,0.15), rgba(184,175,235,0.1)); }
.achievement-orange { background: linear-gradient(135deg, var(--orange-light), rgba(255,200,150,0.3)); }
.achievement-gold { background: linear-gradient(135deg, var(--gold-light), rgba(255,215,100,0.3)); }
.achievement-teal { background: linear-gradient(135deg, var(--teal-light), rgba(150,230,200,0.3)); }

.achievement-title {
    font-family: var(--font-serif);
    font-size: 16px;
    font-weight: 400;
    margin-bottom: 4px;
    letter-spacing: -0.01em;
}

.achievement-desc {
    font-size: 11px;
    color: var(--text-soft);
    line-height: 1.4;
    margin-bottom: 8px;
    min-height: 32px;
}

.achievement-date {
    font-size: 10px;
    color: var(--muted);
    font-weight: 500;
    letter-spacing: 0.02em;
}

/* ═══ RECOMMENDED ═══ */
.recommended-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.recommend-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none;
    color: var(--text);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
}

.recommend-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(30,58,95,0.1);
    border-color: var(--purple);
}

.recommend-thumb {
    aspect-ratio: 16/9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
}

.recommend-body {
    padding: 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.recommend-title {
    font-family: var(--font-serif);
    font-size: 17px;
    font-weight: 400;
    line-height: 1.25;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
}

.recommend-instructor {
    font-size: 12px;
    color: var(--text-soft);
    margin-bottom: 10px;
}

.recommend-meta {
    display: flex;
    gap: 12px;
    font-size: 11px;
    color: var(--muted);
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border);
}

.recommend-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.recommend-price {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
}

.price-free { color: var(--teal); }

.recommend-arrow {
    color: var(--purple);
    font-size: 16px;
    transition: transform 0.3s;
}

.recommend-card:hover .recommend-arrow {
    transform: translateX(4px);
}

/* Responsive */
@media (max-width: 1100px) {
    .courses-grid,
    .recommended-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .achievements-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .two-col-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .courses-grid,
    .recommended-grid,
    .achievements-grid {
        grid-template-columns: 1fr;
    }
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

</body>
</html>