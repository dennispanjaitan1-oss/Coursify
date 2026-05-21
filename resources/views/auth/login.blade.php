<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — Coursify</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --navy: #153759;
            --navy-dark: #0F2744;
            --lav-1: #F5F1FC;
            --lav-2: #E8E1F3;
            --lav-3: #D4CDF0;
            --lav-4: #B8AFEB;
            --purple: #7B6FE8;
            --purple-dark: #5B4FD4;
            --teal: #00C896;
            --orange: #FF8A5B;
            --text: #1A1825;
            --text-soft: #4A4660;
            --muted: #8B87A8;
            --border: rgba(30,58,95,0.1);
            --font-serif: 'Instrument Serif', serif;
            --font-sans: 'Inter', sans-serif;
        }

        *{box-sizing:border-box;margin:0;padding:0}

        body{
            font-family: var(--font-sans);
            background: #FEFDFF;
            color: var(--text);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══ LEFT PANEL (FORM) ═══ */
        .left{
            width: 480px;
            flex-shrink: 0;
            background: white;
            display: flex;
            flex-direction: column;
            padding: 36px 48px;
            min-height: 100vh;
            position: relative;
            z-index: 2;
        }

        /* Logo */
        .logo{
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 56px;
            transition: transform 0.2s;
        }
        .logo:hover { transform: translateY(-1px); }

        .logo-img{
            width: 36px;
            height: 36px;
            border-radius: 9px;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(30,58,95,0.2);
        }

        .logo-text{
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text);
        }

        /* Form Wrapper */
        .form-wrap{
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 380px;
        }

        h1{
            font-family: var(--font-serif);
            font-size: 44px;
            font-weight: 400;
            letter-spacing: -0.02em;
            line-height: 1.05;
            color: var(--text);
            margin-bottom: 10px;
        }
        h1 em {
            font-style: italic;
            color: var(--purple);
        }

        .subtitle{
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 36px;
            line-height: 1.6;
        }
        .subtitle a{
            color: var(--purple);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .subtitle a:hover { color: var(--purple-dark); }

        /* FORM FIELDS */
        .field{ margin-bottom: 18px; }

        label{
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-soft);
            margin-bottom: 7px;
        }

        /* ═══ INPUT WRAP ═══ */
.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

/* Ikon kiri (gembok/email) */
.input-wrap .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 14px;
    pointer-events: none;
    z-index: 10;
}

/* Tombol toggle mata (kanan) */
.input-wrap .input-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--muted);
    cursor: pointer;
    font-size: 14px;
    z-index: 10;
    padding: 6px;
    transition: color 0.2s;
}
.input-wrap .input-toggle:hover {
    color: var(--purple);
}

/* Input field — SATU DEKLARASI SAJA */
.input-wrap input[type=email],
.input-wrap input[type=password],
.input-wrap input[type=text] {
    width: 100%;
    padding: 12px 45px 12px 42px; /* kiri: ruang ikon gembok, kanan: ruang ikon mata */
    border: 1.5px solid var(--border);
    border-radius: 12px;
    font-size: 14px;
    font-family: var(--font-sans);
    color: var(--text);
    background: #FAFAFB;
    outline: none;
    transition: all 0.2s;
}

.input-wrap input::placeholder {
    color: var(--muted);
}

.input-wrap input:focus {
    border-color: var(--purple);
    background: white;
    box-shadow: 0 0 0 4px rgba(123, 111, 232, 0.1);
}

.input-wrap input.error {
    border-color: var(--orange);
    background: rgba(255, 138, 91, 0.03);
}

