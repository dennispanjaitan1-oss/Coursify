<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin Dashboard — Coursify</title>

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
    --red: #EF4444;
    --red-light: #FEE2E2;
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
    padding: 20px 14px;
    position: fixed;
    height: 100vh;
    display: flex;
    flex-direction: column;
    z-index: 50;
    overflow-y: auto;
}

.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-thumb { background: var(--lav-3); border-radius: 4px; }

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 8px 20px;
    text-decoration: none;
    color: var(--text);
    border-bottom: 1px solid var(--border);
    margin-bottom: 16px;
}

.sidebar-logo-img {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(30,58,95,0.2);
    object-fit: cover;
    flex-shrink: 0;
}

.sidebar-logo-text {
    font-size: 17px;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.admin-badge {
    font-size: 9px;
    font-weight: 700;
    color: white;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    padding: 2px 7px;
    border-radius: 100px;
    margin-left: 4px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    vertical-align: middle;
}

.sidebar-section {
    font-size: 10px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    padding: 10px 10px 6px;
}

.sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: 2px;
    margin-bottom: 12px;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 10px;
    border-radius: 9px;
    text-decoration: none;
    color: var(--text-soft);
    font-size: 13px;
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
    width: 16px;
    font-size: 14px;
    text-align: center;
    flex-shrink: 0;
}

.sidebar-badge {
    margin-left: auto;
    background: var(--orange);
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 100px;
    min-width: 18px;
    text-align: center;
}

.sidebar-link.active .sidebar-badge {
    background: white;
    color: var(--purple);
}

/* User Card */
.sidebar-user {
    margin-top: auto;
    padding: 10px;
    background: linear-gradient(135deg, var(--lav-1), white);
    border: 1px solid rgba(123,111,232,0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white;
    font-weight: 700;
    font-size: 12px;
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
    font-size: 12px;
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

.btn-logout {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--muted);
    padding: 4px;
    font-size: 13px;
    flex-shrink: 0;
}

/* ═══ MAIN ═══ */
.main {
    flex: 1;
    margin-left: 240px;
    padding: 20px 28px;
    min-height: 100vh;
    min-width: 0;
}

/* Top Bar */
.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 12px;
    flex-wrap: wrap;
}

.topbar-left {
    flex: 1;
    min-width: 0;
}

.page-title {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 400;
    letter-spacing: -0.02em;
    color: var(--text);
    line-height: 1.1;
    margin-bottom: 4px;
}

.page-title em {
    font-style: italic;
    color: var(--purple);
}

.page-subtitle {
    font-size: 13px;
    color: var(--muted);
    font-weight: 500;
}

.topbar-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.icon-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: var(--text-soft);
    font-size: 15px;
    position: relative;
}

.icon-btn:hover {
    background: var(--lav-1);
    border-color: var(--purple);
}

.icon-btn-dot {
    position: absolute;
    top: 6px;
    right: 6px;
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
    padding: 9px 16px;
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
}

.btn-primary:hover {
    background: #2A2840;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(26,24,37,0.3);
}

/* ═══ STATS GRID ═══ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}

.stat-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 18px;
    transition: all 0.2s;
    min-width: 0;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(30,58,95,0.08);
    border-color: var(--purple);
}

.stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

.stat-icon-wrap {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.stat-icon-purple { background: rgba(123,111,232,0.12); }
.stat-icon-teal { background: var(--teal-light); }
.stat-icon-orange { background: var(--orange-light); }
.stat-icon-gold { background: var(--gold-light); }

.stat-trend {
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 100px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    letter-spacing: 0.02em;
}

.stat-trend-up {
    background: var(--teal-light);
    color: #00805F;
}

.stat-trend-down {
    background: var(--red-light);
    color: var(--red);
}

.stat-trend-neutral {
    background: var(--lav-1);
    color: var(--muted);
}

.stat-value {
    font-family: var(--font-serif);
    font-size: 32px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 5px;
    color: var(--text);
}

.stat-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}

/* ═══ CHARTS ROW ═══ */
.charts-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 14px;
    margin-bottom: 20px;
}

.card-wrap {
    background: white;
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 22px;
    min-width: 0;
}

.card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    flex-wrap: wrap;
    gap: 10px;
}

.card-title {
    font-family: var(--font-serif);
    font-size: 20px;
    font-weight: 400;
    letter-spacing: -0.01em;
    line-height: 1.2;
}

.card-title em {
    font-style: italic;
    color: var(--purple);
}

.card-tabs {
    display: flex;
    gap: 4px;
    background: var(--lav-1);
    border-radius: 100px;
    padding: 3px;
}

