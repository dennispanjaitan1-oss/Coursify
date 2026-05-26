@php
    $currency = $payment->currency ?: 'IDR';
    $fmt = fn ($amount) => $currency === 'USD'
        ? '$' . number_format((float) $amount, 2)
        : 'Rp ' . number_format((float) $amount, 0, ',', '.');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Coursify</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <style>
        :root{--navy:#153759;--purple:#7B6FE8;--purple-dark:#5B4FD4;--teal:#00C896;--orange:#E43D00;--text:#1A1825;--muted:#8B87A8;--font-serif:'Instrument Serif',serif;--font-sans:'Inter',sans-serif;}
        *{box-sizing:border-box} body{margin:0;min-height:100vh;font-family:var(--font-sans);color:var(--text);background:linear-gradient(180deg,#EDE5F9,#D8CEEE 54%,#C4B8E8);display:flex;align-items:center;justify-content:center;padding:28px}
        body:before{content:"";position:fixed;inset:0;background:radial-gradient(720px 360px at 18% 15%,rgba(255,255,255,.62),transparent),radial-gradient(560px 300px at 82% 22%,rgba(255,255,255,.42),transparent);pointer-events:none}
        .card{position:relative;z-index:1;width:min(920px,100%);background:rgba(255,255,255,.76);border:1px solid rgba(255,255,255,.92);border-radius:24px;box-shadow:0 30px 90px rgba(30,58,95,.18);backdrop-filter:blur(28px) saturate(170%);overflow:hidden}
        .top{padding:28px 34px;border-bottom:1px solid rgba(30,58,95,.08);display:flex;justify-content:space-between;gap:24px;align-items:center;flex-wrap:wrap}
        .brand{display:flex;align-items:center;gap:12px;font-weight:800;color:var(--purple-dark)} .brand img{width:36px;height:36px;border-radius:10px}
        .steps{display:grid;grid-template-columns:auto 80px auto 80px auto;align-items:center;gap:10px;color:#073B3F}.step{display:flex;align-items:center;gap:8px;font-weight:700}.num{width:26px;height:26px;border-radius:50%;display:grid;place-items:center;background:#073B3F;color:white;font-size:12px}.line{height:4px;background:#073B3F}.step.active .num{background:var(--teal)} 
        .body{padding:46px 42px;display:grid;grid-template-columns:1fr 330px;gap:36px}
        .success{width:76px;height:76px;border-radius:50%;display:grid;place-items:center;background:linear-gradient(135deg,var(--teal),#00A075);color:white;font-size:34px;box-shadow:0 16px 38px rgba(0,200,150,.28);margin-bottom:22px}
        h1{margin:0 0 14px;color:#073B3F;font-size:clamp(38px,6vw,62px);line-height:.95;font-weight:800}
        p{margin:0;color:#4A4660;line-height:1.7}.actions{display:flex;gap:12px;margin-top:30px;flex-wrap:wrap}.btn{height:48px;padding:0 22px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-weight:800}.primary{background:var(--orange);color:white;box-shadow:0 16px 34px rgba(228,61,0,.20)}.secondary{background:white;color:var(--purple-dark);border:1px solid rgba(123,111,232,.24)}
        .receipt{background:rgba(255,255,255,.62);border:1px solid rgba(255,255,255,.95);border-radius:18px;padding:22px;box-shadow:inset 0 1px 0 rgba(255,255,255,.7)}.receipt h2{margin:0 0 18px;color:#073B3F;font-size:18px}.row{display:flex;justify-content:space-between;gap:16px;padding:12px 0;border-bottom:1px solid rgba(30,58,95,.08);font-size:14px}.row:last-child{border:0}.label{color:var(--muted)}.value{font-weight:800;text-align:right}.total{font-size:18px;color:#073B3F}
        @media(max-width:820px){.body{grid-template-columns:1fr}.steps{grid-template-columns:auto 32px auto 32px auto}.step span:last-child{display:none}}
    </style>
</head>
<body>
    <main class="card">
        <div class="top">
            <div class="brand"><img src="{{ asset('images/logo.png') }}" alt="Coursify"> Coursify Checkout</div>
            <div class="steps" aria-label="Checkout steps">
                <div class="step"><span class="num">1</span><span>Course</span></div><div class="line"></div>
                <div class="step"><span class="num">2</span><span>Payment</span></div><div class="line"></div>
                <div class="step active"><span class="num">3</span><span>Confirmation</span></div>
            </div>
        </div>
        <div class="body">
            <section>
                <div class="success"><i class="fa-solid fa-check"></i></div>
                <h1>You're enrolled.</h1>
                <p>Pembayaran berhasil dan akses Verified untuk <strong>{{ $course->title }}</strong> sudah aktif. Kamu bisa langsung mulai belajar dan sertifikat akan tersedia setelah course selesai.</p>
                <div class="actions">
                    <a class="btn primary" href="{{ route('student.learn', $course->slug) }}">Start learning</a>
                    <a class="btn secondary" href="{{ route('student.courses') }}">My courses</a>
                </div>
            </section>
            <aside class="receipt">
                <h2>Order confirmation</h2>
                <div class="row"><span class="label">Order number</span><span class="value">{{ $payment->transaction_id }}</span></div>
                <div class="row"><span class="label">Course</span><span class="value">{{ Str::limit($course->title, 48) }}</span></div>
                <div class="row"><span class="label">Learner</span><span class="value">{{ $payment->first_name }} {{ $payment->last_name }}</span></div>
                <div class="row"><span class="label">Method</span><span class="value">{{ strtoupper($payment->card_brand ?? 'CARD') }} **** {{ $payment->card_last4 }}</span></div>
                @if($payment->discount_amount > 0)
                    <div class="row"><span class="label">Discount</span><span class="value">-{{ $fmt($payment->discount_amount) }}</span></div>
                @endif
                <div class="row total"><span class="label">Total paid</span><span class="value">{{ $fmt($payment->amount) }}</span></div>
            </aside>
        </div>
    </main>
</body>
</html>
