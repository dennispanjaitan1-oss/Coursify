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
    }
    .univ-card-featured .univ-card-banner {
        width: 260px;
        min-width: 260px;
        height: auto;
        border-radius: 0;
        flex-shrink: 0;
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

        {{-- Stats --}}
        <div class="univ-stats">
            <div class="univ-stat">
                <div class="univ-stat-val"><em>9+</em></div>
                <div class="univ-stat-label">Universitas</div>
            </div>
            <div class="univ-stat">
                <div class="univ-stat-val"><em>200+</em></div>
                <div class="univ-stat-label">Kursus</div>
            </div>
            <div class="univ-stat">
                <div class="univ-stat-val"><em>50K+</em></div>
                <div class="univ-stat-label">Mahasiswa</div>
            </div>
            <div class="univ-stat">
                <div class="univ-stat-val"><em>15+</em></div>
                <div class="univ-stat-label">Kota</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════ --}}
{{-- FILTER BAR                                  --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="univ-filter-wrap">
    <div class="univ-filter-bar">
        <span class="univ-filter-label">Filter</span>
        <div class="univ-filter-pills">
            <button class="filter-pill active" onclick="filterUniv('all', this)">Semua</button>
            <button class="filter-pill" onclick="filterUniv('negeri', this)">PTN</button>
            <button class="filter-pill" onclick="filterUniv('swasta', this)">PTS</button>
            <button class="filter-pill" onclick="filterUniv('teknik', this)">Teknik</button>
            <button class="filter-pill" onclick="filterUniv('bisnis', this)">Bisnis</button>
            <button class="filter-pill" onclick="filterUniv('kesehatan', this)">Kesehatan</button>
        </div>
        <div class="univ-search-wrap">
            <i class="fa-solid fa-magnifying-glass univ-search-icon"></i>
            <input type="text" class="univ-search" placeholder="Cari universitas..." oninput="searchUniv(this.value)" id="univSearch">
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- UNIVERSITY GRID                             --}}
{{-- ═══════════════════════════════════════════ --}}
<section class="univ-section">
    <div class="univ-grid" id="univGrid">

        {{--
        ═══════════════════════════════════════════════════════════════════
        CARA MENAMBAHKAN GAMBAR UNIVERSITAS:

        Pilihan 1 — Gambar lokal (taruh di public/images/universities/):
            <img src="{{ asset('images/universities/ui-logo.png') }}" alt="UI">

        Pilihan 2 — URL eksternal:
            <img src="https://upload.wikimedia.org/.../UI_logo.png" alt="UI">

        Untuk banner (foto kampus), ganti class banner-* dengan:
            style="background-image: url('{{ asset('images/universities/ui-banner.jpg') }}');
                   background-size: cover; background-position: center;"

        atau hapus class banner-* dan tambahkan inline style di atas.
        ═══════════════════════════════════════════════════════════════════
        --}}

        {{-- ══ FEATURED: Universitas Indonesia ══ --}}
        <a href="{{ route('courses.index', ['university' => 'ui']) }}"
           class="univ-card univ-card-featured"
           data-type="negeri teknik">
            <div class="univ-card-banner banner-ui">
                <span class="univ-card-tag tag-featured">⭐ Featured</span>
                <div class="univ-logo-placeholder" style="width: 100%; height: 100%; overflow: hidden; position: relative;">
    <img src="{{ asset('images/universities/ui-logo.png') }}" 
         alt="UI" 
         style="width: 100%; height: 100%; object-fit: cover; display: block;">
    
    {{-- Ikon tetap ada sebagai fallback atau overlay jika diinginkan --}}
    {{-- <i class="fa-solid fa-building-columns" style="position:absolute; z-index:1; ..."></i> --}}
