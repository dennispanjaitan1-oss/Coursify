@extends('layouts.app')

@section('title', 'Programs & Specializations — Coursify')
@section('meta_description', 'Explore professional certificate programs and specializations from top universities. Build job-ready skills with structured learning paths.')

@push('styles')
<style>
/* ═══ PAGE HERO ═══ */
.page-hero {
    text-align: center;
    padding: 52px 20px 44px;
    position: relative;
    z-index: 1;
}
.page-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(123,111,232,0.2);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    color: var(--purple-dark);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 20px;
}
.page-hero-title {
    font-family: var(--font-serif);
    font-size: clamp(36px, 6vw, 68px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-bottom: 16px;
    color: var(--text);
}
.page-hero-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.page-hero-subtitle {
    font-size: 16px;
    line-height: 1.6;
    color: var(--text-soft);
    max-width: 540px;
    margin: 0 auto 36px;
}

/* ═══ STATS BAR ═══ */
.stats-bar {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}
.stat-item { text-align: center; }
.stat-num {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 400;
    color: var(--navy);
    line-height: 1;
}
.stat-label { font-size: 12px; color: var(--muted); margin-top: 4px; }

/* ═══ SEARCH + FILTERS ═══ */
.filter-wrap {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    padding: 20px 24px;
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}
.search-box {
    flex: 1;
    min-width: 240px;
    position: relative;
}
.search-box svg {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.4;
    pointer-events: none;
}
.search-box input {
    width: 100%;
    padding: 11px 14px 11px 42px;
    background: rgba(255,255,255,0.9);
    border: 1.5px solid rgba(123,111,232,0.12);
    border-radius: 12px;
    font-size: 14px;
    font-family: var(--font-sans);
    color: var(--text);
    outline: none;
    transition: border-color 0.2s;
}
.search-box input:focus { border-color: rgba(123,111,232,0.4); }
.filter-select {
    padding: 10px 14px;
    background: rgba(255,255,255,0.9);
    border: 1.5px solid rgba(123,111,232,0.12);
    border-radius: 12px;
    font-size: 13.5px;
    font-family: var(--font-sans);
    color: var(--text);
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s;
}
.filter-select:focus { border-color: rgba(123,111,232,0.4); }

/* ═══ TYPE CHIPS ═══ */
.type-chips {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 28px;
}
.type-chip {
    padding: 8px 18px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    border: 1.5px solid rgba(123,111,232,0.18);
    background: rgba(255,255,255,0.7);
    color: var(--text-soft);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.type-chip:hover {
    background: rgba(123,111,232,0.08);
    border-color: rgba(123,111,232,0.35);
    color: var(--purple-dark);
}
.type-chip.active {
    background: var(--navy);
    border-color: var(--navy);
    color: white;
}
.type-chip-count {
    background: rgba(255,255,255,0.25);
    border-radius: 100px;
    font-size: 11px;
    padding: 1px 7px;
    font-weight: 700;
}
.type-chip.active .type-chip-count { background: rgba(255,255,255,0.2); }

/* ═══ PROGRAM CARDS ═══ */
.programs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
    margin-bottom: 48px;
}
.program-card {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    position: relative;
}
.program-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 60px rgba(30,58,95,0.14);
    border-color: rgba(123,111,232,0.25);
}
.program-card-thumb {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: linear-gradient(135deg, #EDE5F9, #C4B8E8);
    display: block;
    position: relative;
}
.program-thumb-placeholder {
    width: 100%;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: rgba(123,111,232,0.3);
}
.program-type-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    backdrop-filter: blur(20px);
}
.badge-professional_certificate { background: rgba(30,58,95,0.85); color: white; }
.badge-micromasters               { background: rgba(123,111,232,0.9); color: white; }
.badge-xseries                    { background: rgba(0,200,150,0.9); color: white; }
.badge-specialization             { background: rgba(255,138,91,0.9); color: white; }
.badge-program                    { background: rgba(255,255,255,0.9); color: var(--text); }

