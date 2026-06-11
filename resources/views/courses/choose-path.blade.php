@php
    $auditEnds = now()->addWeeks((int) ($course->audit_access_weeks ?: 6))->translatedFormat('d F Y');
    $certPrice = $course->hasCertificatePrice() ? $course->certificate_price : 499000;
    $fmt = fn ($amount) => 'Rp ' . number_format((float) $amount, 0, ',', '.');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jalur Belajar — Coursify</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <style>
        :root {
            --navy:#153759; --purple:#7B6FE8; --purple-dark:#5B4FD4;
            --teal:#00C896; --orange:#E43D00; --text:#1A1825; --text-soft:#4A4660; --muted:#8B87A8;
            --font-serif:'Instrument Serif', serif; --font-sans:'Inter', sans-serif;
        }
        * { box-sizing:border-box; }
        body {
            margin:0; font-family:var(--font-sans); color:var(--text);
            background:linear-gradient(180deg,#EDE5F9 0%,#D8CEEE 54%,#C4B8E8 100%);
            min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px;
        }
        body::before {
            content:""; position:fixed; inset:0; pointer-events:none;
            background:
                radial-gradient(700px 360px at 16% 10%,rgba(255,255,255,.62),transparent),
                radial-gradient(560px 300px at 84% 24%,rgba(255,255,255,.46),transparent),
                radial-gradient(520px 300px at 50% 90%,rgba(255,255,255,.32),transparent);
        }
        .container {
            position:relative; z-index:1;
            width:min(960px,100%); background:rgba(255,255,255,.75);
            backdrop-filter:blur(28px) saturate(170%);
            border:1px solid rgba(255,255,255,.92);
            border-radius:24px; box-shadow:0 30px 90px rgba(30,58,95,.18);
            overflow:hidden;
        }
        .header {
            padding:28px 32px 20px;
            border-bottom:1px solid rgba(30,58,95,.08);
            display:flex; align-items:center; gap:14px; flex-wrap:wrap;
        }
        .header a {
            display:inline-flex; align-items:center; gap:8px;
            color:var(--purple-dark); text-decoration:none; font-weight:700; font-size:14px;
        }
        .header a:hover { opacity:.7; }
        .header a img { width:28px; height:28px; border-radius:7px; object-fit:cover; }
        .header h1 {
            margin:0; font-size:20px; font-weight:800; color:var(--text); flex:1;
        }

        /* ── Comparison Table ── */
        .compare {
            display:grid; grid-template-columns:1fr 1fr;
            padding:0;
        }
        .compare-col {
            padding:32px 28px;
            display:flex; flex-direction:column; gap:0;
        }
        .compare-col:first-child {
            border-right:1px solid rgba(30,58,95,.08);
            background:rgba(255,255,255,.3);
        }
        .compare-col--premium {
            background:rgba(99,102,241,.04);
        }

        /* Badge header */
        .compare-badge {
            display:inline-flex; align-items:center; gap:7px;
            padding:6px 14px; border-radius:100px;
            font-size:12px; font-weight:700; letter-spacing:0.03em;
            margin-bottom:16px; width:fit-content;
        }
        .compare-badge--audit {
            background:#f3f4f6; color:#6b7280; border:1px solid #e5e7eb;
        }
        .compare-badge--cert {
            background:#1e3a5f; color:#fff;
        }

        /* Title */
        .compare-title {
            font-size:24px; font-weight:800; color:var(--text);
            margin:0 0 4px; letter-spacing:-0.02em;
        }
        .compare-sub {
            font-size:13px; color:var(--muted); margin:0 0 20px;
        }

        /* Price */
        .compare-price {
            font-size:28px; font-weight:800; color:var(--navy);
            letter-spacing:-0.02em; margin:0 0 20px; padding-bottom:20px;
            border-bottom:1px solid rgba(30,58,95,.08);
        }
        .compare-price small {
            font-size:14px; font-weight:500; color:var(--muted);
        }
        .compare-price--free { color:var(--teal); }

        /* Certificate preview */
        .cert-preview {
            border-radius:10px; overflow:hidden;
            border:1px solid rgba(30,58,95,.10);
            margin-bottom:20px; position:relative;
        }
        .cert-preview img {
            width:100%; display:block; max-height:120px;
            object-fit:cover; object-position:top;
        }
        .cert-badge {
            position:absolute; bottom:8px; right:8px;
            background:var(--purple); color:#fff;
            font-size:10px; font-weight:700; padding:3px 10px;
            border-radius:20px;
        }
        .cert-fallback {
            height:100px; display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg,#1e3a5f,#2d5986);
            color:#fff; font-weight:700; font-style:italic; font-size:13px;
        }

        /* Feature list */
        .compare-features {
            list-style:none; margin:0 0 auto; padding:0;
            display:flex; flex-direction:column; gap:10px;
        }
        .compare-features li {
            font-size:13px; color:#374151; line-height:1.45;
            display:flex; align-items:flex-start; gap:10px;
        }
        .cf-check { color:#16a34a; font-size:13px; flex-shrink:0; margin-top:2px; }
        .cf-times { color:#dc2626; font-size:13px; flex-shrink:0; margin-top:2px; }

        /* CTA */
        .compare-action { margin-top:24px; }
        .compare-btn {
            display:block; width:100%; text-align:center;
            padding:13px; border-radius:100px;
            font-size:15px; font-weight:700; text-decoration:none;
            transition:all .2s; cursor:pointer; border:none; font-family:var(--font-sans);
        }
        .compare-btn--primary {
            background:linear-gradient(135deg,var(--purple),var(--purple-dark));
            color:#fff; box-shadow:0 8px 24px rgba(123,111,232,.28);
        }
        .compare-btn--primary:hover {
            transform:translateY(-2px);
            box-shadow:0 12px 32px rgba(91,79,212,.35);
        }
        .compare-btn--outline {
            background:transparent; color:var(--purple);
            border:2px solid var(--purple);
        }
        .compare-btn--outline:hover { background:#f5f3ff; }
        form.lp-form { margin:0; }

        /* Cert note */
        .cert-note {
            font-size:11px; color:var(--muted); line-height:1.6;
            margin:16px 0 0; padding-top:16px;
            border-top:1px solid rgba(30,58,95,.08);
        }

        @media (max-width:700px) {
            .compare { grid-template-columns:1fr; }
            .compare-col:first-child {
                border-right:none;
                border-bottom:1px solid rgba(30,58,95,.08);
            }
            .header { flex-direction:column; align-items:flex-start; }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="header">
            <a href="{{ route('courses.show', $course) }}">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <h1>Pilih Jalur Belajar</h1>
        </div>

        <div class="compare">
            {{-- ═══ KIRI — AUDIT ═══ --}}
            <div class="compare-col">
                <div class="compare-badge compare-badge--audit">
                    <i class="fa-solid fa-circle-xmark"></i> Tanpa Sertifikat
                </div>
                <h2 class="compare-title">Audit Course</h2>
                <p class="compare-sub">Akses terbatas, tanpa sertifikat</p>

                <div class="compare-price compare-price--free">Gratis <small>(Rp 0)</small></div>

                <ul class="compare-features">
                    <li><i class="fa-solid fa-check cf-check"></i> Akses materi non-nilai (video & bacaan)</li>
                    <li><i class="fa-solid fa-xmark cf-times"></i> <strong>Tidak</strong> mendapat sertifikat kelulusan</li>
                    <li><i class="fa-solid fa-xmark cf-times"></i> <strong>Tidak</strong> bisa akses tugas bernilai</li>
                    <li><i class="fa-solid fa-xmark cf-times"></i> Akses berakhir pada {{ $auditEnds }}</li>
                </ul>

                <div class="compare-action">
                    <form class="lp-form" method="POST" action="{{ route('enroll', $course) }}">
                        @csrf
                        <input type="hidden" name="track" value="audit">
                        <button class="compare-btn compare-btn--outline" type="submit">
                            <i class="fa-solid fa-play"></i> Audit Gratis
                        </button>
                    </form>
                </div>
            </div>

            {{-- ═══ KANAN — CERTIFICATE ═══ --}}
            <div class="compare-col compare-col--premium">
                <div class="compare-badge compare-badge--cert">
                    <i class="fa-solid fa-certificate"></i> Bersertifikat
                </div>
                <h2 class="compare-title">Jalur Tersertifikasi</h2>
                <p class="compare-sub">Akses penuh + sertifikat resmi</p>

                <div class="cert-preview">
                    <img src="{{ asset('images/certificate-preview.jpg') }}"
                         alt="Contoh Sertifikat"
                         onerror="this.closest('.cert-preview').innerHTML='<div class=\'cert-fallback\'><i class=\'fa-solid fa-certificate\'></i> Certificate of Completion</div>'">
                    <div class="cert-badge"><i class="fa-solid fa-certificate"></i> Verified</div>
                </div>

                <div class="compare-price">{{ $fmt($certPrice) }}</div>

                <ul class="compare-features">
                    <li><i class="fa-solid fa-check cf-check"></i> Akses penuh & seumur hidup ke semua materi</li>
                    <li><i class="fa-solid fa-check cf-check"></i> Tugas bernilai & dinilai</li>
                    <li><i class="fa-solid fa-check cf-check"></i> Dapatkan sertifikat resmi Coursify</li>
                    <li><i class="fa-solid fa-check cf-check"></i> Bukukan prestasi & tingkatkan karir</li>
                </ul>

                <div class="compare-action">
                    <a href="{{ route('payment.index', ['course' => $course->id, 'track' => 'verified']) }}"
                       class="compare-btn compare-btn--primary">
                        <i class="fa-solid fa-certificate"></i> Ambil Sertifikat
                    </a>
                </div>

                <p class="cert-note">
                    <i class="fa-solid fa-shield-halved"></i> Pembayaran aman. Garansi uang kembali 30 hari.
                </p>
            </div>
        </div>
    </main>
</body>
</html>
