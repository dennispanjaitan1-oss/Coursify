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

        /* Sembunyikan toggle password bawaan browser */
        input[type=password]::-ms-reveal,
        input[type=password]::-ms-clear { display: none; }
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button { visibility: hidden; }

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

        .strength-bar {
            height: 4px; border-radius: 2px;
            background: #F0EEF5; margin-top: 7px; overflow: hidden;
        }
        .strength-fill { height: 100%; border-radius: 2px; transition: all 0.4s ease; width: 0%; }
        .strength-label { font-size: 11px; margin-top: 4px; color: var(--muted); font-weight: 500; }

        .match-indicator {
            display: flex; align-items: center; gap: 6px;
            font-size: 11px; margin-top: 5px; font-weight: 500;
            transition: all 0.2s; height: 16px;
        }
        .match-indicator.match { color: var(--teal); }
        .match-indicator.no-match { color: var(--orange); }
        .match-indicator.empty { color: transparent; }

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

        .footer-note {
            margin-top: auto; font-size: 11px; color: var(--muted);
            text-align: center; padding-top: 20px; letter-spacing: 0.02em;
        }
        .footer-note strong { color: var(--purple); font-weight: 600; }

        /* ═══════════════════════════════════════════════
           RIGHT PANEL — OVERPOWERED 3D
        ═══════════════════════════════════════════════ */
        /* ═══ RIGHT PANEL ═══ */
        .right{
            flex: 1;
            background: linear-gradient(180deg, #EDE5F9 0%, #D8CEEE 50%, #C4B8E8 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 48px 48px 32px 48px;
            position: relative;
            overflow: hidden;
        }

        .right::before{
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 600px 300px at 20% 10%, rgba(255,255,255,0.5), transparent),
                radial-gradient(ellipse 500px 250px at 80% 30%, rgba(255,255,255,0.4), transparent),
                radial-gradient(ellipse 600px 300px at 50% 90%, rgba(255,255,255,0.4), transparent);
            pointer-events: none;
        }

        .right-heading{
            font-family: var(--font-serif);
            font-size: 64px;
            font-weight: 400;
            letter-spacing: -0.03em;
            line-height: 1.0;
            color: var(--text);
            text-align: center;
            white-space: nowrap;
            margin-bottom: 20px;
            z-index: 1;
        }
        .right-heading em{
            font-style: italic;
            background: linear-gradient(135deg, var(--purple), var(--lav-4));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding-right: 0.15em;
        }

        /* Character Stage */
        .character-stage {
            position: relative;
            width: 420px;
            height: 290px;
            margin: 0 auto 24px auto;
            z-index: 1;
        }
        .character-body {
            position: absolute;
            bottom: 0;
            border-radius: 10px 10px 0 0;
            transition: transform 0.7s cubic-bezier(0.25, 0.8, 0.25, 1), height 0.7s cubic-bezier(0.25, 0.8, 0.25, 1);
            transform-origin: bottom center;
            overflow: hidden;
        }
        .eyes-wrap {
            position: absolute;
            display: flex;
            gap: 16px;
            transition: left 0.7s cubic-bezier(0.25, 0.8, 0.25, 1), top 0.7s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .eyeball {
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: height 0.15s ease-in-out, width 0.15s ease-in-out;
        }
        .pupil {
            border-radius: 50%;
            background: #2D2D2D;
            transition: transform 0.1s ease-out;
        }
        .pupil-only {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #2D2D2D;
            transition: transform 0.1s ease-out;
        }
        .yellow-body .eyes-wrap { gap: 12px; }
        .black-body .eyes-wrap { gap: 10px; }
        .mouth {
            position: absolute;
            width: 50px;
            height: 3px;
            background: #2D2D2D;
            border-radius: 10px;
            transition: left 0.7s cubic-bezier(0.25, 0.8, 0.25, 1), top 0.7s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Tagline Cards */
        .tagline-cards {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            max-width: 420px;
            margin-bottom: 20px;
            z-index: 1;
        }
        .tagline-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 16px;
            padding: 14px 20px;
        }
        .tagline-icon {
            font-size: 22px;
            flex-shrink: 0;
        }
        .tagline-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 2px;
        }
        .tagline-sub {
            font-size: 12px;
            color: var(--muted);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        @media(max-width: 900px) {
            .right { display: none; }
            .left { width: 100%; padding: 24px 20px; }
            .form-wrap { max-width: 100%; }
            h1 { font-size: 30px; }
            .role-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body x-data="registerInteraction()" @mousemove="handleMouseMove($event)">

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



        @error('google')
            <div class="error-msg" style="margin-bottom: 20px; text-align: left; background: #FFF0F2; color: #D32F2F; padding: 12px 16px; border-radius: 8px; border: 1px solid #FFCDD2; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('register') }}"
              id="registerForm"
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
                        class="{{ $errors->has('name') ? 'error-input' : '' }}"
                        @focus="isTyping = true; updatePositions()"
                        @blur="isTyping = false; updatePositions()">
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
                        class="{{ $errors->has('email') ? 'error-input' : '' }}"
                        @focus="isTyping = true; updatePositions()"
                        @blur="isTyping = false; updatePositions()">
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
                    <input
                        id="password" name="password"
                        placeholder="Minimal 8 karakter"
                        required autocomplete="new-password"
                        x-model="password"
                        @focus="isTyping = true; updatePositions()"
                        @blur="isTyping = false; updatePositions()"
                        @input="checkStrength($event.target.value); updatePositions()"
                        class="{{ $errors->has('password') ? 'error-input' : '' }}"
                        :type="showPassword ? 'text' : 'password'">
                    <button type="button" class="input-toggle" @click="showPassword = !showPassword; $nextTick(() => updatePositions())" tabindex="-1">
                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
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
                    <input
                        id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password"
                        required autocomplete="new-password"
                        x-model="confirm"
                        @focus="isTyping = true; updatePositions()"
                        @blur="isTyping = false; updatePositions()"
                        @input="updatePositions()"
                        :class="matchState === 'match' ? 'success-input' : (matchState === 'no-match' ? 'error-input' : '')"
                        :type="showConfirm ? 'text' : 'password'">
                    <button type="button" class="input-toggle" @click="showConfirm = !showConfirm; $nextTick(() => updatePositions())" tabindex="-1">
                        <i :class="showConfirm ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                <div class="match-indicator" :class="matchState">
                    <template x-if="matchState === 'match'">
                        <span><i class="fa-solid fa-circle-check"></i> Password cocok</span>
                    </template>
                    <template x-if="matchState === 'no-match'">
                        <span><i class="fa-solid fa-circle-xmark"></i> Password tidak cocok</span>
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
                </span>
            </button>
        </form>

        {{-- Divider --}}
        <div style="display:flex;align-items:center;gap:12px;margin:16px 0;">
            <div style="flex:1;height:1px;background:var(--border);"></div>
            <span style="font-size:11px;color:var(--muted);font-weight:500;letter-spacing:0.08em;text-transform:uppercase;">Atau daftar dengan</span>
            <div style="flex:1;height:1px;background:var(--border);"></div>
        </div>

        {{-- Google Button --}}
        <a href="{{ route('auth.google.register') }}"
           style="display:flex;align-items:center;justify-content:center;gap:10px;
                  width:100%;padding:12px;border-radius:100px;border:1.5px solid var(--border);
                  background:white;color:var(--text);font-size:14px;font-weight:500;
                  text-decoration:none;transition:all 0.2s;font-family:var(--font-sans);
                  box-shadow:0 1px 4px rgba(0,0,0,0.06);margin-bottom:12px;"
           onmouseover="this.style.borderColor='var(--purple)';this.style.background='var(--lav-1)';this.style.transform='translateY(-1px)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.background='white';this.style.transform='none'">
            <svg width="18" height="18" viewBox="0 0 48 48">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.36-8.16 2.36-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                <path fill="none" d="M0 0h48v48H0z"/>
            </svg>
            Lanjutkan dengan Google
        </a>
    </div>

    <div class="footer-note">
        © {{ date('Y') }} <strong>Coursify</strong> Platform E-Learning
    </div>
</div>

{{-- RIGHT: Branding --}}
<div class="right">

    {{-- Heading Besar --}}
    <h2 class="right-heading">Welcome, <em>Learner</em></h2>

    {{-- Cartoon Characters Stage --}}
    <div class="character-stage">
        <!-- Purple tall rectangle character -->
        <div id="purple-char" class="character-body purple-body"
             :style="{
                 height: (isTyping || (password.length > 0 && !showPassword)) ? '375px' : '340px',
                 transform: (password.length > 0 && showPassword) ? 'skewX(0deg)' : (isTyping || (password.length > 0 && !showPassword)) ? 'skewX(' + (purple.bodySkew - 12) + 'deg) translateX(34px)' : 'skewX(' + purple.bodySkew + 'deg)'
             }"
             style="background: var(--purple); width: 150px; left: 58px; z-index: 1;">
            <div class="eyes-wrap"
                 :style="{
                     left: (password.length > 0 && showPassword) ? '18px' : isLookingAtEachOther ? '46px' : (38 + purple.faceX) + 'px',
                     top: (password.length > 0 && showPassword) ? '30px' : isLookingAtEachOther ? '55px' : (34 + purple.faceY) + 'px'
                 }">
                <div id="purple-eye-l" class="eyeball" :style="{ height: isPurpleBlinking ? '2px' : '15px', width: '15px' }">
                    <div class="pupil" x-show="!isPurpleBlinking" :style="{ transform: 'translate(' + pupils.purpleL.x + 'px, ' + pupils.purpleL.y + 'px)' }" style="width: 6px; height: 6px;"></div>
                </div>
                <div id="purple-eye-r" class="eyeball" :style="{ height: isPurpleBlinking ? '2px' : '15px', width: '15px' }">
                    <div class="pupil" x-show="!isPurpleBlinking" :style="{ transform: 'translate(' + pupils.purpleR.x + 'px, ' + pupils.purpleR.y + 'px)' }" style="width: 6px; height: 6px;"></div>
                </div>
            </div>
        </div>

        <!-- Black/Navy tall rectangle character -->
        <div id="black-char" class="character-body black-body"
             :style="{
                 transform: (password.length > 0 && showPassword) ? 'skewX(0deg)' : isLookingAtEachOther ? 'skewX(' + (black.bodySkew * 1.5 + 10) + 'deg) translateX(17px)' : (isTyping || (password.length > 0 && !showPassword)) ? 'skewX(' + (black.bodySkew * 1.5) + 'deg)' : 'skewX(' + black.bodySkew + 'deg)'
             }"
             style="background: var(--navy); width: 100px; height: 260px; left: 200px; z-index: 2;">
            <div class="eyes-wrap"
                 :style="{
                     left: (password.length > 0 && showPassword) ? '8px' : isLookingAtEachOther ? '27px' : (22 + black.faceX) + 'px',
                     top: (password.length > 0 && showPassword) ? '24px' : isLookingAtEachOther ? '10px' : (27 + black.faceY) + 'px'
                 }">
                <div id="black-eye-l" class="eyeball" :style="{ height: isBlackBlinking ? '2px' : '14px', width: '14px' }">
                    <div class="pupil" x-show="!isBlackBlinking" :style="{ transform: 'translate(' + pupils.blackL.x + 'px, ' + pupils.blackL.y + 'px)' }" style="width: 5px; height: 5px;"></div>
                </div>
                <div id="black-eye-r" class="eyeball" :style="{ height: isBlackBlinking ? '2px' : '14px', width: '14px' }">
                    <div class="pupil" x-show="!isBlackBlinking" :style="{ transform: 'translate(' + pupils.blackR.x + 'px, ' + pupils.blackR.y + 'px)' }" style="width: 5px; height: 5px;"></div>
                </div>
            </div>
        </div>

        <!-- Orange semi-circle character -->
        <div id="orange-char" class="character-body orange-body"
             :style="{
                 transform: (password.length > 0 && showPassword) ? 'skewX(0deg)' : 'skewX(' + orange.bodySkew + 'deg)'
             }"
             style="background: var(--orange); width: 200px; height: 170px; left: 0px; z-index: 3; border-radius: 100px 100px 0 0;">
            <div class="eyes-wrap" style="gap: 18px;"
                 :style="{
                     left: (password.length > 0 && showPassword) ? '42px' : (70 + orange.faceX) + 'px',
                     top: (password.length > 0 && showPassword) ? '72px' : (76 + orange.faceY) + 'px'
                 }">
                <div id="orange-eye-l" class="pupil-only" :style="{ transform: 'translate(' + pupils.orangeL.x + 'px, ' + pupils.orangeL.y + 'px)' }"></div>
                <div id="orange-eye-r" class="pupil-only" :style="{ transform: 'translate(' + pupils.orangeR.x + 'px, ' + pupils.orangeR.y + 'px)' }"></div>
            </div>
        </div>
    </div>

    {{-- Footer Links --}}
    <div style="display: flex; gap: 24px; justify-content: center; z-index: 10;">
        <a href="{{ route('privacy') }}" style="color: var(--text-soft); font-size: 13px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--text-soft)'">Privacy Policy</a>
        <a href="{{ route('about') }}" style="color: var(--text-soft); font-size: 13px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--text-soft)'">About Us</a>
        <a href="{{ route('contact') }}" style="color: var(--text-soft); font-size: 13px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--text-soft)'">Contact</a>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('registerInteraction', () => ({
            mouseX: 0,
            mouseY: 0,
            isPurpleBlinking: false,
            isBlackBlinking: false,
            isTyping: false,
            isLookingAtEachOther: false,
            isPurplePeeking: false,
            password: '',
            confirm: '',
            showPassword: false,
            showConfirm: false,

            get matchState() {
                if (!this.confirm) return 'empty';
                return this.password === this.confirm ? 'match' : 'no-match';
            },

            purple: { faceX: 0, faceY: 0, bodySkew: 0 },
            black: { faceX: 0, faceY: 0, bodySkew: 0 },
            orange: { faceX: 0, faceY: 0, bodySkew: 0 },
            yellow: { faceX: 0, faceY: 0, bodySkew: 0 },

            pupils: {
                purpleL: { x: 0, y: 0 },
                purpleR: { x: 0, y: 0 },
                blackL: { x: 0, y: 0 },
                blackR: { x: 0, y: 0 },
                orangeL: { x: 0, y: 0 },
                orangeR: { x: 0, y: 0 },
                yellowL: { x: 0, y: 0 },
                yellowR: { x: 0, y: 0 }
            },

            init() {
                this.schedulePurpleBlink();
                this.scheduleBlackBlink();
                this.updatePositions();

                this.$watch('password', (value) => {
                    this.updatePeeking();
                    this.updatePositions();
                });
                this.$watch('showPassword', (value) => {
                    this.updatePeeking();
                    this.updatePositions();
                });
                this.$watch('isTyping', (value) => {
                    if (value) {
                        this.isLookingAtEachOther = true;
                        setTimeout(() => {
                            this.isLookingAtEachOther = false;
                            this.updatePositions();
                        }, 800);
                    } else {
                        this.isLookingAtEachOther = false;
                    }
                    this.updatePositions();
                });
            },

            updatePeeking() {
                if (this.password.length > 0 && this.showPassword) {
                    if (!this.peekInterval) {
                        this.peekInterval = setInterval(() => {
                            if (this.password.length > 0 && this.showPassword) {
                                this.isPurplePeeking = true;
                                this.updatePositions();
                                setTimeout(() => {
                                    this.isPurplePeeking = false;
                                    this.updatePositions();
                                }, 800);
                            } else {
                                clearInterval(this.peekInterval);
                                this.peekInterval = null;
                            }
                        }, 3000);
                    }
                } else {
                    if (this.peekInterval) {
                        clearInterval(this.peekInterval);
                        this.peekInterval = null;
                    }
                    this.isPurplePeeking = false;
                }
            },

            schedulePurpleBlink() {
                setTimeout(() => {
                    this.isPurpleBlinking = true;
                    setTimeout(() => {
                        this.isPurpleBlinking = false;
                        this.schedulePurpleBlink();
                    }, 150);
                }, Math.random() * 4000 + 3000);
            },

            scheduleBlackBlink() {
                setTimeout(() => {
                    this.isBlackBlinking = true;
                    setTimeout(() => {
                        this.isBlackBlinking = false;
                        this.scheduleBlackBlink();
                    }, 150);
                }, Math.random() * 4000 + 3000);
            },

            handleMouseMove(e) {
                this.mouseX = e.clientX;
                this.mouseY = e.clientY;
                this.updatePositions();
            },

            updatePositions() {
                this.purple = this.calcPos('purple-char');
                this.black = this.calcPos('black-char');
                this.orange = this.calcPos('orange-char');
                this.yellow = this.calcPos('yellow-char');

                const hasPassword = this.password.length > 0;

                let purpleForceX, purpleForceY;
                if (hasPassword && this.showPassword) {
                    purpleForceX = this.isPurplePeeking ? 4 : -4;
                    purpleForceY = this.isPurplePeeking ? 5 : -4;
                } else if (this.isLookingAtEachOther) {
                    purpleForceX = 3;
                    purpleForceY = 4;
                }

                let blackForceX, blackForceY;
                if (hasPassword && this.showPassword) {
                    blackForceX = -4;
                    blackForceY = -4;
                } else if (this.isLookingAtEachOther) {
                    blackForceX = 0;
                    blackForceY = -4;
                }

                let orangeForceX, orangeForceY;
                if (hasPassword && this.showPassword) {
                    orangeForceX = -5;
                    orangeForceY = -4;
                }

                let yellowForceX, yellowForceY;
                if (hasPassword && this.showPassword) {
                    yellowForceX = -5;
                    yellowForceY = -4;
                }

                this.pupils.purpleL = this.calcPupil('purple-eye-l', 5, purpleForceX, purpleForceY);
                this.pupils.purpleR = this.calcPupil('purple-eye-r', 5, purpleForceX, purpleForceY);
                this.pupils.blackL = this.calcPupil('black-eye-l', 4, blackForceX, blackForceY);
                this.pupils.blackR = this.calcPupil('black-eye-r', 4, blackForceX, blackForceY);
                this.pupils.orangeL = this.calcPupil('orange-eye-l', 5, orangeForceX, orangeForceY);
                this.pupils.orangeR = this.calcPupil('orange-eye-r', 5, orangeForceX, orangeForceY);
                this.pupils.yellowL = this.calcPupil('yellow-eye-l', 5, yellowForceX, yellowForceY);
                this.pupils.yellowR = this.calcPupil('yellow-eye-r', 5, yellowForceX, yellowForceY);
            },

            calcPos(id) {
                const el = document.getElementById(id);
                if (!el) return { faceX: 0, faceY: 0, bodySkew: 0 };

                const rect = el.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 3;

                const deltaX = this.mouseX - centerX;
                const deltaY = this.mouseY - centerY;

                const faceX = Math.max(-15, Math.min(15, deltaX / 20));
                const faceY = Math.max(-10, Math.min(10, deltaY / 30));
                const bodySkew = Math.max(-6, Math.min(6, -deltaX / 120));

                return { faceX, faceY, bodySkew };
            },

            calcPupil(id, maxDistance, forceX, forceY) {
                if (forceX !== undefined && forceY !== undefined) {
                    return { x: forceX, y: forceY };
                }
                const el = document.getElementById(id);
                if (!el) return { x: 0, y: 0 };

                const rect = el.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;

                const deltaX = this.mouseX - centerX;
                const deltaY = this.mouseY - centerY;
                const distance = Math.min(Math.sqrt(deltaX ** 2 + deltaY ** 2), maxDistance);

                const angle = Math.atan2(deltaY, deltaX);
                return {
                    x: Math.cos(angle) * distance,
                    y: Math.sin(angle) * distance
                };
            }
        }));
    });

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
        if (val.length >= 8)          score++;
        if (/[A-Z]/.test(val))        score++;
        if (/[0-9]/.test(val))        score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const configs = [
            { w: '0%',   c: '#9CA3AF', t: 'Masukkan password' },
            { w: '25%',  c: '#C29393', t: 'Lemah' },
            { w: '50%',  c: '#D4AF37', t: 'Cukup' },
            { w: '75%',  c: '#6B728E', t: 'Kuat' },
            { w: '100%', c: '#4D6151', t: 'Sangat kuat' },
        ];
        const cfg = val.length === 0 ? configs[0] : (configs[score] || configs[0]);
        fill.style.width      = cfg.w;
        fill.style.background = cfg.c;
        label.textContent     = cfg.t;
        label.style.color     = cfg.c;
    }

    // ─── Form submit ──────────────────────────────────────────
    function handleSubmit(e) {
        const terms   = document.getElementById('terms');
        const btn     = document.getElementById('submitBtn');
        const spinner = document.getElementById('btnSpinner');
        const btnText = document.getElementById('btnText');

        if (!terms.checked) {
            e.preventDefault();
            terms.style.borderColor = 'var(--orange)';
            terms.style.animation   = 'shake 0.4s ease';
            setTimeout(() => { terms.style.animation = ''; terms.style.borderColor = ''; }, 500);
            terms.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        btn.disabled = true;
        btn.classList.add('loading');
        spinner.style.display = 'block';
        btnText.textContent   = 'Membuat akun...';
    }
</script>

<style>
@keyframes shake {
    0%,100% { transform: translateX(0); }
    20%      { transform: translateX(-4px); }
    40%      { transform: translateX(4px); }
    60%      { transform: translateX(-4px); }
    80%      { transform: translateX(4px); }
}
</style>

</body>
</html>