.program-card-body {
    padding: 20px 22px 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.program-institution {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}
.institution-logo {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    object-fit: cover;
    background: rgba(30,58,95,0.1);
    flex-shrink: 0;
}
.institution-name {
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.program-title {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    line-height: 1.3;
    color: var(--text);
    margin-bottom: 10px;
    letter-spacing: -0.01em;
}
.program-description {
    font-size: 13px;
    color: var(--text-soft);
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 16px;
    flex: 1;
}
.program-meta {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    padding-top: 14px;
    border-top: 1px solid rgba(30,58,95,0.06);
}
.program-meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}
.program-meta-item svg { opacity: 0.6; }
.program-price {
    margin-left: auto;
    font-weight: 700;
    font-size: 15px;
    color: var(--navy);
}
.program-price.free { color: var(--teal); }

/* ═══ EMPTY STATE ═══ */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: rgba(255,255,255,0.5);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.8);
}
.empty-icon { font-size: 48px; margin-bottom: 16px; opacity: 0.4; }
.empty-title { font-family: var(--font-serif); font-size: 24px; margin-bottom: 8px; }
.empty-desc { font-size: 14px; color: var(--muted); }

/* ═══ PAGINATION ═══ */
.pagination-wrap {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 60px;
}
.pagination-wrap a, .pagination-wrap span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 14px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 500;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(255,255,255,0.9);
    color: var(--text-soft);
    text-decoration: none;
    transition: all 0.2s;
}
.pagination-wrap a:hover { background: rgba(123,111,232,0.1); color: var(--purple-dark); }
.pagination-wrap .active, .pagination-wrap span[aria-current] {
    background: var(--navy);
    color: white;
    border-color: var(--navy);
}

@media (max-width: 768px) {
    .filter-wrap { flex-direction: column; }
    .search-box { min-width: 100%; }
    .programs-grid { grid-template-columns: 1fr; }
    .stats-bar { gap: 24px; }
}
</style>
@endpush

@section('content')
<!-- ═══ HERO ═══ -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-eyebrow">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="5" fill="#7B6FE8"/></svg>
            Programs & Specializations
        </span>
        <h1 class="page-hero-title">
            Level up with<br><em>structured programs</em>
        </h1>
        <p class="page-hero-subtitle">
            Curated learning paths from top institutions. Earn professional certificates and build job-ready expertise.
        </p>

        <!-- Stats -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-num">{{ $totalPrograms }}</div>
                <div class="stat-label">Programs</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">{{ $programTypes->get('professional_certificate', 0) + $programTypes->get('micromasters', 0) }}</div>
                <div class="stat-label">Certificates</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">50+</div>
                <div class="stat-label">Institutions</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">100%</div>
                <div class="stat-label">Online</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ MAIN CONTENT ═══ -->
