@extends('layouts.app')

@section('title', 'FAQ — Coursify')

@push('styles')
<style>
/* ══════════════════════════════════════════
   FAQ PAGE
   resources/views/faq.blade.php
   Route: Route::view('/faq', 'faq')->name('faq');
══════════════════════════════════════════ */

/* ── Hero ── */
.faq-hero {
    text-align: center;
    padding: 56px 20px 48px;
    position: relative;
    z-index: 1;
}
.faq-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(123,111,232,0.1);
    border: 1px solid rgba(123,111,232,0.2);
    color: var(--purple-dark);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 6px 16px;
    border-radius: 100px;
    margin-bottom: 20px;
}
.faq-hero-title {
    font-family: var(--font-serif);
    font-size: clamp(42px, 6vw, 72px);
    font-weight: 400;
    line-height: 1.08;
    letter-spacing: -0.025em;
    margin-bottom: 18px;
    color: var(--text);
}
.faq-hero-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    padding-right: 0.08em;
}
.faq-hero-sub {
    font-size: 16px;
    color: var(--text-soft);
    line-height: 1.65;
    max-width: 520px;
    margin: 0 auto 36px;
}

/* ── Search bar ── */
.faq-search-wrap {
    max-width: 540px;
    margin: 0 auto;
    position: relative;
}
.faq-search-icon {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 16px;
    pointer-events: none;
}
.faq-search {
    width: 100%;
    padding: 15px 60px 15px 50px;
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(20px);
    border: 1.5px solid rgba(255,255,255,0.95);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 15px;
    color: var(--text);
    outline: none;
    transition: all 0.25s;
    box-shadow: 0 8px 30px rgba(30,58,95,0.08);
}
.faq-search::placeholder { color: var(--muted); }
.faq-search:focus {
    background: white;
    border-color: var(--purple);
    box-shadow: 0 0 0 5px rgba(123,111,232,0.1), 0 8px 30px rgba(30,58,95,0.08);
}
.faq-search-clear {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--lav-2);
    border: none;
    cursor: pointer;
    color: var(--muted);
    font-size: 14px;
    display: none;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.faq-search-clear:hover { background: var(--lav-3); color: var(--text); }
.faq-search-clear.visible { display: flex; }

/* ── Layout ── */
.faq-main {
    padding: 0 20px 80px;
    position: relative;
    z-index: 1;
}
.faq-inner {
    max-width: 1060px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 28px;
    align-items: start;
}

/* ── Category sidebar ── */
.faq-sidebar {
    position: sticky;
    top: 110px;
    background: rgba(255,255,255,0.68);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.92);
    border-radius: 20px;
    padding: 20px 16px;
    box-shadow: 0 4px 20px rgba(30,58,95,0.04);
}
.faq-sidebar-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    padding: 0 8px;
    margin-bottom: 10px;
}
.faq-cat-btn {
    display: flex;
    align-items: center;
    gap: 9px;
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
    text-align: left;
    margin-bottom: 2px;
}
.faq-cat-btn:hover { background: var(--lav-1); color: var(--text); }
.faq-cat-btn.active {
    background: rgba(123,111,232,0.12);
    color: var(--purple-dark);
    font-weight: 600;
}
.faq-cat-btn i { width: 16px; text-align: center; font-size: 13px; opacity: 0.7; }
.faq-cat-count {
    margin-left: auto;
    font-size: 10px;
    font-weight: 700;
    background: var(--lav-2);
    color: var(--muted);
    padding: 1px 7px;
    border-radius: 100px;
}
.faq-cat-btn.active .faq-cat-count {
    background: rgba(123,111,232,0.2);
    color: var(--purple-dark);
}
.faq-sidebar-divider {
    height: 1px;
    background: rgba(30,58,95,0.07);
    margin: 12px 8px;
}

/* ── FAQ Content ── */
.faq-content { min-width: 0; }

