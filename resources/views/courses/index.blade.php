@extends('layouts.app')

@section('title', 'Browse Courses — Coursify')

@push('styles')
<style>
/* ═══════════════════════════════════════════
   COURSES INDEX — page-specific styles only
   (global vars, body bg, navbar sudah dari layouts/app.blade.php)
═══════════════════════════════════════════ */

/* ═══ PAGE HERO ═══ */
.page-hero {
    text-align: center;
    padding: 48px 20px 40px;
    position: relative;
    z-index: 1;
}
.page-hero-title {
    font-family: var(--font-serif);
    font-size: clamp(38px, 6vw, 68px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-bottom: 14px;
    overflow: visible;
}
.page-hero-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
    padding-bottom: 0.25em;
    line-height: 1.3;
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
.search-wrap { max-width: 640px; margin: 0 auto; position: relative; }
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
    position: absolute; left: 22px; top: 50%;
    transform: translateY(-50%);
    font-size: 18px; color: var(--muted); pointer-events: none;
}
.search-btn {
    position: absolute; right: 8px; top: 50%;
    transform: translateY(-50%);
    padding: 9px 20px;
    background: #1A1825; color: white;
    border: none; border-radius: 100px;
    font-family: var(--font-sans); font-size: 13px; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
}
.search-btn:hover { background: #2A2840; }

/* ═══ POPULAR SEARCHES ═══ */
.popular-searches {
    display: flex; gap: 8px; justify-content: center;
    flex-wrap: wrap; margin-top: 20px;
    max-width: 640px; margin-left: auto; margin-right: auto;
}
.popular-label { font-size: 12px; color: var(--muted); font-weight: 500; letter-spacing: 0.02em; padding-top: 5px; }
.popular-tag {
    padding: 6px 14px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    font-size: 12px; color: var(--text-soft); font-weight: 500;
    text-decoration: none; cursor: pointer; transition: all 0.2s;
}
.popular-tag:hover { background: white; color: var(--purple); transform: translateY(-1px); }

/* ═══ STATS BAR ═══ */
.stats-bar {
    max-width: 880px; margin: 32px auto 0;
    background: rgba(255,255,255,0.5);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: 20px; padding: 20px 32px;
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
}
.stat-item { text-align: center; border-right: 1px solid rgba(30,58,95,0.08); }
.stat-item:last-child { border-right: none; }
.stat-value {
    font-family: var(--font-serif); font-size: 26px;
    font-weight: 400; letter-spacing: -0.02em; line-height: 1; margin-bottom: 4px;
}
.stat-value em { font-style: italic; color: var(--purple); }
.stat-label { font-size: 10px; color: var(--muted); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; }

/* ═══ MAIN LAYOUT ═══ */
.main-section { padding: 40px 20px 60px; }
.layout-grid { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }

/* ═══ FILTER SIDEBAR ═══ */
.filter-sidebar {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px; padding: 24px;
    position: sticky; top: 110px;
    max-height: calc(100vh - 140px);
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(30,58,95,0.05);
}
.filter-sidebar::-webkit-scrollbar { width: 4px; }
.filter-sidebar::-webkit-scrollbar-thumb { background: var(--lav-3); border-radius: 4px; }
.filter-header {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-bottom: 20px; padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}
.filter-title { font-family: var(--font-serif); font-size: 20px; font-weight: 400; letter-spacing: -0.01em; }
.filter-clear {
    font-size: 11px; color: var(--purple);
    background: none; border: none; cursor: pointer;
    font-weight: 600; padding: 4px 10px; border-radius: 100px;
    transition: all 0.2s; text-decoration: none;
}
.filter-clear:hover { background: rgba(123,111,232,0.1); }
.filter-group { margin-bottom: 22px; padding-bottom: 22px; border-bottom: 1px solid var(--border); }
.filter-group:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
.filter-group-title {
    font-size: 11px; font-weight: 700; color: var(--text-soft);
    letter-spacing: 0.1em; text-transform: uppercase;
    margin-bottom: 12px;
    display: flex; align-items: center; justify-content: space-between;
}
.filter-group-count {
    background: var(--lav-1); color: var(--purple);
    padding: 2px 7px; border-radius: 100px;
    font-size: 10px; font-weight: 600; letter-spacing: 0;
}
.filter-option {
    display: flex; align-items: center; justify-content: space-between;
    padding: 7px 10px; border-radius: 8px; cursor: pointer;
    transition: background 0.2s; margin-bottom: 2px;
}
.filter-option:hover { background: var(--lav-1); }
.filter-option-left { display: flex; align-items: center; gap: 9px; flex: 1; min-width: 0; }
.filter-checkbox {
    appearance: none; width: 16px; height: 16px;
    border: 1.5px solid var(--border); border-radius: 4px;
    background: white; cursor: pointer; position: relative;
    flex-shrink: 0; transition: all 0.2s;
}
.filter-checkbox:checked { background: var(--purple); border-color: var(--purple); }
.filter-checkbox:checked::after {
    content: '✓'; position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%); color: white; font-size: 10px; font-weight: 700;
}
.filter-option-label { font-size: 13px; color: var(--text-soft); font-weight: 500; display: flex; align-items: center; gap: 6px; }
.filter-option-count { font-size: 11px; color: var(--muted); font-weight: 500; }
.price-range { padding: 8px 0; }
.price-slider {
    -webkit-appearance: none; width: 100%; height: 4px;
    background: var(--lav-2); border-radius: 100px; outline: none; margin-bottom: 10px;
}
.price-slider::-webkit-slider-thumb {
    -webkit-appearance: none; width: 16px; height: 16px;
    background: var(--purple); border-radius: 50%; cursor: pointer;
    box-shadow: 0 2px 6px rgba(123,111,232,0.4);
}
.price-range-labels { display: flex; justify-content: space-between; font-size: 11px; color: var(--muted); font-weight: 500; }
.rating-option {
    display: flex; align-items: center; gap: 9px;
    padding: 7px 10px; border-radius: 8px; cursor: pointer;
    transition: background 0.2s; margin-bottom: 2px;
}
.rating-option:hover { background: var(--lav-1); }
.rating-stars { color: var(--gold); font-size: 14px; letter-spacing: 1px; }
.rating-stars-muted { color: var(--lav-3); }