<div class="container">

    <!-- Type chips -->
    <div class="type-chips">
        <a href="{{ route('programs.index', request()->except('type', 'page')) }}"
           class="type-chip {{ !request('type') ? 'active' : '' }}">
            All Programs
            <span class="type-chip-count">{{ $totalPrograms }}</span>
        </a>
        @foreach([
            'professional_certificate' => 'Professional Certificate',
            'micromasters'             => 'MicroMasters',
            'xseries'                  => 'XSeries',
            'specialization'           => 'Specialization',
        ] as $key => $label)
            @if($programTypes->has($key))
            <a href="{{ route('programs.index', array_merge(request()->except('type', 'page'), ['type' => $key])) }}"
               class="type-chip {{ request('type') === $key ? 'active' : '' }}">
                {{ $label }}
                <span class="type-chip-count">{{ $programTypes->get($key, 0) }}</span>
            </a>
            @endif
        @endforeach
    </div>

    <!-- Filter bar -->
    <form method="GET" action="{{ route('programs.index') }}" class="filter-wrap">
        @if(request('type'))
            <input type="hidden" name="type" value="{{ request('type') }}">
        @endif

        <div class="search-box">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="6.5" cy="6.5" r="5" stroke="#1A1825" stroke-width="1.5"/>
                <path d="M10 10L14 14" stroke="#1A1825" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <input type="text" name="q" placeholder="Search programs…" value="{{ request('q') }}">
        </div>

        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">All Subjects</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-dark" style="padding: 10px 22px; font-size:13px;">Search</button>
    </form>

    <!-- Results count -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <p style="font-size:13px; color:var(--muted);">
            Showing <strong style="color:var(--text);">{{ $programs->total() }}</strong> programs
            @if(request('q')) for "<strong style="color:var(--text);">{{ request('q') }}</strong>" @endif
        </p>
    </div>

    <!-- Programs grid -->
    @if($programs->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🎓</div>
            <h2 class="empty-title">No programs found</h2>
            <p class="empty-desc">Try adjusting your search or filters.</p>
        </div>
    @else
        <div class="programs-grid">
            @foreach($programs as $program)
            <a href="{{ route('programs.show', $program->slug) }}" class="program-card">

                <!-- Thumbnail -->
                <div style="position:relative;">
                    @if($program->thumbnail_url)
                        <img src="{{ $program->thumbnail_url }}" alt="{{ $program->title }}" class="program-card-thumb" loading="lazy">
                    @else
                        <div class="program-thumb-placeholder"
                             style="background: linear-gradient(135deg,
                                {{ ['#EDE5F9,#C4B8E8','#D6EAF8,#AED6F1','#D5F5E3,#A9DFBF','#FDEBD0,#FAD7A0'][($program->id ?? 0) % 4] }});">
                            🎓
                        </div>
                    @endif
                    <!-- Type badge -->
                    <span class="program-type-badge badge-{{ $program->type }}">
                        {{ match($program->type) {
                            'professional_certificate' => 'Prof. Cert.',
                            'micromasters'             => 'MicroMasters',
                            'xseries'                  => 'XSeries',
                            'specialization'           => 'Specialization',
                            default                    => 'Program',
                        } }}
                    </span>
                </div>

                <!-- Body -->
                <div class="program-card-body">
                    <!-- Institution -->
                    <div class="program-institution">
                        @if($program->institution?->logo_url)
                            <img src="{{ $program->institution->logo_url }}" alt="" class="institution-logo">
                        @else
                            <div class="institution-logo" style="background:linear-gradient(135deg,var(--navy),#2D4D7A);display:flex;align-items:center;justify-content:center;color:white;font-size:10px;font-weight:700;">
                                {{ strtoupper(substr($program->institution?->name ?? 'C', 0, 1)) }}
                            </div>
                        @endif
                        <span class="institution-name">{{ $program->institution?->name ?? 'Coursify' }}</span>
                    </div>

                    <!-- Title -->
                    <h2 class="program-title">{{ $program->title }}</h2>

                    <!-- Description -->
                    <p class="program-description">{{ $program->description }}</p>

                    <!-- Meta -->
                    <div class="program-meta">
                        <span class="program-meta-item">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><rect x="1" y="3" width="11" height="9" rx="2" stroke="#8B87A8" stroke-width="1.3"/><path d="M1 6h11" stroke="#8B87A8" stroke-width="1.3"/><path d="M4 1v2M9 1v2" stroke="#8B87A8" stroke-width="1.3" stroke-linecap="round"/></svg>
                            {{ $program->duration_months ? $program->duration_months . ' mo' : ($program->courses->count() . ' courses') }}
                        </span>
                        <span class="program-meta-item">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><circle cx="6.5" cy="6.5" r="5.5" stroke="#8B87A8" stroke-width="1.3"/><path d="M6.5 3.5v3l2 1.5" stroke="#8B87A8" stroke-width="1.3" stroke-linecap="round"/></svg>
                            {{ $program->effort_per_week ? $program->effort_per_week . ' hrs/wk' : 'Self-paced' }}
                        </span>
                        <span class="program-meta-item">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M6.5 1L8 4.5H12L9 7l1 4-3.5-2L3 11l1-4L1 4.5H5L6.5 1z" stroke="#8B87A8" stroke-width="1.3" stroke-linejoin="round"/></svg>
                            {{ $program->courses->count() }} courses
                        </span>

                        <span class="program-price {{ ($program->price ?? 0) == 0 ? 'free' : '' }}">
                            @if(($program->price ?? 0) == 0)
                                Free
                            @else
                                Rp {{ number_format($program->price, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($programs->hasPages())
        <div class="pagination-wrap">
            {{ $programs->onEachSide(2)->links('vendor.pagination.simple-coursify') }}
        </div>
        @endif
    @endif

</div>
@endsection
