<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — Coursify</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --navy:        #153759;
            --lav-1:       #F5F1FC;
            --lav-2:       #E8E1F3;
            --lav-3:       #D4CDF0;
            --lav-4:       #B8AFEB;
            --purple:      #7B6FE8;
            --purple-dark: #5B4FD4;
            --teal:        #00C896;
            --orange:      #FF8A5B;
            --text:        #1A1825;
            --text-soft:   #4A4660;
            --muted:       #8B87A8;
            --border:      rgba(30,58,95,0.1);
            --font-serif:  'Instrument Serif', serif;
            --font-sans:   'Inter', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-sans);
            background: #FEFDFF;
            color: var(--text);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══ LEFT PANEL ═══ */
        .left {
            width: 520px;
            flex-shrink: 0;
            background: white;
            display: flex;
            flex-direction: column;
            padding: 32px 48px;
            min-height: 100vh;
            position: relative;
            z-index: 2;
            overflow-y: auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 28px;
            transition: transform 0.2s;
        }
        .logo:hover { transform: translateY(-1px); }
        .logo-img {
            width: 36px; height: 36px;
            border-radius: 9px; object-fit: cover;
            box-shadow: 0 4px 12px rgba(30,58,95,0.2);
        }
        .logo-text { font-size: 20px; font-weight: 700; letter-spacing: -0.02em; color: var(--text); }

        .form-wrap { flex: 1; display: flex; flex-direction: column; max-width: 420px; }

        h1 {
            font-family: var(--font-serif);
            font-size: 36px; font-weight: 400;
            letter-spacing: -0.02em; line-height: 1.05;
            color: var(--text); margin-bottom: 8px;
        }
        h1 em { font-style: italic; color: var(--purple); }

        .subtitle {
            font-size: 14px; color: var(--muted);
            margin-bottom: 20px; line-height: 1.6;
        }
        .subtitle a { color: var(--purple); font-weight: 600; text-decoration: none; }
        .subtitle a:hover { color: var(--purple-dark); }

        /* ─── Benefits ─── */
        .benefits {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 8px 16px; margin-bottom: 20px;
            padding: 14px 16px;
            background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
            border: 1px solid rgba(123,111,232,0.12);
            border-radius: 14px;
        }
        .benefit-item {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: var(--text-soft); font-weight: 500;
        }
        .check-ic {
            width: 16px; height: 16px; border-radius: 50%;
            background: var(--teal); color: white;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 9px; font-weight: 700;
        }

        /* ─── Role Selector ─── */
        .role-section { margin-bottom: 16px; }
        .field-label-top {
            display: block; font-size: 13px; font-weight: 500;
            color: var(--text-soft); margin-bottom: 8px;
        }
        .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .role-card {
            padding: 12px 14px;
            border: 1.5px solid var(--border);
            border-radius: 14px; cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; gap: 10px;
            background: white;
        }
        .role-card:hover { border-color: var(--lav-4); background: var(--lav-1); }
        .role-card.selected {
            border-color: var(--purple);
            background: linear-gradient(135deg, var(--lav-1), rgba(123,111,232,0.05));
            box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
        }
        .role-card input[type=radio] { display: none; }
        .role-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--lav-2);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0; transition: all 0.2s;
            color: var(--purple);
        }
        .role-card.selected .role-icon { background: var(--purple); color: white; transform: scale(1.05); }
        .role-label { font-family: var(--font-serif); font-size: 15px; color: var(--text); letter-spacing: -0.01em; }
        .role-sub { font-size: 11px; color: var(--muted); margin-top: 1px; }

        /* ─── Fields ─── */
        .field { margin-bottom: 13px; }
        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-soft); margin-bottom: 5px; }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted); font-size: 14px; pointer-events: none;
            width: 16px; text-align: center;
        }
        .input-toggle {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: transparent; border: none;
            color: var(--muted); cursor: pointer;
            padding: 6px; font-size: 13px; transition: color 0.2s;
        }
        .input-toggle:hover { color: var(--purple); }

        input[type=email], input[type=password], input[type=text] {
            width: 100%;
            padding: 11px 16px 11px 42px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 14px; font-family: var(--font-sans);
            color: var(--text); background: #FAFAFB;
            outline: none; transition: all 0.2s;
        }
        input::placeholder { color: var(--muted); }
        input:focus {
            border-color: var(--purple); background: white;
            box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
        }
        input.error-input { border-color: var(--orange); background: rgba(255,138,91,0.03); }
        input.success-input { border-color: var(--teal); background: rgba(0,200,150,0.03); }

        .error-msg {
            font-size: 12px; color: var(--orange); margin-top: 4px;
            font-weight: 500; display: flex; align-items: center; gap: 4px;
        }

        /* ─── Password Strength ─── */
        .strength-bar {
            height: 4px; border-radius: 2px;
            background: #F0EEF5; margin-top: 7px; overflow: hidden;
        }
        .strength-fill { height: 100%; border-radius: 2px; transition: all 0.4s ease; width: 0%; }
        .strength-label { font-size: 11px; margin-top: 4px; color: var(--muted); font-weight: 500; }

        /* ─── Password Match ─── */
        .match-indicator {
            display: flex; align-items: center; gap: 6px;
            font-size: 11px; margin-top: 5px; font-weight: 500;
            transition: all 0.2s; height: 16px;
        }
        .match-indicator.match { color: var(--teal); }
        .match-indicator.no-match { color: var(--orange); }
        .match-indicator.empty { color: transparent; }

        /* ─── Terms ─── */
        .terms-check {
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 18px; font-size: 13px;
            color: var(--text-soft); line-height: 1.5;
        }
        .terms-check input {
            appearance: none; width: 16px; height: 16px;
            border: 1.5px solid var(--border); border-radius: 4px;
            background: white; cursor: pointer; position: relative;
            transition: all 0.2s; margin-top: 2px; flex-shrink: 0;
            padding: 0;
        }
        .terms-check input:checked { background: var(--purple); border-color: var(--purple); }
        .terms-check input:checked::after {
            content: '✓'; position: absolute;
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            color: white; font-size: 10px; font-weight: 700;
        }
        .terms-check a { color: var(--purple); text-decoration: none; font-weight: 500; }
        .terms-check a:hover { color: var(--purple-dark); text-decoration: underline; }

        /* ─── Submit Button ─── */
        .btn-submit {
            width: 100%; padding: 13px; border-radius: 100px;
            border: none; background: #1A1825; color: white;
            font-family: var(--font-sans); font-size: 14px; font-weight: 600;
            cursor: pointer; transition: all 0.25s; margin-bottom: 12px;
            box-shadow: 0 4px 14px rgba(26,24,37,0.3);
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover:not(:disabled) {
            background: #2A2840; transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26,24,37,0.4);
        }
        .btn-submit:active:not(:disabled) { transform: scale(0.98); }
        .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        /* Loading spinner */
        .btn-spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white; border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-submit.loading .btn-spinner { display: block; }
        .btn-submit.loading .btn-text { opacity: 0.7; }

        .sdg-line { text-align: center; font-size: 11px; color: var(--muted); margin-bottom: 6px; }
        .sdg-line strong { color: var(--purple); font-weight: 600; }

        .footer-note {
            margin-top: auto; font-size: 11px; color: var(--muted);
            text-align: center; padding-top: 20px; letter-spacing: 0.02em;
        }
        .footer-note strong { color: var(--purple); font-weight: 600; }

        /* ═══ RIGHT PANEL ═══ */
        .right {
            flex: 1;
            background: linear-gradient(180deg, #EDE5F9 0%, #D8CEEE 50%, #C4B8E8 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 48px; position: relative; overflow: hidden;
        }
        .right::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 600px 300px at 20% 10%, rgba(255,255,255,0.5), transparent),
                radial-gradient(ellipse 500px 250px at 80% 30%, rgba(255,255,255,0.4), transparent),
                radial-gradient(ellipse 600px 300px at 50% 90%, rgba(255,255,255,0.4), transparent);
            pointer-events: none;
        }
        .right-content { position: relative; z-index: 1; max-width: 420px; width: 100%; }

        .home-link {
            position: absolute; top: 20px; right: 24px;
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.7); backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.9); border-radius: 100px;
            padding: 8px 16px; font-size: 12px; font-weight: 500;
            color: var(--text-soft); text-decoration: none; transition: all 0.2s; z-index: 10;
        }
        .home-link:hover { background: white; color: var(--purple); }

        .testimonial-card {
            background: rgba(255,255,255,0.7); backdrop-filter: blur(30px) saturate(180%);
            border: 1px solid rgba(255,255,255,0.9); border-radius: 24px;
            padding: 28px; margin-bottom: 16px;
            box-shadow: 0 20px 50px rgba(30,58,95,0.1);
        }
        .testimonial-tag {
            font-size: 11px; font-weight: 700; color: var(--purple);
            text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 14px;
            display: flex; align-items: center; gap: 8px;
        }
        .testimonial-tag::before {
            content: ''; display: block; width: 20px; height: 2px;
            background: var(--purple); border-radius: 2px;
        }
        .testimonial-stars { color: #FFC452; font-size: 14px; margin-bottom: 10px; letter-spacing: 2px; }
        .testimonial-quote {
            font-family: var(--font-serif); font-size: 17px; color: var(--text);
            line-height: 1.5; margin-bottom: 18px; letter-spacing: -0.01em;
        }
        .tauthor { display: flex; align-items: center; gap: 12px; }
        .tav {
            width: 40px; height: 40px; border-radius: 50%;
            background: linear-gradient(135deg, var(--navy), #2D4D7A);
            color: white; font-size: 15px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .tname { font-size: 13px; font-weight: 600; color: var(--text); }
        .trole { font-size: 11px; color: var(--muted); margin-top: 1px; }

        .stats-card {
            background: rgba(255,255,255,0.7); backdrop-filter: blur(30px) saturate(180%);
            border: 1px solid rgba(255,255,255,0.9); border-radius: 24px;
            padding: 20px 28px; margin-bottom: 16px;
            box-shadow: 0 10px 30px rgba(30,58,95,0.08);
        }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); text-align: center; }
        .stat-cell { padding: 0 12px; border-right: 1px solid rgba(30,58,95,0.08); }
        .stat-cell:last-child { border-right: none; }
        .stat-n {
            font-family: var(--font-serif); font-size: 28px; font-weight: 400;
            color: var(--text); letter-spacing: -0.02em; line-height: 1; margin-bottom: 4px;
        }
        .stat-n em { font-style: italic; color: var(--purple); }
        .stat-l { font-size: 11px; color: var(--muted); font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase; }

        .sdg-wrapper { text-align: center; margin-top: 8px; }
        .sdg-header { font-size: 11px; color: var(--text-soft); margin-bottom: 10px; font-weight: 500; }
        .sdg-strip { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
        .sdg-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 600; padding: 6px 12px; border-radius: 100px;
            background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.9); color: var(--text-soft); transition: all 0.2s;
        }
        .sdg-badge:hover { background: white; transform: translateY(-2px); }

        @media(max-width: 900px) {
            .right { display: none; }
            .left { width: 100%; padding: 24px 20px; }
            .form-wrap { max-width: 100%; }
            h1 { font-size: 30px; }
            .benefits { grid-template-columns: 1fr; }
            .role-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- LEFT: Form --}}