.faq-group { margin-bottom: 36px; }
.faq-group-title {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    letter-spacing: -0.01em;
    color: var(--text);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.faq-group-title i {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.icon-bg-purple { background: rgba(123,111,232,0.12); color: var(--purple); }
.icon-bg-teal   { background: rgba(0,200,150,0.12);   color: #009970; }
.icon-bg-orange { background: rgba(255,138,91,0.12);  color: #D05020; }
.icon-bg-navy   { background: rgba(30,58,95,0.1);     color: var(--navy); }
.icon-bg-gold   { background: rgba(255,196,82,0.15);  color: #9A6E00; }

/* ── FAQ Item ── */
.faq-item {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    margin-bottom: 8px;
    overflow: hidden;
    transition: all 0.3s;
}
.faq-item:hover { border-color: rgba(123,111,232,0.3); }
.faq-item.active {
    border-color: var(--purple);
    box-shadow: 0 4px 20px rgba(123,111,232,0.08);
}
.faq-question {
    width: 100%;
    background: transparent;
    border: none;
    padding: 18px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    font-family: var(--font-sans);
    font-size: 14.5px;
    font-weight: 500;
    text-align: left;
    cursor: pointer;
    color: var(--text);
    transition: all 0.2s;
}
.faq-question:hover { color: var(--purple); }
.faq-item.active .faq-question { color: var(--purple-dark); }
.faq-icon {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: rgba(123,111,232,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--purple);
    font-size: 15px;
    flex-shrink: 0;
    transition: all 0.3s;
    font-weight: 700;
    line-height: 1;
}
.faq-item.active .faq-icon {
    transform: rotate(45deg);
    background: var(--purple);
    color: white;
}
.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.faq-item.active .faq-answer { max-height: 400px; }
.faq-answer-inner {
    padding: 0 20px 20px;
    font-size: 14px;
    color: var(--text-soft);
    line-height: 1.75;
    border-top: 1px solid rgba(30,58,95,0.06);
    padding-top: 16px;
    margin: 0 20px;
    margin-bottom: 4px;
}
.faq-answer-inner strong { color: var(--text); font-weight: 600; }
.faq-answer-inner a { color: var(--purple); text-decoration: underline; }

/* no results */
.faq-no-results {
    text-align: center;
    padding: 48px 20px;
    background: rgba(255,255,255,0.5);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.8);
    display: none;
}
.faq-no-results.visible { display: block; }
.faq-no-results-icon { font-size: 44px; margin-bottom: 14px; color: var(--lav-3); }
.faq-no-results-title {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    color: var(--text);
    margin-bottom: 8px;
}
.faq-no-results-desc { font-size: 13px; color: var(--muted); }

/* ── CTA ── */
.faq-cta-section { padding: 0 20px 80px; }
.faq-cta-card {
    max-width: 1060px;
    margin: 0 auto;
    background: rgba(255,255,255,0.68);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.92);
    border-radius: 24px;
    padding: 44px 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 28px;
    box-shadow: 0 4px 20px rgba(30,58,95,0.04);
    flex-wrap: wrap;
}
.faq-cta-left { min-width: 0; }
.faq-cta-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--purple);
    margin-bottom: 10px;
}
.faq-cta-title {
    font-family: var(--font-serif);
    font-size: clamp(26px, 3vw, 36px);
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1.15;
    color: var(--text);
    margin-bottom: 10px;
}
.faq-cta-title em { font-style: italic; color: var(--purple); }
.faq-cta-desc { font-size: 14px; color: var(--text-soft); line-height: 1.6; max-width: 440px; }
.faq-cta-buttons { display: flex; gap: 10px; flex-wrap: wrap; flex-shrink: 0; }
.btn-faq-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 26px;
    background: var(--navy);
    color: white;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(30,58,95,0.28);
    white-space: nowrap;
}
.btn-faq-primary:hover { background: #2D4D7A; transform: translateY(-2px); }
.btn-faq-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 26px;
    background: rgba(255,255,255,0.7);
    color: var(--text);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: 1.5px solid rgba(255,255,255,0.9);
    white-space: nowrap;
}
.btn-faq-ghost:hover { background: white; transform: translateY(-2px); }

