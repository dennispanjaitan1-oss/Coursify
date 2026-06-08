<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Masuk — Coursify</title>

    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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

        .field{ margin-bottom: 18px; }

        label{
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-soft);
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

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

        .input-wrap input[type=email],
        .input-wrap input[type=password],
        .input-wrap input[type=text] {
            width: 100%;
            padding: 12px 45px 12px 42px;
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

        .error-msg {
            font-size: 12px;
            color: var(--orange);
            margin-top: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

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

        .footer-note{
            margin-top: auto;
            font-size: 11px;
            color: var(--muted);
            text-align: center;
            padding-top: 32px;
            letter-spacing: 0.02em;
        }

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

        @media(max-width: 900px){
            .right{ display: none; }
            .left{
                width: 100%;
                padding: 32px 24px;
            }
            .form-wrap{ max-width: 100%; }
            h1{ font-size: 36px; }
        }

        input[type=password]::-ms-reveal,
        input[type=password]::-ms-clear { display: none; }
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button { visibility: hidden; }
    </style>
</head>
<body x-data="loginInteraction()" @mousemove="handleMouseMove($event)">


<div class="left">
    <a href="<?php echo e(route('home')); ?>" class="logo">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Coursify" class="logo-img">
        <span class="logo-text">Coursify</span>
    </a>

    <div class="form-wrap">
        <h1>Good To See <em>You</em></h1>
        <p class="subtitle">
            Belum punya akun?
            <a href="<?php echo e(route('register')); ?>">Daftar gratis</a>
        </p>

        <?php if(session('status')): ?>
            <div class="status-msg">
                ✓ <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php $__errorArgs = ['google'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error-msg" style="margin-bottom: 20px; text-align: left; background: #FFF0F2; color: #D32F2F; padding: 12px 16px; border-radius: 8px; border: 1px solid #FFCDD2; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?>

            </div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="fa-regular fa-envelope input-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        placeholder="nama@email.com"
                        required
                        autofocus
                        autocomplete="username"
                        class="<?php echo e($errors->has('email') ? 'error' : ''); ?>"
                        @focus="isTyping = true; updatePositions()"
                        @blur="isTyping = false; updatePositions()"
                    >
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-msg">⚠ <?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                        class="<?php echo e($errors->has('password') ? 'error' : ''); ?>"
                        x-model="password"
                        @focus="isTyping = true; updatePositions()"
                        @blur="isTyping = false; updatePositions()"
                        @input="updatePositions()"
                    >
                    <button type="button" class="input-toggle" @click="showPassword = !showPassword; $nextTick(() => updatePositions())" tabindex="-1">
                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-msg">⚠ <?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="remember-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" class="forgot">Lupa password?</a>
                <?php endif; ?>
            </div>

            
            <button type="submit" class="btn-submit">
                Masuk ke Coursify
            </button>
        </form>

        <div class="divider"><span>Atau masuk dengan</span></div>

        <a href="<?php echo e(route('auth.google')); ?>" class="btn-google" style="text-decoration:none;">
            <svg width="18" height="18" viewBox="0 0 48 48">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.36-8.16 2.36-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                <path fill="none" d="M0 0h48v48H0z"/>
            </svg>
            Lanjutkan dengan Google
        </a>

        <div class="demo-hint">
            <div class="demo-hint-grid"></div>
        </div>
    </div>

    <div class="footer-note">
        © <?php echo e(date('Y')); ?> Coursify All rights reserved.
    </div>
</div>


<div class="right">

    
    <h2 class="right-heading">Learn Anything, <em>Anytime</em></h2>

    
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

    
    <div style="display: flex; gap: 24px; justify-content: center; z-index: 10;">
        <a href="<?php echo e(route('privacy')); ?>" style="color: var(--text-soft); font-size: 13px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--text-soft)'">Privacy Policy</a>
        <a href="<?php echo e(route('about')); ?>" style="color: var(--text-soft); font-size: 13px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--text-soft)'">About Us</a>
        <a href="<?php echo e(route('contact')); ?>" style="color: var(--text-soft); font-size: 13px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--text-soft)'">Contact</a>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('loginInteraction', () => ({
            mouseX: 0,
            mouseY: 0,
            isPurpleBlinking: false,
            isBlackBlinking: false,
            isTyping: false,
            isLookingAtEachOther: false,
            isPurplePeeking: false,
            password: '',
            showPassword: false,

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
</script>

</body>
</html><?php /**PATH C:\laragon\www\coursify\resources\views/auth/login.blade.php ENDPATH**/ ?>