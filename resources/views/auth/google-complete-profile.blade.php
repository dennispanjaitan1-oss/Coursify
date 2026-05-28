<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lengkapi Profil — Coursify</title>

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
            padding: 40px 48px;
            min-height: 100vh;
            position: relative;
            z-index: 2;
            overflow-y: auto;
            justify-content: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 32px;
            transition: transform 0.2s;
        }
        .logo:hover { transform: translateY(-1px); }
        .logo-img {
            width: 36px; height: 36px;
            border-radius: 9px; object-fit: cover;
            box-shadow: 0 4px 12px rgba(30,58,95,0.2);
        }
        .logo-text { font-size: 20px; font-weight: 700; letter-spacing: -0.02em; color: var(--text); }

        .form-wrap { flex: 1; display: flex; flex-direction: column; max-width: 420px; justify-content: center; }

        .avatar-preview {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            padding: 16px;
            background: var(--lav-1);
            border-radius: 16px;
            border: 1px dashed var(--lav-3);
        }
        .avatar-img {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(123,111,232,0.2);
        }
        .avatar-info h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
        }
        .avatar-info p {
            font-size: 13px;
            color: var(--text-soft);
        }

        h1 {
            font-family: var(--font-serif);
            font-size: 38px; font-weight: 400;
            letter-spacing: -0.02em; line-height: 1.1;
            color: var(--text); margin-bottom: 8px;
        }
        h1 em { font-style: italic; color: var(--purple); }

        .subtitle {
            font-size: 14px; color: var(--muted);
            margin-bottom: 24px; line-height: 1.6;
        }

        .role-section { margin-bottom: 20px; }
        .field-label-top {
            display: block; font-size: 13px; font-weight: 500;
            color: var(--text-soft); margin-bottom: 8px;
        }
        .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .role-card {
            padding: 14px;
            border: 1.5px solid var(--border);
            border-radius: 14px; cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
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
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--lav-2);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0; transition: all 0.2s;
            color: var(--purple);
        }
        .role-card.selected .role-icon { background: var(--purple); color: white; transform: scale(1.05); }
        .role-label { font-family: var(--font-serif); font-size: 16px; color: var(--text); letter-spacing: -0.01em; font-weight: bold; }
        .role-sub { font-size: 11px; color: var(--muted); margin-top: 1px; }

        .field { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-soft); margin-bottom: 6px; }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted); font-size: 14px;
            transition: color 0.2s;
        }
        .input-wrap input {
            width: 100%; padding: 13px 16px 13px 40px;
            border-radius: 12px; border: 1.5px solid var(--border);
            font-family: var(--font-sans); font-size: 14px;
            color: var(--text); background: white;
            transition: all 0.25s;
        }
        .input-wrap input:focus {
            outline: none; border-color: var(--purple);
            box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
        }
        .input-wrap input:focus + .input-icon { color: var(--purple); }
        .input-wrap input:disabled {
            background: #F8F7FA;
            color: var(--muted);
            cursor: not-allowed;
        }

        .error-msg { font-size: 12px; color: var(--orange); margin-top: 5px; font-weight: 500; }

        .btn-submit {
            width: 100%; padding: 14px; border-radius: 100px;
            border: none; background: #1A1825; color: white;
            font-family: var(--font-sans); font-size: 14px; font-weight: 600;
            cursor: pointer; transition: all 0.25s; margin-top: 8px;
            box-shadow: 0 4px 14px rgba(26,24,37,0.3);
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

        .btn-submit.loading .btn-spinner { display: block; }
        .btn-submit.loading .btn-text { opacity: 0.7; }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ═══ RIGHT PANEL (BRANDING) ═══ */
        .right {
            flex: 1;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        /* Dekomasi Lingkaran */
        .right::before {
            content: ''; position: absolute; top: -10%; right: -10%;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(123,111,232,0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .right::after {
            content: ''; position: absolute; bottom: -10%; left: -10%;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(0,200,150,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .right-content {
            max-width: 440px; margin: auto 0;
            position: relative; z-index: 1;
        }

        .right h2 {
            font-family: var(--font-serif);
            font-size: 56px; font-weight: 400; line-height: 1.05;
            letter-spacing: -0.02em; margin-bottom: 24px;
        }
        .right h2 em { font-style: italic; color: var(--teal); }
        .right p { font-size: 16px; line-height: 1.6; color: rgba(255,255,255,0.7); }

        .footer-note {
            font-size: 12px; color: rgba(255,255,255,0.4);
            position: relative; z-index: 1;
        }

        /* Responsive */
        @media(max-width: 1024px) {
            .right { display: none; }
            body { justify-content: center; background: #FEFDFF; }
            .left { width: 100%; max-width: 540px; box-shadow: none; padding: 40px 24px; }
        }
    </style>
</head>
<body>

<div class="left">
    <div class="form-wrap">
        {{-- Logo --}}
        <a href="/" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            <span class="logo-text">Coursify</span>
        </a>

        <h1>Satu langkah <em>lagi</em></h1>
        <p class="subtitle">
            Lengkapi data diri Anda untuk menyelesaikan pendaftaran dengan akun Google.
        </p>

        {{-- Google User Info --}}
        <div class="avatar-preview">
            @if(!empty($googleUser['avatar']))
                <img src="{{ $googleUser['avatar'] }}" alt="Avatar" class="avatar-img">
            @else
                <div class="avatar-img" style="background:#E8E1F3; display:flex; align-items:center; justify-content:center; color:var(--purple); font-weight:bold; font-size:18px;">
                    {{ strtoupper(substr($googleUser['name'] ?? 'U', 0, 1)) }}
                </div>
            @endif
            <div class="avatar-info">
                <h3>Terhubung sebagai Google</h3>
                <p>{{ $googleUser['email'] }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('auth.google.complete.post') }}" id="completeForm" onsubmit="handleSubmit(event)">
            @csrf

            {{-- Role Selector --}}
            <div class="role-section">
                <label class="field-label-top">Saya ingin mendaftar sebagai</label>
                <div class="role-grid">
                    <label class="role-card selected" id="role-student">
                        <input type="radio" name="role" value="student" checked onchange="selectRole(this)">
                        <div class="role-icon">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="role-label">Pelajar</div>
                            <div class="role-sub">Ingin belajar</div>
                        </div>
                    </label>
                    <label class="role-card" id="role-instructor">
                        <input type="radio" name="role" value="instructor" onchange="selectRole(this)">
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
                    <div class="error-msg">⚠ {{ $message }}</div>
                @enderror
            </div>

            {{-- Name --}}
            <div class="field">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $googleUser['name'] ?? '') }}"
                        placeholder="Nama Lengkap"
                        required
                        autofocus
                    >
                </div>
                @error('name')
                    <div class="error-msg">⚠ {{ $message }}</div>
                @enderror
            </div>

            {{-- Readonly Email --}}
            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="fa-regular fa-envelope input-icon"></i>
                    <input
                        type="email"
                        id="email"
                        value="{{ $googleUser['email'] }}"
                        disabled
                    >
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit" id="submitBtn">
                <div class="btn-spinner" id="btnSpinner"></div>
                <span class="btn-text" id="btnText">Selesaikan Pendaftaran</span>
            </button>
        </form>
    </div>
</div>

{{-- RIGHT: Branding --}}
<div class="right">
    <div class="right-content">
        <h2>Join the<br><em>Community</em></h2>
        <p>
            Tingkatkan keterampilan Anda, terhubung dengan ribuan pelajar dan instruktur di seluruh dunia, dan capai tujuan karir Anda.
        </p>
    </div>
    <div class="footer-note">
        © {{ date('Y') }} Coursify. All rights reserved.
    </div>
</div>

<script>
    function selectRole(radio) {
        document.querySelectorAll('.role-card').forEach(card => card.classList.remove('selected'));
        if (radio.checked) {
            radio.closest('.role-card').classList.add('selected');
        }
    }

    function handleSubmit(e) {
        const btn = document.getElementById('submitBtn');
        const spinner = document.getElementById('btnSpinner');
        const text = document.getElementById('btnText');

        btn.disabled = true;
        btn.classList.add('loading');
        spinner.style.display = 'block';
        text.innerText = 'Memproses...';
    }
</script>

</body>
</html>