/* ── Responsive ── */
@media (max-width: 860px) {
    .faq-inner { grid-template-columns: 1fr; }
    .faq-sidebar { position: static; display: flex; flex-wrap: wrap; gap: 6px; padding: 14px; }
    .faq-sidebar-title { width: 100%; margin-bottom: 4px; }
    .faq-sidebar-divider { display: none; }
    .faq-cat-btn { width: auto; padding: 8px 14px; border-radius: 100px; margin-bottom: 0; }
    .faq-cta-card { padding: 32px 28px; flex-direction: column; align-items: flex-start; }
}
@media (max-width: 560px) {
    .faq-cat-btn span { display: none; }
    .faq-cat-btn i { margin: 0; }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section class="faq-hero">
    <div class="container">
        <div class="faq-hero-eyebrow">
            <i class="fa-solid fa-circle-question"></i>
            Pusat Bantuan
        </div>
        <h1 class="faq-hero-title">
            <br><em>F A Q</em>
        </h1>
        <p class="faq-hero-sub">
            Temukan jawaban atas pertanyaanmu di sini. Tidak menemukan yang dicari? Tim kami siap membantu.
        </p>

        {{-- Search --}}
        <div class="faq-search-wrap">
            <i class="fa-solid fa-magnifying-glass faq-search-icon"></i>
            <input
                type="text"
                id="faqSearch"
                class="faq-search"
                placeholder="Cari pertanyaan..."
                oninput="searchFaq(this.value)"
                autocomplete="off"
            >
            <button class="faq-search-clear" id="searchClear" onclick="clearSearch()" aria-label="Hapus pencarian">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════ --}}