<div class="left">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
        <span class="logo-text">Coursify</span>
    </a>

    <div class="form-wrap">
        <h1>Buat akun <em>gratis</em></h1>
        <p class="subtitle">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </p>

        {{-- Benefits --}}
        <div class="benefits">
            @foreach([
                ['fa-book-open', 'Ratusan kursus gratis'],
                ['fa-chart-line', 'Progress tersimpan'],
                ['fa-award', 'Sertifikat digital'],
                ['fa-users', 'Komunitas aktif'],
            ] as [$icon, $label])
                <div class="benefit-item">
                    <div class="check-ic">
                        <i class="fa-solid fa-check" style="font-size:8px;"></i>
                    </div>
                    {{ $label }}
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('register') }}"
              id="registerForm"
              x-data="{
                showPass: false,
                showConfirm: false,
                password: '',
                confirm: '',
                get matchState() {
                    if (!this.confirm) return 'empty';
                    return this.password === this.confirm ? 'match' : 'no-match';
                }
              }"
              @submit="handleSubmit($event)">
            @csrf

            {{-- Role Selector --}}
            <div class="role-section">
                <label class="field-label-top">Daftar sebagai</label>
                <div class="role-grid">
                    <label class="role-card {{ old('role','student')==='student' ? 'selected' : '' }}" id="role-student">
                        <input type="radio" name="role" value="student"
                            {{ old('role','student')==='student' ? 'checked' : '' }}
                            onchange="selectRole(this)">
                        <div class="role-icon">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="role-label">Pelajar</div>
                            <div class="role-sub">Ingin belajar</div>
                        </div>
                    </label>
                    <label class="role-card {{ old('role')==='instructor' ? 'selected' : '' }}" id="role-instructor">
                        <input type="radio" name="role" value="instructor"
                            {{ old('role')==='instructor' ? 'checked' : '' }}
                            onchange="selectRole(this)">
                        <div class="role-icon">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <div class="role-label">Instruktur</div>
                            <div class="role-sub">Ingin mengajar</div>
                        </div>
                    </label>
                </div>
                @error('role')
                    <div class="error-msg">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Name --}}
            <div class="field">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required autofocus autocomplete="name"
                        class="{{ $errors->has('name') ? 'error-input' : '' }}">
                </div>
                @error('name')
                    <div class="error-msg">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="field">
                <label for="email">Alamat Email</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        required autocomplete="username"
                        class="{{ $errors->has('email') ? 'error-input' : '' }}">
                </div>
                @error('email')
                    <div class="error-msg">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input :type="showPass ? 'text' : 'password'"
                        id="password" name="password"
                        placeholder="Minimal 8 karakter"
                        required autocomplete="new-password"
                        x-model="password"
                        @input="checkStrength($event.target.value)"
                        class="{{ $errors->has('password') ? 'error-input' : '' }}">
                    <button type="button" class="input-toggle"
                        @click="showPass = !showPass" tabindex="-1">
                        <i :class="showPass ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                <div class="strength-bar">
                    <div class="strength-fill" id="strengthFill"></div>
                </div>
                <div class="strength-label" id="strengthLabel">Masukkan password</div>
                @error('password')
                    <div class="error-msg">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="field">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input :type="showConfirm ? 'text' : 'password'"
                        id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password"
                        required autocomplete="new-password"
                        x-model="confirm"
                        :class="matchState === 'match' ? 'success-input' : (matchState === 'no-match' ? 'error-input' : '')">
                    <button type="button" class="input-toggle"
                        @click="showConfirm = !showConfirm" tabindex="-1">
                        <i :class="showConfirm ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                {{-- Password match indicator --}}
                <div class="match-indicator" :class="matchState">
                    <template x-if="matchState === 'match'">
                        <span>
                            <i class="fa-solid fa-circle-check"></i> Password cocok
                        </span>
                    </template>
                    <template x-if="matchState === 'no-match'">
                        <span>
                            <i class="fa-solid fa-circle-xmark"></i> Password tidak cocok
                        </span>
                    </template>
                    <template x-if="matchState === 'empty'">
                        <span>&nbsp;</span>
                    </template>
                </div>
            </div>

            {{-- Terms --}}
            <div class="terms-check">
                <input type="checkbox" id="terms" name="terms">
                <label for="terms" style="margin:0;cursor:pointer;font-size:13px;color:var(--text-soft);line-height:1.5;">
                    Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan
                    <a href="#">Kebijakan Privasi</a> Coursify
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit" id="submitBtn">
                <div class="btn-spinner" id="btnSpinner"></div>
                <span class="btn-text" id="btnText">
                    Buat Akun Sekarang
                    <i class="fa-solid fa-arrow-right" style="margin-left:4px;font-size:12px;"></i>
                </span>
            </button>
        </form>
    </div>

    <div class="footer-note">
        © {{ date('Y') }} <strong>Coursify</strong> Platform E-Learning 
    </div>
