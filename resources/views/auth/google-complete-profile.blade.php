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

        /* ═══ RIGHT PANEL ═══ */
        .right {
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

        .right::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 600px 300px at 20% 10%, rgba(255,255,255,0.5), transparent),
                radial-gradient(ellipse 500px 250px at 80% 30%, rgba(255,255,255,0.4), transparent),
                radial-gradient(ellipse 600px 300px at 50% 90%, rgba(255,255,255,0.4), transparent);
            pointer-events: none;
        }

        .right-heading {
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
        .right-heading em {
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
        .yellow-body .eyes-wrap { gap: 10px; }
        .black-body .eyes-wrap { gap: 10px; }

        .footer-note {
            font-size: 11px;
            color: var(--muted);
            text-align: center;
            padding-top: 32px;
            letter-spacing: 0.02em;
            z-index: 1;
        }

        @media(max-width: 900px) {
            .right { display: none; }
            body { justify-content: center; background: #FEFDFF; }
            .left { width: 100%; max-width: 540px; box-shadow: none; padding: 40px 24px; }
        }
    </style>
</head>
<body x-data="completeInteraction()" @mousemove="handleMouseMove($event)">

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
        {{-- Google User Info --}}
        <div class="avatar-preview" x-data="{ imgFailed: false }">
            <template x-if="!imgFailed && '{{ $googleUser['avatar'] ?? '' }}'">
                <img src="{{ $googleUser['avatar'] }}" alt="Avatar" class="avatar-img" @@error="imgFailed = true">
            </template>
            <template x-if="imgFailed || !'{{ $googleUser['avatar'] ?? '' }}'">
                <div class="avatar-img" style="background:#E8E1F3; display:flex; align-items:center; justify-content:center; color:var(--purple); font-weight:bold; font-size:18px;">
                    {{ strtoupper(substr($googleUser['name'] ?? 'U', 0, 1)) }}
                </div>
            </template>
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
    {{-- Heading Besar --}}
    <h2 class="right-heading">Learn Anything, <em>Anytime</em></h2>

    {{-- Cartoon Characters Stage --}}
    <div class="character-stage">
        <!-- Purple tall rectangle character -->
        <div id="purple-char" class="character-body purple-body"
             :style="{
                 transform: 'skewX(' + purple.bodySkew + 'deg)'
             }"
             style="background: var(--purple); width: 140px; height: 260px; left: 30px; z-index: 1;">
            <div class="eyes-wrap"
                 :style="{
                     left: (35 + purple.faceX) + 'px',
                     top: (30 + purple.faceY) + 'px'
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
                 transform: 'skewX(' + black.bodySkew + 'deg)'
             }"
             style="background: var(--navy); width: 90px; height: 210px; left: 180px; z-index: 2;">
            <div class="eyes-wrap"
                 :style="{
                     left: (20 + black.faceX) + 'px',
                     top: (25 + black.faceY) + 'px'
                 }">
                <div id="black-eye-l" class="eyeball" :style="{ height: isBlackBlinking ? '2px' : '12px', width: '12px' }">
                    <div class="pupil" x-show="!isBlackBlinking" :style="{ transform: 'translate(' + pupils.blackL.x + 'px, ' + pupils.blackL.y + 'px)' }" style="width: 4px; height: 4px;"></div>
                </div>
                <div id="black-eye-r" class="eyeball" :style="{ height: isBlackBlinking ? '2px' : '12px', width: '12px' }">
                    <div class="pupil" x-show="!isBlackBlinking" :style="{ transform: 'translate(' + pupils.blackR.x + 'px, ' + pupils.blackR.y + 'px)' }" style="width: 4px; height: 4px;"></div>
                </div>
            </div>
        </div>

        <!-- Yellow tall rectangle character (The new 4th character!) -->
        <div id="yellow-char" class="character-body yellow-body"
             :style="{
                 transform: 'skewX(' + yellow.bodySkew + 'deg)'
             }"
             style="background: #FFC72C; width: 90px; height: 180px; left: 280px; z-index: 1; border-radius: 45px 45px 0 0;">
            <div class="eyes-wrap"
                 :style="{
                     left: (20 + yellow.faceX) + 'px',
                     top: (25 + yellow.faceY) + 'px'
                 }">
                <div id="yellow-eye-l" class="eyeball" :style="{ height: isYellowBlinking ? '2px' : '12px', width: '12px' }">
                    <div class="pupil" x-show="!isYellowBlinking" :style="{ transform: 'translate(' + pupils.yellowL.x + 'px, ' + pupils.yellowL.y + 'px)' }" style="width: 4px; height: 4px;"></div>
                </div>
                <div id="yellow-eye-r" class="eyeball" :style="{ height: isYellowBlinking ? '2px' : '12px', width: '12px' }">
                    <div class="pupil" x-show="!isYellowBlinking" :style="{ transform: 'translate(' + pupils.yellowR.x + 'px, ' + pupils.yellowR.y + 'px)' }" style="width: 4px; height: 4px;"></div>
                </div>
            </div>
        </div>

        <!-- Orange semi-circle character -->
        <div id="orange-char" class="character-body orange-body"
             :style="{
                 transform: 'skewX(' + orange.bodySkew + 'deg)'
             }"
             style="background: var(--orange); width: 170px; height: 130px; left: 0px; z-index: 3; border-radius: 85px 85px 0 0;">
            <div class="eyes-wrap" style="gap: 14px;"
                 :style="{
                     left: (55 + orange.faceX) + 'px',
                     top: (55 + orange.faceY) + 'px'
                 }">
                <div id="orange-eye-l" class="pupil-only" :style="{ transform: 'translate(' + pupils.orangeL.x + 'px, ' + pupils.orangeL.y + 'px)' }"></div>
                <div id="orange-eye-r" class="pupil-only" :style="{ transform: 'translate(' + pupils.orangeR.x + 'px, ' + pupils.orangeR.y + 'px)' }"></div>
            </div>
        </div>
    </div>

    <div class="footer-note">
        © {{ date('Y') }} Coursify. All rights reserved.
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('completeInteraction', () => ({
            mouseX: 0,
            mouseY: 0,
            isPurpleBlinking: false,
            isBlackBlinking: false,
            isYellowBlinking: false,

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
                this.scheduleYellowBlink();
                this.updatePositions();
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

            scheduleYellowBlink() {
                setTimeout(() => {
                    this.isYellowBlinking = true;
                    setTimeout(() => {
                        this.isYellowBlinking = false;
                        this.scheduleYellowBlink();
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

                this.pupils.purpleL = this.calcPupil('purple-eye-l', 5);
                this.pupils.purpleR = this.calcPupil('purple-eye-r', 5);
                this.pupils.blackL = this.calcPupil('black-eye-l', 4);
                this.pupils.blackR = this.calcPupil('black-eye-r', 4);
                this.pupils.orangeL = this.calcPupil('orange-eye-l', 5);
                this.pupils.orangeR = this.calcPupil('orange-eye-r', 5);
                this.pupils.yellowL = this.calcPupil('yellow-eye-l', 5);
                this.pupils.yellowR = this.calcPupil('yellow-eye-r', 5);
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

            calcPupil(id, maxDistance) {
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
