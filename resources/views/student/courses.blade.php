<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>My Courses — Coursify</title>

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

/* ═══ FILTER TABS + SEARCH ═══ */
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

.filter-tab:hover {
    color: var(--purple);
}

.filter-tab.active {
    background: var(--text);
    color: white;
    box-shadow: 0 4px 12px rgba(26,24,37,0.2);
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
    background: var(--lav-2);
    color: var(--purple-dark);
}

/* Search */
.search-mycourses {
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
    border-color: var(--purple);
    box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
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
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    background: white;
    color: var(--text-soft);
    cursor: pointer;
    font-size: 16px;
    transition: all 0.2s;
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.course-menu:hover {
    border-color: var(--purple);
    color: var(--purple);
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
</style>
</head>
<body>

@include('partials.navbar')


{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="container">
        <div class="page-badge">
            <span class="page-badge-dot"></span>
            <span>{{ $stats['total'] }} {{ $stats['total'] == 1 ? 'course' : 'courses' }} enrolled</span>
        </div>

        <h1 class="page-title">
            My <em>Courses</em>
        </h1>

        <p class="page-subtitle">
            Continue your learning journey. Your progress is automatically saved across all courses.
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
                <a href="{{ route('student.courses') }}"
                   class="filter-tab {{ $currentFilter === 'all' ? 'active' : '' }}">
                    📚 All
                    <span class="filter-tab-count">{{ $stats['total'] }}</span>
                </a>
                <a href="{{ route('student.courses', ['filter' => 'in_progress']) }}"
                   class="filter-tab {{ $currentFilter === 'in_progress' ? 'active' : '' }}">
                    ⚡ In Progress
                    <span class="filter-tab-count">{{ $stats['in_progress'] }}</span>
                </a>
                <a href="{{ route('student.courses', ['filter' => 'completed']) }}"
                   class="filter-tab {{ $currentFilter === 'completed' ? 'active' : '' }}">
                    ✅ Completed
                    <span class="filter-tab-count">{{ $stats['completed'] }}</span>
                </a>
                <a href="{{ route('student.courses', ['filter' => 'not_started']) }}"
                   class="filter-tab {{ $currentFilter === 'not_started' ? 'active' : '' }}">
                    🔖 Not Started
                    <span class="filter-tab-count">{{ $stats['not_started'] }}</span>
                </a>
            </div>

            <form action="{{ route('student.courses') }}" method="GET" class="search-mycourses">
                <span class="search-icon">🔍</span>
                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Search your courses..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
                @if($currentFilter !== 'all')
                    <input type="hidden" name="filter" value="{{ $currentFilter }}">
                @endif
            </form>
        </div>

        {{-- Courses Grid --}}
        <div class="courses-grid">

            @php
                // Fallback dummy data kalau belum ada enrollments
                $defaultCourses = collect([
                    (object)[
                        'id' => 1,
                        'progress_percent' => 65,
                        'status' => 'active',
                        'course' => (object)[
                            'id' => 1,
                            'title' => 'Fullstack Web Development with Laravel 12',
                            'slug' => 'fullstack-web-development-with-laravel-12',
                            'thumb' => 1,
                            'icon' => '💻',
                            'category' => (object)['name' => 'Programming'],
                            'instructor_name' => 'Budi Santoso',
                            'initial' => 'B',
                            'lessons_total' => 124,
                            'lessons_done' => 80,
                        ]
                    ],
                    (object)[
                        'id' => 2,
                        'progress_percent' => 100,
                        'status' => 'completed',
                        'course' => (object)[
                            'id' => 2,
                            'title' => 'UI/UX Design Fundamentals',
                            'slug' => 'ui-ux-design-fundamentals',
                            'thumb' => 2,
                            'icon' => '🎨',
                            'category' => (object)['name' => 'Design'],
                            'instructor_name' => 'Sari Dewi',
                            'initial' => 'S',
                            'lessons_total' => 45,
                            'lessons_done' => 45,
                        ]
                    ],
                    (object)[
                        'id' => 3,
                        'progress_percent' => 0,
                        'status' => 'active',
                        'course' => (object)[
                            'id' => 3,
                            'title' => 'Python for Data Analysis & Visualization',
                            'slug' => 'python-for-data-analysis',
                            'thumb' => 3,
                            'icon' => '📊',
                            'category' => (object)['name' => 'Data Science'],
                            'instructor_name' => 'Rio Ahmad',
                            'initial' => 'R',
                            'lessons_total' => 38,
                            'lessons_done' => 0,
                        ]
                    ],
                ]);

                // Pakai data real kalau ada, atau dummy kalau kosong
                $displayCourses = ($enrollments->count() > 0) ? $enrollments : $defaultCourses;
            @endphp

            @forelse($displayCourses as $index => $enrollment)
                @php
                    // Handle both Eloquent & dummy data
                    $course = $enrollment->course ?? null;
                    if (!$course) {
                        continue;
                    }

                    $progress = $enrollment->progress_percent ?? 0;
                    $status = $enrollment->status ?? 'active';

                    // Determine status display
                    if ($progress >= 100 || $status === 'completed') {
                        $statusClass = 'status-completed';
                        $statusLabel = '✓ Completed';
                        $progressClass = 'completed';
                        $btnLabel = '🏆 View Certificate';
                        $btnClass = 'completed';
                    } elseif ($progress == 0) {
                        $statusClass = 'status-not-started';
                        $statusLabel = '🔖 Not Started';
                        $progressClass = 'not-started';
                        $btnLabel = '▶ Start Learning';
                        $btnClass = '';
                    } else {
                        $statusClass = 'status-in-progress';
                        $statusLabel = '⚡ In Progress';
                        $progressClass = '';
                        $btnLabel = '▶ Resume';
                        $btnClass = '';
                    }

                    // Course data
                    $courseTitle = is_object($course) ? ($course->title ?? 'Untitled') : 'Untitled';
                    $courseSlug = is_object($course) ? ($course->slug ?? 'course') : 'course';
                    $categoryName = is_object($course) && isset($course->category) ? ($course->category->name ?? 'General') : 'General';
                    $thumb = $course->thumb ?? (($index % 6) + 1);
                    $icon = $course->icon ?? '📚';
                    $instructorName = $course->instructor_name ?? (isset($course->instructors) && $course->instructors->count() > 0 ? $course->instructors->first()->name : 'Coursify Team');
                    $initial = $course->initial ?? strtoupper(substr($instructorName, 0, 1));
                    $lessonsTotal = $course->lessons_total ?? 0;
                    $lessonsDone = $course->lessons_done ?? 0;
                @endphp

                <div class="course-card">
                    <div class="course-thumb course-thumb-{{ $thumb }}">
                        <span class="course-status {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
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
                            <a href="{{ route('courses.show', $courseSlug) }}"
                               class="btn-continue {{ $btnClass }}">
                                {{ $btnLabel }}
                            </a>
                            <button class="course-menu" title="More options"
                                    onclick="toggleMenu(this, event)">
                                ⋯
                            </button>
                        </div>
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

    // Course menu toggle
    function toggleMenu(btn, event) {
        event.preventDefault();
        event.stopPropagation();
        alert('Menu options:\n• Unenroll from course\n• Download materials\n• Mark as favorite\n• Share with friends');
    }

    // Search form auto-submit on enter
    document.querySelector('.search-mycourses input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.closest('form').submit();
        }
    });
</script>

</body>
</html>