/* Error message */
.error-msg {
    font-size: 12px;
    color: var(--orange);
    margin-top: 6px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 4px;
}


        /* Remember + Forgot Row */
        .remember-row{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .checkbox-label{
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-soft);
            cursor: pointer;
            user-select: none;
        }
        .checkbox-label input[type=checkbox]{
            appearance: none;
            width: 16px;
            height: 16px;
            border: 1.5px solid var(--border);
            border-radius: 4px;
            background: white;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }
        .checkbox-label input[type=checkbox]:checked{
            background: var(--purple);
            border-color: var(--purple);
        }
        .checkbox-label input[type=checkbox]:checked::after{
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 11px;
            font-weight: 700;
        }

        .forgot{
            font-size: 13px;
            color: var(--purple);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .forgot:hover { color: var(--purple-dark); }

        /* Submit Button */
        .btn-submit{
            width: 100%;
            padding: 14px;
            border-radius: 100px;
            border: none;
            background: #1A1825;
            color: white;
            font-family: var(--font-sans);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(26,24,37,0.3);
            position: relative;
            overflow: hidden;
        }
        .btn-submit:hover{
            background: #2A2840;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26,24,37,0.4);
        }
        .btn-submit:active { transform: scale(0.98); }
        .btn-submit::after{
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.3);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn-submit:active::after { opacity: 1; }

        /* Divider */
        .divider{
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .divider::before,
        .divider::after{
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span{
            font-size: 11px;
            color: var(--muted);
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Google Button */
        .btn-google{
            width: 100%;
            padding: 12px;
            border-radius: 100px;
            border: 1.5px solid var(--border);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
            transition: all 0.2s;
            font-family: var(--font-sans);
        }
        .btn-google:hover{
            border-color: var(--purple);
            background: var(--lav-1);
            transform: translateY(-1px);
        }

        
        /* Footer Note */
        .footer-note{
            margin-top: auto;
            font-size: 11px;
            color: var(--muted);
            text-align: center;
            padding-top: 32px;
            letter-spacing: 0.02em;
        }
        .footer-note strong{
            color: var(--purple);
            font-weight: 600;
        }

        /* Status Message */
        .status-msg{
            background: rgba(0,200,150,0.1);
            border: 1px solid rgba(0,200,150,0.25);
            color: #006B52;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ═══ RIGHT PANEL (HERO) ═══ */
        .right{
            flex: 1;
            background: linear-gradient(180deg, #EDE5F9 0%, #D8CEEE 50%, #C4B8E8 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        /* Cloud overlays */
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

        .right-content{
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 520px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .right-badge{
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.9);
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 500;
            color: var(--text-soft);
            margin-bottom: 24px;
        }
        .right-badge-dot{
            width: 6px;
            height: 6px;
            background: var(--teal);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        .right h2{
            font-family: var(--font-serif);
            font-size: 44px;
            font-weight: 400;
            letter-spacing: -0.02em;
            color: var(--text);
            margin-bottom: 14px;
            line-height: 1.05;
        }
        .right h2 em{
            font-style: italic;
            background: linear-gradient(135deg, var(--purple), var(--lav-4));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .right p{
            font-size: 14px;
            color: var(--text-soft);
            line-height: 1.65;
            margin-bottom: 36px;
            max-width: 400px;
        }

        /* Phone Mockup */
        .phone-stage{
            position: relative;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 10px;
            margin-bottom: 36px;
        }

        .phone{
            background: white;
            border-radius: 28px;
            padding: 4px;
            box-shadow: 0 15px 50px rgba(30,58,95,0.15);
            animation: floatPhone 5s ease-in-out infinite;
        }
        .phone-main{
            width: 180px;
            height: 360px;
            z-index: 2;
        }
        .phone-side{
            width: 120px;
            height: 280px;
            opacity: 0.85;
        }
        .phone-side-left{
            transform: rotate(-8deg) translate(16px, 16px);
            animation-delay: 0.3s;
        }
        .phone-side-right{
            transform: rotate(8deg) translate(-16px, 16px);
            animation-delay: 0.6s;
        }
        @keyframes floatPhone {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .phone-side-left { animation: floatPhoneLeft 5s ease-in-out infinite 0.3s; }
        .phone-side-right { animation: floatPhoneRight 5s ease-in-out infinite 0.6s; }
        @keyframes floatPhoneLeft {
            0%, 100% { transform: rotate(-8deg) translate(16px, 16px); }
            50% { transform: rotate(-8deg) translate(16px, 8px); }
        }
        @keyframes floatPhoneRight {
            0%, 100% { transform: rotate(8deg) translate(-16px, 16px); }
            50% { transform: rotate(8deg) translate(-16px, 8px); }
        }

        .phone-screen{
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, #F5F1FC, #E8E1F3);
            border-radius: 24px;
            padding: 14px 10px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .phone-status{
            font-size: 10px;
            color: var(--text-soft);
            text-align: center;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .phone-label{
            font-size: 9px;
            color: var(--muted);
            text-align: center;
            font-weight: 500;
            margin-bottom: 3px;
        }
        .phone-card{
            background: rgba(255,255,255,0.95);
            border-radius: 10px;
            padding: 8px;
        }
        .phone-avatar{
            width: 100%;
            aspect-ratio: 1;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--navy), #2D4D7A);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
        }
        .phone-name{
            font-family: var(--font-serif);
            font-size: 14px;
            text-align: center;
            letter-spacing: -0.01em;
        }

        /* Stats Bar */
        .stats-bar{
            display: flex;
            gap: 0;
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 20px;
            padding: 20px 28px;
            margin-top: 8px;
        }
        .stat{
            text-align: center;
            padding: 0 20px;
            border-right: 1px solid rgba(30,58,95,0.08);
        }
        .stat:last-child { border-right: none; }
        .stat-n{
            font-family: var(--font-serif);
            font-size: 26px;
            font-weight: 400;
            letter-spacing: -0.02em;
            color: var(--text);
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-n em{
            font-style: italic;
            color: var(--purple);
        }
        .stat-l{
            font-size: 10px;
            color: var(--muted);
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Responsive */
        @media(max-width: 900px){
            .right{ display: none; }
            .left{
                width: 100%;
                padding: 32px 24px;
            }
            .form-wrap{ max-width: 100%; }
            h1{ font-size: 36px; }
        }

        /* Sembunyikan toggle password bawaan browser */
input[type=password]::-ms-reveal,
input[type=password]::-ms-clear {
    display: none;
}
input[type="password"]::-webkit-contacts-auto-fill-button,
input[type="password"]::-webkit-credentials-auto-fill-button {
    visibility: hidden;
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
        <h1>Good To See <em>You</em></h1>
        <p class="subtitle">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar gratis</a>
        </p>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="status-msg">
                ✓ {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
            @csrf

            {{-- Email --}}
            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="fa-regular fa-envelope input-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        required
                        autofocus
                        autocomplete="username"
                        class="{{ $errors->has('email') ? 'error' : '' }}"
                    >
                </div>
                @error('email')
                    <div class="error-msg">⚠ {{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
<div class="field">
    <label for="password">Password</label>
    <div class="input-wrap">
        {{-- Ikon Gembok di Kiri --}}
        <i class="fa-solid fa-lock input-icon"></i>
        
        <input
            :type="showPassword ? 'text' : 'password'"
            id="password"
            name="password"
            placeholder="Masukkan password"
            required
            autocomplete="current-password"
            class="{{ $errors->has('password') ? 'error' : '' }}"
        >

        <button type="button" class="input-toggle" @click="showPassword = !showPassword" tabindex="-1">
    <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
</button>
    </div>
    
    @error('password')
        <div class="error-msg">⚠ {{ $message }}</div>
    @enderror
</div>

            {{-- Remember + Forgot --}}
            <div class="remember-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot">Lupa password?</a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit">
                Masuk ke Coursify
            </button>
        </form>

        {{-- Divider --}}
        <div class="divider"><span>Atau masuk dengan</span></div>

        {{-- Google --}}
        <button class="btn-google" type="button" onclick="alert('Google login segera hadir!')">
            <svg width="18" height="18" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Lanjutkan dengan Google
        </button>

        {{-- Demo Credentials --}}
        <div class="demo-hint">
            
            <div class="demo-hint-grid">
                
            </div>
        </div>
    </div>

    <div class="footer-note">
        © {{ date('Y') }} Coursify All rights reserved. 
    </div>
</div>

{{-- RIGHT: Branding --}}
<div class="right">
    <div class="right-content">

        

        {{-- Heading --}}
        <h2>Learn Anything,<br><em>Anytime</em></h2>
        <p>
            Akses ribuan kursus dari instruktur terbaik. Mulai gratis, belajar fleksibel, raih sertifikat yang diakui industri.
        </p>

        {{-- Phone Mockup --}}
        <div class="phone-stage">
            {{-- Phone Left --}}
            <div class="phone phone-side phone-side-left">
                <div class="phone-screen">
                    <div class="phone-status">9:41</div>
                    <div class="phone-label">Progress</div>
                    <div class="phone-card">
                        <div style="font-size:10px;font-weight:600;margin-bottom:3px;">Laravel</div>
                        <div style="height:3px;background:#E8E1F3;border-radius:2px;">
                            <div style="height:100%;width:75%;background:var(--purple);border-radius:2px;"></div>
                        </div>
                    </div>
                    <div class="phone-card">
                        <div style="font-size:10px;font-weight:600;margin-bottom:3px;">UI/UX</div>
                        <div style="height:3px;background:#E8E1F3;border-radius:2px;">
                            <div style="height:100%;width:45%;background:var(--teal);border-radius:2px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phone Main --}}
            <div class="phone phone-main">
                <div class="phone-screen">
                    <div class="phone-status">9:41</div>
                    <div class="phone-label">Featured Instructor</div>
                    <div class="phone-card">
                        <div class="phone-avatar">A</div>
                        <div class="phone-name">Meet Andi</div>
                        <div style="font-size:9px;color:var(--muted);text-align:center;margin-top:2px;">Senior Dev</div>
                    </div>
                    <div style="background:var(--purple);color:white;padding:6px 10px;border-radius:100px;font-size:9px;text-align:center;font-weight:600;">
                        Start Learning 
                    </div>
                </div>
            </div>

            {{-- Phone Right --}}
            <div class="phone phone-side phone-side-right">
                <div class="phone-screen">
                    <div class="phone-status">9:41</div>
                    <div class="phone-label">Lesson 12</div>
                    <div class="phone-card">
                        <div style="aspect-ratio:16/10;background:linear-gradient(135deg,var(--navy),#2D4D7A);border-radius:6px;display:flex;align-items:center;justify-content:center;margin-bottom:4px;">
                            <div style="width:22px;height:22px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:9px;color:var(--navy);">▶</div>
                        </div>
                        <div style="font-size:9px;font-weight:600;">Authentication</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="stats-bar">
            <div class="stat">
                <div class="stat-n"><em>Ratusan</em></div>
                <div class="stat-l">Courses</div>
            </div>
            <div class="stat">
                <div class="stat-n"><em>Ribuan</em></div>
                <div class="stat-l">Learners</div>
            </div>
            <div class="stat">
                <div class="stat-n"><em>Menghasilkan</em></div>
                <div class="stat-l">Experts</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>