<section class="faq-main">
    <div class="faq-inner">

        {{-- ── Sidebar Kategori ── --}}
        <aside class="faq-sidebar">
            <div class="faq-sidebar-title">Kategori</div>
            <button class="faq-cat-btn active" onclick="filterCategory('all', this)">
                <i class="fa-solid fa-border-all"></i>
                <span>Semua</span>
                <span class="faq-cat-count" id="count-all">20</span>
            </button>
            <button class="faq-cat-btn" onclick="filterCategory('akun', this)">
                <i class="fa-solid fa-user-circle"></i>
                <span>Akun & Profil</span>
                <span class="faq-cat-count" id="count-akun">4</span>
            </button>
            <button class="faq-cat-btn" onclick="filterCategory('kursus', this)">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Kursus</span>
                <span class="faq-cat-count" id="count-kursus">4</span>
            </button>
            <button class="faq-cat-btn" onclick="filterCategory('pembayaran', this)">
                <i class="fa-solid fa-credit-card"></i>
                <span>Pembayaran</span>
                <span class="faq-cat-count" id="count-pembayaran">4</span>
            </button>
            <button class="faq-cat-btn" onclick="filterCategory('sertifikat', this)">
                <i class="fa-solid fa-certificate"></i>
                <span>Sertifikat</span>
                <span class="faq-cat-count" id="count-sertifikat">4</span>
            </button>
            <button class="faq-cat-btn" onclick="filterCategory('instruktur', this)">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Instruktur</span>
                <span class="faq-cat-count" id="count-instruktur">4</span>
            </button>
            <div class="faq-sidebar-divider"></div>
            <button class="faq-cat-btn" onclick="window.location.href='mailto:support@coursify.id'">
                <i class="fa-solid fa-envelope"></i>
                <span>Hubungi Kami</span>
            </button>
        </aside>

        {{-- ── FAQ List ── --}}
        <div class="faq-content" id="faqContent" x-data="{ openFaq: null }">

            {{-- No results --}}
            <div class="faq-no-results" id="noResults">
                <div class="faq-no-results-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="faq-no-results-title">Tidak ada hasil ditemukan</div>
                <p class="faq-no-results-desc">Coba kata kunci lain atau pilih kategori yang berbeda.</p>
            </div>

            @php
                $faqGroups = [
                    [
                        'id'    => 'akun',
                        'label' => 'Akun & Profil',
                        'icon'  => 'fa-user-circle',
                        'icon_class' => 'icon-bg-purple',
                        'items' => [
                            [
                                'q' => 'Bagaimana cara membuat akun di Coursify?',
                                'a' => 'Klik tombol <strong>Get Started</strong> di pojok kanan atas, lalu isi nama, email, dan password. Setelah itu kamu akan langsung bisa mengakses ratusan kursus gratis tanpa perlu verifikasi email terlebih dahulu.',
                            ],
                            [
                                'q' => 'Apakah saya bisa mengubah email atau password akun saya?',
                                'a' => 'Ya, buka <strong>Profile Settings</strong> dari menu dropdown di pojok kanan atas. Di sana kamu bisa mengubah nama, email, password, dan foto profil kapan saja.',
                            ],
                            [
                                'q' => 'Bagaimana jika saya lupa password?',
                                'a' => 'Klik <strong>Lupa Password</strong> di halaman login, masukkan emailmu, dan kami akan mengirimkan link reset password. Link tersebut berlaku selama 60 menit.',
                            ],
                            [
                                'q' => 'Apakah saya bisa menggunakan satu akun di beberapa perangkat?',
                                'a' => 'Ya! Akun Coursify bisa diakses dari browser manapun dan perangkat apapun — laptop, tablet, maupun smartphone — secara bersamaan tanpa biaya tambahan.',
                            ],
                        ],
                    ],
                    [
                        'id'    => 'kursus',
                        'label' => 'Kursus',
                        'icon'  => 'fa-graduation-cap',
                        'icon_class' => 'icon-bg-teal',
                        'items' => [
                            [
                                'q' => 'Bagaimana cara mendaftar ke sebuah kursus?',
                                'a' => 'Buka halaman detail kursus, lalu klik <strong>Enroll Now</strong>. Untuk kursus gratis, kamu langsung bisa mulai belajar. Untuk kursus berbayar, kamu akan diarahkan ke halaman pembayaran.',
                            ],
                            [
                                'q' => 'Apakah saya bisa mengakses kursus secara offline?',
                                'a' => 'Subscriber <strong>Pro dan Business</strong> bisa mengunduh video pelajaran ke aplikasi mobile Coursify untuk ditonton tanpa koneksi internet. Sangat praktis untuk belajar saat perjalanan.',
                            ],
                            [
                                'q' => 'Berapa lama saya punya akses ke kursus yang sudah dibeli?',
                                'a' => 'Semua kursus yang kamu beli memberikan <strong>akses seumur hidup</strong> — termasuk semua pembaruan konten di masa mendatang. Tidak ada tenggat waktu untuk menyelesaikannya.',
                            ],
                            [
                                'q' => 'Apakah ada kursus gratis?',
                                'a' => 'Ya! Kami menyediakan lebih dari <strong>100 kursus gratis</strong> yang bisa diakses tanpa kartu kredit. Cukup buat akun dan mulai belajar. Kursus gratis juga disertai sertifikat penyelesaian.',
                            ],
                        ],
                    ],
                    [
                        'id'    => 'pembayaran',
                        'label' => 'Pembayaran',
                        'icon'  => 'fa-credit-card',
                        'icon_class' => 'icon-bg-orange',
                        'items' => [
                            [
                                'q' => 'Metode pembayaran apa saja yang tersedia?',
                                'a' => 'Kami menerima berbagai metode pembayaran: <strong>kartu kredit/debit</strong> (Visa, Mastercard), <strong>transfer bank</strong> (BCA, Mandiri, BNI, BRI), <strong>e-wallet</strong> (GoPay, OVO, DANA, ShopeePay), dan <strong>QRIS</strong>.',
                            ],
                            [
                                'q' => 'Apakah ada garansi uang kembali?',
                                'a' => 'Ya! Kami menawarkan <strong>garansi uang kembali 30 hari</strong> untuk semua langganan Pro. Jika kamu tidak puas dengan alasan apapun, hubungi tim support kami untuk refund penuh tanpa pertanyaan tambahan.',
                            ],
                            [
                                'q' => 'Apakah ada paket untuk perusahaan atau tim?',
                                'a' => 'Tentu. Paket <strong>Business</strong> kami dirancang untuk tim hingga 25 orang dan mencakup dashboard admin, analitik tim, dan learning path kustom. Untuk perusahaan lebih besar, hubungi tim sales kami.',
                            ],
                            [
                                'q' => 'Bisakah saya membatalkan langganan kapan saja?',
                                'a' => 'Ya, langganan bisa dibatalkan kapan saja tanpa biaya tambahan. Akses premium kamu tetap berlaku hingga akhir periode penagihan yang sudah dibayar.',
                            ],
                        ],
                    ],
                    [
                        'id'    => 'sertifikat',
                        'label' => 'Sertifikat',
                        'icon'  => 'fa-certificate',
                        'icon_class' => 'icon-bg-gold',
                        'items' => [
                            [
                                'q' => 'Apakah sertifikat Coursify diakui oleh perusahaan?',
                                'a' => 'Ya! Sertifikat Coursify diterbitkan bersama institusi partner seperti UI, ITB, dan UGM, dilengkapi <strong>ID verifikasi unik</strong> yang bisa dicek online oleh rekruter. Banyak alumni kami sudah berhasil masuk ke Gojek, Tokopedia, dan Shopee menggunakan sertifikat ini.',
                            ],
                            [
                                'q' => 'Bagaimana cara mendapatkan sertifikat?',
                                'a' => 'Selesaikan semua pelajaran di kursus dan capai nilai minimal 70% di kuis akhir. Sertifikat akan otomatis tersedia di dashboard kamu dalam format <strong>PDF beresolusi tinggi</strong> yang siap dicetak.',
                            ],
                            [
                                'q' => 'Bisakah saya membagikan sertifikat ke LinkedIn?',
                                'a' => 'Bisa! Setiap sertifikat punya tombol <strong>Tambah ke LinkedIn</strong> yang langsung mengisi data kursus dan ID verifikasi secara otomatis ke profil LinkedIn-mu.',
                            ],
                            [
                                'q' => 'Apakah sertifikat kursus gratis berbeda dengan kursus berbayar?',
                                'a' => 'Secara tampilan dan format sama. Perbedaannya ada pada institusi penerbit — sertifikat kursus berbayar biasanya mencantumkan logo universitas partner, sedangkan kursus gratis diterbitkan langsung oleh Coursify.',
                            ],
                        ],
                    ],
                    [
                        'id'    => 'instruktur',
                        'label' => 'Instruktur',
                        'icon'  => 'fa-chalkboard-user',
                        'icon_class' => 'icon-bg-navy',
                        'items' => [
                            [
                                'q' => 'Bagaimana cara menjadi instruktur di Coursify?',
                                'a' => 'Kamu membutuhkan minimal <strong>3 tahun pengalaman industri</strong> dan portofolio pekerjaan yang relevan. Daftar melalui portal instruktur kami, dan tim kami akan meninjau aplikasimu dalam 7 hari kerja.',
                            ],
                            [
                                'q' => 'Berapa pendapatan yang bisa saya dapatkan sebagai instruktur?',
                                'a' => 'Instruktur mendapatkan <strong>70% dari setiap penjualan kursus</strong> yang mereka buat. Tidak ada biaya pendaftaran — kamu hanya perlu fokus membuat konten berkualitas dan kami yang mengurus pemasarannya.',
                            ],
                            [
                                'q' => 'Apakah Coursify membantu pembuatan konten kursus?',
                                'a' => 'Ya! Tim content kami menyediakan <strong>panduan kurikulum, template slide, dan sesi review</strong> sebelum kursus diluncurkan. Kami juga memberikan akses ke tools produksi video untuk instruktur baru.',
                            ],
                            [
                                'q' => 'Berapa lama proses review kursus sebelum bisa dipublikasikan?',
                                'a' => 'Proses review biasanya memakan waktu <strong>5–10 hari kerja</strong>. Tim kami akan mengecek kualitas audio/video, akurasi konten, dan kelengkapan materi. Kamu akan mendapat feedback detail jika ada yang perlu diperbaiki.',
                            ],
                        ],
                    ],
                ];
            @endphp

            @foreach($faqGroups as $group)
                <div class="faq-group" data-category="{{ $group['id'] }}">
                    <div class="faq-group-title">
                        <i class="fa-solid {{ $group['icon'] }} {{ $group['icon_class'] }}"></i>
                        {{ $group['label'] }}
                    </div>

                    @foreach($group['items'] as $idx => $faq)
                        @php $itemId = $group['id'] . '_' . $idx; @endphp
                        <div class="faq-item" id="faq-{{ $itemId }}" data-category="{{ $group['id'] }}">
                            <button
                                class="faq-question"
                                onclick="toggleFaq('{{ $itemId }}')"
                                aria-expanded="false"
                            >
                                <span>{{ $faq['q'] }}</span>
                                <span class="faq-icon">+</span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">{!! $faq['a'] !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>{{-- /.faq-content --}}
    </div>{{-- /.faq-inner --}}
