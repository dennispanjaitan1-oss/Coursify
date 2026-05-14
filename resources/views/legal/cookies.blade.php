{{-- resources/views/legal/cookies.blade.php --}}

@extends('layouts.app')

@section('title', 'Cookie Policy — Coursify')

@push('styles')
<style>
    .cookie-hero {
        text-align: center;
        padding: 60px 20px 44px;
    }

    .cookie-eyebrow {
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
        margin-bottom: 20px;
    }

    .cookie-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(40px, 6vw, 72px);
        line-height: 1.08;
        letter-spacing: -0.03em;
        color: #1A1825;
        margin-bottom: 18px;
        font-weight: 400;
    }

    .cookie-title em {
        font-style: italic;
        background: linear-gradient(135deg, #9F94F2 0%, #7B6FE8 50%, #5B4FD4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .cookie-sub {
        max-width: 700px;
        margin: 0 auto;
        font-size: 16px;
        line-height: 1.7;
        color: #5D5875;
    }

    .cookie-wrap {
        max-width: 980px;
        margin: 0 auto;
        padding: 0 20px 90px;
    }

    .cookie-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 32px;
        padding: 42px;
        box-shadow: 0 10px 40px rgba(30,58,95,0.06);
    }

    .cookie-meta {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .cookie-badge {
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(123,111,232,0.08);
        color: #5B4FD4;
        font-size: 12px;
        font-weight: 700;
    }

    .cookie-section {
        margin-bottom: 42px;
    }

    .cookie-heading {
        font-family: 'Instrument Serif', serif;
        font-size: 34px;
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: #1A1825;
        margin-bottom: 18px;
        font-weight: 400;
    }

    .cookie-text {
        font-size: 15px;
        line-height: 1.9;
        color: #4A4660;
        margin-bottom: 18px;
    }

    .cookie-list {
        padding-left: 20px;
        margin: 0;
    }

    .cookie-list li {
        margin-bottom: 12px;
        color: #4A4660;
        line-height: 1.8;
        font-size: 15px;
    }

    .cookie-highlight {
        padding: 24px;
        border-radius: 24px;
        background: linear-gradient(
            135deg,
            rgba(123,111,232,0.08),
            rgba(30,58,95,0.05)
        );
        border: 1px solid rgba(123,111,232,0.14);
        margin-top: 18px;
    }

    .cookie-contact {
        margin-top: 50px;
        padding: 30px;
        border-radius: 28px;
        background: linear-gradient(135deg, #1E3A5F 0%, #10243D 100%);
        color: white;
    }

    .cookie-contact-title {
        font-family: 'Instrument Serif', serif;
        font-size: 30px;
        line-height: 1.2;
        margin-bottom: 12px;
        font-weight: 400;
    }

    .cookie-contact p {
        color: rgba(255,255,255,0.72);
        line-height: 1.8;
        margin-bottom: 22px;
    }

    .cookie-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 24px;
        border-radius: 999px;
        background: white;
        color: #1E3A5F;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .cookie-btn:hover {
        transform: translateY(-2px);
        background: #F5F1FC;
    }

    @media (max-width: 768px) {
        .cookie-card {
            padding: 28px;
            border-radius: 24px;
        }

        .cookie-heading {
            font-size: 28px;
        }
    }
</style>
@endpush

@section('content')

<section class="cookie-hero">
    <div class="container">

        <div class="cookie-eyebrow">
            <i class="fa-solid fa-cookie-bite"></i>
            Cookie Policy
        </div>

        <h1 class="cookie-title">
            Kebijakan <em>Cookie</em>
        </h1>

        <p class="cookie-sub">
            Halaman ini menjelaskan bagaimana Coursify menggunakan cookies dan teknologi serupa untuk meningkatkan pengalaman pengguna.
        </p>

    </div>
</section>

<section class="cookie-wrap">

    <div class="cookie-card">

        <div class="cookie-meta">
            <div class="cookie-badge">
                Berlaku sejak 12 Mei 2026
            </div>

            <div class="cookie-badge">
                Last Updated
            </div>
        </div>

        {{-- SECTION --}}
        <div class="cookie-section">
            <h2 class="cookie-heading">
                1. Apa itu Cookie?
            </h2>

            <p class="cookie-text">
                Cookie adalah file kecil yang disimpan pada perangkat pengguna saat mengunjungi website. Cookie membantu sistem mengenali pengguna dan meningkatkan pengalaman penggunaan platform.
            </p>
        </div>

        {{-- SECTION --}}
        <div class="cookie-section">
            <h2 class="cookie-heading">
                2. Mengapa Kami Menggunakan Cookie?
            </h2>

            <p class="cookie-text">
                Coursify menggunakan cookie untuk menyediakan layanan yang lebih aman, cepat, dan personal.
            </p>

            <ul class="cookie-list">
                <li>Menyimpan sesi login pengguna.</li>
                <li>Mengingat preferensi tampilan dan bahasa.</li>
                <li>Menganalisis performa website.</li>
                <li>Meningkatkan keamanan sistem.</li>
                <li>Menyediakan pengalaman pembelajaran yang lebih personal.</li>
            </ul>
        </div>

        {{-- SECTION --}}
        <div class="cookie-section">
            <h2 class="cookie-heading">
                3. Jenis Cookie yang Digunakan
            </h2>

            <ul class="cookie-list">
                <li><strong>Essential Cookies</strong> — diperlukan agar website berfungsi dengan baik.</li>
                <li><strong>Analytics Cookies</strong> — membantu memahami perilaku pengguna.</li>
                <li><strong>Preference Cookies</strong> — menyimpan pengaturan dan preferensi pengguna.</li>
                <li><strong>Security Cookies</strong> — membantu melindungi akun dan data pengguna.</li>
            </ul>
        </div>

        {{-- SECTION --}}
        <div class="cookie-section">
            <h2 class="cookie-heading">
                4. Cookie Pihak Ketiga
            </h2>

            <p class="cookie-text">
                Kami dapat menggunakan layanan pihak ketiga seperti analytics, payment gateway, atau integrasi media sosial yang juga dapat menyimpan cookie pada perangkat pengguna.
            </p>

            <div class="cookie-highlight">
                <strong>Catatan:</strong>
                Cookie pihak ketiga memiliki kebijakan masing-masing yang berada di luar kontrol langsung Coursify.
            </div>
        </div>

        {{-- SECTION --}}
        <div class="cookie-section">
            <h2 class="cookie-heading">
                5. Mengelola Cookie
            </h2>

            <p class="cookie-text">
                Pengguna dapat mengatur, membatasi, atau menghapus cookie melalui pengaturan browser masing-masing.
            </p>

            <ul class="cookie-list">
                <li>Google Chrome</li>
                <li>Mozilla Firefox</li>
                <li>Safari</li>
                <li>Microsoft Edge</li>
            </ul>

            <p class="cookie-text">
                Menonaktifkan beberapa cookie dapat memengaruhi fungsi tertentu pada website.
            </p>
        </div>

        {{-- SECTION --}}
        <div class="cookie-section">
            <h2 class="cookie-heading">
                6. Perubahan Kebijakan Cookie
            </h2>

            <p class="cookie-text">
                Kebijakan cookie ini dapat diperbarui sewaktu-waktu untuk menyesuaikan perkembangan layanan, teknologi, maupun regulasi terbaru.
            </p>
        </div>

        {{-- CONTACT --}}
        <div class="cookie-contact">

            <div class="cookie-contact-title">
                Ada pertanyaan mengenai cookie?
            </div>

            <p>
                Hubungi tim Coursify apabila Anda memiliki pertanyaan mengenai penggunaan cookie atau teknologi tracking lainnya.
            </p>

            <a href="{{ route('contact') }}" class="cookie-btn">
                <i class="fa-solid fa-envelope"></i>
                Hubungi Kami
            </a>

        </div>

    </div>

</section>

@endsection