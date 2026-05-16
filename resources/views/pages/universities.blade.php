@extends('layouts.app')

@section('title', 'Universitas Partner — Coursify')

@push('styles')
<style>
    /* ═══ PAGE HERO ═══ */
    .univ-hero {
        text-align: center;
        padding: 52px 20px 44px;
        position: relative;
        z-index: 1;
    }
    .univ-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(123,111,232,0.1);
        border: 1px solid rgba(123,111,232,0.2);
        color: #5B4FD4;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 100px;
        margin-bottom: 20px;
    }
    .univ-hero-eyebrow i { font-size: 12px; }
    .univ-hero-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(40px, 6vw, 72px);
        font-weight: 400;
        line-height: 1.08;
        letter-spacing: -0.025em;
        margin-bottom: 18px;
        color: #1A1825;
    }
    .univ-hero-title em {
        font-style: italic;
        background: linear-gradient(135deg, #9F94F2 0%, #7B6FE8 50%, #5B4FD4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        padding-right: 0.1em;
    }
    .univ-hero-sub {
        font-size: 16px;
        color: #4A4660;
        line-height: 1.65;
        max-width: 560px;
        margin: 0 auto 36px;
    }

    /* ═══ STATS STRIP ═══ */
    .univ-stats {
        display: flex;
        justify-content: center;
        gap: 0;
        max-width: 680px;
        margin: 0 auto 52px;
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.85);
        border-radius: 20px;
        overflow: hidden;
    }
    .univ-stat {
        flex: 1;
        text-align: center;
        padding: 20px 16px;
        position: relative;
    }
    .univ-stat + .univ-stat::before {
        content: '';
        position: absolute;
        left: 0; top: 20%; bottom: 20%;
        width: 1px;
        background: rgba(30,58,95,0.1);
    }
    .univ-stat-val {
        font-family: 'Instrument Serif', serif;
        font-size: 30px;
        font-weight: 400;
        letter-spacing: -0.02em;
        line-height: 1;
        margin-bottom: 5px;
        color: #1A1825;
    }
    .univ-stat-val em { font-style: italic; color: #7B6FE8; }
    .univ-stat-label {
        font-size: 11px;
        font-weight: 600;
        color: #8B87A8;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    /* ═══ FILTER BAR ═══ */
    .univ-filter-wrap {
        max-width: 1160px;
        margin: 0 auto 32px;
        padding: 0 20px;
    }
    .univ-filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.65);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 100px;
        padding: 6px 6px 6px 20px;
        flex-wrap: wrap;
    }
    .univ-filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #8B87A8;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        white-space: nowrap;
        margin-right: 4px;
    }
    .univ-filter-pills {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        flex: 1;
    }
    .filter-pill {
        padding: 7px 18px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 500;
        color: #4A4660;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
        white-space: nowrap;
    }
    .filter-pill:hover { background: rgba(123,111,232,0.08); color: #5B4FD4; }
    .filter-pill.active {
        background: #1E3A5F;
        color: white;
        font-weight: 600;
    }
    .univ-search-wrap {
        position: relative;
        margin-left: auto;
    }
    .univ-search {
        padding: 9px 18px 9px 38px;
        background: rgba(255,255,255,0.8);
        border: 1px solid rgba(255,255,255,0.95);
        border-radius: 100px;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: #1A1825;
        outline: none;
        width: 220px;
        transition: all 0.2s;
    }
    .univ-search::placeholder { color: #8B87A8; }
    .univ-search:focus {
        background: white;
        border-color: #7B6FE8;
        box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
        width: 260px;
    }
    .univ-search-icon {
        position: absolute;
        left: 14px; top: 50%;
        transform: translateY(-50%);
        color: #8B87A8;
        font-size: 14px;
        pointer-events: none;
    }

    /* ═══ UNIVERSITY GRID ═══ */
    .univ-section {
        max-width: 1160px;
        margin: 0 auto;
        padding: 0 20px 80px;
    }
    .univ-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    /* ═══ UNIVERSITY CARD ═══ */
    .univ-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 24px;
        overflow: hidden;
        text-decoration: none;
        color: #1A1825;
        transition: all 0.32s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px rgba(30,58,95,0.04);
        position: relative;
    }
    .univ-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 48px rgba(30,58,95,0.13);
        border-color: rgba(123,111,232,0.35);
    }
    .univ-card-banner {
        height: 140px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* Default gradients per-univ — can be replaced with actual image */
    .banner-ui    { background: linear-gradient(135deg, #1E3A5F 0%, #2D5F9E 100%); }
    .banner-itb   { background: linear-gradient(135deg, #1A5276 0%, #148F77 100%); }
    .banner-ugm   { background: linear-gradient(135deg, #1B4F72 0%, #7D6608 100%); }
    .banner-its   { background: linear-gradient(135deg, #6E2F7C 0%, #1E3A5F 100%); }
    .banner-unair { background: linear-gradient(135deg, #922B21 0%, #1E3A5F 100%); }
    .banner-ipb   { background: linear-gradient(135deg, #1E8449 0%, #1A5276 100%); }
    .banner-binus { background: linear-gradient(135deg, #D35400 0%, #922B21 100%); }
    .banner-undip { background: linear-gradient(135deg, #1E3A5F 0%, #1A5276 100%); }
    .banner-ub    { background: linear-gradient(135deg, #7D6608 0%, #922B21 100%); }

    /* Placeholder logo inside banner */
    .univ-logo-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 16px;
        background: rgba(255,255,255,0.18);
        border: 2px solid rgba(255,255,255,0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        backdrop-filter: blur(10px);
        transition: transform 0.3s;
        overflow: hidden;
    }
    .univ-card:hover .univ-logo-placeholder { transform: scale(1.05); }
    .univ-logo-placeholder img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 8px;
    }

    /* Partner cards: full-cover photo banner (no small box) */
    .univ-card:not(.univ-card-featured) .univ-logo-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 0;
        background: transparent;
        border: none;
        backdrop-filter: none;
        overflow: hidden;
        position: absolute;
        top: 0; left: 0;
    }
    .univ-card:not(.univ-card-featured) .univ-logo-placeholder img {
        object-fit: cover;
        padding: 0;
    }
    /* hide icon overlays on partner cards */
    .univ-card:not(.univ-card-featured) .univ-logo-placeholder i {
        display: none;
    }

    /* Badge on banner */
    .univ-card-tag {
        position: absolute;
        top: 12px; left: 12px;
        padding: 4px 11px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }
    .tag-featured {
        background: rgba(255,215,0,0.9);
        color: #5A3A00;
    }
    .tag-partner {
        background: rgba(255,255,255,0.22);
        color: white;
        border: 1px solid rgba(255,255,255,0.35);
    }

    .univ-card-body {
        padding: 20px 22px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .univ-card-type {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #8B87A8;
        margin-bottom: 6px;
    }
    .univ-card-name {
        font-family: 'Instrument Serif', serif;
        font-size: 20px;
        font-weight: 400;
        line-height: 1.25;
        letter-spacing: -0.01em;
        margin-bottom: 6px;
        color: #1A1825;
    }
    .univ-card-location {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #8B87A8;
        font-weight: 500;
        margin-bottom: 14px;
    }
    .univ-card-location i { font-size: 13px; }
    .univ-card-desc {
        font-size: 13px;
        color: #4A4660;
        line-height: 1.6;
        margin-bottom: 18px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .univ-card-stats {
        display: flex;
        gap: 16px;
        padding-top: 16px;
        border-top: 1px solid rgba(30,58,95,0.08);
        margin-bottom: 16px;
    }
    .univ-card-stat {
        text-align: center;
    }
    .univ-card-stat-val {
        font-family: 'Instrument Serif', serif;
        font-size: 18px;
        font-weight: 400;
        letter-spacing: -0.01em;
        color: #1A1825;
        line-height: 1;
        margin-bottom: 3px;
    }
    .univ-card-stat-label {
        font-size: 10px;
        color: #8B87A8;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .univ-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .univ-card-programs {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    .prog-badge {
        padding: 3px 10px;
        background: rgba(123,111,232,0.1);
        color: #5B4FD4;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.03em;
    }
    .univ-card-cta {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        color: #7B6FE8;
        transition: gap 0.2s;
    }
    .univ-card-cta i { font-size: 16px; transition: transform 0.2s; }
    .univ-card:hover .univ-card-cta i { transform: translateX(4px); }

    /* ═══ FEATURED / HERO CARD (spans 2 cols) ═══ */
    .univ-card-featured {
        grid-column: span 2;
        flex-direction: row;
        align-items: stretch;
    }
    .univ-card-featured .univ-card-banner {
        width: 280px;
        min-width: 280px;
        height: auto;
        align-self: stretch;
        border-radius: 0;
        flex-shrink: 0;
        overflow: hidden;
    }
    .univ-card-featured .univ-card-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .univ-card-featured .univ-card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .univ-card-featured .univ-card-desc {
        -webkit-line-clamp: 4;
    }

    /* ═══ EMPTY STATE ═══ */
    .univ-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: rgba(255,255,255,0.5);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.8);
    }
    .univ-empty-icon { font-size: 48px; color: #D4CDF0; margin-bottom: 16px; }
    .univ-empty-title {
        font-family: 'Instrument Serif', serif;
        font-size: 24px;
        font-weight: 400;
        letter-spacing: -0.01em;
        margin-bottom: 8px;
    }
    .univ-empty-desc { font-size: 14px; color: #8B87A8; }

    /* ═══ CTA BANNER ═══ */
    .univ-cta-section {
        max-width: 1160px;
        margin: 0 auto 60px;
        padding: 0 20px;
    }
    .univ-cta-banner {
        background: linear-gradient(135deg, #1E3A5F 0%, #0F2744 100%);
        border-radius: 28px;
        padding: 52px 56px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
        overflow: hidden;
        position: relative;
    }
    .univ-cta-banner::before {
        content: '';
        position: absolute;
        right: -60px; top: -60px;
        width: 300px; height: 300px;
        border-radius: 50%;
        background: rgba(123,111,232,0.15);
        pointer-events: none;
    }
    .univ-cta-banner::after {
        content: '';
        position: absolute;
        right: 80px; bottom: -80px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(0,200,150,0.08);
        pointer-events: none;
    }
    .univ-cta-text { position: relative; z-index: 1; }
    .univ-cta-eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #B8AFEB;
        margin-bottom: 12px;
    }
    .univ-cta-title {
        font-family: 'Instrument Serif', serif;
        font-size: 34px;
        font-weight: 400;
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: white;
        margin-bottom: 12px;
    }
    .univ-cta-title em { font-style: italic; color: #B8AFEB; }
    .univ-cta-desc { font-size: 15px; color: rgba(255,255,255,0.6); line-height: 1.6; }
    .univ-cta-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    .btn-cta-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        background: white;
        color: #1E3A5F;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 700;
        border-radius: 100px;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
        border: none;
        cursor: pointer;
    }
    .btn-cta-primary:hover { background: #F5F1FC; transform: translateY(-2px); }
    .btn-cta-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        background: rgba(255,255,255,0.1);
        color: white;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 600;
        border-radius: 100px;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.2s;
        white-space: nowrap;
        cursor: pointer;
    }
    .btn-cta-secondary:hover { background: rgba(255,255,255,0.18); }

    /* ═══ PATCH: Results info ═══ */
    .univ-results-info {
        max-width: 1160px;
        margin: 0 auto 18px;
        padding: 0 20px;
        font-size: 13px;
        color: #8B87A8;
    }
    .univ-results-info strong { color: #1A1825; }
    .univ-results-info em { color: #7B6FE8; font-style: normal; }

    /* ═══ PATCH: Empty state improved ═══ */
    .univ-empty-wrap {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px 20px;
    }
    .univ-empty-wrap .univ-empty-icon { font-size: 40px; opacity: .25; margin-bottom: 16px; }
    .univ-empty-wrap .univ-empty-title { font-size: 18px; font-weight: 700; color: #1A1825; margin-bottom: 8px; }
    .univ-empty-wrap .univ-empty-desc { font-size: 14px; color: #8B87A8; margin-bottom: 24px; }
    .univ-reset-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: #1E3A5F; color: white; font-size: 13px; font-weight: 600;
        padding: 10px 22px; border-radius: 100px; text-decoration: none;
        transition: background .2s;
    }
    .univ-reset-btn:hover { background: #2D4E7C; color: white; }

    /* ═══ PATCH: Pagination ═══ */
    .univ-pagination {
        display: flex; justify-content: center; align-items: center;
        gap: 6px; margin: 48px 0 24px; padding: 0 20px; flex-wrap: wrap;
    }
    .page-btn {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 40px; height: 40px; padding: 0 8px;
        border-radius: 12px; font-size: 14px; font-weight: 500;
        color: #4A4660; background: rgba(255,255,255,0.7);
        border: 1px solid rgba(255,255,255,0.9);
        backdrop-filter: blur(10px); text-decoration: none;
        transition: all .18s;
    }
    .page-btn:hover { background: rgba(123,111,232,0.1); color: #5B4FD4; border-color: rgba(123,111,232,0.3); }
    .page-btn-active { background: #1E3A5F !important; color: white !important; border-color: #1E3A5F !important; font-weight: 700; }
    .page-btn-disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 1024px) {
        .univ-grid { grid-template-columns: repeat(2, 1fr); }
        .univ-card-featured { grid-column: span 2; }
    }
    @media (max-width: 700px) {
        .univ-grid { grid-template-columns: 1fr; }
        .univ-card-featured { grid-column: span 1; flex-direction: column; }
        .univ-card-featured .univ-card-banner { width: 100%; height: 140px; }
        .univ-stats { flex-wrap: wrap; }
        .univ-cta-banner { flex-direction: column; padding: 36px 28px; }
        .univ-filter-bar { border-radius: 16px; }
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════ --}}
{{-- HERO                                        --}}
{{-- ═══════════════════════════════════════════ --}}
<section class="univ-hero">
    <div class="container">
        <div class="univ-hero-eyebrow">
            <i class="fa-solid fa-building-columns"></i>
            Universitas Partner
        </div>
        <h1 class="univ-hero-title">
            Belajar dari <em>universitas</em><br>terbaik Indonesia
        </h1>
        <p class="univ-hero-sub">
            Coursify bermitra dengan universitas-universitas terkemuka untuk menghadirkan pendidikan berkualitas tinggi yang dapat diakses oleh siapa saja, di mana saja.
        </p>

        {{-- GANTIAN 1 — Stats real-time dari DB --}}
        <div class="univ-stats" style="display:flex;">
            <div class="univ-stat">
                <div class="univ-stat-val"><em>{{ $totalInstitutions }}</em></div>
                <div class="univ-stat-label">Institusi</div>
            </div>
            <div class="univ-stat">
                <div class="univ-stat-val"><em>{{ $totalCourses }}</em></div>
                <div class="univ-stat-label">Kursus</div>
            </div>
            <div class="univ-stat">
                <div class="univ-stat-val"><em>{{ $totalStudents }}</em></div>
                <div class="univ-stat-label">Mahasiswa</div>
            </div>
            <div class="univ-stat">
                <div class="univ-stat-val"><em>{{ $institutions->total() }}</em></div>
                <div class="univ-stat-label">Hasil Filter</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════ --}}
{{-- GANTIAN 2 — FILTER BAR (server-side)        --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="univ-filter-wrap">
    <form method="GET" action="{{ route('universities') }}" id="filterForm" style="margin:0;">
        <div class="univ-filter-bar">
            <span class="univ-filter-label">Filter</span>
            <div class="univ-filter-pills">
                @php
                    $filters = [
                        'all'         => 'Semua',
                        'universitas' => 'Universitas',
                        'teknologi'   => 'Institut/Teknik',
                        'bisnis'      => 'Bisnis',
                        'lainnya'     => 'Lainnya',
                    ];
                @endphp
                @foreach($filters as $key => $label)
                <button type="submit" name="type" value="{{ $key }}"
                        class="filter-pill {{ ($typeFilter === $key || ($key==='all' && !$typeFilter)) ? 'active' : '' }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>
            <div class="univ-search-wrap">
                <i class="fa-solid fa-magnifying-glass univ-search-icon"></i>
                <input type="text" name="search" id="univSearch"
                       class="univ-search"
                       placeholder="Cari institusi..."
                       value="{{ $search }}"
                       onkeydown="if(event.key==='Enter'){this.form.submit()}">
            </div>
        </div>
    </form>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- GANTIAN 3 — GRID UTAMA + PAGINATION         --}}
{{-- ═══════════════════════════════════════════ --}}
<section class="univ-section">

    {{-- Info hasil --}}
    <div class="univ-results-info">
        @if($institutions->total() > 0)
            Menampilkan <strong>{{ $institutions->firstItem() }}–{{ $institutions->lastItem() }}</strong>
            dari <strong>{{ $institutions->total() }}</strong> institusi
            @if($search) · pencarian "<em>{{ $search }}</em>" @endif
            @if($typeFilter && $typeFilter !== 'all') · filter: <em>{{ ['universitas'=>'Universitas','teknologi'=>'Institut/Teknik','bisnis'=>'Bisnis','lainnya'=>'Lainnya'][$typeFilter] ?? $typeFilter }}</em> @endif
        @endif
    </div>

    <div class="univ-grid" id="univGrid">

        @forelse ($institutions as $inst)
        <a href="{{ route('universities.show', $inst['slug']) }}"
           class="univ-card {{ $loop->first && $institutions->currentPage() === 1 ? 'univ-card-featured' : '' }}"
           data-type="{{ $inst['type_key'] }}">

            {{-- Banner --}}
            <div class="univ-card-banner"
                 style="background:{{ $inst['banner_color'] }};position:relative;overflow:hidden;">
                @if($loop->first && $institutions->currentPage() === 1)
                    <span class="univ-card-tag tag-featured">⭐ Featured</span>
                @elseif($inst['is_verified'])
                    <span class="univ-card-tag tag-partner">✓ Verified</span>
                @endif
                <div class="univ-logo-placeholder">
                    @if(!empty($inst['logo_url']))
                        <img src="{{ $inst['logo_url'] }}"
                             alt="{{ $inst['name'] }}"
                             style="max-width:80px;max-height:80px;object-fit:contain;border-radius:8px;background:white;padding:6px;"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <span style="display:none;width:64px;height:64px;background:rgba(255,255,255,0.15);border-radius:12px;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:white;">
                            {{ $inst['initials'] }}
                        </span>
                    @else
                        <span style="display:flex;width:64px;height:64px;background:rgba(255,255,255,0.15);border-radius:12px;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:white;">
                            {{ $inst['initials'] }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Body --}}
            <div class="univ-card-body">
                <div class="univ-card-type">{{ $inst['type_label'] }}</div>
                <div class="univ-card-name">{{ $inst['name'] }}</div>
                @if(!empty($inst['website_url']))
                <div class="univ-card-location">
                    <i class="fa-solid fa-globe" style="font-size:11px;opacity:.6;"></i>
                    {{ parse_url($inst['website_url'], PHP_URL_HOST) ?? $inst['website_url'] }}
                </div>
                @endif
                @if(!empty($inst['description']))
                <p class="univ-card-desc">{{ Str::limit($inst['description'], 100) }}</p>
                @else
                <p class="univ-card-desc" style="opacity:.4;font-style:italic;">Klik untuk melihat detail institusi.</p>
                @endif
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">{{ $inst['courses_count'] }}</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">{{ $inst['students_count'] }}</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">{{ $inst['avg_rating'] }}</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        @if($inst['is_verified'])
                            <span class="prog-badge">✓ Verified</span>
                        @endif
                        <span class="prog-badge">{{ $inst['type_label'] }}</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>

        </a>

        @empty
        {{-- Empty state --}}
        <div class="univ-empty-wrap">
            <div class="univ-empty-icon"><i class="fa-solid fa-building-columns"></i></div>
            <div class="univ-empty-title">Tidak ada institusi ditemukan</div>
            <p class="univ-empty-desc">
                @if($search)
                    Tidak ada hasil untuk "<strong>{{ $search }}</strong>".
                @else
                    Tidak ada institusi di kategori ini.
                @endif
            </p>
            <a href="{{ route('universities') }}" class="univ-reset-btn">
                <i class="fa-solid fa-rotate-left"></i> Reset Filter
            </a>
        </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($institutions->hasPages())
    <div class="univ-pagination">
        @if($institutions->onFirstPage())
            <span class="page-btn page-btn-disabled"><i class="fa-solid fa-chevron-left"></i></span>
        @else
            <a href="{{ $institutions->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
        @endif

        @if($institutions->currentPage() > 3)
            <a href="{{ $institutions->url(1) }}" class="page-btn">1</a>
            @if($institutions->currentPage() > 4)
                <span class="page-btn page-btn-disabled">…</span>
            @endif
        @endif

        @foreach(range(max(1, $institutions->currentPage()-2), min($institutions->lastPage(), $institutions->currentPage()+2)) as $page)
            @if($page == $institutions->currentPage())
                <span class="page-btn page-btn-active">{{ $page }}</span>
            @else
                <a href="{{ $institutions->url($page) }}" class="page-btn">{{ $page }}</a>
            @endif
        @endforeach

        @if($institutions->currentPage() < $institutions->lastPage() - 2)
            @if($institutions->currentPage() < $institutions->lastPage() - 3)
                <span class="page-btn page-btn-disabled">…</span>
            @endif
            <a href="{{ $institutions->url($institutions->lastPage()) }}" class="page-btn">{{ $institutions->lastPage() }}</a>
        @endif

        @if($institutions->hasMorePages())
            <a href="{{ $institutions->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
        @else
            <span class="page-btn page-btn-disabled"><i class="fa-solid fa-chevron-right"></i></span>
        @endif
    </div>
    @endif

</section>

{{-- ═══════════════════════════════════════════ --}}
{{-- CTA BANNER                                  --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="univ-cta-section">
    <div class="univ-cta-banner">
        <div class="univ-cta-text">
            <div class="univ-cta-eyebrow">
                <i class="fa-solid fa-handshake"></i> &nbsp;Bergabung sebagai Partner
            </div>
            <div class="univ-cta-title">
                Universitas Anda ingin<br>bergabung bersama <em>kami?</em>
            </div>
            <p class="univ-cta-desc">
                Kami membuka peluang kemitraan dengan universitas dan institusi pendidikan di seluruh Indonesia.<br>Mari wujudkan pendidikan berkualitas yang lebih terjangkau bersama.
            </p>
        </div>
        <div class="univ-cta-actions">
            <a href="#" class="btn-cta-primary">
                <i class="fa-solid fa-envelope"></i>
                Hubungi Kami
            </a>
            <a href="#" class="btn-cta-secondary">
                <i class="fa-solid fa-file-lines"></i>
                Pelajari Program Partner
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
/* Filter & search sekarang server-side via form GET.
   Script ini hanya untuk UX tambahan (opsional). */
</script>
@endpush