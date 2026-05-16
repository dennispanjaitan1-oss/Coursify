@extends('layouts.app')

@section('title', $institution->name . ' — Coursify')

@push('styles')
<style>
/* ══ HERO BANNER ══ */
.detail-hero {
    position: relative;
    background: linear-gradient(135deg, #1E3A5F 0%, #2D4E7C 100%);
    padding: 60px 20px 48px;
    overflow: hidden;
}
.detail-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(123,111,232,0.25) 0%, transparent 60%);
}
.detail-hero-inner {
    max-width: 1100px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
    display: flex;
    gap: 36px;
    align-items: flex-start;
    flex-wrap: wrap;
}
.detail-logo-wrap {
    width: 110px;
    height: 110px;
    background: white;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    padding: 10px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
}
.detail-logo-wrap img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}
.detail-logo-initials {
    font-size: 34px;
    font-weight: 800;
    color: #1E3A5F;
    letter-spacing: -2px;
}
.detail-hero-info { flex: 1; min-width: 260px; }
.detail-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.85);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 100px;
    margin-bottom: 14px;
}
.detail-title {
    font-family: 'Instrument Serif', serif;
    font-size: clamp(28px, 5vw, 48px);
    font-weight: 400;
    color: white;
    line-height: 1.1;
    margin-bottom: 12px;
    letter-spacing: -0.02em;
}
.detail-website {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: rgba(255,255,255,0.7);
    font-size: 13px;
    text-decoration: none;
    transition: color .2s;
}
.detail-website:hover { color: white; }
.detail-hero-stats {
    display: flex;
    gap: 0;
    margin-top: 28px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 16px;
    overflow: hidden;
    width: fit-content;
}
.detail-hero-stat {
    text-align: center;
    padding: 14px 28px;
    position: relative;
}
.detail-hero-stat + .detail-hero-stat::before {
    content: '';
    position: absolute;
    left: 0; top: 15%; bottom: 15%;
    width: 1px;
    background: rgba(255,255,255,0.15);
}
.detail-hero-stat-val {
    font-family: 'Instrument Serif', serif;
    font-size: 26px;
    color: white;
    line-height: 1;
    margin-bottom: 4px;
}
.detail-hero-stat-label {
    font-size: 10px;
    font-weight: 700;
    color: rgba(255,255,255,0.55);
    text-transform: uppercase;
    letter-spacing: .06em;
}

/* ══ BACK LINK ══ */
.detail-back {
    max-width: 1100px;
    margin: 28px auto 0;
    padding: 0 20px;
}
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #5B4FD4;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: gap .2s;
}
.back-link:hover { gap: 12px; }

/* ══ BODY LAYOUT ══ */
.detail-body {
    max-width: 1100px;
    margin: 36px auto 60px;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 32px;
    align-items: start;
}
@media (max-width: 860px) {
    .detail-body { grid-template-columns: 1fr; }
}

/* ══ SECTIONS ══ */
.detail-section {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 24px;
}
.detail-section-title {
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #8B87A8;
    margin-bottom: 16px;
}
.detail-desc {
    font-size: 15px;
    line-height: 1.75;
    color: #2D2B3D;
}

/* ══ COURSE LIST ══ */
.course-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(30,58,95,0.06);
    text-decoration: none;
    transition: background .15s;
    border-radius: 10px;
}
.course-row:last-child { border-bottom: none; }
.course-row:hover { background: rgba(123,111,232,0.05); padding-left: 8px; }
.course-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #7B6FE8, #5B4FD4);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
}
.course-row-info { flex: 1; min-width: 0; }
.course-row-title {
    font-size: 14px;
    font-weight: 600;
    color: #1A1825;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.course-row-meta {
    font-size: 12px;
    color: #8B87A8;
    margin-top: 2px;
}
.course-row-badge {
    font-size: 11px;
    font-weight: 600;
    color: #5B4FD4;
    background: rgba(91,79,212,0.08);
    padding: 3px 10px;
    border-radius: 100px;
    white-space: nowrap;
}
.no-courses {
    text-align: center;
    padding: 32px 0;
    color: #8B87A8;
    font-size: 14px;
}