</div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Negeri</div>
                <div class="univ-card-name">Universitas Indonesia</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Depok, Jawa Barat
                </div>
                <p class="univ-card-desc">
                    Universitas terkemuka di Indonesia dengan reputasi internasional. Menawarkan program-program unggulan di bidang sains, teknologi, humaniora, dan sosial yang diakui secara global.
                </p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">38</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">12K+</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.8</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S1</span>
                        <span class="prog-badge">S2</span>
                        <span class="prog-badge">Sertifikat</span>
                        <span class="prog-badge">MOOC</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat Kursus <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- ══ ITB ══ --}}
        <a href="{{ route('courses.index', ['university' => 'itb']) }}"
           class="univ-card"
           data-type="negeri teknik">
            <div class="univ-card-banner banner-itb">
                <span class="univ-card-tag tag-partner">Partner</span>
                <div class="univ-logo-placeholder">
                    <img src="{{ asset('images/universities/itb-logo.png') }}" alt="ITB"> 
                    <i class="fa-solid fa-flask" style="font-size:30px;color:rgba(255,255,255,0.9);"></i>
                </div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Negeri</div>
                <div class="univ-card-name">Institut Teknologi Bandung</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Bandung, Jawa Barat
                </div>
                <p class="univ-card-desc">Institut teknologi terbaik di Asia Tenggara dengan spesialisasi teknik, sains terapan, dan inovasi.</p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">29</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">8.4K</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.9</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S2</span>
                        <span class="prog-badge">Sertifikat</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- ══ UGM ══ --}}
        <a href="{{ route('courses.index', ['university' => 'ugm']) }}"
           class="univ-card"
           data-type="negeri bisnis">
            <div class="univ-card-banner banner-ugm">
                <span class="univ-card-tag tag-partner">Partner</span>
                <div class="univ-logo-placeholder">
                     <img src="{{ asset('images/universities/ugm-logo.png') }}" alt="UGM"> 
                    <i class="fa-solid fa-landmark" style="font-size:30px;color:rgba(255,255,255,0.9);"></i>
                </div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Negeri</div>
                <div class="univ-card-name">Universitas Gadjah Mada</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Yogyakarta, DIY
                </div>
                <p class="univ-card-desc">Salah satu universitas tertua dan terprestisius di Indonesia dengan keunggulan riset multidisiplin.</p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">24</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">7.1K</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.7</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S1</span>
                        <span class="prog-badge">S2</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- ══ ITS ══ --}}
        <a href="{{ route('courses.index', ['university' => 'its']) }}"
           class="univ-card"
           data-type="negeri teknik">
            <div class="univ-card-banner banner-its">
                <span class="univ-card-tag tag-partner">Partner</span>
                <div class="univ-logo-placeholder">
                     <img src="{{ asset('images/universities/its-logo.png') }}" alt="ITS"> 
                    <i class="fa-solid fa-microchip" style="font-size:30px;color:rgba(255,255,255,0.9);"></i>
                </div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Negeri</div>
                <div class="univ-card-name">ITS Surabaya</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Surabaya, Jawa Timur
                </div>
                <p class="univ-card-desc">Institut teknologi unggulan di Jawa Timur dengan fokus pada inovasi teknologi kelautan, informatika, dan teknik industri.</p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">18</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">5.2K</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.8</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S2</span>
                        <span class="prog-badge">Sertifikat</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- ══ UNAIR ══ --}}
        <a href="{{ route('courses.index', ['university' => 'unair']) }}"
           class="univ-card"
           data-type="negeri kesehatan">
            <div class="univ-card-banner banner-unair">
                <span class="univ-card-tag tag-partner">Partner</span>
                <div class="univ-logo-placeholder">
                    <img src="{{ asset('images/universities/unair-logo.png') }}" alt="Unair"> 
                    <i class="fa-solid fa-stethoscope" style="font-size:30px;color:rgba(255,255,255,0.9);"></i>
                </div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Negeri</div>
                <div class="univ-card-name">Universitas Airlangga</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Surabaya, Jawa Timur
                </div>
                <p class="univ-card-desc">Universitas terkemuka dengan keunggulan di bidang kesehatan, kedokteran, ilmu sosial, dan ekonomi bisnis.</p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">16</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.8K</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.6</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S1</span>
                        <span class="prog-badge">Sertifikat</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- ══ IPB ══ --}}
        <a href="{{ route('courses.index', ['university' => 'ipb']) }}"
           class="univ-card"
           data-type="negeri">
            <div class="univ-card-banner banner-ipb">
                <span class="univ-card-tag tag-partner">Partner</span>
                <div class="univ-logo-placeholder">
                    <img src="{{ asset('images/universities/ipb-logo.png') }}" alt="IPB"> 
                    <i class="fa-solid fa-leaf" style="font-size:30px;color:rgba(255,255,255,0.9);"></i>
                </div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Negeri</div>
                <div class="univ-card-name">IPB University</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Bogor, Jawa Barat
                </div>
                <p class="univ-card-desc">Institusi riset terkemuka di bidang pertanian, lingkungan, dan ilmu hayati dengan standar penelitian kelas dunia.</p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">14</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">3.5K</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.7</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S2</span>
                        <span class="prog-badge">MOOC</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- ══ BINUS ══ --}}
        <a href="{{ route('courses.index', ['university' => 'binus']) }}"
           class="univ-card"
           data-type="swasta teknik bisnis">
            <div class="univ-card-banner banner-binus">
                <span class="univ-card-tag tag-partner">Partner</span>
                <div class="univ-logo-placeholder">
                    <img src="{{ asset('images/universities/binus-logo.png') }}" alt="BINUS"> 
                    <i class="fa-solid fa-laptop-code" style="font-size:30px;color:rgba(255,255,255,0.9);"></i>
                </div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Swasta</div>
                <div class="univ-card-name">BINUS University</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Jakarta, DKI Jakarta
                </div>
                <p class="univ-card-desc">Universitas swasta terkemuka dengan spesialisasi teknologi informasi, bisnis digital, dan desain kreatif.</p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">22</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">6.3K</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.5</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S1</span>
                        <span class="prog-badge">Sertifikat</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- ══ UNDIP ══ --}}
        <a href="{{ route('courses.index', ['university' => 'undip']) }}"
           class="univ-card"
           data-type="negeri teknik">
            <div class="univ-card-banner banner-undip">
                <span class="univ-card-tag tag-partner">Partner</span>
                <div class="univ-logo-placeholder">
                    <img src="{{ asset('images/universities/undip-logo.png') }}" alt="Undip">
                    <i class="fa-solid fa-water" style="font-size:30px;color:rgba(255,255,255,0.9);"></i>
                </div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Negeri</div>
                <div class="univ-card-name">Universitas Diponegoro</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Semarang, Jawa Tengah
                </div>
                <p class="univ-card-desc">Universitas riset dengan keunggulan di bidang teknik, hukum, kedokteran, dan ilmu sosial di Jawa Tengah.</p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">12</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">2.9K</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.6</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S2</span>
                        <span class="prog-badge">MOOC</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- ══ UB ══ --}}
        <a href="{{ route('courses.index', ['university' => 'ub']) }}"
           class="univ-card"
           data-type="negeri bisnis">
            <div class="univ-card-banner banner-ub">
                <span class="univ-card-tag tag-partner">Partner</span>
                <div class="univ-logo-placeholder">
                    <img src="{{ asset('images/universities/ub-logo.png') }}" alt="UB"> 
                    <i class="fa-solid fa-scale-balanced" style="font-size:30px;color:rgba(255,255,255,0.9);"></i>
                </div>
            </div>
            <div class="univ-card-body">
                <div class="univ-card-type">Perguruan Tinggi Negeri</div>
                <div class="univ-card-name">Universitas Brawijaya</div>
                <div class="univ-card-location">
                    <i class="fa-solid fa-location-dot"></i> Malang, Jawa Timur
                </div>
                <p class="univ-card-desc">Universitas dengan reputasi kuat di bidang ekonomi, pertanian, teknik, dan ilmu sosial di kawasan Jawa Timur.</p>
                <div class="univ-card-stats">
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">10</div>
                        <div class="univ-card-stat-label">Kursus</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">2.4K</div>
                        <div class="univ-card-stat-label">Pelajar</div>
                    </div>
                    <div class="univ-card-stat">
                        <div class="univ-card-stat-val">4.5</div>
                        <div class="univ-card-stat-label">Rating</div>
                    </div>
                </div>
                <div class="univ-card-footer">
                    <div class="univ-card-programs">
                        <span class="prog-badge">S1</span>
                        <span class="prog-badge">Sertifikat</span>
                    </div>
                    <div class="univ-card-cta">
                        Lihat <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>

        {{-- Empty state (hidden by default, shown by JS) --}}
        <div class="univ-empty" id="univEmpty" style="display:none;">
            <div class="univ-empty-icon"><i class="fa-solid fa-building-columns"></i></div>
            <div class="univ-empty-title">Universitas tidak ditemukan</div>
            <p class="univ-empty-desc">Coba kata kunci lain atau hapus filter yang aktif.</p>
        </div>

    </div>
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
/* ── Filter pills ── */
function filterUniv(type, btn) {
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    applyFilters(type, document.getElementById('univSearch').value);
}

/* ── Search ── */
function searchUniv(query) {
    const activeType = document.querySelector('.filter-pill.active')?.dataset?.type ?? 'all';
    applyFilters(activeType, query);
}

/* ── Combined filter + search ── */
function applyFilters(type, query) {
    const cards  = document.querySelectorAll('#univGrid .univ-card');
    const empty  = document.getElementById('univEmpty');
    const q      = (query || '').toLowerCase().trim();
    let   visible = 0;

    cards.forEach(card => {
        const cardTypes = (card.dataset.type || '').toLowerCase();
        const cardText  = card.innerText.toLowerCase();
        const typeMatch = type === 'all' || cardTypes.includes(type);
        const textMatch = !q || cardText.includes(q);

        if (typeMatch && textMatch) {
            card.style.display = '';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    empty.style.display = visible === 0 ? 'block' : 'none';
}
</script>
@endpush