.card-tab {
    padding: 5px 11px;
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

/* Revenue Chart */
.revenue-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    padding: 14px;
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
    border-radius: 12px;
    margin-bottom: 20px;
}

.revenue-item {
    text-align: left;
    min-width: 0;
}

.revenue-item-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.revenue-item-value {
    font-family: var(--font-serif);
    font-size: 20px;
    font-weight: 400;
    letter-spacing: -0.01em;
    line-height: 1;
    color: var(--text);
    white-space: nowrap;
}

.revenue-item-value em {
    font-style: italic;
    color: var(--purple);
}

.chart-container {
    height: 200px;
    position: relative;
    margin-bottom: 10px;
}

.chart-svg {
    width: 100%;
    height: 100%;
}

.chart-labels-row {
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

/* User Distribution */
.donut-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px 0;
}

.donut-chart {
    position: relative;
    width: 160px;
    height: 160px;
    margin-bottom: 20px;
}

.donut-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.donut-total {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1;
}

.donut-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-top: 4px;
}

.donut-legend {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

.legend-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    background: var(--lav-1);
    border-radius: 10px;
}

.legend-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 0;
}

.legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-label {
    font-size: 12px;
    color: var(--text-soft);
    font-weight: 600;
}

.legend-value {
    font-family: var(--font-serif);
    font-size: 16px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    flex-shrink: 0;
}

/* Responsive */
@media (max-width: 1200px) {
    .charts-grid { grid-template-columns: 1fr; }
}

