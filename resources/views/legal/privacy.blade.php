{{-- resources/views/privacy.blade.php --}}

@extends('layouts.app')

@section('title', 'Kebijakan Privasi')

@push('styles')
<style>
    .privacy-hero {
        text-align: center;
        padding: 60px 20px 44px;
    }

    .privacy-eyebrow {
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

    .privacy-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(40px, 6vw, 72px);
        line-height: 1.08;
        letter-spacing: -0.03em;
        color: #1A1825;
        margin-bottom: 18px;
        font-weight: 400;
    }

    .privacy-title em {
        font-style: italic;
        background: linear-gradient(135deg, #9F94F2 0%, #7B6FE8 50%, #5B4FD4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .privacy-sub {
        max-width: 700px;
        margin: 0 auto;
        font-size: 16px;
        line-height: 1.7;
        color: #5D5875;
    }

    .privacy-wrap {
        max-width: 980px;
        margin: 0 auto;
        padding: 0 20px 90px;
    }

    .privacy-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 32px;
        padding: 42px;
        box-shadow: 0 10px 40px rgba(30,58,95,0.06);
    }

    .privacy-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 30px;
    }

    .privacy-badge {
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(123,111,232,0.08);
        color: #5B4FD4;
        font-size: 12px;
        font-weight: 700;
    }

    .privacy-section {
        margin-bottom: 42px;
    }

    .privacy-section:last-child {
        margin-bottom: 0;
    }

    .privacy-heading {
        font-family: 'Instrument Serif', serif;
        font-size: 34px;
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: #1A1825;
        margin-bottom: 18px;
        font-weight: 400;
    }

    .privacy-text {
        font-size: 15px;
        line-height: 1.9;
        color: #4A4660;
        margin-bottom: 18px;
    }

    .privacy-list {
        padding-left: 20px;
        margin: 0;
    }

    .privacy-list li {
        margin-bottom: 12px;
        color: #4A4660;
        line-height: 1.8;
        font-size: 15px;
    }

    .privacy-highlight {
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

    .privacy-highlight strong {
        color: #1A1825;
    }

    .privacy-contact {
        margin-top: 50px;
        padding: 30px;
        border-radius: 28px;
        background: linear-gradient(135deg, #1E3A5F 0%, #10243D 100%);
        color: white;
    }

    .privacy-contact-title {
        font-family: 'Instrument Serif', serif;
        font-size: 30px;
        line-height: 1.2;
        margin-bottom: 12px;
        font-weight: 400;
    }

    .privacy-contact p {
        color: rgba(255,255,255,0.72);
        line-height: 1.8;
        margin-bottom: 22px;
    }

    .privacy-btn {
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

    .privacy-btn:hover {
        transform: translateY(-2px);
        background: #F5F1FC;
    }

    @media (max-width: 768px) {
        .privacy-card {
            padding: 28px;
            border-radius: 24px;
        }

        .privacy-heading {
            font-size: 28px;
        }
    }
</style>
@endpush

@section('content')

<section class="privacy-hero">
    <div class="container">

        <div class="privacy-eyebrow">
            <i class="fa-solid fa-shield-halved"></i>
            Privacy & Security
        </div>

        <h1 class="privacy-title">
            Kebijakan <em>Privasi</em>
        </h1>

        <p class="privacy-sub">
            Coursify berkomitmen untuk melindungi privasi dan keamanan data seluruh pengguna platform kami.
        </p>

    </div>
</section>

<section class="privacy-wrap">

    <div class="privacy-card">

        <div class="privacy-meta">
            <div class="privacy-badge">
                Berlaku sejak 12 Mei 2026
            </div>

            <div class="privacy-badge">
                Last Updated
            </div>
        </div>

        {{-- SECTION --}}
        <div class="privacy-section">
            <h2 class="privacy-heading">
                1. Informasi yang Kami Kumpulkan
            </h2>

            <p class="privacy-text">
                Saat menggunakan platform Coursify, kami dapat mengumpulkan beberapa informasi untuk meningkatkan kualitas layanan pembelajaran digital.
            </p>

            <ul class="privacy-list">
                <li>Nama lengkap dan informasi akun pengguna.</li>
                <li>Alamat email dan nomor kontak.</li>
                <li>Data aktivitas pembelajaran dan progres kursus.</li>
                <li>Informasi perangkat, browser, dan cookies.</li>
                <li>Riwayat transaksi atau pembayaran kursus.</li>
            </ul>
        </div>

        {{-- SECTION --}}
        <div class="privacy-section">
            <h2 class="privacy-heading">
                2. Penggunaan Informasi
            </h2>

            <p class="privacy-text">
                Informasi yang dikumpulkan digunakan untuk memberikan pengalaman belajar yang lebih personal, aman, dan optimal.
            </p>

            <ul class="privacy-list">
                <li>Mengelola akun dan autentikasi pengguna.</li>
                <li>Menyediakan akses kursus dan sertifikat.</li>
                <li>Meningkatkan kualitas fitur dan sistem.</li>
                <li>Mengirim notifikasi, update, dan informasi penting.</li>
                <li>Mencegah penyalahgunaan atau aktivitas ilegal.</li>
            </ul>
        </div>

        {{-- SECTION --}}
        <div class="privacy-section">
            <h2 class="privacy-heading">
                3. Keamanan Data
            </h2>

            <p class="privacy-text">
                Kami menerapkan langkah-langkah keamanan teknis dan administratif untuk menjaga keamanan data pengguna dari akses tidak sah, kehilangan, maupun penyalahgunaan.
            </p>

            <div class="privacy-highlight">
                <strong>Keamanan akun Anda penting.</strong>
                Gunakan password yang kuat dan jangan membagikan informasi login kepada pihak lain.
            </div>
        </div>

        {{-- SECTION --}}
        <div class="privacy-section">
            <h2 class="privacy-heading">
                4. Cookies & Teknologi Tracking
            </h2>

            <p class="privacy-text">
                Coursify dapat menggunakan cookies dan teknologi serupa untuk meningkatkan pengalaman pengguna, menyimpan preferensi, dan menganalisis performa platform.
            </p>

            <p class="privacy-text">
                Pengguna dapat mengatur atau menonaktifkan cookies melalui pengaturan browser masing-masing.
            </p>
        </div>

        {{-- SECTION --}}
        <div class="privacy-section">
            <h2 class="privacy-heading">
                5. Pembagian Informasi kepada Pihak Ketiga
            </h2>

            <p class="privacy-text">
                Kami tidak menjual data pribadi pengguna. Informasi hanya dapat dibagikan kepada pihak ketiga terpercaya yang membantu operasional platform, seperti:
            </p>

            <ul class="privacy-list">
                <li>Penyedia layanan pembayaran.</li>
                <li>Penyedia email dan notifikasi.</li>
                <li>Partner universitas dan institusi pendidikan.</li>
                <li>Layanan keamanan dan analitik sistem.</li>
            </ul>
        </div>

        {{-- SECTION --}}
        <div class="privacy-section">
            <h2 class="privacy-heading">
                6. Hak Pengguna
            </h2>

            <p class="privacy-text">
                Pengguna memiliki hak untuk mengakses, memperbarui, atau meminta penghapusan data pribadi sesuai kebijakan dan regulasi yang berlaku.
            </p>

            <ul class="privacy-list">
                <li>Memperbarui informasi akun.</li>
                <li>Meminta penghapusan akun tertentu.</li>
                <li>Berhenti menerima email promosi.</li>
            </ul>
        </div>

        {{-- SECTION --}}
        <div class="privacy-section">
            <h2 class="privacy-heading">
                7. Perubahan Kebijakan
            </h2>

            <p class="privacy-text">
                Kebijakan privasi ini dapat diperbarui sewaktu-waktu untuk menyesuaikan perkembangan layanan dan regulasi terbaru.
            </p>

            <p class="privacy-text">
                Perubahan signifikan akan diinformasikan melalui platform atau email pengguna.
            </p>
        </div>

        {{-- CONTACT --}}
        <div class="privacy-contact">

            <div class="privacy-contact-title">
                Pertanyaan tentang privasi data?
            </div>

            <p>
                Jika Anda memiliki pertanyaan terkait keamanan data, kebijakan privasi, atau penggunaan informasi pengguna, silakan hubungi tim Coursify.
            </p>

            <a href="{{ route('contact') }}" class="privacy-btn">
                <i class="fa-solid fa-envelope"></i>
                Hubungi Kami
            </a>

        </div>

    </div>

</section>

@endsection