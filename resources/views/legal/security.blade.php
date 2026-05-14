{{-- resources/views/security.blade.php --}}

@extends('layouts.app')

@section('title', 'Security — Coursify')

@push('styles')
<style>
    /* ═══════════════════════════════
       HERO
    ═══════════════════════════════ */
    .security-hero {
        text-align: center;
        padding: 72px 20px 56px;
        position: relative;
    }

    .security-eyebrow {
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

    .security-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(44px, 6vw, 76px);
        line-height: 1.05;
        letter-spacing: -0.03em;
        font-weight: 400;
        color: #1A1825;
        margin-bottom: 18px;
    }

    .security-title em {
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

    .security-subtitle {
        max-width: 760px;
        margin: 0 auto;
        color: #5D5875;
        font-size: 16px;
        line-height: 1.9;
    }

    /* ═══════════════════════════════
       CONTAINER
    ═══════════════════════════════ */
    .security-container {
        max-width: 980px;
        margin: 0 auto;
        padding: 0 20px 100px;
    }

    /* ═══════════════════════════════
       INFO CARD
    ═══════════════════════════════ */
    .security-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 28px;
        padding: 36px;
        margin-bottom: 26px;
        box-shadow: 0 8px 28px rgba(30,58,95,0.05);
    }

    .security-card h2 {
        font-family: 'Instrument Serif', serif;
        font-size: 34px;
        line-height: 1.2;
        letter-spacing: -0.02em;
        font-weight: 400;
        color: #1A1825;
        margin-bottom: 18px;
    }

    .security-card p {
        color: #5D5875;
        font-size: 15px;
        line-height: 1.9;
        margin-bottom: 18px;
    }

    .security-card p:last-child {
        margin-bottom: 0;
    }

    .security-list {
        display: grid;
        gap: 16px;
        margin-top: 24px;
    }

    .security-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 18px 20px;
        border-radius: 20px;
        background: rgba(123,111,232,0.05);
        border: 1px solid rgba(123,111,232,0.08);
    }

    .security-item-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: rgba(123,111,232,0.12);
        color: #5B4FD4;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 16px;
    }

    .security-item h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1A1825;
        margin-bottom: 6px;
    }

    .security-item p {
        margin: 0;
        font-size: 14px;
        line-height: 1.8;
    }

    /* ═══════════════════════════════
       ALERT BOX
    ═══════════════════════════════ */
    .security-alert {
        background: linear-gradient(
            135deg,
            rgba(123,111,232,0.08),
            rgba(91,79,212,0.06)
        );
        border: 1px solid rgba(123,111,232,0.12);
        border-radius: 24px;
        padding: 26px;
        margin-top: 24px;
    }

    .security-alert-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #1A1825;
        margin-bottom: 12px;
    }

    .security-alert p {
        margin: 0;
    }

    /* ═══════════════════════════════
       CONTACT BOX
    ═══════════════════════════════ */
    .security-contact {
        margin-top: 60px;
        background: linear-gradient(
            135deg,
            #1E3A5F 0%,
            #10243D 100%
        );
        border-radius: 32px;
        padding: 52px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .security-contact::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(123,111,232,0.12);
    }

    .security-contact h2 {
        position: relative;
        z-index: 1;
        font-family: 'Instrument Serif', serif;
        font-size: 40px;
        line-height: 1.15;
        color: white;
        font-weight: 400;
        margin-bottom: 16px;
    }

    .security-contact p {
        position: relative;
        z-index: 1;
        color: rgba(255,255,255,0.7);
        line-height: 1.9;
        margin-bottom: 28px;
    }

    .security-btn {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 28px;
        border-radius: 999px;
        background: white;
        color: #1E3A5F;
        text-decoration: none;
        font-weight: 700;
        transition: .2s ease;
    }

    .security-btn:hover {
        background: #F5F1FC;
        transform: translateY(-2px);
    }

    /* ═══════════════════════════════
       RESPONSIVE
    ═══════════════════════════════ */
    @media (max-width: 768px) {

        .security-card {
            padding: 28px;
        }

        .security-contact {
            padding: 38px 26px;
        }

        .security-contact h2 {
            font-size: 32px;
        }

    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="security-hero">

    <div class="container">

        <div class="security-eyebrow">
            <i class="fa-solid fa-shield-halved"></i>
            Security
        </div>

        <h1 class="security-title">
            Keamanan adalah <em>prioritas</em> kami
        </h1>

        <p class="security-subtitle">
            Coursify berkomitmen untuk menjaga keamanan platform, data pengguna,
            serta pengalaman belajar yang aman dan terpercaya bagi seluruh pengguna.
        </p>

    </div>

</section>

{{-- CONTENT --}}
<section class="security-container">

    {{-- CARD --}}
    <div class="security-card">

        <h2>
            Komitmen Keamanan Coursify
        </h2>

        <p>
            Kami menerapkan berbagai langkah keamanan teknis dan operasional
            untuk melindungi akun, data pribadi, serta aktivitas pembelajaran pengguna.
        </p>

        <p>
            Sistem kami terus dipantau dan diperbarui secara berkala guna menjaga
            stabilitas, integritas, dan keamanan layanan.
        </p>

        <div class="security-list">

            <div class="security-item">

                <div class="security-item-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div>
                    <h3>Enkripsi Data</h3>

                    <p>
                        Seluruh komunikasi data penting dienkripsi menggunakan
                        protokol keamanan modern untuk melindungi informasi pengguna.
                    </p>
                </div>

            </div>

            <div class="security-item">

                <div class="security-item-icon">
                    <i class="fa-solid fa-server"></i>
                </div>

                <div>
                    <h3>Infrastruktur Aman</h3>

                    <p>
                        Infrastruktur platform dijalankan dengan standar keamanan
                        industri dan monitoring sistem secara berkala.
                    </p>
                </div>

            </div>

            <div class="security-item">

                <div class="security-item-icon">
                    <i class="fa-solid fa-user-shield"></i>
                </div>

                <div>
                    <h3>Proteksi Akun</h3>

                    <p>
                        Kami menerapkan sistem autentikasi dan perlindungan akun
                        untuk membantu mencegah akses tidak sah.
                    </p>
                </div>

            </div>

            <div class="security-item">

                <div class="security-item-icon">
                    <i class="fa-solid fa-bug"></i>
                </div>

                <div>
                    <h3>Pelaporan Kerentanan</h3>

                    <p>
                        Kami menghargai laporan terkait potensi kerentanan keamanan
                        yang membantu meningkatkan keamanan platform.
                    </p>
                </div>

            </div>

        </div>

        {{-- ALERT --}}
        <div class="security-alert">

            <div class="security-alert-title">
                <i class="fa-solid fa-circle-exclamation"></i>
                Responsible Disclosure
            </div>

            <p>
                Jika Anda menemukan potensi kerentanan keamanan pada platform Coursify,
                mohon laporkan secara bertanggung jawab kepada tim kami dan jangan
                mengeksploitasi, menyebarkan, atau membagikan informasi tersebut kepada pihak lain.
            </p>

        </div>

    </div>

    {{-- CONTACT --}}
    <div class="security-contact">

        <h2>
            Melaporkan masalah keamanan
        </h2>

        <p>
            Jika Anda menemukan aktivitas mencurigakan atau potensi kerentanan keamanan,
            silakan hubungi tim kami melalui halaman kontak resmi Coursify.
        </p>

        <a href="{{ route('contact') }}" class="security-btn">
            <i class="fa-solid fa-envelope"></i>
            Hubungi Tim Security
        </a>

    </div>

</section>

@endsection