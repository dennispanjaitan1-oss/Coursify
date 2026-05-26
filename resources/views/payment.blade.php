@php
    $currency = $course->currency ?: 'IDR';
    $fmt = fn ($amount) => $currency === 'USD'
        ? '$' . number_format((float) $amount, 2)
        : 'Rp ' . number_format((float) $amount, 0, ',', '.');
    $institutionName = $course->institution?->name ?: 'Coursify Partner';
    $institutionLogo = $course->institution?->logo_url ?: $course->thumbnail_url;
    $logoSrc = $institutionLogo
        ? (Str::startsWith($institutionLogo, ['http://', 'https://']) ? $institutionLogo : asset($institutionLogo))
        : asset('images/logo.png');
    $enrolledCount = number_format(($course->enrollments_count ?? 0) + 676730);
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Coursify</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <style>
        :root {
            --navy:#153759; --navy-dark:#0F2744; --lav-1:#F5F1FC; --lav-2:#E8E1F3;
            --lav-3:#D4CDF0; --purple:#7B6FE8; --purple-dark:#5B4FD4; --teal:#00C896;
            --orange:#E43D00; --text:#1A1825; --text-soft:#4A4660; --muted:#8B87A8;
            --font-serif:'Instrument Serif', serif; --font-sans:'Inter', sans-serif;
        }
        * { box-sizing:border-box; }
        body {
            margin:0; min-height:100vh; font-family:var(--font-sans); color:var(--text);
            background:
                linear-gradient(90deg, rgba(255,255,255,.72) 0%, rgba(255,255,255,.72) 63%, rgba(245,241,252,.76) 63%),
                linear-gradient(180deg,#EDE5F9 0%,#D8CEEE 54%,#C4B8E8 100%);
            -webkit-font-smoothing:antialiased; overflow-x:hidden;
        }
        body::before {
            content:""; position:fixed; inset:0; pointer-events:none;
            background:
                radial-gradient(760px 360px at 16% 8%, rgba(255,255,255,.65), transparent),
                radial-gradient(540px 280px at 82% 22%, rgba(255,255,255,.46), transparent),
                radial-gradient(600px 320px at 46% 92%, rgba(255,255,255,.28), transparent);
        }
        a { color:inherit; }
        .checkout-shell {
            position:relative; z-index:1; width:min(1180px,calc(100% - 40px)); margin:0 auto;
            display:grid; grid-template-columns:minmax(0,1fr) 400px; gap:54px; padding:34px 0 56px;
        }
        .brand-link { display:inline-flex; align-items:center; gap:10px; color:var(--purple-dark); text-decoration:none; font-weight:800; margin-bottom:14px; }
        .brand-link img { width:32px; height:32px; border-radius:9px; object-fit:cover; box-shadow:0 10px 26px rgba(30,58,95,.18); }
        h1 { margin:0 0 30px; color:#073B3F; font-size:clamp(44px,6vw,64px); line-height:.92; font-weight:800; letter-spacing:0; }
        .steps { display:grid; grid-template-columns:auto minmax(80px,150px) auto minmax(80px,150px) auto; align-items:center; gap:10px; margin:0 0 34px 72px; max-width:660px; }
        .step { display:inline-flex; align-items:center; gap:10px; color:#073B3F; font-size:20px; white-space:nowrap; }
        .step-number { width:28px; height:28px; border-radius:50%; display:grid; place-items:center; background:#073B3F; color:white; font-size:12px; font-weight:800; box-shadow:0 8px 20px rgba(7,59,63,.18); }
        .step.disabled { color:#AEB8BB; } .step.disabled .step-number { background:#C7D0D2; box-shadow:none; }
        .step-line { height:4px; border-radius:999px; background:#073B3F; } .step-line.muted { background:#C7D0D2; }
        .form-block { margin-top:34px; }
        .section-title { margin:0 0 22px; color:#073B3F; font-size:17px; font-weight:800; }
        .field-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:20px; }
        .field { display:flex; flex-direction:column; gap:8px; }
        label { color:#24242D; font-size:15px; font-weight:800; }
        input, select {
            width:100%; height:50px; border:1px solid rgba(30,58,95,.18); border-radius:10px;
            background:rgba(255,255,255,.70); backdrop-filter:blur(16px); padding:0 16px;
            color:var(--text); font:500 16px var(--font-sans); outline:none;
            box-shadow:inset 0 1px 0 rgba(255,255,255,.7); transition:.18s ease;
        }
        input:focus, select:focus { border-color:var(--purple); box-shadow:0 0 0 4px rgba(123,111,232,.13), inset 0 1px 0 rgba(255,255,255,.8); background:white; }
        .secure-title { display:inline-flex; align-items:center; gap:9px; color:#07845F; font-size:17px; margin:0 0 18px; font-weight:800; }
        .card-row { display:grid; grid-template-columns:minmax(260px,1fr) 206px 206px; gap:12px; align-items:end; }
        .card-input-wrap, .cvc-wrap { position:relative; } .card-input-wrap input { padding-right:166px; } .cvc-wrap input { padding-right:54px; }
        .card-icons { position:absolute; right:10px; top:50%; transform:translateY(-50%); display:flex; gap:4px; pointer-events:none; }
        .card-icon { min-width:34px; height:23px; border-radius:5px; display:grid; place-items:center; color:#fff; font-size:9px; font-weight:800; }
        .visa{background:#1558A8}.mc{background:linear-gradient(90deg,#EA001B 0 48%,#F79E1B 48%)}.jcb{background:#0C8A57}.amex{background:#4A9CCA}
        .cvc-badge { position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#7F8990; font-size:22px; }
        .buy-row { display:flex; justify-content:flex-end; margin-top:38px; }
        .buy-btn {
            width:min(430px,100%); height:58px; border:0; border-radius:999px; cursor:pointer;
            background:linear-gradient(135deg,var(--orange),#C93500); color:white; font:800 20px var(--font-sans);
            box-shadow:0 20px 42px rgba(228,61,0,.22); transition:.2s ease;
        }
        .buy-btn:hover { transform:translateY(-2px); box-shadow:0 26px 54px rgba(228,61,0,.30); }
        .error-list { margin:0 0 24px; padding:14px 16px; border:1px solid #F2B7B7; background:#FFF5F5; border-radius:12px; color:#9B1C1C; line-height:1.7; }
        .summary-column { padding-top:18px; }
        .cart-card, .coupon-card {
            background:rgba(255,255,255,.72); backdrop-filter:blur(28px) saturate(170%);
            border:1px solid rgba(255,255,255,.92); border-radius:14px; box-shadow:0 22px 70px rgba(30,58,95,.12); overflow:hidden;
        }
        .cart-card { padding:18px; }
        .cart-head { display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:30px; padding-bottom:28px; border-bottom:1px solid rgba(30,58,95,.10); }
        .cart-head h2 { margin:0; color:#073B3F; font-size:20px; font-weight:800; }
        .enrolled-pill { display:inline-flex; align-items:center; gap:7px; border:1px solid #00866B; background:#C9F2EA; color:#073B3F; border-radius:7px; padding:8px 10px; font-size:12px; font-weight:800; white-space:nowrap; }
        .course-line { display:grid; grid-template-columns:172px 1fr; gap:28px; padding-bottom:32px; border-bottom:1px solid rgba(30,58,95,.10); }
        .course-logo { height:88px; border:1px solid rgba(30,58,95,.10); background:rgba(255,255,255,.46); border-radius:8px; display:flex; align-items:center; justify-content:center; padding:12px; overflow:hidden; }
        .course-logo img { max-width:100%; max-height:100%; object-fit:contain; }
        .course-title { margin:2px 0 12px; color:#33343C; font-size:18px; line-height:1.38; font-weight:800; }
        .certificate-badge { display:inline-flex; align-items:center; gap:7px; background:#164E43; color:#fff; border-radius:6px; padding:8px 10px; font-size:12px; font-weight:800; }
        .price-line { display:flex; align-items:center; justify-content:space-between; gap:18px; padding-top:20px; font-size:16px; }
        .currency-link { margin-left:auto; color:#1A6A68; font-size:14px; text-decoration:underline; }
        .coupon-card { margin-top:32px; } .coupon-top { height:46px; background:#073B3F; }
        .coupon-body { padding:18px; } .coupon-title { margin:0 0 16px; font-size:17px; font-weight:800; }
        .coupon-row { display:grid; grid-template-columns:1fr 92px; gap:12px; padding-bottom:18px; border-bottom:1px solid rgba(30,58,95,.10); }
        .apply-btn { border:0; border-radius:999px; background:#9AA9AD; color:#fff; font:800 18px var(--font-sans); cursor:pointer; transition:.18s; }
        .apply-btn.active { background:var(--purple-dark); } .apply-btn:hover { transform:translateY(-1px); }
        .discount-row, .total-row { display:flex; align-items:center; justify-content:space-between; gap:14px; padding-top:18px; }
        .discount-row { display:none; color:#13865C; font-size:14px; font-weight:800; } .total-row { font-size:18px; } .total-row strong { font-size:20px; }
        .fine-print { color:var(--muted); font-size:12px; line-height:1.7; margin:18px 0 0; }
        @media (max-width:980px){ body{background:linear-gradient(180deg,#EDE5F9,#D8CEEE 54%,#C4B8E8)} .checkout-shell{grid-template-columns:1fr;gap:34px;width:min(720px,calc(100% - 28px))}.summary-column{padding-top:0}.steps{margin-left:0}.card-row{grid-template-columns:1fr} }
        @media (max-width:620px){ .field-grid,.course-line,.coupon-row{grid-template-columns:1fr}.steps{grid-template-columns:auto 1fr auto 1fr auto}.step span:last-child{display:none}.card-input-wrap input{padding-right:16px}.card-icons{position:static;transform:none;margin-top:8px} }
    </style>
</head>
<body>
    <main class="checkout-shell">
        <section>
            <a class="brand-link" href="{{ route('courses.show', $course) }}">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify">
                Back to course
            </a>

            <h1>Checkout</h1>

            <div class="steps" aria-label="Checkout steps">
                <div class="step"><span class="step-number">1</span><span>Course</span></div>
                <div class="step-line"></div>
                <div class="step"><span class="step-number">2</span><span>Payment</span></div>
                <div class="step-line muted"></div>
                <div class="step disabled"><span class="step-number">3</span><span>Confirmation</span></div>
            </div>

            @if (isset($errors) && $errors->any())
                <div class="error-list">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('payment.store') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="track" value="{{ $track }}">

                <div class="form-block" style="margin-top:0;">
                    <h2 class="section-title">Billing information</h2>
                    <div class="field-grid">
                        <div class="field">
                            <label for="first_name">First name (required)</label>
                            <input id="first_name" name="first_name" value="{{ old('first_name', Str::before(auth()->user()->name, ' ')) }}" required autocomplete="given-name">
                        </div>
                        <div class="field">
                            <label for="last_name">Last name (required)</label>
                            <input id="last_name" name="last_name" value="{{ old('last_name', Str::after(auth()->user()->name, ' ')) }}" required autocomplete="family-name">
                        </div>
                    </div>
                    <div class="field" style="max-width:420px;">
                        <label for="country">Country (required)</label>
                        <select id="country" name="country" required>
                            <option value="">Choose country</option>
                            @foreach (['Indonesia', 'Singapore', 'Malaysia', 'United States', 'Australia', 'United Kingdom'] as $country)
                                <option value="{{ $country }}" @selected(old('country', 'Indonesia') === $country)>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-block">
                    <h2 class="section-title" style="font-size:24px;">Payment methods</h2>
                    <div class="secure-title">
                        <i class="fa-solid fa-lock"></i>
                        <span>Secure {{ $currency === 'USD' ? 'US Dollar' : 'Indonesian Rupiah' }} Checkout</span>
                    </div>

                    <div class="card-row">
                        <div class="field">
                            <label for="card_number">Card number</label>
                            <div class="card-input-wrap">
                                <input id="card_number" name="card_number" inputmode="numeric" placeholder="1234 1234 1234 1234" value="{{ old('card_number') }}" required>
                                <div class="card-icons" aria-hidden="true">
                                    <span class="card-icon visa">VISA</span><span class="card-icon mc">MC</span><span class="card-icon jcb">JCB</span><span class="card-icon amex">AMEX</span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="card_expiry">Expiration date</label>
                            <input id="card_expiry" name="card_expiry" inputmode="numeric" placeholder="MM / YY" value="{{ old('card_expiry') }}" required>
                        </div>
                        <div class="field">
                            <label for="card_cvc">Security code</label>
                            <div class="cvc-wrap">
                                <input id="card_cvc" name="card_cvc" inputmode="numeric" placeholder="CVC" value="{{ old('card_cvc') }}" required>
                                <i class="fa-regular fa-credit-card cvc-badge"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buy-row">
                    <button type="submit" class="buy-btn">Buy Now</button>
                </div>
            </form>
        </section>

        <aside class="summary-column">
            <div class="cart-card">
                <div class="cart-head">
                    <h2>In your cart</h2>
                    <span class="enrolled-pill"><i class="fa-solid fa-user-group"></i>{{ $enrolledCount }} already enrolled</span>
                </div>

                <div class="course-line">
                    <div class="course-logo"><img src="{{ $logoSrc }}" alt="{{ $institutionName }}"></div>
                    <div>
                        <h3 class="course-title">{{ $institutionName }}:<br>{{ $course->title }}</h3>
                        <span class="certificate-badge"><i class="fa-solid fa-certificate"></i>Verified certificate</span>
                    </div>
                </div>

                <div class="price-line">
                    <span>Price</span>
                    <a class="currency-link" href="{{ route('courses.show', $course) }}">View course details</a>
                    <strong>{{ $fmt($price) }}</strong>
                </div>
            </div>

            <div class="coupon-card">
                <div class="coupon-top"></div>
                <div class="coupon-body">
                    <p class="coupon-title">Add coupon code (optional)</p>
                    <div class="coupon-row">
                        <input form="paymentForm" type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code') }}">
                        <button type="button" class="apply-btn" id="applyCoupon">Apply</button>
                    </div>
                    <div class="discount-row" id="discountRow">
                        <span>Coupon COURSIFY10</span>
                        <span id="discountValue">-</span>
                    </div>
                    <div class="total-row">
                        <strong>Today's total</strong>
                        <span id="todayTotal">{{ $fmt($price) }}</span>
                    </div>
                    <p class="fine-print">This checkout records the payment directly in Coursify and activates your course access immediately.</p>
                </div>
            </div>
        </aside>
    </main>

    <script>
        const basePrice = Number(@json((float) $price));
        const currency = @json($currency);
        const coupon = document.getElementById('coupon_code');
        const apply = document.getElementById('applyCoupon');
        const discountRow = document.getElementById('discountRow');
        const discountValue = document.getElementById('discountValue');
        const todayTotal = document.getElementById('todayTotal');
        const cardNumber = document.getElementById('card_number');
        const cardExpiry = document.getElementById('card_expiry');
        const cardCvc = document.getElementById('card_cvc');
        function money(amount) {
            return currency === 'USD'
                ? '$' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                : 'Rp ' + amount.toLocaleString('id-ID', { maximumFractionDigits: 0 });
        }
        function refreshCoupon() {
            const active = coupon.value.trim().toUpperCase() === 'COURSIFY10';
            const discount = active ? Math.round(basePrice * .1) : 0;
            discountRow.style.display = active ? 'flex' : 'none';
            discountValue.textContent = '-' + money(discount);
            todayTotal.textContent = money(Math.max(0, basePrice - discount));
            apply.classList.toggle('active', active);
        }
        apply.addEventListener('click', refreshCoupon);
        coupon.addEventListener('input', () => { if (!coupon.value.trim()) refreshCoupon(); });
        cardNumber.addEventListener('input', () => {
            const digits = cardNumber.value.replace(/\D/g, '').slice(0, 19);
            cardNumber.value = digits.replace(/(.{4})/g, '$1 ').trim();
        });
        cardExpiry.addEventListener('input', () => {
            let digits = cardExpiry.value.replace(/\D/g, '').slice(0, 4);
            if (digits.length > 2) digits = digits.slice(0, 2) + '/' + digits.slice(2);
            cardExpiry.value = digits;
        });
        cardCvc.addEventListener('input', () => {
            cardCvc.value = cardCvc.value.replace(/\D/g, '').slice(0, 4);
        });
        refreshCoupon();
    </script>
</body>
</html>
