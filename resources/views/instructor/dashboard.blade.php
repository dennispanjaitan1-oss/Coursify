<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Instructor Dashboard — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

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
    --blue: #4FACFE;
    --blue-light: #E6F4FE;
    --pink: #F093FB;
    --pink-light: #FCE8FD;
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

.role-pill {
    display: inline-block;
    padding: 3px 10px;
    background: linear-gradient(135deg, var(--purple), var(--purple-dark));
    color: white;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    border-radius: 100px;
    margin-left: 4px;
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

/* Create Course CTA */
.sidebar-cta {
    margin: 16px 4px;
    padding: 16px;
    background: linear-gradient(135deg, var(--navy) 0%, #1E4A7A 100%);
    border-radius: 14px;
    color: white;
    position: relative;
    overflow: hidden;
}

.sidebar-cta::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, rgba(184,175,235,0.3), transparent);
    pointer-events: none;
}

.sidebar-cta-title {
    font-family: var(--font-serif);
    font-size: 16px;
    font-weight: 400;
    line-height: 1.2;
    margin-bottom: 6px;
    position: relative;
    z-index: 1;
}

.sidebar-cta-title em { font-style: italic; color: var(--lav-4); }

.sidebar-cta-desc {
    font-size: 11px;
    color: rgba(255,255,255,0.7);
    margin-bottom: 12px;
    line-height: 1.5;
    position: relative;
    z-index: 1;
}

.sidebar-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 7px 14px;
    background: white;
    color: var(--navy);
    border-radius: 100px;
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
    transition: transform 0.2s;
    position: relative;
    z-index: 1;
}

.sidebar-cta-btn:hover { transform: translateY(-1px); }

/* User Card */
.sidebar-user {
    margin-top: auto;
    padding: 12px;
    background: linear-gradient(135deg, var(--lav-1), white);
    border: 1px solid rgba(123,111,232,0.15);
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
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

.user-info { flex: 1; min-width: 0; }

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

/* ═══ MAIN ═══ */
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

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 18px;
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
}

.btn-primary:hover {
    background: #2A2840;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(26,24,37,0.3);
}

/* ═══ WELCOME ═══ */
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
}

.welcome-card::after {
    content: '';
    position: absolute;
    bottom: -50px;
    left: 40%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(0,200,150,0.15), transparent 70%);
}

.welcome-content { position: relative; z-index: 1; }

.welcome-greeting {
    font-size: 13px;
    color: var(--lav-4);
    margin-bottom: 8px;
    font-weight: 500;
}

.welcome-title {
    font-family: var(--font-serif);
    font-size: 36px;
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-bottom: 12px;
}

.welcome-title em { font-style: italic; color: var(--lav-4); }

.welcome-subtitle {
    font-size: 14px;
    color: rgba(255,255,255,0.75);
    line-height: 1.6;
    max-width: 420px;
    margin-bottom: 18px;
}

.welcome-actions { display: flex; gap: 10px; }

.btn-welcome {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    border-radius: 100px;
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

.btn-welcome-ghost:hover { background: rgba(255,255,255,0.25); }

.welcome-visual { position: relative; z-index: 1; }

.welcome-earnings {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 20px;
    padding: 20px 28px;
    text-align: center;
    min-width: 200px;
}

.earnings-label {
    font-size: 11px;
    color: rgba(255,255,255,0.7);
    font-weight: 500;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.earnings-amount {
    font-family: var(--font-serif);
    font-size: 36px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 4px;
}

.earnings-amount em {
    font-style: italic;
    color: var(--lav-4);
}

.earnings-trend {
    font-size: 11px;
    color: var(--teal-light);
    font-weight: 600;
}

/* ═══ STATS ═══ */
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
.stat-icon-blue { background: var(--blue-light); }
.stat-icon-pink { background: var(--pink-light); }

.stat-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
    margin-bottom: 4px;
}

.stat-value {
    font-family: var(--font-serif);
    font-size: 30px;
    font-weight: 400;
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
    transition: gap 0.2s;
}

.section-link:hover {
    color: var(--purple-dark);
    gap: 8px;
}

/* ═══ REVENUE CHART ═══ */
.two-col-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 16px;
    margin-bottom: 28px;
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
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.2s;
    font-family: var(--font-sans);
}

