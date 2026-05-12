@extends('layouts.app')

@section('title', 'Contact Us')

@push('styles')
<style>
    /* ═══════════════════════════════════ */
    /* HERO SECTION                       */
    /* ═══════════════════════════════════ */
    .contact-hero {
        text-align: center;
        padding: 56px 20px 48px;
        position: relative;
        z-index: 1;
    }

    .contact-hero-eyebrow {
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

    .contact-hero-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(42px, 6vw, 72px);
        line-height: 1.08;
        letter-spacing: -0.03em;
        color: #1A1825;
        margin-bottom: 18px;
        font-weight: 400;
    }

    .contact-hero-title em {
        font-style: italic;
        background: linear-gradient(135deg, #9F94F2 0%, #7B6FE8 50%, #5B4FD4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .contact-hero-sub {
        max-width: 640px;
        margin: 0 auto;
        font-size: 16px;
        line-height: 1.7;
        color: #4A4660;
    }

    /* ═══════════════════════════════════ */
    /* MAIN WRAPPER                       */
    /* ═══════════════════════════════════ */
    .contact-wrapper {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 20px 90px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 24px;
        align-items: start;
    }

    /* ═══════════════════════════════════ */
    /* FORM CARD                          */
    /* ═══════════════════════════════════ */
    .contact-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 28px;
        padding: 34px;
        box-shadow: 0 8px 30px rgba(30,58,95,0.06);
    }

    .contact-card-header {
        margin-bottom: 28px;
    }

    .contact-card-title {
        font-family: 'Instrument Serif', serif;
        font-size: 34px;
        line-height: 1.1;
        letter-spacing: -0.02em;
        color: #1A1825;
        margin-bottom: 10px;
        font-weight: 400;
    }

    .contact-card-title em {
        color: #7B6FE8;
        font-style: italic;
    }

    .contact-card-desc {
        font-size: 14px;
        line-height: 1.7;
        color: #6E6987;
    }

    .contact-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: #7A7596;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        border: 1px solid rgba(30,58,95,0.08);
        background: rgba(255,255,255,0.88);
        border-radius: 18px;
        padding: 15px 18px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #1A1825;
        outline: none;
        transition: all .2s ease;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: #7B6FE8;
        box-shadow: 0 0 0 4px rgba(123,111,232,0.12);
        background: #fff;
    }

    .form-textarea {
        min-height: 160px;
        resize: vertical;
        line-height: 1.7;
    }

    .contact-submit {
        margin-top: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 15px 28px;
        border-radius: 999px;
        background: linear-gradient(135deg, #1E3A5F 0%, #152B47 100%);
        color: white;
        border: none;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all .25s ease;
        text-decoration: none;
    }

    .contact-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 32px rgba(30,58,95,0.16);
    }

    /* ═══════════════════════════════════ */
    /* SIDEBAR                            */
    /* ═══════════════════════════════════ */
    .contact-side {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .info-card {
        background: rgba(255,255,255,0.68);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 28px;
        padding: 28px;
        box-shadow: 0 8px 28px rgba(30,58,95,0.05);
    }

    .info-title {
        font-family: 'Instrument Serif', serif;
        font-size: 28px;
        font-weight: 400;
        line-height: 1.15;
        color: #1A1825;
        margin-bottom: 18px;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .info-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: rgba(123,111,232,0.1);
        color: #5B4FD4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #8B87A8;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 14px;
        line-height: 1.6;
        color: #1A1825;
        font-weight: 500;
    }

    .faq-card {
        background: linear-gradient(135deg, #1E3A5F 0%, #10243D 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .faq-card::before {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(123,111,232,0.12);
        top: -100px;
        right: -70px;
    }

    .faq-title {
        position: relative;
        z-index: 1;
        font-family: 'Instrument Serif', serif;
        font-size: 30px;
        line-height: 1.15;
        font-weight: 400;
        margin-bottom: 12px;
    }

    .faq-desc {
        position: relative;
        z-index: 1;
        font-size: 14px;
        line-height: 1.8;
        color: rgba(255,255,255,0.7);
        margin-bottom: 22px;
    }

    .faq-btn {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 22px;
        border-radius: 999px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.16);
        color: white;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .faq-btn:hover {
        background: rgba(255,255,255,0.18);
        transform: translateY(-2px);
    }

    /* ═══════════════════════════════════ */
    /* RESPONSIVE                         */
    /* ═══════════════════════════════════ */
    @media (max-width: 920px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .contact-card,
        .info-card {
            padding: 24px;
            border-radius: 24px;
        }

        .contact-form-grid {
            grid-template-columns: 1fr;
        }

        .contact-hero {
            padding-top: 42px;
        }
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════ --}}
{{-- HERO                               --}}
{{-- ═══════════════════════════════════ --}}
<section class="contact-hero">
    <div class="container">
        <div class="contact-hero-eyebrow">
            <i class="fa-solid fa-headset"></i>
            Contact & Support
        </div>

        <h1 class="contact-hero-title">
            Kami siap <em>membantu</em><br>perjalanan belajar Anda
        </h1>

        <p class="contact-hero-sub">
            Punya pertanyaan tentang kursus, partnership, pembayaran, atau pengalaman belajar di Coursify? Tim kami akan membantu Anda secepat mungkin.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════ --}}
{{-- CONTACT SECTION                    --}}
{{-- ═══════════════════════════════════ --}}
<section class="contact-wrapper">
    <div class="contact-grid">

        {{-- FORM --}}
        <div class="contact-card">
            <div class="contact-card-header">
                <h2 class="contact-card-title">
                    Kirim <em>Pesan</em>
                </h2>
                <p class="contact-card-desc">
                    Isi formulir di bawah ini dan tim Coursify akan menghubungi Anda melalui email dalam 1×24 jam kerja.
                </p>
            </div>

            <form action="#" method="POST">
                @csrf

                <div class="contact-form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" placeholder="nama@email.com">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-input" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Pilih kategori</option>
                            <option>Informasi Kursus</option>
                            <option>Pembayaran</option>
                            <option>Sertifikat</option>
                            <option>Kerja Sama Universitas</option>
                            <option>Laporan Bug / Kendala</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Subjek</label>
                        <input type="text" name="subject" class="form-input" placeholder="Tulis subjek pesan Anda">
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Pesan</label>
                        <textarea name="message" class="form-textarea" placeholder="Jelaskan pertanyaan atau kendala Anda secara detail..."></textarea>
                    </div>
                </div>

                <button type="submit" class="contact-submit">
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Pesan
                </button>
            </form>
        </div>

        {{-- SIDEBAR --}}
        <div class="contact-side">

            {{-- CONTACT INFO --}}
            <div class="info-card">
                <h3 class="info-title">Informasi Kontak</h3>

                <div class="info-list">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value">support@coursify.id</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="info-label">Telepon</div>
                            <div class="info-value">+62 812-3456-7890</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <div class="info-label">Alamat</div>
                            <div class="info-value">
                                Coursify Education Center<br>
                                Jakarta Selatan, Indonesia
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <div class="info-label">Jam Operasional</div>
                            <div class="info-value">
                                Senin — Jumat<br>
                                08.00 — 17.00 WIB
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ / SUPPORT --}}
            <div class="info-card faq-card">
                <h3 class="faq-title">
                    Butuh bantuan lebih cepat?
                </h3>

                <p class="faq-desc">
                    Kunjungi pusat bantuan Coursify untuk menemukan jawaban dari pertanyaan yang paling sering ditanyakan mahasiswa.
                </p>

                <a href="#" class="faq-btn">
                    <i class="fa-solid fa-circle-question"></i>
                    Pusat Bantuan
                </a>
            </div>

        </div>
    </div>
</section>

@endsection