/* ═══ RESULTS AREA ═══ */
.results-area { min-width: 0; }
.results-toolbar {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
    padding: 14px 20px;
    background: rgba(255,255,255,0.6); backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.8); border-radius: 14px;
}
.results-count { font-size: 13px; color: var(--text-soft); font-weight: 500; }
.results-count strong { font-family: var(--font-serif); font-size: 20px; color: var(--text); font-weight: 400; margin-right: 4px; letter-spacing: -0.01em; }
.toolbar-right { display: flex; gap: 10px; align-items: center; }
.view-toggle { display: flex; background: var(--lav-1); border-radius: 10px; padding: 3px; gap: 2px; }
.view-btn { padding: 6px 10px; border: none; background: transparent; border-radius: 8px; cursor: pointer; color: var(--muted); font-size: 14px; transition: all 0.2s; }
.view-btn.active { background: white; color: var(--purple); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
.sort-select {
    padding: 8px 14px; background: white;
    border: 1px solid var(--border); border-radius: 10px;
    font-family: var(--font-sans); font-size: 13px; color: var(--text);
    cursor: pointer; outline: none; transition: all 0.2s; font-weight: 500;
}
.sort-select:hover { border-color: var(--purple); }
.sort-select:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(123,111,232,0.1); }

/* ═══ ACTIVE FILTERS ═══ */
.active-filters { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 18px; align-items: center; }
.active-filter-label { font-size: 12px; color: var(--muted); font-weight: 500; }
.active-filter-tag {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px;
    background: rgba(123,111,232,0.1); color: var(--purple-dark);
    border: 1px solid rgba(123,111,232,0.2); border-radius: 100px;
    font-size: 12px; font-weight: 600; transition: all 0.2s; cursor: pointer;
}
.active-filter-tag:hover { background: rgba(123,111,232,0.15); }
.active-filter-remove { background: none; border: none; cursor: pointer; color: var(--purple); font-size: 13px; padding: 0; line-height: 1; font-weight: 700; }

