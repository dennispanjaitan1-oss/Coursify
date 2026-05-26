@php
    $currency = $course->currency ?: 'IDR';
    $fmt = fn ($amount) => $currency === 'USD'
        ? '$' . number_format((float) $amount, 2)
        : 'Rp ' . number_format((float) $amount, 0, ',', '.');
    $auditEnds = now()->addWeeks($course->audit_access_weeks ?: 6)->translatedFormat('d F Y');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose your learning path - Coursify</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <style>
        :root {
            --navy:#153759; --navy-dark:#0F2744; --lav-1:#F5F1FC; --lav-2:#E8E1F3;
            --purple:#7B6FE8; --purple-dark:#5B4FD4; --teal:#00C896; --orange:#E43D00;
            --text:#1A1825; --text-soft:#4A4660; --muted:#8B87A8;
            --font-serif:'Instrument Serif', serif; --font-sans:'Inter', sans-serif;
        }
        * { box-sizing:border-box; }
        body {
            margin:0; font-family:var(--font-sans); color:var(--text);
            background:linear-gradient(180deg,#EDE5F9 0%,#D8CEEE 54%,#C4B8E8 100%);
            overflow-x:hidden;
        }
        body::before {
            content:""; position:fixed; inset:0; pointer-events:none;
            background:
                radial-gradient(700px 360px at 16% 10%,rgba(255,255,255,.62),transparent),
                radial-gradient(560px 300px at 84% 24%,rgba(255,255,255,.46),transparent),
                radial-gradient(520px 300px at 50% 90%,rgba(255,255,255,.32),transparent);
        }
        
        .back { position: absolute; top: 30px; left: 0; display:inline-flex; align-items:center; gap:10px; text-decoration:none; color:var(--purple-dark); font-weight:800; font-size: 15px; z-index: 10; }
        .back img { width:30px; height:30px; border-radius:8px; object-fit:cover; box-shadow:0 8px 22px rgba(30,58,95,.18); }

        /* ===== LEARNING PATH PAGE ===== */

        .lp-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 16px 40px;
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
        }

        /* Page title */
        .lp-page__title {
            font-size: clamp(22px, 3vw, 32px);
            font-weight: 800;
            color: #111;
            text-align: center;
            margin: 0 0 4px;
            letter-spacing: -0.02em;
        }

        .lp-page__subtitle {
            font-size: 15px;
            font-weight: 600;
            color: #444;
            text-align: center;
            margin: 0 0 24px;
        }

        /* Cards container */
        .lp-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            width: 100%;
            max-width: 780px;
        }

        /* Card base */
        .lp-card {
            background: #fff;
            border-radius: 16px;
            border: 1.5px solid rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .lp-card--premium {
            border-color: #6366f1;
            box-shadow: 0 4px 20px rgba(99,102,241,0.12);
        }

        /* Card header */
        .lp-card__header {
            padding: 10px 16px;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.04em;
        }

        .lp-card__header--dark {
            background: #1e3a5f;
            color: #fff;
        }

        .lp-card__header--light {
            background: #f3f4f6;
            color: #6b7280;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }

        /* Card body */
        .lp-card__body {
            padding: 14px 18px 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
            gap: 12px;
        }

        /* Certificate preview */
        .lp-cert-preview {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }

        .lp-cert-preview img {
            width: 100%;
            display: block;
            max-height: 130px;
            object-fit: cover;
            object-position: top;
        }

        .lp-cert-badge {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: #6366f1;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .lp-cert-fallback {
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a5f, #2d5986);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            font-style: italic;
        }

        /* Price */
        .lp-price__amount {
            font-size: 22px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.02em;
        }

        /* Feature list */
        .lp-features {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .lp-features li {
            font-size: 12.5px;
            color: #374151;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.4;
        }

        .lp-check--green { color: #16a34a; font-size: 12px; margin-top: 2px; flex-shrink: 0; }
        .lp-check--red   { color: #dc2626; font-size: 12px; margin-top: 2px; flex-shrink: 0; }

        /* Audit title */
        .lp-audit__title {
            font-size: 18px;
            font-weight: 800;
            color: #111;
            margin: 0;
        }

        .lp-audit__sub {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
        }

        .lp-audit__spacer {
            flex: 1;
        }

        /* CTA Buttons */
        .lp-btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }

        .lp-btn--primary {
            background: #6366f1;
            color: #fff;
        }

        .lp-btn--primary:hover {
            background: #4f46e5;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        }

        .lp-btn--outline {
            background: transparent;
            color: #6366f1;
            border: 2px solid #6366f1;
        }

        .lp-btn--outline:hover {
            background: #f5f3ff;
        }

        form.lp-btn-form {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .lp-cards {
                grid-template-columns: 1fr;
            }
            .back { position: static; margin-bottom: 20px; }
            .lp-page { padding-top: 40px; }
        }
    </style>
</head>
<body>
    <main class="lp-page">
        <a href="{{ route('courses.show', $course) }}" class="back">
            <img src="{{ asset('images/logo.png') }}" alt="Coursify">
            Back to course
        </a>

        <h1 class="lp-page__title">Choose your learning path</h1>
        <div class="lp-page__subtitle">{{ $course->title }}</div>

        <section class="lp-cards">
            <!-- Card Kiri — Certificate Track -->
            <div class="lp-card lp-card--premium">
                <div class="lp-card__header lp-card__header--dark">
                    <span>Course certificate track</span>
                </div>
                <div class="lp-card__body">
                    <div class="lp-cert-preview">
                        <img src="{{ asset('images/certificate-preview.jpg') }}"
                             alt="Contoh Sertifikat Coursify"
                             onerror="this.closest('.lp-cert-preview').innerHTML='<div class=\'lp-cert-fallback\'>Certificate of Completion</div>'">
                        <div class="lp-cert-badge">
                            <i class="fa-solid fa-certificate"></i> Verified
                        </div>
                    </div>

                    <div class="lp-price">
                        <span class="lp-price__amount">{{ $course->hasCertificatePrice() ? $fmt($course->certificate_price) : $fmt(499000) }}</span>
                    </div>

                    <ul class="lp-features">
                        <li><i class="fa-solid fa-check lp-check--green"></i> Unlimited access to course materials</li>
                        <li><i class="fa-solid fa-check lp-check--green"></i> Graded and non-graded assignments</li>
                        <li><i class="fa-solid fa-check lp-check--green"></i> Earn a verified certificate</li>
                        <li><i class="fa-solid fa-check lp-check--green"></i> Unlock career opportunities</li>
                    </ul>

                    <div class="lp-audit__spacer"></div>

                    <a href="{{ route('payment.index', ['course' => $course->id, 'track' => 'verified']) }}" class="lp-btn lp-btn--primary">
                        Earn a certificate
                    </a>
                </div>
            </div>

            <!-- Card Kanan — Audit -->
            <div class="lp-card lp-card--audit">
                <div class="lp-card__header lp-card__header--light">
                    <i class="fa-solid fa-circle-xmark"></i> No certificate
                </div>
                <div class="lp-card__body">
                    <h3 class="lp-audit__title">Audit this course</h3>
                    <p class="lp-audit__sub">No proof of completion</p>

                    <ul class="lp-features lp-features--audit">
                        <li><i class="fa-solid fa-check lp-check--green"></i> Access non-graded course materials, including videos and readings</li>
                        <li><i class="fa-solid fa-xmark lp-check--red"></i> You will <strong>not receive a certificate</strong> of completion</li>
                        <li><i class="fa-solid fa-xmark lp-check--red"></i> You will <strong>not be able to access graded</strong> course materials</li>
                        <li><i class="fa-solid fa-xmark lp-check--red"></i> Access will expire on {{ $auditEnds }}</li>
                    </ul>

                    <div class="lp-audit__spacer"></div>

                    <form class="lp-btn-form" method="POST" action="{{ route('enroll', $course) }}">
                        @csrf
                        <input type="hidden" name="track" value="audit">
                        <button class="lp-btn lp-btn--outline" type="submit">Audit</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
