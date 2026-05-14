{{-- resources/views/sitemap.blade.php --}}

@extends('layouts.app')

@section('title', 'Sitemap — Coursify')

@push('styles')
<style>
    /* ═══════════════════════════════
       HERO
    ═══════════════════════════════ */
    .sitemap-hero {
        text-align: center;
        padding: 72px 20px 56px;
    }

    .sitemap-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 999px;
        background: rgba(123,111,232,0.1);
        border: 1px solid rgba(123,111,232,0.18);
        color: #5B4FD4;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 22px;
    }

    .sitemap-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(42px, 6vw, 74px);
        line-height: 1.05;
        letter-spacing: -0.03em;
        font-weight: 400;
        color: #1A1825;
        margin-bottom: 18px;
    }

    .sitemap-title em {
        font-style: italic;
        background: linear-gradient(
            135deg,
            #9F94F2 0%,
            #7B6FE8 50%,
            #5B4FD4 100%
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .sitemap-subtitle {
        max-width: 700px;
        margin: 0 auto;
        color: #5D5875;
        font-size: 16px;
        line-height: 1.9;
    }

    /* ═══════════════════════════════
       CONTAINER
    ═══════════════════════════════ */
    .sitemap-container {
        max-width: 1160px;
        margin: 0 auto;
        padding: 0 20px 100px;
    }

    .sitemap-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    /* ═══════════════════════════════
       CARD
    ═══════════════════════════════ */
    .sitemap-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 28px;
        padding: 30px;
        box-shadow: 0 8px 28px rgba(30,58,95,0.05);
    }

    .sitemap-card-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: rgba(123,111,232,0.12);
        color: #5B4FD4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 22px;
    }

    .sitemap-card-title {
        font-family: 'Instrument Serif', serif;
        font-size: 28px;
        font-weight: 400;
        line-height: 1.2;
        color: #1A1825;
        margin-bottom: 18px;
    }

    .sitemap-links {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .sitemap-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-radius: 16px;
        text-decoration: none;
        color: #4A4660;
        background: rgba(123,111,232,0.04);
        border: 1px solid transparent;
        transition: .25s ease;
        font-size: 14px;
        font-weight: 500;
    }

    .sitemap-link:hover {
        transform: translateY(-2px);
        border-color: rgba(123,111,232,0.14);
        background: rgba(123,111,232,0.08);
        color: #5B4FD4;
    }

    .sitemap-link i {
        font-size: 13px;
        opacity: .7;
    }

    /* ═══════════════════════════════
       RESPONSIVE
    ═══════════════════════════════ */
    @media (max-width: 1024px) {

        .sitemap-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media (max-width: 768px) {

        .sitemap-grid {
            grid-template-columns: 1fr;
        }

        .sitemap-card {
            padding: 24px;
        }

    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="sitemap-hero">

    <div class="container">

        <div class="sitemap-eyebrow">
            <i class="fa-solid fa-sitemap"></i>
            Sitemap
        </div>

        <h1 class="sitemap-title">
            Jelajahi seluruh halaman <em>Coursify</em>
        </h1>

        <p class="sitemap-subtitle">
            Gunakan sitemap ini untuk menemukan halaman penting,
            informasi legal, kursus, dukungan, dan berbagai fitur lainnya di Coursify.
        </p>

    </div>

</section>

{{-- CONTENT --}}
<section class="sitemap-container">

    <div class="sitemap-grid">

        {{-- MAIN --}}
        <div class="sitemap-card">

            <div class="sitemap-card-icon">
                <i class="fa-solid fa-house"></i>
            </div>

            <h2 class="sitemap-card-title">
                Halaman Utama
            </h2>

            <div class="sitemap-links">

                <a href="{{ route('home') }}" class="sitemap-link">
                    Beranda
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a href="{{ route('courses.index') }}" class="sitemap-link">
                    Semua Kursus
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a href="{{ route('universities') }}" class="sitemap-link">
                    Universitas Partner
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a href="{{ route('blog') }}" class="sitemap-link">
                    Blog & Berita
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

        </div>

        {{-- SUPPORT --}}
        <div class="sitemap-card">

            <div class="sitemap-card-icon">
                <i class="fa-solid fa-headset"></i>
            </div>

            <h2 class="sitemap-card-title">
                Bantuan & Dukungan
            </h2>

            <div class="sitemap-links">

                <a href="{{ route('contact') }}" class="sitemap-link">
                    Contact Us
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a href="{{ route('faq') }}" class="sitemap-link">
                    FAQ
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a href="{{ route('security') }}" class="sitemap-link">
                    Security
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

        </div>

        {{-- LEGAL --}}
        <div class="sitemap-card">

            <div class="sitemap-card-icon">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>

            <h2 class="sitemap-card-title">
                Legal
            </h2>

            <div class="sitemap-links">

                <a href="{{ route('terms') }}" class="sitemap-link">
                    Syarat & Ketentuan
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a href="{{ route('privacy') }}" class="sitemap-link">
                    Kebijakan Privasi
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <a href="{{ route('cookies') }}" class="sitemap-link">
                    Cookie Policy
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

        </div>

    </div>

</section>

@endsection