@media (max-width: 1000px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
    }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0; padding: 16px; }
    .revenue-summary { grid-template-columns: 1fr; gap: 10px; }
    .page-title { font-size: 22px; }
}
</style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="sidebar-logo-img">
        <span class="sidebar-logo-text">Coursify</span>
        <span class="admin-badge">ADMIN</span>
    </a>

    <div class="sidebar-section">Overview</div>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link active">
            <span class="sidebar-link-icon">📊</span>
            <span>Dashboard</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">📈</span>
            <span>Analytics</span>
        </a>
    </nav>

    <div class="sidebar-section">Management</div>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">👥</span>
            <span>Users</span>
            <span class="sidebar-badge">3.4K</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">📚</span>
            <span>Courses</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">🏫</span>
            <span>Institutions</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">🗂</span>
            <span>Categories</span>
        </a>
    </nav>

    <div class="sidebar-section">Moderation</div>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">✅</span>
            <span>Approvals</span>
            <span class="sidebar-badge">5</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">⭐</span>
            <span>Reviews</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">🚩</span>
            <span>Reports</span>
            <span class="sidebar-badge">2</span>
        </a>
    </nav>

    <div class="sidebar-section">Finance</div>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">💰</span>
            <span>Transactions</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">💳</span>
            <span>Payouts</span>
        </a>
    </nav>

    <div class="sidebar-section">System</div>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">⚙️</span>
            <span>Settings</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="sidebar-link-icon">📋</span>
            <span>Logs</span>
        </a>
    </nav>

    {{-- User Card --}}
    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="user-role">Administrator</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout" title="Logout">🚪</button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<main class="main">

    {{-- TOP BAR --}}
    <div class="topbar">
        <div class="topbar-left">
            <h1 class="page-title">
                Welcome, <em>{{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}</em>
            </h1>
            <div class="page-subtitle">
                {{ now()->format('l, d F Y') }} · Platform overview
            </div>
        </div>

        <div class="topbar-actions">
            <button class="icon-btn" title="Notifications">
                🔔
                <span class="icon-btn-dot"></span>
            </button>
            <button class="icon-btn" title="Search">🔍</button>
            <a href="#" class="btn-primary">
                ↓ Export
            </a>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrap stat-icon-purple">👥</div>
                <span class="stat-trend stat-trend-up">↑ 12%</span>
            </div>
            <div class="stat-value">{{ $totalUsers ?? '3.4K' }}</div>
            <div class="stat-label">Total Users</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrap stat-icon-teal">📚</div>
                <span class="stat-trend stat-trend-up">↑ 8%</span>
            </div>
            <div class="stat-value">{{ $totalCourses ?? 20 }}</div>
            <div class="stat-label">Total Courses</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrap stat-icon-gold">💰</div>
                <span class="stat-trend stat-trend-up">↑ 24%</span>
            </div>
            <div class="stat-value">42.8M</div>
            <div class="stat-label">Revenue (IDR)</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrap stat-icon-orange">🎓</div>
                <span class="stat-trend stat-trend-up">↑ 18%</span>
            </div>
            <div class="stat-value">{{ $totalEnrollments ?? 1847 }}</div>
            <div class="stat-label">Enrollments</div>
        </div>
    </div>

    {{-- CHARTS --}}
    <div class="charts-grid">
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
                <div class="revenue-item">
                    <div class="revenue-item-label">Total</div>
                    <div class="revenue-item-value">Rp <em>42.8M</em></div>
                </div>
                <div class="revenue-item">
                    <div class="revenue-item-label">This Month</div>
                    <div class="revenue-item-value">Rp 12.4M</div>
                </div>
                <div class="revenue-item">
                    <div class="revenue-item-label">Avg / Day</div>
                    <div class="revenue-item-value">Rp 412K</div>
                </div>
            </div>

            <div class="chart-container">
                <svg class="chart-svg" viewBox="0 0 400 180" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="revGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#7B6FE8" stop-opacity="0.25"/>
                            <stop offset="100%" stop-color="#7B6FE8" stop-opacity="0"/>
                        </linearGradient>
                    </defs>

                    <line x1="0" y1="45" x2="400" y2="45" stroke="#E8E1F3" stroke-dasharray="3,3"/>
                    <line x1="0" y1="90" x2="400" y2="90" stroke="#E8E1F3" stroke-dasharray="3,3"/>
                    <line x1="0" y1="135" x2="400" y2="135" stroke="#E8E1F3" stroke-dasharray="3,3"/>

                    <path d="M 0,130 L 40,115 L 80,90 L 120,100 L 160,75 L 200,65 L 240,55 L 280,70 L 320,45 L 360,30 L 400,35 L 400,180 L 0,180 Z"
                          fill="url(#revGrad)"/>

                    <path d="M 0,130 L 40,115 L 80,90 L 120,100 L 160,75 L 200,65 L 240,55 L 280,70 L 320,45 L 360,30 L 400,35"
                          stroke="#7B6FE8" stroke-width="2.5" fill="none" stroke-linecap="round"/>

                    <circle cx="360" cy="30" r="5" fill="white" stroke="#7B6FE8" stroke-width="2.5"/>
                    <circle cx="400" cy="35" r="6" fill="#7B6FE8"/>
                </svg>
            </div>

            <div class="chart-labels-row">
                <span class="chart-label">Week 1</span>
                <span class="chart-label">Week 2</span>
                <span class="chart-label">Week 3</span>
                <span class="chart-label">Week 4</span>
            </div>
        </div>

        {{-- User Distribution --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">User <em>distribution</em></h3>
            </div>

            <div class="donut-wrap">
                <div class="donut-chart">
                    <svg width="160" height="160" viewBox="0 0 160 160">
                        <circle cx="80" cy="80" r="60" fill="none" stroke="#E8E1F3" stroke-width="18"/>

                        {{-- Students 80% (purple) --}}
                        <circle cx="80" cy="80" r="60" fill="none"
                                stroke="#7B6FE8" stroke-width="18"
                                stroke-dasharray="301.6 377"
                                stroke-dashoffset="0"
                                transform="rotate(-90 80 80)"
                                stroke-linecap="round"/>

                        {{-- Instructors 15% (teal) --}}
                        <circle cx="80" cy="80" r="60" fill="none"
                                stroke="#00C896" stroke-width="18"
                                stroke-dasharray="56.5 377"
                                stroke-dashoffset="-305"
                                transform="rotate(-90 80 80)"
                                stroke-linecap="round"/>

                        {{-- Admin 5% (gold) --}}
                        <circle cx="80" cy="80" r="60" fill="none"
                                stroke="#FFC452" stroke-width="18"
                                stroke-dasharray="18.8 377"
                                stroke-dashoffset="-364"
                                transform="rotate(-90 80 80)"
                                stroke-linecap="round"/>
                    </svg>

                    <div class="donut-center">
                        <div class="donut-total">3.4K</div>
                        <div class="donut-label">Total</div>
                    </div>
                </div>

                <div class="donut-legend">
                    <div class="legend-item">
                        <div class="legend-left">
                            <div class="legend-dot" style="background:var(--purple);"></div>
                            <div class="legend-label">Students</div>
                        </div>
                        <div class="legend-value">80%</div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-left">
                            <div class="legend-dot" style="background:var(--teal);"></div>
                            <div class="legend-label">Instructors</div>
                        </div>
                        <div class="legend-value">15%</div>
                    </div>
                    <div class="legend-item">
                        <div class="legend-left">
                            <div class="legend-dot" style="background:var(--gold);"></div>
                            <div class="legend-label">Admins</div>
                        </div>
                        <div class="legend-value">5%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- RECENT USERS TABLE                                   --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="card-wrap" style="margin-bottom: 20px;">
        <div class="card-head">
            <h3 class="card-title">Recent <em>users</em></h3>
            <div style="display:flex;gap:8px;align-items:center;">
                <div class="filter-tabs">
                    <button class="filter-tab active">All</button>
                    <button class="filter-tab">Students</button>
                    <button class="filter-tab">Instructors</button>
                </div>
                <a href="#" class="section-link">View all →</a>
            </div>
        </div>

        <div class="users-table-wrap">
            <table class="users-table">
                <thead>
                    <tr>
                        <th style="width:35%;">User</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Activity</th>
                        <th>Status</th>
                        <th style="width:60px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $recentUsers = [
                            ['name' => 'Andi Pratama', 'email' => 'andi@email.com', 'role' => 'student', 'joined' => '2 hours ago', 'activity' => '3 courses', 'status' => 'active', 'color' => 'purple'],
                            ['name' => 'Sari Wijaya', 'email' => 'sari@email.com', 'role' => 'instructor', 'joined' => '1 day ago', 'activity' => '1 course created', 'status' => 'active', 'color' => 'teal'],
                            ['name' => 'Rizky Hakim', 'email' => 'rizky@email.com', 'role' => 'student', 'joined' => '2 days ago', 'activity' => '5 courses', 'status' => 'active', 'color' => 'orange'],
                            ['name' => 'Maya Putri', 'email' => 'maya@email.com', 'role' => 'student', 'joined' => '3 days ago', 'activity' => '2 courses', 'status' => 'inactive', 'color' => 'purple'],
                            ['name' => 'Dimas Saputra', 'email' => 'dimas@email.com', 'role' => 'instructor', 'joined' => '5 days ago', 'activity' => '3 courses created', 'status' => 'pending', 'color' => 'gold'],
                        ];
                    @endphp

                    @foreach($recentUsers as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-cell-avatar avatar-{{ $user['color'] }}">
                                        {{ strtoupper(substr($user['name'], 0, 1)) }}
                                    </div>
                                    <div class="user-cell-info">
                                        <div class="user-cell-name">{{ $user['name'] }}</div>
                                        <div class="user-cell-email">{{ $user['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user['role'] === 'student')
                                    <span class="role-pill role-student">
                                        <span>🎓</span> Student
                                    </span>
                                @elseif($user['role'] === 'instructor')
                                    <span class="role-pill role-instructor">
                                        <span>👨‍🏫</span> Instructor
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="cell-value">{{ $user['joined'] }}</div>
                            </td>
                            <td>
                                <div class="cell-value">{{ $user['activity'] }}</div>
                            </td>
                            <td>
                                @if($user['status'] === 'active')
                                    <span class="status-badge status-active">
                                        <span class="status-dot status-dot-teal"></span>
                                        Active
                                    </span>
                                @elseif($user['status'] === 'pending')
                                    <span class="status-badge status-pending">
                                        <span class="status-dot status-dot-orange"></span>
                                        Pending
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <span class="status-dot status-dot-gray"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-wrap" x-data="{ open: false }">
                                    <button class="action-btn" @click="open = !open">⋯</button>
                                    <div x-show="open" @click.away="open = false" x-transition class="actions-menu">
                                        <a href="#" class="actions-item">👁 View Profile</a>
                                        <a href="#" class="actions-item">✉ Send Message</a>
                                        <a href="#" class="actions-item">🔑 Reset Password</a>
                                        <div style="height:1px;background:var(--border);margin:4px 0;"></div>
                                        <a href="#" class="actions-item actions-danger">🚫 Suspend</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- APPROVALS + ACTIVITY (2 columns)                     --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="two-col-grid">

        {{-- Pending Approvals --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Pending <em>approvals</em></h3>
                <span class="count-badge">5 pending</span>
            </div>

            <div class="approval-list">
                @php
                    $pendingApprovals = [
                        ['type' => 'course', 'title' => 'Advanced Machine Learning', 'author' => 'Sari Dewi', 'submitted' => '2h ago', 'icon' => '📚', 'color' => 'purple'],
                        ['type' => 'instructor', 'title' => 'Dimas Wijaya wants to be an instructor', 'author' => 'dimas@coursify.test', 'submitted' => '5h ago', 'icon' => '👨‍🏫', 'color' => 'teal'],
                        ['type' => 'course', 'title' => 'Flutter Mobile Development', 'author' => 'Rio Ahmad', 'submitted' => '1d ago', 'icon' => '📚', 'color' => 'purple'],
                        ['type' => 'report', 'title' => 'Inappropriate content on Lesson 12', 'author' => 'Reported by 3 users', 'submitted' => '2d ago', 'icon' => '🚩', 'color' => 'orange'],
                    ];
                @endphp

                @foreach($pendingApprovals as $item)
                    <div class="approval-item">
                        <div class="approval-icon approval-icon-{{ $item['color'] }}">
                            {{ $item['icon'] }}
                        </div>
                        <div class="approval-info">
                            <div class="approval-title">{{ $item['title'] }}</div>
                            <div class="approval-meta">{{ $item['author'] }} · {{ $item['submitted'] }}</div>
                        </div>
                        <div class="approval-actions">
                            <button class="btn-approve" title="Approve">✓</button>
                            <button class="btn-reject" title="Reject">✕</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Activity Feed --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Live <em>activity</em></h3>
                <div class="live-indicator">
                    <span class="live-dot"></span>
                    <span>Live</span>
                </div>
            </div>

            <div class="activity-feed">
                @php
                    $activities = [
                        ['type' => 'enroll', 'text' => 'New enrollment in', 'highlight' => 'Laravel Fullstack', 'time' => '30s ago', 'icon' => '🎓', 'color' => 'purple'],
                        ['type' => 'user', 'text' => 'New user registered', 'highlight' => 'andi@email.com', 'time' => '1m ago', 'icon' => '👤', 'color' => 'teal'],
                        ['type' => 'payment', 'text' => 'Payment received', 'highlight' => 'Rp 299.000', 'time' => '3m ago', 'icon' => '💰', 'color' => 'gold'],
                        ['type' => 'review', 'text' => '5-star review on', 'highlight' => 'Python Basics', 'time' => '5m ago', 'icon' => '⭐', 'color' => 'orange'],
                        ['type' => 'course', 'text' => 'Course published:', 'highlight' => 'UI/UX Fundamentals', 'time' => '12m ago', 'icon' => '📚', 'color' => 'purple'],
                        ['type' => 'cert', 'text' => 'Certificate issued for', 'highlight' => 'Data Analysis', 'time' => '18m ago', 'icon' => '🏆', 'color' => 'gold'],
                    ];
                @endphp

                @foreach($activities as $act)
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-{{ $act['color'] }}">
                            {{ $act['icon'] }}
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">
                                {{ $act['text'] }}
                                <span class="activity-highlight">{{ $act['highlight'] }}</span>
                            </div>
                            <div class="activity-time">{{ $act['time'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- SDG IMPACT + TOP COURSES                             --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="bottom-grid">

        {{-- Top Courses --}}
        <div class="card-wrap">
            <div class="card-head">
                <h3 class="card-title">Top <em>courses</em></h3>
                <a href="#" class="section-link">All →</a>
            </div>

            <div class="top-courses-admin">
                @php
                    $topCoursesAdmin = [
                        ['rank' => 1, 'title' => 'Fullstack Web Dev', 'instructor' => 'Budi Santoso', 'enrollments' => 1203, 'revenue' => 'Rp 8.4M', 'rating' => 4.9, 'thumb' => 1],
                        ['rank' => 2, 'title' => 'UI/UX Design', 'instructor' => 'Sari Dewi', 'enrollments' => 856, 'revenue' => 'Rp 5.2M', 'rating' => 4.8, 'thumb' => 2],
                        ['rank' => 3, 'title' => 'Python for Data', 'instructor' => 'Rio Ahmad', 'enrollments' => 642, 'revenue' => 'Rp 3.1M', 'rating' => 4.9, 'thumb' => 3],
                    ];
                @endphp

                @foreach($topCoursesAdmin as $course)
                    <div class="top-course-admin">
                        <div class="rank-medal rank-{{ $course['rank'] === 1 ? 'gold' : ($course['rank'] === 2 ? 'silver' : 'bronze') }}">
                            {{ $course['rank'] }}
                        </div>
                        <div class="course-thumb-sm course-thumb-{{ $course['thumb'] }}">
                            {{ $course['rank'] === 1 ? '💻' : ($course['rank'] === 2 ? '🎨' : '📊') }}
                        </div>
                        <div class="course-info-sm">
                            <div class="course-title-sm">{{ $course['title'] }}</div>
                            <div class="course-meta-sm">
                                <span>👨‍🏫 {{ $course['instructor'] }}</span>
                                <span>⭐ {{ $course['rating'] }}</span>
                            </div>
                        </div>
                        <div class="course-stats-sm">
                            <div class="stat-mini-val">{{ number_format($course['enrollments']) }}</div>
                            <div class="stat-mini-label">Students</div>
                        </div>
                        <div class="course-stats-sm">
                            <div class="stat-mini-val">{{ $course['revenue'] }}</div>
                            <div class="stat-mini-label">Revenue</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- SDG Impact Card --}}
        <div class="sdg-card">
            <div class="sdg-header">
                <div class="sdg-title-wrap">
                    <div class="sdg-eyebrow">Platform Impact</div>
                    <h3 class="sdg-main-title">
                        Supporting <em>SDGs</em>
                    </h3>
                </div>
                <div class="sdg-globe">🌍</div>
            </div>

            <div class="sdg-metrics">
                <div class="sdg-metric">
                    <div class="sdg-metric-icon sdg-4">4</div>
                    <div class="sdg-metric-content">
                        <div class="sdg-metric-title">Quality Education</div>
                        <div class="sdg-metric-value">
                            <span class="sdg-big-number">1,847</span>
                            <span class="sdg-unit">enrollments</span>
                        </div>
                        <div class="sdg-progress">
                            <div class="sdg-progress-fill" style="width:85%;"></div>
                        </div>
                    </div>
                </div>

                <div class="sdg-metric">
                    <div class="sdg-metric-icon sdg-8">8</div>
                    <div class="sdg-metric-content">
                        <div class="sdg-metric-title">Decent Work</div>
                        <div class="sdg-metric-value">
                            <span class="sdg-big-number">324</span>
                            <span class="sdg-unit">certified</span>
                        </div>
                        <div class="sdg-progress">
                            <div class="sdg-progress-fill sdg-progress-teal" style="width:65%;"></div>
                        </div>
                    </div>
                </div>

                <div class="sdg-metric">
                    <div class="sdg-metric-icon sdg-10">10</div>
                    <div class="sdg-metric-content">
                        <div class="sdg-metric-title">Reduced Inequalities</div>
                        <div class="sdg-metric-value">
                            <span class="sdg-big-number">62%</span>
                            <span class="sdg-unit">free courses</span>
                        </div>
                        <div class="sdg-progress">
                            <div class="sdg-progress-fill sdg-progress-gold" style="width:62%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sdg-footer">
                <div class="sdg-footer-text">Total beneficiaries this year</div>
                <div class="sdg-footer-number">3,412 learners</div>
            </div>
        </div>

    </div>

    {{-- Footer spacer --}}
    <div style="height: 30px;"></div>

</main>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- ADDITIONAL STYLES                                    --}}
{{-- ═══════════════════════════════════════════════════ --}}
<style>

/* ═══ SECTION LINK ═══ */
.section-link {
    font-size: 12px;
    color: var(--purple);
    text-decoration: none;
    font-weight: 600;
    transition: gap 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 2px;
    white-space: nowrap;
}

.section-link:hover {
    color: var(--purple-dark);
    gap: 6px;
}

/* ═══ FILTER TABS ═══ */
.filter-tabs {
    display: flex;
    gap: 3px;
    background: var(--lav-1);
    border-radius: 100px;
    padding: 3px;
}

.filter-tab {
    padding: 5px 11px;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.filter-tab.active {
    background: white;
    color: var(--text);
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

/* ═══ USERS TABLE ═══ */
.users-table-wrap {
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

.users-table thead {
    background: var(--lav-1);
    border-radius: 10px;
}

.users-table th {
    padding: 12px 14px;
    text-align: left;
    font-size: 10px;
    font-weight: 700;
    color: var(--muted);
    letter-spacing: 0.1em;
    text-transform: uppercase;
}

.users-table th:first-child { border-radius: 10px 0 0 10px; }
.users-table th:last-child { border-radius: 0 10px 10px 0; }

.users-table td {
    padding: 14px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.users-table tbody tr:last-child td {
    border-bottom: none;
}

.users-table tbody tr {
    transition: background 0.2s;
}

.users-table tbody tr:hover {
    background: var(--lav-1);
}

.user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.user-cell-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: white;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.avatar-purple { background: linear-gradient(135deg, var(--purple), var(--purple-dark)); }
.avatar-teal { background: linear-gradient(135deg, var(--teal), #00A075); }
.avatar-orange { background: linear-gradient(135deg, var(--orange), #E66B3A); }
.avatar-gold { background: linear-gradient(135deg, var(--gold), #D19E2E); }

.user-cell-info {
    min-width: 0;
    flex: 1;
}

.user-cell-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-cell-email {
    font-size: 11px;
    color: var(--muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cell-value {
    font-size: 12px;
    color: var(--text-soft);
    font-weight: 500;
    white-space: nowrap;
}

/* Role Pills */
.role-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.role-student {
    background: rgba(123,111,232,0.12);
    color: var(--purple-dark);
}

.role-instructor {
    background: var(--teal-light);
    color: #00805F;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.status-active {
    background: var(--teal-light);
    color: #00805F;
}

.status-pending {
    background: var(--orange-light);
    color: #C24E1F;
}

.status-inactive {
    background: rgba(139,135,168,0.15);
    color: var(--muted);
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-dot-teal { background: var(--teal); }
.status-dot-orange { background: var(--orange); }
.status-dot-gray { background: var(--muted); }

/* Actions */
.actions-wrap {
    position: relative;
}

.action-btn {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: 1px solid transparent;
    background: transparent;
    cursor: pointer;
    font-size: 15px;
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
    min-width: 170px;
    box-shadow: 0 10px 40px rgba(30,58,95,0.12);
    z-index: 10;
}

.actions-item {
    display: block;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    color: var(--text-soft);
    font-size: 12.5px;
    font-weight: 500;
    transition: all 0.2s;
    white-space: nowrap;
}

.actions-item:hover {
    background: var(--lav-1);
    color: var(--text);
}

.actions-danger { color: var(--red); }
.actions-danger:hover {
    background: var(--red-light);
    color: var(--red);
}

/* ═══ TWO COL GRID ═══ */
.two-col-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 20px;
}

/* ═══ APPROVAL LIST ═══ */
.count-badge {
    background: var(--orange);
    color: white;
    padding: 3px 10px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.02em;
}

.approval-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.approval-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: all 0.2s;
}

.approval-item:hover {
    border-color: var(--purple);
    background: var(--lav-1);
}

.approval-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.approval-icon-purple { background: rgba(123,111,232,0.12); }
.approval-icon-teal { background: var(--teal-light); }
.approval-icon-orange { background: var(--orange-light); }

.approval-info {
    flex: 1;
    min-width: 0;
}

.approval-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 3px;
    line-height: 1.3;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
}

.approval-meta {
    font-size: 11px;
    color: var(--muted);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.approval-actions {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
}

.btn-approve, .btn-reject {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    transition: all 0.2s;
}

.btn-approve {
    background: var(--teal-light);
    color: #00805F;
}

.btn-approve:hover {
    background: var(--teal);
    color: white;
    transform: scale(1.05);
}

.btn-reject {
    background: var(--red-light);
    color: var(--red);
}

.btn-reject:hover {
    background: var(--red);
    color: white;
    transform: scale(1.05);
}

/* ═══ LIVE INDICATOR ═══ */
.live-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    color: var(--teal);
    padding: 4px 10px;
    background: var(--teal-light);
    border-radius: 100px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.live-dot {
    width: 6px;
    height: 6px;
    background: var(--teal);
    border-radius: 50%;
    animation: livePulse 1.5s infinite;
}

@keyframes livePulse {
    0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 0 0 rgba(0,200,150,0.6); }
    50% { opacity: 0.6; transform: scale(1.3); box-shadow: 0 0 0 6px rgba(0,200,150,0); }
}

/* ═══ ACTIVITY FEED ═══ */
.activity-feed {
    display: flex;
    flex-direction: column;
    gap: 2px;
    max-height: 360px;
    overflow-y: auto;
    padding-right: 4px;
}

.activity-feed::-webkit-scrollbar { width: 4px; }
.activity-feed::-webkit-scrollbar-thumb { background: var(--lav-3); border-radius: 4px; }

.activity-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border-radius: 10px;
    transition: background 0.2s;
}

.activity-item:hover {
    background: var(--lav-1);
}

.activity-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.activity-icon-purple { background: rgba(123,111,232,0.12); }
.activity-icon-teal { background: var(--teal-light); }
.activity-icon-orange { background: var(--orange-light); }
.activity-icon-gold { background: var(--gold-light); }

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-text {
    font-size: 12.5px;
    color: var(--text-soft);
    line-height: 1.4;
    margin-bottom: 2px;
}

.activity-highlight {
    color: var(--text);
    font-weight: 600;
}

.activity-time {
    font-size: 10.5px;
    color: var(--muted);
    font-weight: 500;
}

/* ═══ BOTTOM GRID ═══ */
.bottom-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 14px;
    margin-bottom: 20px;
}

/* ═══ TOP COURSES ADMIN ═══ */
.top-courses-admin {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.top-course-admin {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: var(--lav-1);
    border-radius: 12px;
    transition: all 0.2s;
    cursor: pointer;
    min-width: 0;
}

.top-course-admin:hover {
    background: white;
    box-shadow: 0 8px 20px rgba(30,58,95,0.08);
    border: 1px solid var(--purple);
}

.rank-medal {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 12px;
    flex-shrink: 0;
}

.rank-gold {
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #6B4A00;
    box-shadow: 0 2px 6px rgba(255,193,7,0.3);
}

.rank-silver {
    background: linear-gradient(135deg, #E0E0E0, #B0B0B0);
    color: #424242;
}

.rank-bronze {
    background: linear-gradient(135deg, #CD7F32, #8B4513);
    color: white;
}

.course-thumb-sm {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
.course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
.course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }

.course-info-sm {
    flex: 1;
    min-width: 0;
}

.course-title-sm {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.course-meta-sm {
    display: flex;
    gap: 10px;
    font-size: 11px;
    color: var(--muted);
    flex-wrap: wrap;
}

.course-stats-sm {
    text-align: right;
    flex-shrink: 0;
    min-width: 70px;
}

.stat-mini-val {
    font-family: var(--font-serif);
    font-size: 15px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    line-height: 1;
    margin-bottom: 2px;
}

.stat-mini-label {
    font-size: 9px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* ═══ SDG CARD ═══ */
.sdg-card {
    background: linear-gradient(135deg, var(--navy) 0%, #1E4A7A 100%);
    border-radius: 20px;
    padding: 24px;
    color: white;
    position: relative;
    overflow: hidden;
}

.sdg-card::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(184,175,235,0.2), transparent 70%);
    pointer-events: none;
}

.sdg-card::after {
    content: '';
    position: absolute;
    bottom: -40px;
    left: -40px;
    width: 180px;
    height: 180px;
    background: radial-gradient(circle, rgba(0,200,150,0.15), transparent 70%);
    pointer-events: none;
}

.sdg-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}

.sdg-title-wrap {
    min-width: 0;
    flex: 1;
}

.sdg-eyebrow {
    font-size: 10px;
    font-weight: 700;
    color: var(--lav-4);
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.sdg-main-title {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.01em;
    line-height: 1.2;
}

.sdg-main-title em {
    font-style: italic;
    color: var(--lav-4);
}

.sdg-globe {
    font-size: 32px;
    flex-shrink: 0;
}

.sdg-metrics {
    display: flex;
    flex-direction: column;
    gap: 16px;
    position: relative;
    z-index: 1;
    margin-bottom: 20px;
}

.sdg-metric {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sdg-metric-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-serif);
    font-size: 20px;
    font-weight: 400;
    color: white;
    flex-shrink: 0;
}

.sdg-4 { background: #7B6FE8; }
.sdg-8 { background: #00C896; }
.sdg-10 { background: #FFC452; color: #5A3A00; }

.sdg-metric-content {
    flex: 1;
    min-width: 0;
}

.sdg-metric-title {
    font-size: 11px;
    color: var(--lav-4);
    font-weight: 500;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sdg-metric-value {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-bottom: 6px;
}

.sdg-big-number {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    color: white;
    letter-spacing: -0.01em;
}

.sdg-unit {
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    font-weight: 500;
}

.sdg-progress {
    height: 4px;
    background: rgba(255,255,255,0.12);
    border-radius: 100px;
    overflow: hidden;
}

.sdg-progress-fill {
    height: 100%;
    background: var(--lav-4);
    border-radius: 100px;
    transition: width 1s ease;
}

.sdg-progress-teal { background: var(--teal); }
.sdg-progress-gold { background: var(--gold); }

.sdg-footer {
    padding-top: 16px;
    border-top: 1px solid rgba(255,255,255,0.12);
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.sdg-footer-text {
    font-size: 11px;
    color: rgba(255,255,255,0.7);
}

.sdg-footer-number {
    font-family: var(--font-serif);
    font-size: 16px;
    font-weight: 400;
    color: var(--lav-4);
    letter-spacing: -0.01em;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 1200px) {
    .bottom-grid { grid-template-columns: 1fr; }
}

@media (max-width: 900px) {
    .two-col-grid { grid-template-columns: 1fr; }
    .course-meta-sm { display: none; }
    .course-stats-sm { min-width: 60px; }
}

@media (max-width: 768px) {
    .filter-tabs { display: none; }
    .topbar-actions .btn-primary { display: none; }
}
</style>

</body>
</html>