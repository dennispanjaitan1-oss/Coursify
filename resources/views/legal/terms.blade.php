{{-- resources/views/terms.blade.php --}}

@extends('layouts.app')

@section('title', 'Syarat & Ketentuan — Coursify')

@push('styles')
<style>
    .terms-hero {
        text-align: center;
        padding: 60px 20px 44px;
    }

    .terms-eyebrow {
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

    .terms-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(40px, 6vw, 72px);
        line-height: 1.08;
        letter-spacing: -0.03em;
        color: #1A1825;
        margin-bottom: 18px;
        font-weight: 400;
    }

    .terms-title em {
        font-style: italic;
        background: linear-gradient(135deg, #9F94F2 0%, #7B6FE8 50%, #5B4FD4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .terms-sub {
        max-width: 680px;
        margin: 0 auto;
        font-size: 16px;
        line-height: 1.7;
        color: #5D5875;
    }

    .terms-wrap {
        max-width: 980px;
        margin: 0 auto;
        padding: 0 20px 90px;
    }

    .terms-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 32px;
        padding: 42px;
        box-shadow: 0 10px 40px rgba(30,58,95,0.06);
    }

    .terms-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 30px;
    }

    .meta-badge {
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(123,111,232,0.08);
        color: #5B4FD4;
        font-size: 12px;
        font-weight: 700;
    }

    .terms-section {
        margin-bottom: 38px;
    }

    .terms-section:last-child {
        margin-bottom: 0;
    }

    .terms-heading {
        font-family: 'Instrument Serif', serif;
        font-size: 34px;
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: #1A1825;
        margin-bottom: 18px;
        font-weight: 400;
    }

    .terms-text {
        font-size: 15px;
        line-height: 1.9;
        color: #4A4660;
        margin-bottom: 18px;
    }

    .terms-list {
        padding-left: 20px;
        margin: 0;
    }

    .terms-list li {
        margin-bottom: 12px;
        color: #4A4660;
        line-height: 1.8;
        font-size: 15px;
    }

    .terms-highlight {
        padding: 22px 24px;
        border-radius: 24px;
        background: linear-gradient(135deg,
            rgba(123,111,232,0.08),
            rgba(30,58,95,0.05));
        border: 1px solid rgba(123,111,232,0.12);
        margin-top: 18px;
    }

    .terms-highlight strong {
        color: #1A1825;
    }

    .terms-contact {
        margin-top: 46px;
        padding: 28px;
        border-radius: 28px;
        background: linear-gradient(135deg, #1E3A5F 0%, #10243D 100%);
        color: white;
    }

    .terms-contact-title {
        font-family: 'Instrument Serif', serif;
        font-size: 30px;
        margin-bottom: 10px;
        font-weight: 400;
    }

    .terms-contact p {
        color: rgba(255,255,255,0.72);
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .terms-btn {
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

    .terms-btn:hover {
        transform: translateY(-2px);
        background: #F5F1FC;
    }

    @media (max-width: 768px) {
        .terms-card {
            padding: 28px;
            border-radius: 24px;
        }

        .terms-heading {
            font-size: 28px;
        }
    }
</style>
@endpush

@section('content')

<section class="terms-hero">
    <div class="container">
        <div class="terms-eyebrow">
            <i class="fa-solid fa-scale-balanced"></i>
            Legal & Policy
        </div>

        <h1 class="terms-title">
            Syarat & <em>Ketentuan</em>
        </h1>

        <p class="terms-sub">
            Harap membaca syarat dan ketentuan penggunaan platform Coursify secara seksama sebelum menggunakan layanan kami.
        </p>
    </div>
</section>

<section class="terms-wrap">
    <div class="terms-card">

        <div class="terms-meta">
            <div class="meta-badge">
                Berlaku sejak 12 Mei 2026
            </div>

            <div class="meta-badge">
                Versi 1.0
            </div>
        </div>

        {{-- SECTION --}}
        <div class="terms-section">
            <h2 class="terms-heading">
                1. Penggunaan Platform
            </h2>

            <p class="terms-text">
                Dengan menggunakan Coursify, Anda menyetujui seluruh syarat dan kebijakan yang berlaku pada platform ini. Pengguna diwajibkan menggunakan layanan secara bertanggung jawab dan tidak melanggar hukum yang berlaku.
            </p>

            <ul class="terms-list">
                <li>Tidak menggunakan platform untuk aktivitas ilegal.</li>
                <li>Tidak menyalahgunakan sistem, data, atau layanan digital.</li>
                <li>Menjaga keamanan akun dan informasi pribadi.</li>
            </ul>
        </div>

        {{-- SECTION --}}
        <div class="terms-section">
            <h2 class="terms-heading">
                2. Akun Pengguna
            </h2>

            <p class="terms-text">
                Pengguna bertanggung jawab atas seluruh aktivitas yang dilakukan melalui akun masing-masing. Coursify berhak menangguhkan akun yang melanggar ketentuan platform.
            </p>

            <div class="terms-highlight">
                <strong>Penting:</strong>
                Jangan membagikan password akun Anda kepada pihak lain demi menjaga keamanan data dan aktivitas pembelajaran.
            </div>
        </div>

        {{-- SECTION --}}
        <div class="terms-section">
            <h2 class="terms-heading">
                3. Konten & Hak Cipta
            </h2>

            <p class="terms-text">
                Seluruh materi kursus, desain, video, artikel, dan konten pada Coursify dilindungi oleh hak cipta dan tidak boleh disalin, diperjualbelikan, atau disebarluaskan tanpa izin resmi.
            </p>

            <ul class="terms-list">
                <li>Materi hanya untuk kebutuhan pembelajaran pribadi.</li>
                <li>Dilarang mendistribusikan ulang konten premium.</li>
                <li>Hak cipta tetap dimiliki oleh Coursify dan partner universitas.</li>
            </ul>
        </div>

        {{-- SECTION --}}
        <div class="terms-section">
            <h2 class="terms-heading">
                4. Pembayaran & Refund
            </h2>

            <p class="terms-text">
                Beberapa kursus pada platform Coursify dapat berbayar. Dengan melakukan pembayaran, pengguna menyetujui harga dan kebijakan refund yang berlaku.
            </p>

            <p class="terms-text">
                Refund dapat diproses sesuai ketentuan tertentu dan maksimal dalam periode yang telah ditentukan oleh sistem.
            </p>
        </div>

        {{-- SECTION --}}
        <div class="terms-section">
            <h2 class="terms-heading">
                5. Privasi Data
            </h2>

            <p class="terms-text">
                Kami menjaga keamanan dan kerahasiaan data pengguna sesuai kebijakan privasi yang berlaku. Informasi pribadi tidak akan dibagikan tanpa izin pengguna.
            </p>
        </div>

        {{-- SECTION --}}
        <div class="terms-section">
            <h2 class="terms-heading">
                6. Perubahan Ketentuan
            </h2>

            <p class="terms-text">
                Coursify dapat memperbarui syarat dan ketentuan sewaktu-waktu untuk meningkatkan kualitas layanan dan menyesuaikan regulasi terbaru.
            </p>
        </div>

        {{-- CONTACT --}}
        <div class="terms-contact">
            <div class="terms-contact-title">
                Ada pertanyaan mengenai kebijakan kami?
            </div>

            <p>
                Tim Coursify siap membantu Anda terkait syarat penggunaan, privasi, pembayaran, maupun kebijakan platform lainnya.
            </p>

            <a href="{{ route('contact') }}" class="terms-btn">
                <i class="fa-solid fa-envelope"></i>
                Hubungi Kami
            </a>
        </div>

    </div>
</section>

@endsection