</div>

{{-- RIGHT: Testimonial & Stats --}}
<div class="right">
    <a href="{{ route('home') }}" class="home-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Home
    </a>

    <div class="right-content">
        <div class="testimonial-card">
            <div class="testimonial-tag">Testimoni Pelajar</div>
            <div class="testimonial-stars">★★★★★</div>
            <p class="testimonial-quote">
                "Coursify benar-benar mengubah karier saya. Dalam 3 bulan belajar Data Science, saya langsung dapat pekerjaan impian sebagai Data Analyst di Tokopedia!"
            </p>
            <div class="tauthor">
                <div class="tav">R</div>
                <div>
                    <div class="tname">Rizky Pratama</div>
                    <div class="trole">Data Analyst · Alumni 2024</div>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-grid">
                <div class="stat-cell">
                    <div class="stat-n"><em>50+</em></div>
                    <div class="stat-l">Kursus</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-n"><em>1.2K+</em></div>
                    <div class="stat-l">Pelajar</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-n"><em>95%</em></div>
                    <div class="stat-l">Rating</div>
                </div>
            </div>
        </div>

        <div class="sdg-wrapper">
            <div class="sdg-header">Mendukung Sustainable Development Goals</div>
            <div class="sdg-strip">
                <span class="sdg-badge">📚 SDG 4 · Pendidikan</span>
                <span class="sdg-badge">💼 SDG 8 · Pekerjaan</span>
                <span class="sdg-badge">⚖️ SDG 10 · Kesetaraan</span>
            </div>
        </div>
    </div>