</section>

{{-- ══════════════════════════════════════════
     CTA
══════════════════════════════════════════ --}}
<section class="faq-cta-section">
    <div class="faq-cta-card">
        <div class="faq-cta-left">
            <div class="faq-cta-eyebrow">
                <i class="fa-solid fa-headset" style="margin-right:5px;"></i>
                Masih Ada Pertanyaan?
            </div>
            <h2 class="faq-cta-title">
                Tim kami siap<br><em>membantu kamu</em>
            </h2>
            <p class="faq-cta-desc">
                Tidak menemukan jawaban yang kamu cari? Hubungi tim support kami yang responsif — biasanya membalas dalam kurang dari 2 jam.
            </p>
        </div>
        <div class="faq-cta-buttons">
            <a href="{{ route('contact') }}" class="btn-faq-primary">
                <i class="fa-solid fa-envelope"></i>
                Email Support
            </a>
            <a href="#" class="btn-faq-ghost">
                <i class="fa-brands fa-whatsapp"></i>
                WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
/* ── Toggle accordion ── */
function toggleFaq(id) {
    var item = document.getElementById('faq-' + id);
    if (!item) return;
    var isActive = item.classList.contains('active');

    // Close all
    document.querySelectorAll('.faq-item.active').forEach(function(el) {
        el.classList.remove('active');
        el.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
    });

    // Open clicked if it was closed
    if (!isActive) {
        item.classList.add('active');
        item.querySelector('.faq-question').setAttribute('aria-expanded', 'true');
        // Smooth scroll into view on mobile
        if (window.innerWidth < 860) {
            setTimeout(function() {
                item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 50);
        }
    }
}

/* ── Category filter ── */
function filterCategory(cat, btn) {
    // Update active button
    document.querySelectorAll('.faq-cat-btn').forEach(function(b) {
        b.classList.remove('active');
    });
    btn.classList.add('active');

    // Show/hide groups
    document.querySelectorAll('.faq-group').forEach(function(group) {
        if (cat === 'all' || group.dataset.category === cat) {
            group.style.display = '';
        } else {
            group.style.display = 'none';
        }
    });

    // Reset search
    var searchInput = document.getElementById('faqSearch');
    if (searchInput) { searchInput.value = ''; }
    document.getElementById('searchClear').classList.remove('visible');
    document.getElementById('noResults').classList.remove('visible');
}

/* ── Search ── */
function searchFaq(query) {
    var q = query.trim().toLowerCase();
    var clearBtn = document.getElementById('searchClear');
    var noResults = document.getElementById('noResults');
    var found = 0;

    clearBtn.classList.toggle('visible', q.length > 0);

    // Reset category filter UI
    document.querySelectorAll('.faq-cat-btn').forEach(function(b) { b.classList.remove('active'); });
    document.querySelector('.faq-cat-btn').classList.add('active'); // "Semua"

    document.querySelectorAll('.faq-group').forEach(function(group) {
        var groupVisible = false;
        group.style.display = '';

        group.querySelectorAll('.faq-item').forEach(function(item) {
            if (!q) {
                item.style.display = '';
                groupVisible = true;
                found++;
                return;
            }
            var text = item.innerText.toLowerCase();
            if (text.includes(q)) {
                item.style.display = '';
                groupVisible = true;
                found++;
                // Auto-open matching item
                if (!item.classList.contains('active')) {
                    item.classList.add('active');
                }
            } else {
                item.style.display = 'none';
                item.classList.remove('active');
            }
        });

        group.style.display = groupVisible ? '' : 'none';
    });

    noResults.classList.toggle('visible', found === 0 && q.length > 0);
}

function clearSearch() {
    var input = document.getElementById('faqSearch');
    input.value = '';
    searchFaq('');
    input.focus();
}
</script>
@endpush