/* ═══ COURSE GRID ═══ */
.courses-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.course-card {
    background: rgba(255,255,255,0.7); backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9); border-radius: 20px;
    overflow: hidden; text-decoration: none; color: var(--text);
    transition: all 0.3s; display: flex; flex-direction: column;
    box-shadow: 0 4px 16px rgba(30,58,95,0.04); min-width: 0;
}
.course-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(30,58,95,0.12); border-color: var(--purple); }
.course-thumb { aspect-ratio: 16/10; position: relative; display: flex; align-items: center; justify-content: center; font-size: 54px; overflow: hidden; }
.course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
.course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
.course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }
.course-thumb-4 { background: linear-gradient(135deg, #FA709A, #FEE140); }
.course-thumb-5 { background: linear-gradient(135deg, #30CFD0, #330867); }
.course-thumb-6 { background: linear-gradient(135deg, #A8EDEA, #FED6E3); }
.course-badge {
    position: absolute; top: 12px; left: 12px;
    padding: 4px 10px; border-radius: 100px;
    font-size: 10px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;
    backdrop-filter: blur(10px);
}
.badge-new        { background: rgba(255,138,91,0.95); color: white; }
.badge-bestseller { background: rgba(255,200,50,0.95); color: #5A3A00; }
.badge-free       { background: rgba(0,200,150,0.95);  color: white; }
.badge-premium    { background: rgba(123,111,232,0.95);color: white; }
.course-wishlist {
    position: absolute; top: 12px; right: 12px;
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);
    border: none; display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 15px; transition: all 0.2s;
}
.course-wishlist:hover { background: white; transform: scale(1.1); }
.course-wishlist.active { background: #FF6B8A; color: white; }
.course-body { padding: 18px; flex: 1; display: flex; flex-direction: column; }
.course-category { font-size: 10px; color: var(--muted); font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 6px; }
.course-institution {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 10px; color: var(--text-soft); font-weight: 600;
    margin-bottom: 8px; padding: 3px 8px;
    background: var(--lav-1); border-radius: 100px;
    width: fit-content; letter-spacing: 0.02em;
}
.course-institution i { color: var(--purple); font-size: 9px; }
.course-title {
    font-family: var(--font-serif); font-size: 18px; font-weight: 400;
    line-height: 1.25; letter-spacing: -0.01em; margin-bottom: 10px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; min-height: 44px;
}
.course-instructor { font-size: 12px; color: var(--text-soft); margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
.course-instructor-avatar {
    width: 20px; height: 20px; border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white; font-size: 10px; font-weight: 700;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.course-meta {
    display: flex; gap: 12px; font-size: 11px; color: var(--muted);
    margin-bottom: 14px; padding-bottom: 14px; border-bottom: 1px solid var(--border);
}
.course-meta span { display: inline-flex; align-items: center; gap: 3px; }
.course-footer { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
.course-price { font-family: var(--font-serif); font-size: 22px; font-weight: 400; letter-spacing: -0.01em; line-height: 1; }
.course-price-free { color: var(--teal); }
.course-arrow { font-size: 18px; color: var(--purple); transition: transform 0.3s; }
.course-card:hover .course-arrow { transform: translateX(4px); }

/* ═══ PAGINATION ═══ */
.pagination { display: flex; justify-content: center; gap: 6px; margin-top: 40px; align-items: center; flex-wrap: wrap; }
.page-btn {
    min-width: 38px; height: 38px; border-radius: 10px;
    border: 1px solid var(--border);
    background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);
    font-family: var(--font-sans); font-size: 13px; font-weight: 600;
    color: var(--text-soft); cursor: pointer; transition: all 0.2s;
    display: inline-flex; align-items: center; justify-content: center;
    padding: 0 10px; text-decoration: none;
}
.page-btn:hover:not([disabled]) { background: white; border-color: var(--purple); color: var(--purple); }
.page-btn.active { background: #1A1825; border-color: #1A1825; color: white; cursor: default; }
.page-btn[disabled] { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
.page-dots { color: var(--muted); padding: 0 4px; font-weight: 600; }

/* ═══ EMPTY STATE ═══ */
.empty-state {
    text-align: center; padding: 60px 20px;
    background: rgba(255,255,255,0.5); backdrop-filter: blur(20px);
    border-radius: 20px; border: 1px solid rgba(255,255,255,0.8);
}
.empty-icon { font-size: 56px; margin-bottom: 16px; }
.empty-title { font-family: var(--font-serif); font-size: 24px; font-weight: 400; margin-bottom: 8px; letter-spacing: -0.01em; }
.empty-desc { font-size: 13px; color: var(--muted); max-width: 380px; margin: 0 auto 20px; line-height: 1.6; }

/* ═══ CATEGORY ACCORDION ═══ */
.cat-accordion {
    border-radius: 10px;
    margin-bottom: 2px;
    transition: background 0.15s;
}
.cat-accordion.open {
    background: rgba(123,111,232,0.04);
    border: 1px solid rgba(123,111,232,0.08);
}
.cat-parent-row {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 7px 10px; border-radius: 8px;
    cursor: pointer; transition: background 0.15s;
    gap: 6px;
}
.cat-parent-row:hover { background: var(--lav-1); }
.cat-parent-left { flex: 1; min-width: 0; }
.cat-parent-right {
    display: flex; align-items: center; gap: 6px;
    flex-shrink: 0;
}
.cat-chevron {
    font-size: 14px; color: var(--muted);
    transition: transform 0.2s; display: inline-block;
    line-height: 1; user-select: none;
    width: 14px; text-align: center;
}
.cat-accordion.open .cat-chevron { transform: none; }
.cat-children {
    padding: 4px 0 6px 26px;
    border-left: 2px solid var(--lav-2);
    margin-left: 22px;
    margin-bottom: 4px;
}
.cat-child-row {
    padding: 5px 8px !important;
    border-radius: 6px !important;
    margin-bottom: 1px !important;
}
.cat-child-row .filter-option-label {
    font-size: 12px !important;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 1100px) {
    .layout-grid { grid-template-columns: 240px 1fr; }
    .courses-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 900px) {
    .layout-grid { grid-template-columns: 1fr; }
    .filter-sidebar { position: static; max-height: none; }
    .stats-bar { grid-template-columns: repeat(2, 1fr); padding: 16px 20px; }
    .stat-item:nth-child(2) { border-right: none; }
}
@media (max-width: 640px) {
    .courses-grid { grid-template-columns: 1fr; }
    .results-toolbar { flex-direction: column; align-items: flex-start; }
    .search-input { padding: 14px 50px 14px 46px; font-size: 14px; }
    .search-btn { display: none; }
}
</style>
@endpush

@section('content')

{{-- ════════════════════════════════════════════════════ --}}
{{-- PAGE HERO                                            --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title">Find your perfect <em>course</em></h1>
        <p class="page-hero-subtitle">
            Browse our curated collection of courses from world-class instructors. Filter, compare, and start learning today.
        </p>

        {{-- Search form (terpisah dari filterForm agar tidak konflik) --}}
        <form action="{{ route('courses.index') }}" method="GET" class="search-wrap">
            {{-- Pertahankan filter aktif saat search disubmit --}}
            @foreach(request()->except('search', 'page') as $key => $value)
                @if(is_array($value))
                    @foreach($value as $v)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <span class="search-icon-left">🔍</span>
            <input type="text" name="search" class="search-input"
                placeholder="Search for courses, instructors, or topics..."
                value="{{ request('search') }}" autocomplete="off">
            <button type="submit" class="search-btn">Search</button>
        </form>

        {{-- Popular searches --}}
        <div class="popular-searches">
            <span class="popular-label">Popular:</span>
            <a href="{{ route('courses.index', ['search' => 'laravel']) }}" class="popular-tag">Laravel</a>
            <a href="{{ route('courses.index', ['search' => 'react']) }}" class="popular-tag">React.js</a>
            <a href="{{ route('courses.index', ['search' => 'python']) }}" class="popular-tag">Python</a>
            <a href="{{ route('courses.index', ['search' => 'design']) }}" class="popular-tag">UI/UX Design</a>
            <a href="{{ route('courses.index', ['search' => 'data']) }}" class="popular-tag">Data Science</a>
        </div>

        {{-- Stats bar (dari DB via controller) --}}
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value"><em>{{ $totalCourses }}+</em></div>
                <div class="stat-label">Courses</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>{{ $categories->count() }}+</em></div>
                <div class="stat-label">Categories</div>
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

{{-- ════════════════════════════════════════════════════ --}}
{{-- MAIN CONTENT                                         --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="main-section">
    <div class="container">
        <div class="layout-grid">

            {{-- ═══════════════════════════════════════ --}}
            {{-- FILTER SIDEBAR                          --}}
            {{-- ═══════════════════════════════════════ --}}
            <form id="filterForm" method="GET" action="{{ route('courses.index') }}">
                @if(request()->filled('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <aside class="filter-sidebar">
                    <div class="filter-header">
                        <h3 class="filter-title">Filters</h3>
                        <a href="{{ route('courses.index') }}" class="filter-clear">Clear all</a>
                    </div>

                    {{-- Categories Accordion (parent → sub) --}}
                    @php
                        $iconMap = [
                            'Technology' => '💻', 'Programming' => '💻', 'Design' => '🎨',
                            'Business' => '📊', 'Marketing' => '📈', 'Data Science' => '🔬',
                            'Video' => '🎬', 'Languages' => '🌍', 'Language' => '🌍',
                            'Music' => '🎵', 'Finance' => '💰', 'Health' => '🏃',
                            'Photography' => '📷', 'DevOps' => '🐳', 'Architecture' => '🏛️',
                            'Art' => '🎨', 'Science' => '🔬', 'Engineering' => '⚙️',
                            'Mathematics' => '📐', 'Social Science' => '👥', 'Economics' => '📊',
                            'Psychology' => '🧠', 'Education' => '🎓', 'Law' => '⚖️',
                            'Medicine' => '🏥', 'Environmental' => '🌿', 'History' => '📜',
                            'Philosophy' => '💭', 'Literature' => '📖', 'Cybersecurity' => '🔒',
                        ];
                        $activeCats = (array) request('category', []);
                    @endphp

                    <div class="filter-group" style="padding-bottom:0;border-bottom:none;">
                        <div class="filter-group-title" style="margin-bottom:10px;">
                            <span>Category</span>
                            <span class="filter-group-count">{{ $parentCategories->count() }}</span>
                        </div>

                        @forelse($parentCategories as $parent)
                            @php
                                $parentIcon = $iconMap[$parent->name] ?? '📚';
                                $hasChildren = $parent->children->count() > 0;
                                $isParentChecked = in_array($parent->slug, $activeCats);
                                $anyChildActive = $parent->children->contains(fn($c) => in_array($c->slug, $activeCats));
                                $isOpen = $isParentChecked || $anyChildActive;
                                $totalCount = $parent->courses_count + $parent->children->sum('courses_count');
                            @endphp

                            <div class="cat-accordion {{ $isOpen ? 'open' : '' }}" data-id="cat-{{ $parent->id }}">

                                {{-- Parent row --}}
                                <div class="cat-parent-row" onclick="toggleCat('cat-{{ $parent->id }}')">
                                    <div class="cat-parent-left">
                                        <label class="filter-option" style="padding:0;margin:0;flex:1;" onclick="event.stopPropagation()">
                                            <div class="filter-option-left">
                                                <input type="checkbox"
                                                    class="filter-checkbox"
                                                    name="category[]"
                                                    value="{{ $parent->slug }}"
                                                    @checked($isParentChecked)
                                                    onchange="document.getElementById('filterForm').submit()">
                                                <span class="filter-option-label">
                                                    <span>{{ $parentIcon }}</span>
                                                    <span style="font-weight:{{ $isParentChecked || $anyChildActive ? '700' : '500' }};color:{{ $isParentChecked || $anyChildActive ? 'var(--purple)' : 'var(--text-soft)' }}">{{ $parent->name }}</span>
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="cat-parent-right">
                                        @if($totalCount > 0)
                                            <span class="filter-option-count">{{ $totalCount }}</span>
                                        @endif
                                        @if($hasChildren)
                                            <span class="cat-chevron">{{ $isOpen ? '▾' : '›' }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Children --}}
                                @if($hasChildren)
                                    <div class="cat-children" style="{{ $isOpen ? '' : 'display:none;' }}">
                                        @foreach($parent->children as $child)
                                            @php
                                                $isChildChecked = in_array($child->slug, $activeCats);
                                            @endphp
                                            <label class="filter-option cat-child-row">
                                                <div class="filter-option-left">
                                                    <input type="checkbox"
                                                        class="filter-checkbox"
                                                        name="category[]"
                                                        value="{{ $child->slug }}"
                                                        @checked($isChildChecked)
                                                        onchange="document.getElementById('filterForm').submit()">
                                                    <span class="filter-option-label" style="color:{{ $isChildChecked ? 'var(--purple)' : '' }}">
                                                        {{ $child->name }}
                                                    </span>
                                                </div>
                                                @if($child->courses_count > 0)
                                                    <span class="filter-option-count">{{ $child->courses_count }}</span>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                @endif

                            </div>{{-- end .cat-accordion --}}
                        @empty
                            <p style="font-size:12px;color:var(--muted);padding:8px 10px;">No categories found</p>
                        @endforelse
                    </div>

                    {{-- Difficulty --}}
                    <div class="filter-group">
                        <div class="filter-group-title"><span>Level</span></div>
                        @foreach([
                            ['label' => 'Beginner',     'value' => 'beginner'],
                            ['label' => 'Intermediate',  'value' => 'intermediate'],
                            ['label' => 'Advanced',      'value' => 'advanced'],
                        ] as $level)
                            <label class="filter-option">
                                <div class="filter-option-left">
                                    <input type="checkbox"
                                        class="filter-checkbox"
                                        name="difficulty[]"
                                        value="{{ $level['value'] }}"
                                        @checked(in_array($level['value'], (array) request('difficulty', [])))
                                        onchange="document.getElementById('filterForm').submit()">
                                    <span class="filter-option-label">{{ $level['label'] }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    {{-- Price --}}
                    <div class="filter-group">
                        <div class="filter-group-title"><span>Price</span></div>
                        <label class="filter-option">
                            <div class="filter-option-left">
                                <input type="checkbox" class="filter-checkbox" name="price[]" value="free"
                                    @checked(in_array('free', (array) request('price', [])))
                                    onchange="document.getElementById('filterForm').submit()">
                                <span class="filter-option-label">🆓 Free courses</span>
                            </div>
                        </label>
                        <label class="filter-option">
                            <div class="filter-option-left">
                                <input type="checkbox" class="filter-checkbox" name="price[]" value="paid"
                                    @checked(in_array('paid', (array) request('price', [])))
                                    onchange="document.getElementById('filterForm').submit()">
                                <span class="filter-option-label">💎 Premium</span>
                            </div>
                        </label>
                        <div class="price-range" style="margin-top:10px;">
                            <input type="range" min="0" max="500000" step="50000"
                                name="max_price" id="priceSlider"
                                value="{{ request('max_price', 500000) }}"
                                class="price-slider"
                                oninput="updatePriceDisplay(this.value)"
                                onchange="document.getElementById('filterForm').submit()">
                            <div class="price-range-labels">
                                <span>Rp 0</span>
                                <span id="priceDisplay">
                                    {{ request('max_price', 500000) >= 500000
                                        ? 'Rp 500K+'
                                        : 'Rp '.number_format(request('max_price'), 0, ',', '.') }}
                                </span>
                                <span>Rp 500K+</span>
                            </div>
                        </div>
                    </div>

                    {{-- Rating --}}
                    <div class="filter-group">
                        <div class="filter-group-title"><span>Rating</span></div>
                        @foreach([5, 4, 3] as $stars)
                            <label class="rating-option">
                                <input type="radio" class="filter-checkbox" name="rating" value="{{ $stars }}"
                                    @checked((string)request('rating') === (string)$stars)
                                    onchange="document.getElementById('filterForm').submit()">
                                <span class="rating-stars">
                                    {{ str_repeat('★', $stars) }}<span class="rating-stars-muted">{{ str_repeat('★', 5 - $stars) }}</span>
                                </span>
                                <span class="filter-option-label" style="font-size:12px;">& up</span>
                            </label>
                        @endforeach
                    </div>

                    {{-- Language --}}
                    <div class="filter-group">
                        <div class="filter-group-title"><span>Language</span></div>
                        @foreach([
                            ['value' => 'id', 'label' => '🇮🇩 Indonesia'],
                            ['value' => 'en', 'label' => '🇬🇧 English'],
                        ] as $lang)
                            <label class="filter-option">
                                <div class="filter-option-left">
                                    <input type="checkbox" class="filter-checkbox"
                                        name="language[]" value="{{ $lang['value'] }}"
                                        @checked(in_array($lang['value'], (array) request('language', [])))
                                        onchange="document.getElementById('filterForm').submit()">
                                    <span class="filter-option-label">{{ $lang['label'] }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    {{-- Fallback tanpa JS --}}
                    <noscript>
                        <button type="submit" style="width:100%;margin-top:12px;padding:10px;background:#1A1825;color:white;border:none;border-radius:100px;cursor:pointer;font-weight:600;">
                            Apply Filters
                        </button>
                    </noscript>
                </aside>
            </form>

            {{-- ═══════════════════════════════════════ --}}
            {{-- RESULTS AREA                            --}}
            {{-- ═══════════════════════════════════════ --}}
            <div class="results-area">

                {{-- Toolbar --}}
                <div class="results-toolbar">
                    <div class="results-count">
                        <strong>{{ $courses->total() }}</strong>
                        course{{ $courses->total() !== 1 ? 's' : '' }} found
                        @if(request('search'))
                            for "<span style="color:var(--purple);font-weight:600;">{{ request('search') }}</span>"
                        @endif
                    </div>
                    <div class="toolbar-right">
                        <div class="view-toggle">
                            <button class="view-btn active" title="Grid view" onclick="switchView('grid', this)" type="button">▦</button>
                            <button class="view-btn" title="List view" onclick="switchView('list', this)" type="button">☰</button>
                        </div>
                        <select class="sort-select" name="sort" form="filterForm"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="popular"    @selected(request('sort', 'popular') === 'popular')>Most Popular</option>
                            <option value="newest"     @selected(request('sort') === 'newest')>Newest First</option>
                            <option value="rating"     @selected(request('sort') === 'rating')>Highest Rated</option>
                            <option value="price_low"  @selected(request('sort') === 'price_low')>Price: Low to High</option>
                            <option value="price_high" @selected(request('sort') === 'price_high')>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                {{-- Active Filters (dinamis dari request()) --}}
                @php
                    $activeFilters = [];
                    foreach ((array) request('category', []) as $slug) {
                        $cat = $categories->firstWhere('slug', $slug);
                        if ($cat) $activeFilters[] = ['label' => $cat->name, 'param' => 'category', 'value' => $slug];
                    }
                    foreach ((array) request('difficulty', []) as $diff) {
                        $activeFilters[] = ['label' => ucfirst($diff), 'param' => 'difficulty', 'value' => $diff];
                    }
                    foreach ((array) request('price', []) as $p) {
                        $activeFilters[] = ['label' => $p === 'free' ? '🆓 Free' : '💎 Premium', 'param' => 'price', 'value' => $p];
                    }
                    if (request()->filled('rating')) {
                        $activeFilters[] = ['label' => '⭐ '.request('rating').'+ stars', 'param' => 'rating', 'value' => request('rating')];
                    }
                    foreach ((array) request('language', []) as $lang) {
                        $activeFilters[] = ['label' => $lang === 'id' ? '🇮🇩 Indonesia' : '🇬🇧 English', 'param' => 'language', 'value' => $lang];
                    }
                    if (request()->filled('search')) {
                        $activeFilters[] = ['label' => '🔍 "'.request('search').'"', 'param' => 'search', 'value' => request('search')];
                    }
                @endphp

                @if(count($activeFilters) > 0)
                    <div class="active-filters">
                        <span class="active-filter-label">Active:</span>
                        @foreach($activeFilters as $filter)
                            <span class="active-filter-tag"
                                onclick="removeFilter('{{ $filter['param'] }}', '{{ $filter['value'] }}')"
                                title="Remove filter">
                                {{ $filter['label'] }}
                                <button class="active-filter-remove" type="button">✕</button>
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Course Grid --}}
                <div class="courses-grid" id="coursesGrid">
                    @forelse($courses as $course)
                        @php
                            $thumbIndex       = ($loop->index % 6) + 1;
                            $instructorName   = $course->instructors->first()?->name ?? 'Coursify Team';
                            $instructorInitial = strtoupper(substr($instructorName, 0, 1));
                            $ratingVal        = $course->reviews_avg_rating
                                ? number_format($course->reviews_avg_rating, 1) : '—';
                            $studentsCount    = $course->enrollments_count ?? 0;
                            $studentsFormatted = $studentsCount >= 1000
                                ? number_format($studentsCount / 1000, 1).'k' : $studentsCount;

                            $badge = null;
                            if ($course->isFree()) { $badge = 'free'; }
                            elseif ($studentsCount > 5000) { $badge = 'bestseller'; }
                            elseif ($course->created_at?->gt(now()->subDays(30))) { $badge = 'new'; }

                            $catIconMap = [
                                'Programming' => '💻', 'Design' => '🎨', 'Business' => '📊',
                                'Marketing' => '📈', 'Data Science' => '🔬', 'Video' => '🎬',
                                'Languages' => '🌍', 'Music' => '🎵', 'DevOps' => '🐳',
                            ];
                            $courseIcon = $catIconMap[$course->category?->name] ?? '📚';
                        @endphp

                        <a href="{{ route('courses.show', $course->slug) }}" class="course-card">
                            <div class="course-thumb course-thumb-{{ $thumbIndex }}">
                                @if($badge)
                                    <span class="course-badge badge-{{ $badge }}">
                                        @if($badge === 'bestseller') ⭐ Bestseller
                                        @elseif($badge === 'new') 🆕 New
                                        @elseif($badge === 'free') Free
                                        @endif
                                    </span>
                                @endif
                                @auth
                                    @php
    $isWishlisted = auth()->check() && auth()->user()
        ->wishlists()->where('course_id', $course->id)->exists();
@endphp

<button class="course-wishlist {{ $isWishlisted ? 'active' : '' }}"
    onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist(this, {{ $course->id }});"
    title="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}">
    {{ $isWishlisted ? '❤️' : '🤍' }}
</button>
                                @endauth
                                @if($course->thumbnail_url)
                                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}"
                                        style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.85;">
                                @else
                                    {{ $courseIcon }}
                                @endif
                            </div>

                            <div class="course-body">
                                <div class="course-category">{{ $course->category?->name ?? 'General' }}</div>
                                @if($course->institution)
                                    <div class="course-institution">
                                        <i class="fa-solid fa-building-columns"></i>
                                        {{ $course->institution->name }}
                                    </div>
                                @endif
                                <div class="course-title">{{ $course->title }}</div>
                                <div class="course-instructor">
                                    <div class="course-instructor-avatar">{{ $instructorInitial }}</div>
                                    <span>{{ $instructorName }}</span>
                                </div>
                                <div class="course-meta">
                                    <span>⭐ {{ $ratingVal }}</span>
                                    <span>👥 {{ $studentsFormatted }}</span>
                                    @if($course->duration_weeks)
                                        <span>🕐 {{ $course->duration_weeks }}w</span>
                                    @endif
                                </div>
                                <div class="course-footer">
                                    <div>
                                        <span class="course-price {{ $course->isFree() ? 'course-price-free' : '' }}">
                                            {{ $course->isFree() ? 'Free' : 'Rp '.number_format($course->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="course-arrow">→</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state" style="grid-column: 1 / -1;">
                            <div class="empty-icon">🔍</div>
                            <div class="empty-title">No courses found</div>
                            <p class="empty-desc">
                                @if(request()->hasAny(['search', 'category', 'difficulty', 'price', 'rating', 'language']))
                                    Try adjusting your filters or search terms.
                                @else
                                    No published courses yet. Check back soon!
                                @endif
                            </p>
                            <a href="{{ route('courses.index') }}"
                                style="display:inline-block;padding:10px 24px;background:#1A1825;color:white;border-radius:100px;text-decoration:none;font-weight:600;font-size:13px;">
                                Clear filters &amp; browse all
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($courses->hasPages())
                    <div class="pagination">
                        @if($courses->onFirstPage())
                            <button class="page-btn" disabled>← Prev</button>
                        @else
                            <a href="{{ $courses->previousPageUrl() }}" class="page-btn">← Prev</a>
                        @endif

                        @php
                            $current = $courses->currentPage();
                            $last    = $courses->lastPage();
                            $start   = max(1, $current - 2);
                            $end     = min($last, $current + 2);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $courses->url(1) }}" class="page-btn">1</a>
                            @if($start > 2)<span class="page-dots">…</span>@endif
                        @endif

                        @for($p = $start; $p <= $end; $p++)
                            @if($p === $current)
                                <button class="page-btn active">{{ $p }}</button>
                            @else
                                <a href="{{ $courses->url($p) }}" class="page-btn">{{ $p }}</a>
                            @endif
                        @endfor

                        @if($end < $last)
                            @if($end < $last - 1)<span class="page-dots">…</span>@endif
                            <a href="{{ $courses->url($last) }}" class="page-btn">{{ $last }}</a>
                        @endif

                        @if($courses->hasMorePages())
                            <a href="{{ $courses->nextPageUrl() }}" class="page-btn">Next →</a>
                        @else
                            <button class="page-btn" disabled>Next →</button>
                        @endif
                    </div>

                    <p style="text-align:center;margin-top:12px;font-size:12px;color:var(--muted);font-weight:500;">
                        Showing {{ $courses->firstItem() }}–{{ $courses->lastItem() }} of {{ $courses->total() }} courses
                    </p>
                @endif

            </div>{{-- end .results-area --}}
        </div>{{-- end .layout-grid --}}
    </div>{{-- end .container --}}
</section>

@endsection

@push('scripts')
<script>
// ── Category accordion toggle ──────────────────────────
function toggleCat(id) {
    const el = document.querySelector(`[data-id="${id}"]`);
    if (!el) return;
    const children = el.querySelector('.cat-children');
    const chevron  = el.querySelector('.cat-chevron');
    const isOpen   = el.classList.contains('open');
    el.classList.toggle('open', !isOpen);
    if (children) children.style.display = isOpen ? 'none' : 'block';
    if (chevron)  chevron.textContent     = isOpen ? '›' : '▾';
}

// ── Wishlist toggle (AJAX, tanpa reload) ──────────────
function toggleWishlist(btn, courseId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) return;
    fetch(`/wishlist/toggle/${courseId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    })
    .then(res => res.json())
    .then(data => {
        const added = data.status === 'added';
        btn.classList.toggle('active', added);
        btn.textContent = added ? '❤️' : '🤍';
    })
    .catch(() => {
        btn.classList.toggle('active');
        btn.textContent = btn.classList.contains('active') ? '❤️' : '🤍';
    });
}

// ── Price slider display ───────────────────────────────
function updatePriceDisplay(value) {
    const display = document.getElementById('priceDisplay');
    if (!display) return;
    const num = parseInt(value);
    if (num >= 500000)      display.textContent = 'Rp 500K+';
    else if (num >= 1000)   display.textContent = 'Rp ' + (num / 1000).toFixed(0) + 'K';
    else                    display.textContent = 'Rp ' + num;
}

// ── View toggle (grid / list) ──────────────────────────
function switchView(view, btn) {
    document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const grid = document.getElementById('coursesGrid');
    if (grid) grid.style.gridTemplateColumns = view === 'list' ? '1fr' : '';
}

// ── Hapus satu active filter dari URL ─────────────────
function removeFilter(param, value) {
    const url = new URL(window.location.href);
    const sp  = url.searchParams;
    if (param === 'search' || param === 'rating') {
        sp.delete(param);
    } else {
        const key      = param + '[]';
        const existing = sp.getAll(key).filter(v => v !== value);
        sp.delete(key);
        existing.forEach(v => sp.append(key, v));
    }
    sp.delete('page');
    window.location.href = url.toString();
}
</script>
@endpush