</div>

<script>
// ─── Role selection ───────────────────────────────────────
function selectRole(input) {
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
    input.closest('.role-card').classList.add('selected');
}

// ─── Password strength ────────────────────────────────────
function checkStrength(val) {
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;

    const configs = [
    { w: '0%',   c: '#9CA3AF', t: 'Masukkan password' }, // Slate Gray (Netral)
    { w: '25%',  c: '#C29393', t: 'Lemah' },             // Dusty Rose (Elegan, tidak agresif)
    { w: '50%',  c: '#D4AF37', t: 'Cukup' },             // Muted Gold (Mewah, bukan kuning cerah)
    { w: '75%',  c: '#6B728E', t: 'Kuat' },              // Slate Blue-Steel (Tenang & kokoh)
    { w: '100%', c: '#4D6151', t: 'Sangat kuat' },       // Sage Green / Forest Mist (Dewasa)
];
    const cfg = val.length === 0 ? configs[0] : (configs[score] || configs[0]);
    fill.style.width      = cfg.w;
    fill.style.background = cfg.c;
    label.textContent     = cfg.t;
    label.style.color     = cfg.c;
}

// ─── Form submit: validasi terms + loading state ──────────
function handleSubmit(e) {
    const terms  = document.getElementById('terms');
    const btn    = document.getElementById('submitBtn');
    const spinner = document.getElementById('btnSpinner');
    const btnText = document.getElementById('btnText');

    // Validasi terms
    if (!terms.checked) {
        e.preventDefault();
        terms.style.borderColor = 'var(--orange)';
        terms.style.animation = 'shake 0.4s ease';
        setTimeout(() => {
            terms.style.animation = '';
            terms.style.borderColor = '';
        }, 500);

        // Scroll ke terms
        terms.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    // Loading state
    btn.disabled = true;
    btn.classList.add('loading');
    spinner.style.display = 'block';
    btnText.textContent   = 'Membuat akun...';
}
</script>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20%       { transform: translateX(-4px); }
    40%       { transform: translateX(4px); }
    60%       { transform: translateX(-4px); }
    80%       { transform: translateX(4px); }
}
</style>

</body>
</html>