.card-tab.active {
    background: white;
    color: var(--text);
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.revenue-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    padding: 16px;
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
    border-radius: 14px;
    margin-bottom: 24px;
}

.revenue-item-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.revenue-item-value {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
    color: var(--text);
}

.revenue-item-value em {
    font-style: italic;
    color: var(--purple);
}

/* Line chart visualization */
.chart-line-container {
    height: 180px;
    position: relative;
    margin-bottom: 12px;
}

.chart-svg {
    width: 100%;
    height: 100%;
}

.chart-labels {
    display: flex;
    justify-content: space-between;
    padding: 0 4px;
}

.chart-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
}

/* ═══ TOP COURSES ═══ */
.top-courses-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.top-course-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px;
    border-radius: 12px;
    transition: all 0.2s;
    cursor: pointer;
    border: 1px solid transparent;
}

.top-course-item:hover {
    background: var(--lav-1);
    border-color: rgba(123,111,232,0.2);
}

.top-course-rank {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--lav-2);
    color: var(--purple-dark);
    font-weight: 700;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.top-course-rank.gold {
    background: var(--gold-light);
    color: #B8860B;
}

.top-course-thumb {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.top-course-info {
    flex: 1;
    min-width: 0;
}

.top-course-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 2px;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.top-course-meta {
    font-size: 11px;
    color: var(--muted);
}

.top-course-stat {
    font-family: var(--font-serif);
    font-size: 16px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    text-align: right;
}

.top-course-stat-label {
    font-size: 10px;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-align: right;
}

/* Responsive */
@media (max-width: 1100px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .two-col-grid { grid-template-columns: 1fr; }
    .welcome-card { grid-template-columns: 1fr; }
    .welcome-earnings { min-width: 100%; }
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
    }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0; padding: 16px; }
    .revenue-summary { grid-template-columns: 1fr; }
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

    <div class="sidebar-section">Teaching</div>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link active">
            <span class="sidebar-link-icon">📊</span>
            <span>Dashboard</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">📚</span>
            <span>My Courses</span>
            <span class="sidebar-badge">8</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">👥</span>
            <span>Students</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">📨</span>
            <span>Messages</span>
            <span class="sidebar-badge">3</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">⭐</span>
            <span>Reviews</span>
        </a>
    </nav>

    <div class="sidebar-section">Analytics</div>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">💰</span>
            <span>Earnings</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">📈</span>
            <span>Performance</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">🎯</span>
            <span>Insights</span>
        </a>
    </nav>

    {{-- Create Course CTA --}}
    <div class="sidebar-cta">
        <div class="sidebar-cta-title">New <em>course</em>?</div>
        <div class="sidebar-cta-desc">Share your knowledge and earn by creating courses.</div>
        <a href="#" class="sidebar-cta-btn">
             Create
        </a>
    </div>

    {{-- User Card --}}
    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'I', 0, 1)) }}
        </div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name ?? 'Instructor' }}</div>
            <div class="user-role">Instructor</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;font-size:14px;" title="Logout">
                🚪
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<main class="main">

    {{-- TOP BAR --}}
    <div class="topbar">
        <div class="topbar-search">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Search your courses, students, messages...">
        </div>

        <div class="topbar-actions">
            <button class="icon-btn" title="Notifications">
                🔔
                <span class="icon-btn-dot"></span>
            </button>
            <button class="icon-btn" title="Messages">✉</button>
            <a href="#" class="btn-primary">
                ✏️ Create Course
            </a>
        </div>
    </div>

    {{-- WELCOME HERO --}}
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="welcome-greeting">
                {{ now()->format('l, d F Y') }} · Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}
            </div>
            <h1 class="welcome-title">
                Welcome back, <em>{{ explode(' ', auth()->user()->name ?? 'Instructor')[0] }}</em>
            </h1>
            <p class="welcome-subtitle">
                Your courses are making a difference. 247 students enrolled this week, keep up the great work!
            </p>
            <div class="welcome-actions">
                <a href="#" class="btn-welcome btn-welcome-primary">
                    ✏️ Create New Course
                </a>
                <a href="#" class="btn-welcome btn-welcome-ghost">
                    View Analytics
                </a>
            </div>
        </div>

        <div class="welcome-visual">
            <div class="welcome-earnings">
                <div class="earnings-label">This Month</div>
                <div class="earnings-amount">Rp <em>12.4M</em></div>
                <div class="earnings-trend">↑ 18% vs last month</div>
            </div>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-purple">📚</div>
            <div class="stat-label">Published Courses</div>
            <div class="stat-value">{{ $publishedCount ?? 8 }}</div>
            <div class="stat-trend stat-trend-up">↑ 2 this quarter</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-teal">👥</div>
            <div class="stat-label">Total Students</div>
            <div class="stat-value">{{ $studentsCount ?? '3.4K' }}</div>
            <div class="stat-trend stat-trend-up">↑ 247 this week</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-gold">⭐</div>
            <div class="stat-label">Average Rating</div>
            <div class="stat-value">{{ $avgRating ?? '4.8' }}</div>
            <div class="stat-trend stat-trend-up">↑ 0.2 this month</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-orange">💬</div>
            <div class="stat-label">New Reviews</div>
            <div class="stat-value">{{ $reviewsCount ?? 23 }}</div>
            <div class="stat-trend stat-trend-neutral">Last 7 days</div>
        </div>
    </div>

    {{-- REVENUE CHART + TOP COURSES --}}
    <div class="two-col-grid">

        {{-- Revenue Chart --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Revenue <em>overview</em></h3>
                <div class="card-tabs">
                    <button class="card-tab">7D</button>
                    <button class="card-tab active">30D</button>
                    <button class="card-tab">1Y</button>
                </div>
            </div>

            <div class="revenue-summary">
                <div>
                    <div class="revenue-item-label">Total Revenue</div>
                    <div class="revenue-item-value">Rp <em>42.8M</em></div>
                </div>
                <div>
                    <div class="revenue-item-label">This Month</div>
                    <div class="revenue-item-value">Rp 12.4M</div>
                </div>
                <div>
                    <div class="revenue-item-label">Pending Payout</div>
                    <div class="revenue-item-value">Rp 3.2M</div>
                </div>
            </div>

            <div class="chart-line-container">
                <svg class="chart-svg" viewBox="0 0 400 180" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="lineGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#7B6FE8" stop-opacity="0.3"/>
                            <stop offset="100%" stop-color="#7B6FE8" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    {{-- Grid lines --}}
                    <line x1="0" y1="45" x2="400" y2="45" stroke="#E8E1F3" stroke-dasharray="4,4"/>
                    <line x1="0" y1="90" x2="400" y2="90" stroke="#E8E1F3" stroke-dasharray="4,4"/>
                    <line x1="0" y1="135" x2="400" y2="135" stroke="#E8E1F3" stroke-dasharray="4,4"/>

                    {{-- Area fill --}}
                    <path d="M 0,130 L 40,110 L 80,85 L 120,95 L 160,70 L 200,60 L 240,50 L 280,65 L 320,40 L 360,25 L 400,30 L 400,180 L 0,180 Z"
                          fill="url(#lineGrad)"/>

                    {{-- Line --}}
                    <path d="M 0,130 L 40,110 L 80,85 L 120,95 L 160,70 L 200,60 L 240,50 L 280,65 L 320,40 L 360,25 L 400,30"
                          stroke="#7B6FE8" stroke-width="2.5" fill="none" stroke-linecap="round"/>

                    {{-- Dots --}}
                    <circle cx="320" cy="40" r="5" fill="white" stroke="#7B6FE8" stroke-width="2.5"/>
                    <circle cx="360" cy="25" r="5" fill="white" stroke="#7B6FE8" stroke-width="2.5"/>
                    <circle cx="400" cy="30" r="6" fill="#7B6FE8"/>
                </svg>
            </div>

            <div class="chart-labels">
                <span class="chart-label">Week 1</span>
                <span class="chart-label">Week 2</span>
                <span class="chart-label">Week 3</span>
                <span class="chart-label">Week 4</span>
            </div>
        </div>

        {{-- Top Courses --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Top <em>courses</em></h3>
                <a href="#" class="section-link">All →</a>
            </div>

            <div class="top-courses-list">
                @php
                    $topCourses = [
                        ['rank' => 1, 'title' => 'Fullstack Web Dev Laravel', 'students' => '1.2K', 'revenue' => 'Rp 8.4M', 'thumb' => 'course-thumb-1', 'icon' => '💻'],
                        ['rank' => 2, 'title' => 'React.js from Zero to Hero', 'students' => '856', 'revenue' => 'Rp 5.2M', 'thumb' => 'course-thumb-2', 'icon' => '⚛️'],
                        ['rank' => 3, 'title' => 'Python for Data Analysis', 'students' => '642', 'revenue' => 'Rp 3.1M', 'thumb' => 'course-thumb-3', 'icon' => '📊'],
                        ['rank' => 4, 'title' => 'DevOps with Docker', 'students' => '398', 'revenue' => 'Rp 2.4M', 'thumb' => 'course-thumb-5', 'icon' => '🐳'],
                    ];
                @endphp

                @foreach($topCourses as $course)
                    <div class="top-course-item">
                        <div class="top-course-rank {{ $course['rank'] === 1 ? 'gold' : '' }}">
                            {{ $course['rank'] }}
                        </div>
                        <div class="top-course-thumb {{ $course['thumb'] }}"
                             style="background: {{ $course['rank'] === 1 ? 'linear-gradient(135deg,#667EEA,#764BA2)' : ($course['rank'] === 2 ? 'linear-gradient(135deg,#F093FB,#F5576C)' : ($course['rank'] === 3 ? 'linear-gradient(135deg,#4FACFE,#00F2FE)' : 'linear-gradient(135deg,#30CFD0,#330867)')) }};">
                            {{ $course['icon'] }}
                        </div>
                        <div class="top-course-info">
                            <div class="top-course-title">{{ $course['title'] }}</div>
                            <div class="top-course-meta">👥 {{ $course['students'] }} students</div>
                        </div>
                        <div>
                            <div class="top-course-stat">{{ $course['revenue'] }}</div>
                            <div class="top-course-stat-label">Revenue</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    
    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- COURSES MANAGEMENT TABLE                             --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="section-header">
        <h2 class="section-title">Courses <em>management</em></h2>
        <div style="display:flex;gap:10px;align-items:center;">
            <div class="filter-tabs">
                <button class="filter-tab active">All (8)</button>
                <button class="filter-tab">Published (6)</button>
                <button class="filter-tab">Draft (2)</button>
            </div>
            <a href="#" class="section-link">View all →</a>
        </div>
    </div>

    <div class="courses-table-wrap">
        <table class="courses-table">
            <thead>
                <tr>
                    <th style="width:40%;">Course</th>
                    <th>Students</th>
                    <th>Rating</th>
                    <th>Revenue</th>
                    <th>Status</th>
                    <th style="width:80px;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $manageCourses = [
                        ['thumb' => 1, 'icon' => '💻', 'title' => 'Fullstack Web Development with Laravel 12', 'category' => 'Programming', 'students' => 1203, 'rating' => 4.9, 'reviews' => 284, 'revenue' => 'Rp 8.4M', 'status' => 'published'],
                        ['thumb' => 2, 'icon' => '⚛️', 'title' => 'React.js from Zero to Hero', 'category' => 'Programming', 'students' => 856, 'rating' => 4.8, 'reviews' => 167, 'revenue' => 'Rp 5.2M', 'status' => 'published'],
                        ['thumb' => 3, 'icon' => '📊', 'title' => 'Python for Data Analysis', 'category' => 'Data Science', 'students' => 642, 'rating' => 4.9, 'reviews' => 145, 'revenue' => 'Rp 3.1M', 'status' => 'published'],
                        ['thumb' => 4, 'icon' => '🐳', 'title' => 'DevOps with Docker & Kubernetes', 'category' => 'DevOps', 'students' => 398, 'rating' => 4.7, 'reviews' => 89, 'revenue' => 'Rp 2.4M', 'status' => 'published'],
                        ['thumb' => 5, 'icon' => '🎨', 'title' => 'UI/UX Design Masterclass', 'category' => 'Design', 'students' => 0, 'rating' => 0, 'reviews' => 0, 'revenue' => 'Rp 0', 'status' => 'draft'],
                    ];
                @endphp

                @foreach($manageCourses as $course)
                    <tr>
                        <td>
                            <div class="course-cell">
                                <div class="course-cell-thumb course-thumb-{{ $course['thumb'] }}">
                                    {{ $course['icon'] }}
                                </div>
                                <div class="course-cell-info">
                                    <div class="course-cell-title">{{ $course['title'] }}</div>
                                    <div class="course-cell-cat">{{ $course['category'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="cell-value">{{ number_format($course['students']) }}</div>
                            <div class="cell-label">enrolled</div>
                        </td>
                        <td>
                            @if($course['rating'] > 0)
                                <div class="rating-wrap">
                                    <span class="rating-star">⭐</span>
                                    <span class="cell-value">{{ $course['rating'] }}</span>
                                </div>
                                <div class="cell-label">{{ $course['reviews'] }} reviews</div>
                            @else
                                <div class="cell-value" style="color:var(--muted);">—</div>
                                <div class="cell-label">No ratings</div>
                            @endif
                        </td>
                        <td>
                            <div class="cell-value">{{ $course['revenue'] }}</div>
                            <div class="cell-label">lifetime</div>
                        </td>
                        <td>
                            @if($course['status'] === 'published')
                                <span class="status-badge status-published">
                                    <span class="status-dot status-dot-teal"></span>
                                    Published
                                </span>
                            @else
                                <span class="status-badge status-draft">
                                    <span class="status-dot status-dot-orange"></span>
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="actions-wrap" x-data="{ open: false }">
                                <button class="action-btn" @click="open = !open">⋯</button>
                                <div x-show="open" @click.away="open = false" x-transition class="actions-menu">
                                    <a href="#" class="actions-item">👁 View</a>
                                    <a href="#" class="actions-item">✏️ Edit</a>
                                    <a href="#" class="actions-item">📊 Analytics</a>
                                    <a href="#" class="actions-item">📋 Duplicate</a>
                                    <div style="height:1px;background:var(--border);margin:4px 0;"></div>
                                    <a href="#" class="actions-item actions-danger">🗑 Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- TWO COL: ENROLLMENTS + REVIEWS                       --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="two-col-equal">

        {{-- Recent Enrollments --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">New <em>enrollments</em></h3>
                <a href="#" class="section-link">All →</a>
            </div>

            <div class="enrollment-list">
                @php
                    $enrollments = [
                        ['avatar' => 'A', 'name' => 'Andi Pratama', 'course' => 'Laravel 12', 'time' => '2m ago', 'color' => 'purple'],
                        ['avatar' => 'S', 'name' => 'Sari Wijaya', 'course' => 'React.js', 'time' => '18m ago', 'color' => 'teal'],
                        ['avatar' => 'R', 'name' => 'Rizky Hakim', 'course' => 'Python Data', 'time' => '1h ago', 'color' => 'orange'],
                        ['avatar' => 'M', 'name' => 'Maya Putri', 'course' => 'Laravel 12', 'time' => '3h ago', 'color' => 'purple'],
                        ['avatar' => 'D', 'name' => 'Dimas Saputra', 'course' => 'DevOps Docker', 'time' => '5h ago', 'color' => 'gold'],
                    ];
                @endphp

                @foreach($enrollments as $enroll)
                    <div class="enrollment-item">
                        <div class="enroll-avatar enroll-avatar-{{ $enroll['color'] }}">
                            {{ $enroll['avatar'] }}
                        </div>
                        <div class="enroll-info">
                            <div class="enroll-name">
                                <strong>{{ $enroll['name'] }}</strong> enrolled in
                            </div>
                            <div class="enroll-course">{{ $enroll['course'] }}</div>
                        </div>
                        <div class="enroll-time">{{ $enroll['time'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Reviews --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Recent <em>reviews</em></h3>
                <a href="#" class="section-link">All →</a>
            </div>

            <div class="reviews-list">
                @php
                    $reviews = [
                        ['avatar' => 'A', 'name' => 'Ahmad R.', 'rating' => 5, 'course' => 'Laravel 12', 'comment' => 'Best Laravel course I\'ve ever taken! Very clear and practical.', 'time' => '2h ago'],
                        ['avatar' => 'B', 'name' => 'Budi S.', 'rating' => 5, 'course' => 'React.js', 'comment' => 'Andi explains everything so well. Highly recommended!', 'time' => '5h ago'],
                        ['avatar' => 'C', 'name' => 'Citra L.', 'rating' => 4, 'course' => 'Python Data', 'comment' => 'Great content, but a few sections could be more detailed.', 'time' => '1d ago'],
                    ];
                @endphp

                @foreach($reviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div class="review-avatar">{{ $review['avatar'] }}</div>
                            <div class="review-meta">
                                <div class="review-name">{{ $review['name'] }}</div>
                                <div class="review-course">on {{ $review['course'] }}</div>
                            </div>
                            <div class="review-stars">
                                {{ str_repeat('★', $review['rating']) }}<span style="color:var(--lav-3);">{{ str_repeat('★', 5 - $review['rating']) }}</span>
                            </div>
                        </div>
                        <p class="review-comment">"{{ $review['comment'] }}"</p>
                        <div class="review-footer">
                            <span class="review-time">{{ $review['time'] }}</span>
                            <a href="#" class="review-reply">Reply →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- MESSAGES + QUICK ACTIONS                             --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="two-col-grid" style="margin-bottom: 40px;">

        {{-- Student Messages --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Student <em>messages</em></h3>
                <div style="display:flex;gap:8px;align-items:center;">
                    <span class="unread-badge">3 unread</span>
                    <a href="#" class="section-link">Inbox →</a>
                </div>
            </div>

            <div class="messages-list">
                @php
                    $messages = [
                        ['avatar' => 'R', 'name' => 'Rizky Pratama', 'preview' => 'Halo Pak Budi, saya kesulitan di lesson 15 tentang middleware. Bisa dijelaskan lebih detail?', 'time' => '5m ago', 'unread' => true, 'color' => 'purple'],
                        ['avatar' => 'S', 'name' => 'Sari Dewi', 'preview' => 'Terima kasih kursusnya! Saya berhasil dapat kerja sebagai Full-Stack Developer!', 'time' => '2h ago', 'unread' => true, 'color' => 'teal'],
                        ['avatar' => 'D', 'name' => 'Dimas Hakim', 'preview' => 'Kapan ada update konten terbaru? Materinya sangat bermanfaat.', 'time' => '1d ago', 'unread' => true, 'color' => 'orange'],
                        ['avatar' => 'M', 'name' => 'Maya Putri', 'preview' => 'Saya sudah menyelesaikan final project, mohon review Pak.', 'time' => '2d ago', 'unread' => false, 'color' => 'gold'],
                    ];
                @endphp

                @foreach($messages as $msg)
                    <div class="message-item {{ $msg['unread'] ? 'unread' : '' }}">
                        <div class="enroll-avatar enroll-avatar-{{ $msg['color'] }}">
                            {{ $msg['avatar'] }}
                        </div>
                        <div class="message-info">
                            <div class="message-header">
                                <div class="message-name">{{ $msg['name'] }}</div>
                                <div class="message-time">{{ $msg['time'] }}</div>
                            </div>
                            <div class="message-preview">{{ $msg['preview'] }}</div>
                        </div>
                        @if($msg['unread'])
                            <div class="message-dot"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="card-wrap quick-actions-wrap">
            <div class="card-head">
                <h3 class="card-title">Quick <em>actions</em></h3>
            </div>

            <div class="actions-grid">
                <a href="#" class="quick-action">
                    <div class="quick-icon quick-icon-purple">✏️</div>
                    <div class="quick-label">Create Course</div>
                </a>
                <a href="#" class="quick-action">
                    <div class="quick-icon quick-icon-teal">📹</div>
                    <div class="quick-label">Upload Video</div>
                </a>
                <a href="#" class="quick-action">
                    <div class="quick-icon quick-icon-orange">📝</div>
                    <div class="quick-label">Add Quiz</div>
                </a>
                <a href="#" class="quick-action">
                    <div class="quick-icon quick-icon-gold">📨</div>
                    <div class="quick-label">Broadcast</div>
                </a>
                <a href="#" class="quick-action">
                    <div class="quick-icon quick-icon-blue">💰</div>
                    <div class="quick-label">Withdraw</div>
                </a>
                <a href="#" class="quick-action">
                    <div class="quick-icon quick-icon-pink">📊</div>
                    <div class="quick-label">Reports</div>
                </a>
            </div>

            {{-- Tips card --}}
            <div class="tips-card">
                <div class="tips-icon">💡</div>
                <div class="tips-content">
                    <div class="tips-title">Pro Tip</div>
                    <div class="tips-text">Courses with video intro get 3x more enrollments. Add one to your drafts!</div>
                </div>
            </div>
        </div>

    </div>

</main>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- ADDITIONAL STYLES                                    --}}
{{-- ═══════════════════════════════════════════════════ --}}
<style>

/* ═══ FILTER TABS ═══ */
.filter-tabs {
    display: flex;
    gap: 4px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 100px;
    padding: 3px;
}

.filter-tab {
    padding: 6px 14px;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-tab.active {
    background: var(--text);
    color: white;
}

/* ═══ COURSES TABLE ═══ */
.courses-table-wrap {
    background: white;
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 28px;
}

.courses-table {
    width: 100%;
    border-collapse: collapse;
}

.courses-table thead {
    background: var(--lav-1);
}

.courses-table th {
    padding: 14px 20px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: var(--muted);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border-bottom: 1px solid var(--border);
}

.courses-table td {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.courses-table tbody tr:last-child td {
    border-bottom: none;
}

.courses-table tbody tr {
    transition: background 0.2s;
}

.courses-table tbody tr:hover {
    background: var(--lav-1);
}

.course-cell {
    display: flex;
    align-items: center;
    gap: 14px;
}

.course-cell-thumb {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
.course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
.course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }
.course-thumb-4 { background: linear-gradient(135deg, #FA709A, #FEE140); }
.course-thumb-5 { background: linear-gradient(135deg, #30CFD0, #330867); }
.course-thumb-6 { background: linear-gradient(135deg, #A8EDEA, #FED6E3); }

.course-cell-info { min-width: 0; }

.course-cell-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 4px;
    line-height: 1.3;
}

.course-cell-cat {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}

.cell-value {
    font-family: var(--font-serif);
    font-size: 17px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    line-height: 1;
    margin-bottom: 2px;
}

.cell-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.rating-wrap {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.rating-star { font-size: 13px; }

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 10px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.02em;
}

.status-published {
    background: var(--teal-light);
    color: #00805F;
}

.status-draft {
    background: var(--orange-light);
    color: #C24E1F;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-dot-teal { background: var(--teal); }
.status-dot-orange { background: var(--orange); }

/* Action Dropdown */
.actions-wrap {
    position: relative;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid transparent;
    background: transparent;
    cursor: pointer;
    font-size: 16px;
    color: var(--text-soft);
    transition: all 0.2s;
}

.action-btn:hover {
    background: white;
    border-color: var(--border);
    color: var(--purple);
}

.actions-menu {
    position: absolute;
    right: 0;
    top: calc(100% + 4px);
    background: white;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 6px;
    min-width: 160px;
    box-shadow: 0 10px 40px rgba(30,58,95,0.12);
    z-index: 10;
}

.actions-item {
    display: block;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    color: var(--text-soft);
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
}

.actions-item:hover {
    background: var(--lav-1);
    color: var(--text);
}

.actions-danger { color: var(--orange); }
.actions-danger:hover {
    background: var(--orange-light);
    color: var(--orange);
}

/* ═══ TWO COL EQUAL ═══ */
.two-col-equal {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 28px;
}

/* ═══ ENROLLMENT LIST ═══ */
.enrollment-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.enrollment-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 12px;
    transition: background 0.2s;
    cursor: pointer;
}

.enrollment-item:hover {
    background: var(--lav-1);
}

.enroll-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 13px;
    flex-shrink: 0;
}

.enroll-avatar-purple { background: linear-gradient(135deg, var(--purple), var(--purple-dark)); }
.enroll-avatar-teal { background: linear-gradient(135deg, var(--teal), #00A075); }
.enroll-avatar-orange { background: linear-gradient(135deg, var(--orange), #E66B3A); }
.enroll-avatar-gold { background: linear-gradient(135deg, var(--gold), #D19E2E); }

.enroll-info { flex: 1; min-width: 0; }

.enroll-name {
    font-size: 12px;
    color: var(--text-soft);
    line-height: 1.4;
    margin-bottom: 2px;
}

.enroll-name strong {
    color: var(--text);
    font-weight: 600;
}

.enroll-course {
    font-size: 12px;
    color: var(--purple);
    font-weight: 600;
}

.enroll-time {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
    flex-shrink: 0;
}

/* ═══ REVIEWS LIST ═══ */
.reviews-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.review-item {
    padding: 14px;
    border: 1px solid var(--border);
    border-radius: 14px;
    transition: all 0.2s;
}

.review-item:hover {
    border-color: var(--purple);
    background: var(--lav-1);
}

.review-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.review-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--purple), var(--purple-dark));
    color: white;
    font-weight: 700;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.review-meta { flex: 1; min-width: 0; }

.review-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
}

.review-course {
    font-size: 11px;
    color: var(--muted);
}

.review-stars {
    font-size: 13px;
    color: var(--gold);
    letter-spacing: 1px;
    flex-shrink: 0;
}

.review-comment {
    font-family: var(--font-serif);
    font-size: 14px;
    color: var(--text-soft);
    line-height: 1.5;
    font-style: italic;
    margin-bottom: 10px;
}

.review-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.review-time {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}

.review-reply {
    font-size: 12px;
    color: var(--purple);
    text-decoration: none;
    font-weight: 600;
    transition: gap 0.2s;
}

.review-reply:hover { color: var(--purple-dark); }

/* ═══ MESSAGES ═══ */
.unread-badge {
    background: var(--orange);
    color: white;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 100px;
    letter-spacing: 0.02em;
}

.messages-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.message-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    transition: background 0.2s;
    cursor: pointer;
    position: relative;
}

.message-item:hover {
    background: var(--lav-1);
}

.message-item.unread {
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
}

.message-info {
    flex: 1;
    min-width: 0;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
    gap: 10px;
}

.message-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
}

.message-time {
    font-size: 11px;
    color: var(--muted);
    flex-shrink: 0;
}

.message-preview {
    font-size: 12px;
    color: var(--text-soft);
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.message-dot {
    width: 8px;
    height: 8px;
    background: var(--purple);
    border-radius: 50%;
    position: absolute;
    top: 16px;
    right: 12px;
    box-shadow: 0 0 8px rgba(123,111,232,0.4);
}

/* ═══ QUICK ACTIONS ═══ */
.quick-actions-wrap {
    display: flex;
    flex-direction: column;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.quick-action {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px 8px;
    border: 1px solid var(--border);
    border-radius: 14px;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}

.quick-action:hover {
    border-color: var(--purple);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(30,58,95,0.08);
}

.quick-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: transform 0.2s;
}

.quick-action:hover .quick-icon {
    transform: scale(1.1);
}

.quick-icon-purple { background: rgba(123,111,232,0.12); }
.quick-icon-teal { background: var(--teal-light); }
.quick-icon-orange { background: var(--orange-light); }
.quick-icon-gold { background: var(--gold-light); }
.quick-icon-blue { background: var(--blue-light); }
.quick-icon-pink { background: var(--pink-light); }

.quick-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-soft);
    text-align: center;
    letter-spacing: -0.01em;
}

/* Tips Card */
.tips-card {
    display: flex;
    gap: 12px;
    padding: 14px;
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
    border: 1px solid rgba(123,111,232,0.15);
    border-radius: 14px;
    margin-top: auto;
}

.tips-icon {
    font-size: 24px;
    flex-shrink: 0;
}

.tips-title {
    font-family: var(--font-serif);
    font-size: 14px;
    font-weight: 400;
    color: var(--text);
    margin-bottom: 4px;
    letter-spacing: -0.01em;
}

.tips-text {
    font-size: 11px;
    color: var(--text-soft);
    line-height: 1.5;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 1100px) {
    .two-col-equal { grid-template-columns: 1fr; }
    .actions-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    .courses-table {
        font-size: 12px;
    }
    .courses-table th, .courses-table td {
        padding: 12px 10px;
    }
    .course-cell-thumb {
        width: 40px; height: 40px;
        font-size: 18px;
    }
}

@media (max-width: 768px) {
    .courses-table-wrap {
        overflow-x: auto;
    }
    .courses-table {
        min-width: 700px;
    }
    .actions-grid { grid-template-columns: repeat(3, 1fr); }
}
</style>

</body>
</html>