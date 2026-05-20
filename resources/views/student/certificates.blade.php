<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Certificates — Coursify</title>

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
    --gold-dark: #D4A017;
    --gold-light: #FFF7E0;
    --gold-shimmer: #FFE184;
    --pink: #FF6B8A;
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

/* ═══ USER DROPDOWN NAV ═══ */
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

.dropdown-name { font-size: 13px; font-weight: 600; color: var(--text); }
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
.dropdown-item-danger { color: var(--orange); }
.dropdown-item-danger:hover { background: rgba(255,138,91,0.08); color: var(--orange); }

/* ═══ FLASH ═══ */
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
.flash-success { border-left: 4px solid var(--teal); }

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
    background: linear-gradient(135deg, rgba(255,196,82,0.15), rgba(255,225,132,0.1));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,196,82,0.35);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    color: var(--gold-dark);
    margin-bottom: 18px;
}

.page-badge-trophy {
    font-size: 14px;
    animation: trophyShine 2s infinite;
}

@keyframes trophyShine {
    0%, 100% { transform: scale(1) rotate(0deg); filter: brightness(1); }
    50% { transform: scale(1.15) rotate(-5deg); filter: brightness(1.2); }
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
    background: linear-gradient(135deg, #FFD700, #FFC452, #FFA500);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
    padding-bottom: 0.15em;
    margin-top: 0.05em;
    overflow: visible;
    filter: drop-shadow(0 4px 12px rgba(255,196,82,0.3));
}

.page-subtitle {
    font-size: 15px;
    line-height: 1.6;
    color: var(--text-soft);
    max-width: 520px;
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
    font-size: 22px;
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
    color: var(--gold-dark);
}

.stat-value.value-purple em { color: var black; }
.stat-value.value-teal em { color: var black; }

.stat-label {
    font-size: 10px;
    color: var black;
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
.filter-tab:hover { color: var(--gold-dark); }

.filter-tab.active {
    background: linear-gradient(135deg, #FFC452, #D4A017);
    color: white;
    box-shadow: 0 4px 12px rgba(212,160,23,0.3);
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
    background: var(--gold-light);
    color: var(--gold-dark);
}

/* Search */
.search-wrap {
    position: fixed;
    top: 22px;
    right: 24px;
    z-index: 101;
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
    border-color: var(--gold);
    box-shadow: 0 0 0 4px rgba(255,196,82,0.15);
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

/* Responsive */
@media (max-width: 900px) {
    .stats-bar {
        grid-template-columns: repeat(2, 1fr);
    }
    .stat-cell:nth-child(2) { border-right: none; }
    .courses-toolbar { flex-direction: column; align-items: stretch; }
    .search-wrap { min-width: auto; }
}

@media (max-width: 640px) {
    .nav-links { display: none; }
    .user-name-nav { display: none; }
    .user-dropdown { right: -10px; min-width: 220px; }
    .filter-tabs {
        overflow-x: auto;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
    }
}
</style>
</head>
<body>

{{-- NAVBAR (PARTIAL) --}}
@include('partials.navbar')

<form action="{{ route('student.certificates') }}" method="GET" class="search-wrap">
    <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
    <input
        type="text"
        name="search"
        class="search-input"
        placeholder="Search certificates..."
        value="{{ request('search') }}"
        autocomplete="off"
    >
</form>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="flash-wrap" x-data x-init="setTimeout(() => $el.remove(), 4000)">
        <div class="flash flash-success">
            ✓ {{ session('success') }}
        </div>
    </div>
@endif


{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="container">

        <h1 class="page-title">
            My <em>Certificates</em>
        </h1>

        <p class="page-subtitle">
            Your learning achievements, ready to be shared. Download, verify, or display on LinkedIn.
        </p>

        {{-- Stats Bar --}}
        <div class="stats-bar">
            <div class="stat-cell">
                <div class="stat-icon"><i class="fa-solid fa-trophy"></i></div>
                <div class="stat-value"><em>{{ $stats['total'] }}</em></div>
                <div class="stat-label">Total Earned</div>
            </div>
            <div class="stat-cell">
                <div class="stat-icon"><i class="fa-solid fa-calendar"></i></div>
                <div class="stat-value value-purple"><em>{{ $stats['this_year'] }}</em></div>
                <div class="stat-label">This Year</div>
            </div>
            <div class="stat-cell">
                <div class="stat-icon"><i class="fa-solid fa-clock"></i></div>
                <div class="stat-value value-teal"><em>{{ $stats['hours_learned'] }}h</em></div>
                <div class="stat-label">Hours Learned</div>
            </div>
            <div class="stat-cell">
                <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
                <div class="stat-value value-purple"><em>{{ $stats['avg_score'] }}%</em></div>
                <div class="stat-label">Avg Score</div>
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

        {{-- Toolbar --}}
        <div class="courses-toolbar">
            <div class="filter-tabs">
                <a href="{{ route('student.certificates') }}"
                   class="filter-tab {{ $currentFilter === 'all' ? 'active' : '' }}">
                    <i class="fa-solid fa-trophy"></i> All Certificates
                    <span class="filter-tab-count">{{ $stats['total'] }}</span>
                </a>
                <a href="{{ route('student.certificates', ['filter' => 'this_year']) }}"
                   class="filter-tab {{ $currentFilter === 'this_year' ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar"></i> This Year
                    <span class="filter-tab-count">{{ $stats['this_year'] }}</span>
                </a>
            </div>

            <form action="{{ route('student.certificates') }}" method="GET" class="search-wrap">
                <i class="fa-solid fa-search search-icon"></i>
                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Search certificates..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
            </form>
        </div>

        {{-- Certificates Grid --}}
        <div class="certificates-grid">

            @forelse($certificates as $index => $cert)
                @php
                    $course = $cert->course ?? null;
                    if (!$course) continue;

                    $courseTitle = is_object($course) ? ($course->title ?? 'Untitled') : 'Untitled';
                    $courseSlug = is_object($course) ? ($course->slug ?? 'course') : 'course';
                    $categoryName = is_object($course) && isset($course->category)
                        ? ($course->category->name ?? 'General')
                        : 'General';
                    $thumb = $course->thumb ?? (($index % 6) + 1);
                    $instructorName = $course->instructor_name
                        ?? (isset($course->instructors) && $course->instructors->count() > 0
                            ? $course->instructors->first()->name
                            : 'Coursify Team');
                    $initial = $course->initial ?? strtoupper(substr($instructorName, 0, 1));
                    $certNumber = $cert->certificate_number ?? 'CRS-' . date('Y') . '-' . strtoupper(substr(md5($index), 0, 6));
                    $issuedAt = $cert->issued_at ?? now();
                    $issuedMonth = is_object($issuedAt) ? $issuedAt->translatedFormat('F Y') : $issuedAt;
                    $issuedDate = is_object($issuedAt) ? $issuedAt->format('d M Y') : '';
                    $year = is_object($issuedAt) ? $issuedAt->year : date('Y');
                @endphp

                <div class="cert-card">
                    {{-- Certificate Preview --}}
                    <div class="cert-preview">
                        <div class="cert-shimmer"></div>

                        {{-- Ribbon --}}
                        <div class="cert-ribbon">
                            <span class="ribbon-icon">✓</span>
                            <span>VERIFIED</span>
                        </div>

                        {{-- Corner decorations --}}
                        <div class="cert-corner cert-corner-tl"></div>
                        <div class="cert-corner cert-corner-tr"></div>
                        <div class="cert-corner cert-corner-bl"></div>
                        <div class="cert-corner cert-corner-br"></div>

                        {{-- Content --}}
                        <div class="cert-content">
                            <div class="cert-seal">
                                <div class="cert-seal-inner"><i class="fa-solid fa-trophy"></i></div>
                            </div>

                            <div class="cert-label">Certificate of</div>
                            <div class="cert-title-preview">Completion</div>

                            <div class="cert-divider">
                                <div class="cert-divider-line"></div>
                                <span class="cert-divider-dot">✦</span>
                                <div class="cert-divider-line"></div>
                            </div>

                            <div class="cert-awarded-to">Awarded to</div>
                            <div class="cert-name">{{ auth()->user()->name }}</div>

                            <div class="cert-course-info">
                                {{ $courseTitle }}
                            </div>

                            <div class="cert-date">
                                Issued {{ $issuedMonth }}
                            </div>
                        </div>
                    </div>

                    {{-- Certificate Body --}}
                    <div class="cert-body">
                        <div class="cert-category">{{ $categoryName }}</div>

                        <h3 class="cert-course-title">{{ $courseTitle }}</h3>

                        <div class="cert-meta">
                            <div class="cert-instructor">
                                <div class="cert-instructor-avatar">{{ $initial }}</div>
                                <span>{{ $instructorName }}</span>
                            </div>
                            <div class="cert-issued">
                                <i class="fa-solid fa-calendar-days"></i> {{ $issuedDate }}
                            </div>
                        </div>

                        {{-- Credential ID --}}
                        <div class="cert-credential">
                            <div class="credential-label">Credential ID</div>
                            <div class="credential-id">
                                <span>{{ $certNumber }}</span>
                                <button class="credential-copy" onclick="copyCredential('{{ $certNumber }}', this)" title="Copy">
                                    <i class="fa-solid fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="cert-actions">
                            @if($cert instanceof \App\Models\Certificate)
                                <a class="btn-cert-primary btn-download-pdf"
                                   href="{{ route('student.certificates.download', ['certificate' => $cert->id]) }}"
                                   onclick="handleDownload(event, this)"
                                   data-cert-id="{{ $cert->id }}">
                                    <i class="fa-solid fa-download"></i>
                                    <span class="btn-label">Download PDF</span>
                                </a>
                            @else
                                <button class="btn-cert-primary btn-cert-disabled"
                                        onclick="showToast('Ini hanyalah contoh tampilan. Selesaikan kursus untuk mendapatkan sertifikat nyata.', 'info')"
                                        title="Selesaikan kursus untuk mendapatkan sertifikat">
                                    <i class="fa-solid fa-lock"></i>
                                    <span class="btn-label">Download PDF</span>
                                </button>
                            @endif
                            <button class="btn-cert-share" onclick="shareCert(this, '{{ $courseTitle }}', '{{ $certNumber }}')" title="Share">
                                <i class="fa-solid fa-share-nodes"></i> 
                            </button>
                            <button class="btn-cert-share" onclick="verifyCert('{{ $certNumber }}')" title="Verify">
                                <i class="fa-solid fa-shield-halved"></i>
                            </button>
                        </div>

                        {{-- Verify link --}}
                        <a href="{{ route('certificates.verify', $certNumber) }}" class="cert-verify-link">
                            View verification page 
                        </a>
                    </div>
                </div>

            @empty
                {{-- Empty State --}}
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-trophy"></i></div>
                    <h3 class="empty-title">No <em>certificates</em> yet</h3>
                    <p class="empty-desc">
                        Complete courses to earn verified certificates. Your achievements will appear here, ready to download and share on LinkedIn.
                    </p>
                    <a href="{{ route('courses.index') }}" class="btn-browse">
                        <i class="fa-solid fa-magnifying-glass"></i> Browse Courses
                    </a>
                </div>
            @endforelse

        </div>

        {{-- Pro Tip Card --}}
        @if($certificates->count() > 0)
            <div class="tip-card">
                <div class="tip-icon"><i class="fa-solid fa-lightbulb"></i></div>
                <div class="tip-content">
                    <div class="tip-title">
                        Add to your <em>LinkedIn</em>
                    </div>
                    <div class="tip-text">
                        Share your certificates on LinkedIn to boost your professional profile.
                        Follow the instructions to add them to your achievements.
                    </div>
                </div>
                <a href="#" class="tip-action">Learn how </a>
            </div>
        @endif

    </div>
</section>

<div style="height: 60px;"></div>

{{-- ADDITIONAL CSS for Certificate Cards --}}
<style>
/* ═══ CERTIFICATES GRID ═══ */
.certificates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 24px;
}

.cert-card {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 4px 16px rgba(30,58,95,0.04);
    min-width: 0;
}

.cert-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(255,196,82,0.15);
    border-color: var(--gold);
}

/* ═══ CERTIFICATE PREVIEW ═══ */
.cert-preview {
    aspect-ratio: 4/3;
    background: linear-gradient(135deg,
        #FFFDF0 0%,
        #FFF9D9 30%,
        #FFF3B3 60%,
        #FFE88A 100%);
    position: relative;
    padding: 28px 24px;
    overflow: hidden;
    border-bottom: 3px solid var(--gold);
}

/* Shimmer effect */
.cert-shimmer {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        105deg,
        transparent 40%,
        rgba(255,255,255,0.5) 50%,
        transparent 60%
    );
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Ribbon */
.cert-ribbon {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: white;
    padding: 5px 12px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.08em;
    display: flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 4px 12px rgba(212,160,23,0.3);
    z-index: 2;
}

.ribbon-icon {
    background: white;
    color: var(--gold-dark);
    width: 14px;
    height: 14px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    font-weight: 900;
}

/* Corner decorations */
.cert-corner {
    position: absolute;
    width: 32px;
    height: 32px;
    border: 2px solid var(--gold-dark);
    z-index: 1;
}

.cert-corner-tl {
    top: 12px;
    left: 12px;
    border-right: none;
    border-bottom: none;
    border-top-left-radius: 4px;
}

.cert-corner-tr {
    top: 12px;
    right: 12px;
    border-left: none;
    border-bottom: none;
    border-top-right-radius: 4px;
}

.cert-corner-bl {
    bottom: 12px;
    left: 12px;
    border-right: none;
    border-top: none;
    border-bottom-left-radius: 4px;
}

.cert-corner-br {
    bottom: 12px;
    right: 12px;
    border-left: none;
    border-top: none;
    border-bottom-right-radius: 4px;
}

/* Content inside certificate */
.cert-content {
    position: relative;
    z-index: 1;
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.cert-seal {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 6px;
    box-shadow: 0 4px 16px rgba(212,160,23,0.4);
    border: 3px solid white;
}

.cert-seal-inner {
    font-size: 22px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

.cert-label {
    font-family: var(--font-sans);
    font-size: 10px;
    color: var(--gold-dark);
    font-weight: 600;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    margin-bottom: 0;
}

.cert-title-preview {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 400;
    color: var(--navy);
    letter-spacing: -0.02em;
    line-height: 1;
    padding-bottom: 4px;
    margin-bottom: 6px;
}

.cert-divider {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 70%;
    margin: 4px 0;
}

.cert-divider-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-dark), transparent);
}

.cert-divider-dot {
    color: var(--gold-dark);
    font-size: 10px;
}

.cert-awarded-to {
    font-size: 10px;
    color: var(--navy);
    font-weight: 500;
    letter-spacing: 0.05em;
    opacity: 0.8;
}

.cert-name {
    font-family: var(--font-serif);
    font-size: 18px;
    font-style: italic;
    color: var(--navy);
    letter-spacing: -0.01em;
    line-height: 1;
    padding-bottom: 2px;
    margin-bottom: 6px;
    max-width: 90%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.cert-course-info {
    font-size: 11px;
    color: var(--text);
    font-weight: 600;
    max-width: 90%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin-bottom: 4px;
    letter-spacing: -0.01em;
}

.cert-date {
    font-size: 9px;
    color: var(--navy);
    font-weight: 500;
    opacity: 0.7;
    letter-spacing: 0.03em;
}

/* ═══ CERTIFICATE BODY ═══ */
.cert-body {
    padding: 20px;
}

.cert-category {
    font-size: 10px;
    color: var(--muted);
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.cert-course-title {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    line-height: 1.3;
    letter-spacing: -0.01em;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 46px;
    color: var(--text);
}

.cert-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border);
    flex-wrap: wrap;
    gap: 10px;
}

.cert-instructor {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--text-soft);
}

.cert-instructor-avatar {
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

.cert-issued {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}

/* Credential ID */
.cert-credential {
    background: linear-gradient(135deg, var(--gold-light), rgba(255,255,255,0.5));
    border: 1px solid rgba(255,196,82,0.3);
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 14px;
}

.credential-label {
    font-size: 9px;
    color: var(--gold-dark);
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.credential-id {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: 'Courier New', monospace;
    font-size: 12px;
    font-weight: 700;
    color: var(--navy);
    letter-spacing: 0.05em;
}

.credential-copy {
    background: white;
    border: 1px solid var(--gold);
    width: 26px;
    height: 26px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.2s;
}

.credential-copy:hover {
    background: var(--gold);
    transform: scale(1.05);
}

/* Actions */
.cert-actions {
    display: flex;
    gap: 8px;
    margin-bottom: 10px;
}

.btn-cert-primary {
    flex: 1;
    padding: 11px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    letter-spacing: 0.02em;
    box-shadow: 0 4px 12px rgba(212,160,23,0.3);
}

.btn-cert-disabled {
    opacity: 0.55;
    cursor: not-allowed;
}
.btn-cert-disabled:hover {
    transform: none !important;
    box-shadow: none !important;
}
.btn-cert-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(212,160,23,0.4);
}

.btn-cert-share {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    background: white;
    color: var(--text-soft);
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
    flex-shrink: 0;
}

.btn-cert-share:hover {
    border-color: var(--gold);
    color: var(--gold-dark);
    transform: translateY(-2px);
}

.cert-verify-link {
    display: inline-block;
    font-size: 11px;
    color: black;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.cert-verify-link:hover {
    color: var(--purple-dark);
    text-decoration: underline;
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
    animation: trophyShine 2s infinite;
    display: inline-block;
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
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.empty-desc {
    font-size: 14px;
    color: var(--muted);
    max-width: 480px;
    margin: 0 auto 24px;
    line-height: 1.6;
}

.btn-browse {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: white;
    text-decoration: none;
    border-radius: 100px;
    font-size: 14px;
    font-weight: 700;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(212,160,23,0.3);
}

.btn-browse:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(212,160,23,0.4);
}

/* ═══ TIP CARD ═══ */
.tip-card {
    margin-top: 40px;
    background: linear-gradient(135deg, rgba(0,120,212,0.08), rgba(255,255,255,0.5));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(0,120,212,0.15);
    border-radius: 20px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.tip-icon {
    font-size: 40px;
    flex-shrink: 0;
}

.tip-content {
    flex: 1;
    min-width: 240px;
}

.tip-title {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    margin-bottom: 4px;
    letter-spacing: -0.01em;
}

.tip-title em {
    font-style: italic;
    color: #0078D4;
}

.tip-text {
    font-size: 13px;
    color: var(--text-soft);
    line-height: 1.6;
}

.tip-action {
    padding: 10px 20px;
    background: #0078D4;
    color: white;
    text-decoration: none;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s;
    flex-shrink: 0;
    white-space: nowrap;
}

.tip-action:hover {
    background: #005A9E;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,120,212,0.3);
}

@media (max-width: 640px) {
    .certificates-grid { grid-template-columns: 1fr; }
    .tip-card { flex-direction: column; align-items: flex-start; }
}
</style>

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

    // Copy credential ID
    function copyCredential(credentialId, btn) {
        navigator.clipboard.writeText(credentialId).then(() => {
            const originalText = btn.textContent;
            btn.textContent = '✓';
            btn.style.background = 'var(--teal)';
            btn.style.color = 'white';
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = '';
                btn.style.color = '';
            }, 1500);

            showToast('Credential ID copied to clipboard!', 'success');
        });
    }

    // Download certificate — klik anchor, tampilkan loading state
    function handleDownload(e, anchor) {
        const label = anchor.querySelector('.btn-label');
        const icon  = anchor.querySelector('i');

        // Cegah double-click
        if (anchor.dataset.downloading === '1') { e.preventDefault(); return; }
        anchor.dataset.downloading = '1';

        const origLabel = label ? label.textContent : 'Download PDF';
        const origIcon  = icon  ? icon.className    : 'fa-solid fa-download';

        if (label) label.textContent = 'Menyiapkan…';
        if (icon)  { icon.className = 'fa-solid fa-spinner fa-spin'; }
        anchor.style.opacity = '0.75';
        anchor.style.pointerEvents = 'none';

        showToast('📥 Menyiapkan sertifikat PDF kamu…', 'info');

        // Reset tampilan setelah 4 detik (download sudah mulai)
        setTimeout(() => {
            if (label) label.textContent = origLabel;
            if (icon)  icon.className    = origIcon;
            anchor.style.opacity = '';
            anchor.style.pointerEvents = '';
            anchor.dataset.downloading = '0';
            showToast('✅ Sertifikat berhasil diunduh!', 'success');
        }, 4000);
    }

    // Share certificate
    function shareCert(btn, courseTitle, credentialId) {
        const url = window.location.origin + '/verify/' + credentialId;
        const text = `I just earned a certificate for "${courseTitle}" on Coursify! 🏆\n\nVerify: ${url}`;

        if (navigator.share) {
            navigator.share({
                title: 'My Coursify Certificate',
                text: text,
                url: url,
            });
        } else {
            navigator.clipboard.writeText(url);
            showToast('🔗 Verification link copied!', 'success');
        }
    }

    // Verify certificate
    function verifyCert(credentialId) {
        window.open('/verify/' + credentialId, '_blank');
    }

    // Search auto-submit
    document.querySelector('.search-wrap input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.closest('form').submit();
        }
    });

    // Toast helper
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 100px;
            right: 24px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            box-shadow: 0 10px 40px rgba(30,58,95,0.15);
            z-index: 9999;
            border-left: 4px solid ${type === 'success' ? 'var(--teal)' : type === 'info' ? '#0078D4' : 'var(--orange)'};
            animation: slideInRight 0.3s ease;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }
</script>

</body>
</html>