/* ══ SIDEBAR ══ */
.sidebar-card {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 20px;
}
.sidebar-card-title {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #8B87A8;
    margin-bottom: 16px;
}
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(30,58,95,0.06);
    font-size: 13px;
}
.info-row:last-child { border-bottom: none; }
.info-row-label { color: #8B87A8; }
.info-row-val { font-weight: 600; color: #1A1825; }
.verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(16,185,129,0.1);
    color: #059669;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 100px;
}
.cta-btn {
    display: block;
    text-align: center;
    background: #1E3A5F;
    color: white;
    font-size: 14px;
    font-weight: 600;
    padding: 13px 20px;
    border-radius: 12px;
    text-decoration: none;
    transition: background .2s, transform .15s;
    margin-top: 16px;
}
.cta-btn:hover { background: #2D4E7C; transform: translateY(-1px); }
</style>
@endpush

@section('content')

{{-- ══ BACK ══ --}}
<div class="detail-back">
    <a href="{{ route('universities') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Institusi
    </a>
</div>

{{-- ══ HERO ══ --}}
<div class="detail-hero" style="margin-top:20px;">
    <div class="detail-hero-inner">
        {{-- Logo --}}
        <div class="detail-logo-wrap">
            @if(!empty($institution->logo_url))
                <img src="{{ $institution->logo_url }}" alt="{{ $institution->name }}"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                <span class="detail-logo-initials" style="display:none;">
                    {{ strtoupper(substr($institution->name, 0, 2)) }}
                </span>
            @else
                <span class="detail-logo-initials">
                    {{ strtoupper(substr($institution->name, 0, 2)) }}
                </span>
            @endif
        </div>

        {{-- Info --}}
        <div class="detail-hero-info">
            <div class="detail-badge">
                <i class="fa-solid fa-building-columns"></i>
                @if($institution->is_verified) Verified Partner @else Institusi @endif
            </div>
            <h1 class="detail-title">{{ $institution->name }}</h1>
            @if(!empty($institution->website_url))
            <a href="{{ $institution->website_url }}" target="_blank" class="detail-website">
                <i class="fa-solid fa-globe"></i>
                {{ parse_url($institution->website_url, PHP_URL_HOST) ?? $institution->website_url }}
                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:10px;"></i>
            </a>
            @endif

            {{-- Stats --}}
            <div class="detail-hero-stats">
                <div class="detail-hero-stat">
                    <div class="detail-hero-stat-val">{{ $institution->courses_count ?? 0 }}</div>
                    <div class="detail-hero-stat-label">Kursus</div>
                </div>
                <div class="detail-hero-stat">
                    <div class="detail-hero-stat-val">
                        @php
                            $s = $institution->students_count ?? 0;
                            echo $s < 1000 ? $s : (floor($s/1000).'K+');
                        @endphp
                    </div>
                    <div class="detail-hero-stat-label">Pelajar</div>
                </div>
                <div class="detail-hero-stat">
                    <div class="detail-hero-stat-val">
                        {{ $institution->avg_rating ? number_format($institution->avg_rating, 1) : '—' }}
                    </div>
                    <div class="detail-hero-stat-label">Rating</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ BODY ══ --}}
<div class="detail-body">

    {{-- Kolom kiri --}}
    <div>
        {{-- Deskripsi --}}
        <div class="detail-section">
            <div class="detail-section-title"><i class="fa-solid fa-circle-info"></i> &nbsp;Tentang Institusi</div>
            <p class="detail-desc">
                @if(!empty($institution->description))
                    {{ $institution->description }}
                @else
                    {{ $fakerDesc }}
                @endif
            </p>
        </div>

        {{-- Kursus --}}
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-graduation-cap"></i> &nbsp;Kursus Tersedia
                <span style="float:right;font-weight:400;color:#4A4660;text-transform:none;letter-spacing:0;">
                    {{ $institution->courses_count ?? 0 }} kursus total
                </span>
            </div>

            @forelse ($courses as $course)
            <a href="{{ route('courses.show', $course->slug) }}" class="course-row">
                <div class="course-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div class="course-row-info">
                    <div class="course-row-title">{{ $course->title }}</div>
                    <div class="course-row-meta">
                        {{ $course->category->name ?? 'Umum' }}
                        &nbsp;·&nbsp;
                        {{ number_format($course->enrollments_count) }} pelajar
                    </div>
                </div>
                @if($course->price == 0)
                    <span class="course-row-badge">Gratis</span>
                @else
                    <span class="course-row-badge">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                @endif
            </a>
            @empty
            <div class="no-courses">
                <i class="fa-solid fa-box-open" style="font-size:28px;opacity:.3;margin-bottom:10px;display:block;"></i>
                Belum ada kursus yang dipublikasikan dari institusi ini.
            </div>
            @endforelse

            @if(($institution->courses_count ?? 0) > 6)
            <a href="{{ route('courses.index', ['institution' => $institution->slug]) }}"
               style="display:block;text-align:center;margin-top:16px;color:#5B4FD4;font-size:13px;font-weight:600;text-decoration:none;">
                Lihat semua {{ $institution->courses_count }} kursus
                <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i>
            </a>
            @endif
        </div>
    </div>

    {{-- Sidebar --}}
    <div>
        <div class="sidebar-card">
            <div class="sidebar-card-title">Info Institusi</div>
            <div class="info-row">
                <span class="info-row-label">Tipe</span>
                <span class="info-row-val">
                    @php
                        $n = strtolower($institution->name);
                        if (str_contains($n,'universitas')||str_contains($n,'university')) echo 'Universitas';
                        elseif (str_contains($n,'institute')||str_contains($n,'teknologi')) echo 'Institut';
                        else echo 'Institusi';
                    @endphp
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Status</span>
                <span class="info-row-val">
                    @if($institution->is_verified)
                        <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified</span>
                    @else
                        <span style="color:#8B87A8;">Belum Verified</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Total Kursus</span>
                <span class="info-row-val">{{ $institution->courses_count ?? 0 }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Total Pelajar</span>
                <span class="info-row-val">
                    @php $s = $institution->students_count ?? 0; echo $s < 1000 ? $s : (floor($s/1000).'K+'); @endphp
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Rata-rata Rating</span>
                <span class="info-row-val">
                    {{ $institution->avg_rating ? number_format($institution->avg_rating, 1).' ⭐' : '—' }}
                </span>
            </div>

            @if(!empty($institution->website_url))
            <a href="{{ $institution->website_url }}" target="_blank" class="cta-btn">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                &nbsp;Kunjungi Website
            </a>
            @endif

            <a href="{{ route('courses.index', ['institution' => $institution->slug]) }}" class="cta-btn"
               style="background:#7B6FE8;margin-top:10px;">
                <i class="fa-solid fa-graduation-cap"></i>
                &nbsp;Lihat Semua Kursus
            </a>
        </div>
    </div>

</div>

@endsection