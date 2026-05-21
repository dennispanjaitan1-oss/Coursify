<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Profile Settings — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
    (function() {
        const theme = "{{ auth()->user()->theme ?? 'light' }}";
        if (theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    })();
</script>

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
    --teal-light: #E6FBF5;
    --orange: #FF8A5B;
    --orange-light: #FFF0E8;
    --gold: #FFC452;
    --gold-light: #FFF7E0;
    --red: #EF4444;
    --red-light: #FEE2E2;
    --text: #1A1825;
    --text-soft: #4A4660;
    --muted: #8B87A8;
    --border: rgba(30,58,95,0.08);
    --font-serif: 'Instrument Serif', serif;
    --font-sans: 'Inter', sans-serif;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
    font-family: var(--font-sans);
    color: var(--text);
    background: linear-gradient(180deg, #EDE5F9 0%, #D8CEEE 50%, #C4B8E8 100%);
    background-attachment: fixed;
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
    padding-top: 90px;
}

body::before {
    content: '';
    position: fixed;
    inset: 0;
    background:
        radial-gradient(ellipse 800px 400px at 20% 10%, rgba(255,255,255,0.5), transparent),
        radial-gradient(ellipse 600px 300px at 80% 30%, rgba(255,255,255,0.4), transparent),
        radial-gradient(ellipse 700px 400px at 50% 90%, rgba(255,255,255,0.3), transparent);
    pointer-events: none;
    z-index: 0;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 1;
}

/* ═══ NAVBAR ═══ */
.navbar-wrap {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 100;
    padding: 20px 20px 0;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.navbar-wrap.navbar-hidden { transform: translateY(-120%); }
.navbar-wrap.navbar-scrolled .navbar {
    background: rgba(255,255,255,0.9);
    box-shadow: 0 10px 40px rgba(30,58,95,0.1);
}
.navbar {
    max-width: 900px;
    margin: 0 auto;
    background: rgba(255,255,255,0.65);
    backdrop-filter: blur(30px) saturate(180%);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    padding: 8px 8px 8px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 40px rgba(30,58,95,0.08);
}
.logo { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text); }
.logo-img { width: 34px; height: 34px; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 8px rgba(30,58,95,0.2); }
.logo-text { font-size: 17px; font-weight: 700; letter-spacing: -0.02em; }

.nav-links { display: flex; gap: 2px; }
.nav-link {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-soft);
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 100px;
    transition: all 0.2s;
}
.nav-link:hover { background: rgba(255,255,255,0.7); color: var(--text); }

.btn-nav {
    padding: 9px 18px;
    background: #1A1825;
    color: white;
    border-radius: 100px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-nav:hover { background: #2A2840; transform: translateY(-1px); }

/* ═══ USER DROPDOWN ═══ */
.user-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    padding: 6px 14px 6px 6px;
    cursor: pointer;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 500;
    color: var(--text);
    transition: all 0.2s;
}
.user-btn:hover {
    background: rgba(255,255,255,0.95);
    box-shadow: 0 4px 12px rgba(30,58,95,0.08);
}
.user-avatar-nav {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 12px;
    flex-shrink: 0;
}
.user-name-nav { white-space: nowrap; }
.user-dropdown {
    position: absolute;
    right: 0;
    top: calc(100% + 12px);
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    padding: 8px;
    min-width: 240px;
    box-shadow: 0 20px 50px rgba(30,58,95,0.15);
    z-index: 100;
}
.dropdown-header {
    padding: 10px 12px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    margin-bottom: 6px;
}
.dropdown-name { font-size: 13px; font-weight: 600; color: var(--text); }
.dropdown-email {
    font-size: 11px;
    color: var(--muted);
    margin-top: 2px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 12px;
    border-radius: 10px;
    color: var(--text-soft);
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s;
    background: transparent;
    border: none;
    width: 100%;
    cursor: pointer;
    text-align: left;
    font-family: var(--font-sans);
    font-weight: 500;
}
.dropdown-item:hover {
    background: rgba(123,111,232,0.08);
    color: var(--text);
}
.dropdown-item.active-route {
    background: rgba(123,111,232,0.12);
    color: var(--purple-dark);
    font-weight: 600;
}
.dropdown-item-danger { color: var(--orange); }
.dropdown-item-danger:hover { background: rgba(255,138,91,0.08); color: var(--orange); }

/* ═══ FLASH ═══ */
.flash-wrap {
    position: fixed;
    top: 90px;
    right: 24px;
    z-index: 101;
    max-width: 400px;
    animation: slideInRight 0.4s ease-out;
}
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(50px); }
    to { opacity: 1; transform: translateX(0); }
}
.flash {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 14px;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: 0 10px 40px rgba(30,58,95,0.15);
}
.flash-success { border-left: 4px solid var(--teal); }
.flash-error { border-left: 4px solid var(--orange); }

/* ═══ PAGE HEADER ═══ */
.page-header {
    text-align: center;
    padding: 40px 20px 24px;
    position: relative;
    z-index: 1;
}

.page-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 500;
    color: var(--text-soft);
    margin-bottom: 18px;
}

.page-badge-dot {
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

.page-title {
    font-family: var(--font-serif);
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 400;
    line-height: 1.05;
    letter-spacing: -0.02em;
    margin-bottom: 12px;
    padding-bottom: 0.1em;
    overflow: visible;
}

.page-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
    padding-bottom: 0.15em;
    margin-top: 0.05em;
    overflow: visible;
}

.page-subtitle {
    font-size: 15px;
    line-height: 1.6;
    color: var(--text-soft);
    max-width: 520px;
    margin: 0 auto;
}

/* ═══ MAIN LAYOUT ═══ */
.main-section {
    padding: 20px 20px 60px;
}

.layout-grid {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 24px;
    max-width: 1080px;
    margin: 0 auto;
    align-items: start;
}

/* ═══ SIDEBAR TABS ═══ */
.tabs-sidebar {
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    padding: 12px;
    position: sticky;
    top: 110px;
    box-shadow: 0 4px 20px rgba(30,58,95,0.04);
}

.tab-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 12px;
    text-decoration: none;
    color: var(--text-soft);
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
    margin-bottom: 4px;
    cursor: pointer;
    background: transparent;
    border: none;
    width: 100%;
    text-align: left;
    font-family: var(--font-sans);
}

.tab-link:last-child { margin-bottom: 0; }

.tab-link:hover {
    background: var(--lav-1);
    color: var(--text);
}

.tab-link.active {
    background: linear-gradient(135deg, var(--purple), var(--purple-dark));
    color: white;
    box-shadow: 0 4px 12px rgba(123,111,232,0.3);
}

.tab-icon {
    width: 20px;
    font-size: 16px;
    text-align: center;
}

/* ═══ CONTENT CARD ═══ */
.content-card {
    background: rgba(255,255,255,0.65);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(30,58,95,0.04);
}

.card-header {
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}

.card-title {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 400;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
    padding-bottom: 0.05em;
}

.card-title em {
    font-style: italic;
    color: var(--purple);
}

.card-desc {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.5;
}

/* ═══ AVATAR SECTION ═══ */
.avatar-section {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 24px;
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
    border: 1px solid rgba(123,111,232,0.15);
    border-radius: 16px;
    margin-bottom: 28px;
}

.avatar-large {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white;
    font-size: 36px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(30,58,95,0.2);
    position: relative;
}

.avatar-upload-btn {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 32px;
    height: 32px;
    background: white;
    border: 2px solid var(--purple);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 13px;
    color: var(--purple);
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.avatar-upload-btn:hover {
    background: var(--purple);
    color: white;
    transform: scale(1.1);
}

.avatar-info { flex: 1; min-width: 0; }

.avatar-name {
    font-family: var(--font-serif);
    font-size: 24px;
    font-weight: 400;
    letter-spacing: -0.01em;
    margin-bottom: 4px;
    line-height: 1.2;
}

.avatar-email {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 10px;
}

.avatar-role {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    background: rgba(123,111,232,0.15);
    color: var(--purple-dark);
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* ═══ FORM ═══ */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group-full {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--text-soft);
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.form-label .required {
    color: var(--orange);
    margin-left: 2px;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 12px 16px;
    background: rgba(255,255,255,0.8);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    font-family: var(--font-sans);
    font-size: 14px;
    color: var(--text);
    outline: none;
    transition: all 0.2s;
}

.form-input::placeholder,
.form-textarea::placeholder { color: var(--muted); }

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    background: white;
    border-color: var(--purple);
    box-shadow: 0 0 0 4px rgba(123,111,232,0.1);
}

.form-input.error,
.form-textarea.error {
    border-color: var(--orange);
    background: rgba(255,138,91,0.03);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
    font-family: var(--font-sans);
    line-height: 1.6;
}

.form-error {
    font-size: 12px;
    color: var(--orange);
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
    font-weight: 500;
}

.form-help {
    font-size: 11px;
    color: var(--muted);
    margin-top: 6px;
    line-height: 1.5;
}

.form-input-icon {
    position: relative;
}

.form-input-icon input {
    padding-left: 42px;
}

.form-input-icon .icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 15px;
    pointer-events: none;
}

/* ═══ FORM ACTIONS ═══ */
.form-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    padding-top: 24px;
    border-top: 1px solid var(--border);
    margin-top: 8px;
}

.form-actions-info {
    flex: 1;
    font-size: 12px;
    color: var(--muted);
}

.btn-cancel {
    padding: 11px 22px;
    background: rgba(255,255,255,0.7);
    border: 1.5px solid var(--border);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-cancel:hover {
    background: white;
    border-color: var(--muted);
    color: var(--text);
}

.btn-save {
    padding: 11px 24px;
    background: #1A1825;
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(26,24,37,0.3);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-save:hover {
    background: #2A2840;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26,24,37,0.4);
}

.btn-danger {
    padding: 11px 24px;
    background: var(--red);
    color: white;
    border: none;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-danger:hover {
    background: #DC2626;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(239,68,68,0.3);
}

/* ═══ DANGER ZONE ═══ */
.danger-zone {
    margin-top: 24px;
    padding: 20px;
    background: rgba(239,68,68,0.05);
    border: 1px solid rgba(239,68,68,0.2);
    border-radius: 14px;
}

.danger-title {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    color: var(--red);
    margin-bottom: 4px;
}

.danger-desc {
    font-size: 13px;
    color: var(--text-soft);
    line-height: 1.5;
    margin-bottom: 16px;
}

/* ═══ TOGGLE SWITCH ═══ */
.toggle-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    background: rgba(255,255,255,0.5);
    border: 1px solid var(--border);
    border-radius: 12px;
    margin-bottom: 10px;
}

.toggle-info { flex: 1; }

.toggle-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 3px;
}

.toggle-desc {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.5;
}

.toggle-switch {
    position: relative;
    width: 42px;
    height: 24px;
    background: var(--lav-2);
    border-radius: 100px;
    cursor: pointer;
    transition: background 0.2s;
    flex-shrink: 0;
    border: none;
}

.toggle-switch.active {
    background: var(--purple);
}

.toggle-switch::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    transition: transform 0.2s;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.toggle-switch.active::after {
    transform: translateX(18px);
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 900px) {
    .layout-grid { grid-template-columns: 1fr; }
    .tabs-sidebar { position: static; }
    .form-grid { grid-template-columns: 1fr; }
    .avatar-section { flex-direction: column; text-align: center; }
}

@media (max-width: 640px) {
    .nav-links { display: none; }
    .user-name-nav { display: none; }
    .content-card { padding: 24px; }
    .form-actions { flex-direction: column-reverse; align-items: stretch; }
    .form-actions .btn-save,
    .form-actions .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}
</style>
</head>
<body>

{{-- NAVBAR --}}
@include('partials.navbar')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="flash-wrap" x-data x-init="setTimeout(() => $el.remove(), 4000)">
        <div class="flash flash-success"><i class="fa-solid fa-check"></i> {{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="flash-wrap" x-data x-init="setTimeout(() => $el.remove(), 4000)">
        <div class="flash flash-error"><i class="fa-solid fa-xmark"></i> {{ session('error') }}</div>
    </div>
@endif


{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="container">
        <div class="page-badge">
            <span class="page-badge-dot"></span>
            <span>Account settings</span>
        </div>

        <h1 class="page-title">
            Profile <em>Settings</em>
        </h1>

        <p class="page-subtitle">
            Manage your personal information, security, and preferences.
        </p>
    </div>
</section>

{{-- MAIN CONTENT --}}
<section class="main-section" x-data="{ activeTab: '{{ $errors->has('current_password') || $errors->has('password') ? 'security' : 'profile' }}' }">
    <div class="container">
        <div class="layout-grid">

            {{-- ═══════════════════════════════════════════════ --}}
            {{-- SIDEBAR TABS                                    --}}
            {{-- ═══════════════════════════════════════════════ --}}
            <aside class="tabs-sidebar">
                <button @click="activeTab = 'profile'"
                        :class="{ 'active': activeTab === 'profile' }"
                        class="tab-link">
                    <span class="tab-icon"><i class="fa-regular fa-user"></i></span>
                    <span>Profile</span>
                </button>

                <button @click="activeTab = 'security'"
                        :class="{ 'active': activeTab === 'security' }"
                        class="tab-link">
                    <span class="tab-icon"><i class="fa-solid fa-lock"></i></span>
                    <span>Security</span>
                </button>

                <button @click="activeTab = 'notifications'"
                        :class="{ 'active': activeTab === 'notifications' }"
                        class="tab-link">
                    <span class="tab-icon"><i class="fa-regular fa-bell"></i></span>
                    <span>Notifications</span>
                </button>

                <button @click="activeTab = 'preferences'"
                        :class="{ 'active': activeTab === 'preferences' }"
                        class="tab-link">
                    <span class="tab-icon"><i class="fa-solid fa-palette"></i></span>
                    <span>Preferences</span>
                </button>

                <button @click="activeTab = 'billing'"
                        :class="{ 'active': activeTab === 'billing' }"
                        class="tab-link">
                    <span class="tab-icon"><i class="fa-regular fa-credit-card"></i></span>
                    <span>Billing</span>
                </button>
            </aside>

            {{-- ═══════════════════════════════════════════════ --}}
            {{-- TAB CONTENTS                                    --}}
            {{-- ═══════════════════════════════════════════════ --}}
            <div>
                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                {{-- TAB 1: PROFILE                              --}}
                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                <div class="content-card" x-show="activeTab === 'profile'" x-transition>
                    <div class="card-header">
                        <h2 class="card-title">Personal <em>Information</em></h2>
                        <p class="card-desc">Update your profile details and public information.</p>
                    </div>

                    {{-- Avatar Section --}}
                    <div class="avatar-section">
                        <div class="avatar-large" id="avatar-large-container">
                            @if(auth()->user()->avatar_url)
                                <img src="{{ asset(auth()->user()->avatar_url) }}" alt="Avatar" id="avatar-large-img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                <span id="avatar-large-initial">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @endif
                            <button type="button" class="avatar-upload-btn" onclick="triggerAvatarUpload()" title="Change photo">
                                <i class="fa-solid fa-camera"></i>
                            </button>
                        </div>
                        <input type="file" id="avatar-file-input" style="display:none;" accept="image/*" onchange="uploadAvatar(this)">
                        <div class="avatar-info">
                            <div class="avatar-name">{{ auth()->user()->name }}</div>
                            <div class="avatar-email">{{ auth()->user()->email }}</div>
                            @php
                                $role = auth()->user()->role ?? 'student';
                                $roleLabel = match($role) {
                                    'admin' => '<i class="fa-solid fa-gear"></i> Administrator',
                                    'instructor' => '<i class="fa-solid fa-chalkboard-user"></i> Instructor',
                                    default => '<i class="fa-solid fa-graduation-cap"></i> Student',
                                };
                            @endphp
                            <span class="avatar-role">{!! $roleLabel !!}</span>
                        </div>
                    </div>

                    {{-- Profile Form --}}
                    <form method="POST" action="{{ route('student.profile.update') }}" id="profile-settings-form">
                        @csrf

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="name">
                                    Full Name <span class="required">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    placeholder="Your full name"
                                    required
                                >
                                @error('name')
                                    <div class="form-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">
                                    Email Address <span class="required">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                                    value="{{ old('email', auth()->user()->email) }}"
                                    placeholder="you@email.com"
                                    required
                                >
                                @error('email')
                                    <div class="form-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group form-group-full">
                                <label class="form-label" for="headline">Headline</label>
                                <input
                                    type="text"
                                    id="headline"
                                    name="headline"
                                    class="form-input"
                                    value="{{ old('headline', auth()->user()->headline) }}"
                                    placeholder="e.g., Aspiring Full-Stack Developer"
                                    maxlength="100"
                                >
                                <div class="form-help">A short professional tagline that appears under your name (max 100 characters).</div>
                            </div>

                            <div class="form-group form-group-full">
                                <label class="form-label" for="bio">Bio</label>
                                <textarea
                                    id="bio"
                                    name="bio"
                                    class="form-textarea"
                                    placeholder="Tell us a bit about yourself, your interests, and what you're learning..."
                                    maxlength="500"
                                    rows="4"
                                >{{ old('bio', auth()->user()->bio) }}</textarea>
                                <div class="form-help">Brief description for your profile. Maximum 500 characters.</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="website_url">Website</label>
                                <div class="form-input-icon">
                                    <span class="icon"><i class="fa-solid fa-globe"></i></span>
                                    <input
                                        type="url"
                                        id="website_url"
                                        name="website_url"
                                        class="form-input"
                                        value="{{ old('website_url', auth()->user()->website_url ?? '') }}"
                                        placeholder="https://yourwebsite.com"
                                    >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="linkedin_url">LinkedIn</label>
                                <div class="form-input-icon">
                                    <span class="icon">in</span>
                                    <input
                                        type="url"
                                        id="linkedin_url"
                                        name="linkedin_url"
                                        class="form-input"
                                        value="{{ old('linkedin_url', auth()->user()->linkedin_url ?? '') }}"
                                        placeholder="https://linkedin.com/in/..."
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="form-actions-info">
                                * Required fields
                            </div>
                            <a href="{{ route('student.index') }}" class="btn-cancel">Cancel</a>
                            <button type="submit" class="btn-save">
                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                {{-- TAB 2: SECURITY                             --}}
                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                <div class="content-card" x-show="activeTab === 'security'" x-transition>
                    <div class="card-header">
                        <h2 class="card-title">Password & <em>Security</em></h2>
                        <p class="card-desc">Update your password and manage account security.</p>
                    </div>

                    <form method="POST" action="{{ route('student.profile.password') }}" x-data="{ showCurrent: false, showNew: false, showConfirm: false }" id="password-settings-form">
                        @csrf

                        <div class="form-grid" style="grid-template-columns: 1fr;">
                            <div class="form-group">
                                <label class="form-label" for="current_password">
                                    Current Password <span class="required">*</span>
                                </label>
                                <div class="form-input-icon" style="position:relative;">
                                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                    <input
                                        :type="showCurrent ? 'text' : 'password'"
                                        id="current_password"
                                        name="current_password"
                                        class="form-input {{ $errors->has('current_password') ? 'error' : '' }}"
                                        placeholder="Enter your current password"
                                        required
                                        style="padding-right: 42px;"
                                    >
                                    <button type="button" @click="showCurrent = !showCurrent"
                                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:15px;color:var(--muted);">
                                        <span x-show="!showCurrent"><i class="fa-regular fa-eye"></i></span>
                                        <span x-show="showCurrent"><i class="fa-regular fa-eye-slash"></i></span>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="form-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">
                                    New Password <span class="required">*</span>
                                </label>
                                <div class="form-input-icon" style="position:relative;">
                                    <span class="icon"><i class="fa-solid fa-key"></i></span>
                                    <input
                                        :type="showNew ? 'text' : 'password'"
                                        id="password"
                                        name="password"
                                        class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                                        placeholder="At least 8 characters"
                                        required
                                        minlength="8"
                                        style="padding-right: 42px;"
                                    >
                                    <button type="button" @click="showNew = !showNew"
                                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:15px;color:var(--muted);">
                                        <span x-show="!showNew"><i class="fa-regular fa-eye"></i></span>
                                        <span x-show="showNew"><i class="fa-regular fa-eye-slash"></i></span>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="form-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</div>
                                @enderror
                                <div class="form-help">Minimum 8 characters. Use a mix of letters, numbers, and symbols for better security.</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">
                                    Confirm New Password <span class="required">*</span>
                                </label>
                                <div class="form-input-icon" style="position:relative;">
                                    <span class="icon"><i class="fa-solid fa-key"></i></span>
                                    <input
                                        :type="showConfirm ? 'text' : 'password'"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="form-input"
                                        placeholder="Repeat new password"
                                        required
                                        style="padding-right: 42px;"
                                    >
                                    <button type="button" @click="showConfirm = !showConfirm"
                                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:15px;color:var(--muted);">
                                        <span x-show="!showConfirm"><i class="fa-regular fa-eye"></i></span>
                                        <span x-show="showConfirm"><i class="fa-regular fa-eye-slash"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="form-actions-info">
                                <i class="fa-solid fa-shield-halved"></i> Your password is encrypted and secure
                            </div>
                            <button type="submit" class="btn-save">
                                <i class="fa-solid fa-lock"></i> Update Password
                            </button>
                        </div>
                    </form>

                    {{-- Two-Factor Auth Info --}}
                    <div style="margin-top: 28px; padding: 20px; background: linear-gradient(135deg, var(--teal-light), rgba(255,255,255,0.5)); border: 1px solid rgba(0,200,150,0.2); border-radius: 14px;">
                        <div style="display: flex; align-items: flex-start; gap: 14px;">
                            <div style="font-size: 28px;"><i class="fa-solid fa-shield-halved"></i></div>
                            <div style="flex: 1;">
                                <div style="font-family: var(--font-serif); font-size: 18px; margin-bottom: 4px;">
                                    Two-Factor <em style="color: var(--teal);">Authentication</em>
                                </div>
                                <p style="font-size: 13px; color: var(--text-soft); line-height: 1.6; margin-bottom: 12px;">
                                    Add an extra layer of security to your account by enabling 2FA. You'll need to enter a code from your authenticator app when signing in.
                                </p>
                                <button type="button" style="padding: 8px 16px; background: var(--teal); color: white; border: none; border-radius: 100px; font-size: 12px; font-weight: 600; cursor: pointer;" onclick="alert('2FA feature coming soon!')">
                                    Enable 2FA
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Danger Zone --}}
                    <div class="danger-zone">
                        <div class="danger-title">Delete Account</div>
                        <p class="danger-desc">
                            Permanently delete your account and all associated data. This action cannot be undone — all your course progress, certificates, and saved items will be lost forever.
                        </p>
                        <button type="button" class="btn-danger" onclick="openDeleteModal()">
                            <i class="fa-solid fa-trash-can"></i> Delete My Account
                        </button>
                    </div>
                </div>

                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                {{-- TAB 3: NOTIFICATIONS                        --}}
                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                <div class="content-card" x-show="activeTab === 'notifications'" x-transition
                     x-data="{
                        email_courses: true,
                        email_promo: false,
                        email_newsletter: true,
                        push_progress: true,
                        push_reminders: false,
                        push_new_courses: true,
                     }">
                    <div class="card-header">
                        <h2 class="card-title">Notification <em>Preferences</em></h2>
                        <p class="card-desc">Choose how you want to receive updates and alerts.</p>
                    </div>

                    {{-- Email Notifications --}}
                    <div style="margin-bottom: 28px;">
                        <div style="font-family: var(--font-serif); font-size: 20px; margin-bottom: 14px;">
                            <i class="fa-regular fa-envelope"></i> Email Notifications
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Course Updates</div>
                                <div class="toggle-desc">Get notified when there are new lessons, updates, or announcements in your enrolled courses.</div>
                            </div>
                            <button type="button"
                                    @click="email_courses = !email_courses"
                                    :class="{ 'active': email_courses }"
                                    class="toggle-switch"></button>
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Promotional Emails</div>
                                <div class="toggle-desc">Receive special offers, discounts, and deals on courses.</div>
                            </div>
                            <button type="button"
                                    @click="email_promo = !email_promo"
                                    :class="{ 'active': email_promo }"
                                    class="toggle-switch"></button>
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Weekly Newsletter</div>
                                <div class="toggle-desc">Get a weekly digest of new courses, trending topics, and learning tips.</div>
                            </div>
                            <button type="button"
                                    @click="email_newsletter = !email_newsletter"
                                    :class="{ 'active': email_newsletter }"
                                    class="toggle-switch"></button>
                        </div>
                    </div>

                    {{-- Push Notifications --}}
                    <div style="margin-bottom: 28px;">
                        <div style="font-family: var(--font-serif); font-size: 20px; margin-bottom: 14px;">
                            <i class="fa-regular fa-bell"></i> Push Notifications
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Learning Progress</div>
                                <div class="toggle-desc">Celebrate your milestones — certificates earned, lessons completed, and streaks.</div>
                            </div>
                            <button type="button"
                                    @click="push_progress = !push_progress"
                                    :class="{ 'active': push_progress }"
                                    class="toggle-switch"></button>
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">Study Reminders</div>
                                <div class="toggle-desc">Daily reminders to continue your learning journey and build a habit.</div>
                            </div>
                            <button type="button"
                                    @click="push_reminders = !push_reminders"
                                    :class="{ 'active': push_reminders }"
                                    class="toggle-switch"></button>
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-label">New Course Alerts</div>
                                <div class="toggle-desc">Get notified when new courses are published in categories you're interested in.</div>
                            </div>
                            <button type="button"
                                    @click="push_new_courses = !push_new_courses"
                                    :class="{ 'active': push_new_courses }"
                                    class="toggle-switch"></button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="form-actions-info">
                            💡 Changes are saved automatically
                        </div>
                        <button type="button" class="btn-save" onclick="showToast('Notification preferences saved!', 'success')">
                            ✓ Save Preferences
                        </button>
                    </div>
                </div>

                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                {{-- TAB 4: PREFERENCES                          --}}
                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                <div class="content-card" x-show="activeTab === 'preferences'" x-transition>
                    <form id="preferences-settings-form" method="POST" action="{{ route('student.profile.preferences') }}">
                        @csrf
                        <input type="hidden" name="theme" id="theme-input" value="{{ auth()->user()->theme ?? 'light' }}">

                        <div class="card-header">
                            <h2 class="card-title">Learning <em>Preferences</em></h2>
                            <p class="card-desc">Customize your learning experience on Coursify.</p>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="language">Display Language</label>
                                <select id="language" name="language" class="form-select">
                                    <option value="id" {{ (auth()->user()->language ?? 'id') == 'id' ? 'selected' : '' }}>🇮🇩 Bahasa Indonesia</option>
                                    <option value="en" {{ (auth()->user()->language ?? 'id') == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                                    <option value="ja" {{ (auth()->user()->language ?? 'id') == 'ja' ? 'selected' : '' }}>🇯🇵 日本語</option>
                                    <option value="ko" {{ (auth()->user()->language ?? 'id') == 'ko' ? 'selected' : '' }}>🇰🇷 한국어</option>
                                </select>
                                <div class="form-help">Language used across the Coursify interface.</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="timezone">Timezone</label>
                                <select id="timezone" name="timezone" class="form-select">
                                    <option value="Asia/Jakarta" {{ (auth()->user()->timezone ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>🌏 Asia/Jakarta (WIB, UTC+7)</option>
                                    <option value="Asia/Makassar" {{ (auth()->user()->timezone ?? 'Asia/Jakarta') == 'Asia/Makassar' ? 'selected' : '' }}>🌏 Asia/Makassar (WITA, UTC+8)</option>
                                    <option value="Asia/Jayapura" {{ (auth()->user()->timezone ?? 'Asia/Jakarta') == 'Asia/Jayapura' ? 'selected' : '' }}>🌏 Asia/Jayapura (WIT, UTC+9)</option>
                                    <option value="UTC" {{ (auth()->user()->timezone ?? 'Asia/Jakarta') == 'UTC' ? 'selected' : '' }}>🌍 UTC (Universal)</option>
                                </select>
                                <div class="form-help">Used for displaying dates and scheduling.</div>
                            </div>

                            <div class="form-group form-group-full">
                                <label class="form-label">Theme Preference</label>
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 4px;">
                                    <button type="button" class="theme-option {{ (auth()->user()->theme ?? 'light') == 'light' ? 'active' : '' }}" data-theme="light">
                                        <div style="background: white; border: 2px solid var(--border); border-radius: 10px; padding: 18px; margin-bottom: 8px; height: 70px; display: flex; align-items: center; justify-content: center; font-size: 28px;">☀️</div>
                                        <div style="font-size: 12px; font-weight: 600;">Light</div>
                                    </button>
                                    <button type="button" class="theme-option {{ (auth()->user()->theme ?? 'light') == 'dark' ? 'active' : '' }}" data-theme="dark">
                                        <div style="background: linear-gradient(135deg, #1A1825, #2A2840); border: 2px solid var(--border); border-radius: 10px; padding: 18px; margin-bottom: 8px; height: 70px; display: flex; align-items: center; justify-content: center; font-size: 28px;">🌙</div>
                                        <div style="font-size: 12px; font-weight: 600;">Dark</div>
                                    </button>
                                    <button type="button" class="theme-option {{ (auth()->user()->theme ?? 'light') == 'auto' ? 'active' : '' }}" data-theme="auto">
                                        <div style="background: linear-gradient(135deg, white 50%, #1A1825 50%); border: 2px solid var(--border); border-radius: 10px; padding: 18px; margin-bottom: 8px; height: 70px; display: flex; align-items: center; justify-content: center; font-size: 28px;">💫</div>
                                        <div style="font-size: 12px; font-weight: 600;">Auto</div>
                                    </button>
                                </div>
                                <div class="form-help" style="margin-top: 10px;">Choose your preferred color scheme. "Auto" follows your system settings.</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="playback_speed">Default Video Speed</label>
                                <select id="playback_speed" name="playback_speed" class="form-select">
                                    <option value="0.5" {{ (auth()->user()->playback_speed ?? '1') == '0.5' ? 'selected' : '' }}>0.5x (Slow)</option>
                                    <option value="0.75" {{ (auth()->user()->playback_speed ?? '1') == '0.75' ? 'selected' : '' }}>0.75x</option>
                                    <option value="1" {{ (auth()->user()->playback_speed ?? '1') == '1' ? 'selected' : '' }}>1x (Normal)</option>
                                    <option value="1.25" {{ (auth()->user()->playback_speed ?? '1') == '1.25' ? 'selected' : '' }}>1.25x</option>
                                    <option value="1.5" {{ (auth()->user()->playback_speed ?? '1') == '1.5' ? 'selected' : '' }}>1.5x</option>
                                    <option value="2" {{ (auth()->user()->playback_speed ?? '1') == '2' ? 'selected' : '' }}>2x (Fast)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="quality">Video Quality</label>
                                <select id="quality" name="video_quality" class="form-select">
                                    <option value="auto" {{ (auth()->user()->video_quality ?? 'auto') == 'auto' ? 'selected' : '' }}>Auto</option>
                                    <option value="1080p" {{ (auth()->user()->video_quality ?? 'auto') == '1080p' ? 'selected' : '' }}>1080p HD</option>
                                    <option value="720p" {{ (auth()->user()->video_quality ?? 'auto') == '720p' ? 'selected' : '' }}>720p</option>
                                    <option value="480p" {{ (auth()->user()->video_quality ?? 'auto') == '480p' ? 'selected' : '' }}>480p</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="form-actions-info"></div>
                            <button type="submit" class="btn-save">
                                ✓ Save Preferences
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                {{-- TAB 5: BILLING                              --}}
                {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
                <div class="content-card" x-show="activeTab === 'billing'" x-transition>
                    <div class="card-header">
                        <h2 class="card-title">Billing & <em>Payments</em></h2>
                        <p class="card-desc">Manage your subscription and payment methods.</p>
                    </div>

                    {{-- Current Plan --}}
                    <div style="background: linear-gradient(135deg, var(--navy), #2D4D7A); border-radius: 16px; padding: 24px; color: white; margin-bottom: 20px; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(184,175,235,0.3), transparent); pointer-events: none;"></div>

                        <div style="position: relative; z-index: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                                <div>
                                    <div style="font-size: 11px; color: var(--lav-4); font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 6px;">Current Plan</div>
                                    <div style="font-family: var(--font-serif); font-size: 32px; font-weight: 400; line-height: 1; padding-bottom: 2px;">
                                        <em style="color: var(--lav-4);">Free</em> Plan
                                    </div>
                                </div>
                                <span style="padding: 6px 14px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius: 100px; font-size: 11px; font-weight: 700; letter-spacing: 0.05em;">
                                    ACTIVE
                                </span>
                            </div>

                            <p style="font-size: 13px; color: rgba(255,255,255,0.8); line-height: 1.6; margin-bottom: 20px;">
                                You're on the Free plan. Upgrade to Pro to unlock all premium courses, certificates, and advanced features.
                            </p>

                            <a href="{{ route('home') }}#pricing" style="display: inline-flex; align-items: center; gap: 6px; padding: 11px 22px; background: white; color: var(--navy); text-decoration: none; border-radius: 100px; font-size: 13px; font-weight: 700;">
                                ✨ Upgrade to Pro
                            </a>
                        </div>
                    </div>

                    {{-- Payment Methods --}}
                    <div style="margin-bottom: 20px;">
                        <div style="font-family: var(--font-serif); font-size: 20px; margin-bottom: 14px;">
                            <i class="fa-regular fa-credit-card"></i> Payment Methods
                        </div>

                        <div class="payment-method-card" style="padding: 20px; background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 12px; text-align: center;">
                            <div style="font-size: 36px; margin-bottom: 8px;"><i class="fa-regular fa-credit-card"></i></div>
                            <div style="font-size: 14px; color: var(--text-soft); margin-bottom: 12px;">
                                No payment methods added yet
                            </div>
                            <button type="button" style="padding: 10px 20px; background: #1A1825; color: white; border: none; border-radius: 100px; font-size: 12px; font-weight: 600; cursor: pointer;" onclick="alert('Payment integration coming soon!')">
                                + Add Payment Method
                            </button>
                        </div>
                    </div>

                    {{-- Transaction History --}}
                    <div>
                        <div style="font-family: var(--font-serif); font-size: 20px; margin-bottom: 14px;">
                            📋 Transaction History
                        </div>

                        <div class="transaction-history-card" style="padding: 40px 20px; background: rgba(255,255,255,0.5); border: 1px solid var(--border); border-radius: 12px; text-align: center;">
                            <div style="font-size: 36px; margin-bottom: 8px;">📭</div>
                            <div style="font-family: var(--font-serif); font-size: 18px; margin-bottom: 4px;">No transactions yet</div>
                            <div style="font-size: 12px; color: var(--muted);">
                                Your purchase history will appear here
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div style="height: 60px;"></div>

{{-- ADDITIONAL CSS --}}
<style>
.theme-option {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    text-align: center;
    transition: transform 0.2s;
    font-family: var(--font-sans);
    color: var(--text);
}

.theme-option:hover {
    transform: translateY(-3px);
}

.theme-option.active > div:first-child {
    border-color: var(--purple) !important;
    box-shadow: 0 0 0 3px rgba(123,111,232,0.2);
}

.theme-option.active > div:last-child {
    color: var(--purple);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
/* PREMIUM DARK MODE THEME SYSTEM             */
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
html[data-theme="dark"] body {
    background: linear-gradient(180deg, #100E19 0%, #151322 50%, #1A1828 100%) !important;
    color: #E2DEFC !important;
}

html[data-theme="dark"] body::before {
    background:
        radial-gradient(ellipse 800px 400px at 20% 10%, rgba(123,111,232,0.12), transparent),
        radial-gradient(ellipse 600px 300px at 80% 30%, rgba(123,111,232,0.08), transparent),
        radial-gradient(ellipse 700px 400px at 50% 90%, rgba(123,111,232,0.05), transparent) !important;
}

html[data-theme="dark"] {
    --text: #F5F1FC;
    --text-soft: #B8AFEB;
    --border: rgba(255,255,255,0.08);
}

html[data-theme="dark"] .navbar {
    background: rgba(21,19,34,0.7) !important;
    border-color: rgba(255,255,255,0.08) !important;
    backdrop-filter: blur(30px) saturate(180%) !important;
}

html[data-theme="dark"] .navbar-wrap.navbar-scrolled .navbar {
    background: rgba(21,19,34,0.95) !important;
}

html[data-theme="dark"] .profile-sidebar,
html[data-theme="dark"] .content-card {
    background: rgba(21,19,34,0.65) !important;
    border-color: rgba(255,255,255,0.08) !important;
    box-shadow: 0 20px 50px rgba(0,0,0,0.4) !important;
}

html[data-theme="dark"] .form-input,
html[data-theme="dark"] .form-textarea,
html[data-theme="dark"] .form-select {
    background: rgba(255,255,255,0.03) !important;
    border-color: rgba(255,255,255,0.1) !important;
    color: #F5F1FC !important;
}

html[data-theme="dark"] .form-input:focus,
html[data-theme="dark"] .form-textarea:focus,
html[data-theme="dark"] .form-select:focus {
    background: rgba(255,255,255,0.06) !important;
    border-color: var(--purple) !important;
}

html[data-theme="dark"] .card-title {
    color: #FFFFFF !important;
}

html[data-theme="dark"] .card-desc {
    color: #B8AFEB !important;
}

html[data-theme="dark"] .form-label {
    color: #B8AFEB !important;
}

html[data-theme="dark"] .form-help {
    color: #8B87A8 !important;
}

html[data-theme="dark"] .sidebar-nav-title {
    color: #8B87A8 !important;
}

html[data-theme="dark"] .nav-link {
    color: #B8AFEB !important;
}

html[data-theme="dark"] .nav-link:hover {
    background: rgba(255,255,255,0.04) !important;
    color: #FFFFFF !important;
}

html[data-theme="dark"] .nav-link.active {
    background: rgba(255,255,255,0.08) !important;
    color: #FFFFFF !important;
    border-left-color: var(--purple) !important;
}

html[data-theme="dark"] .profile-stats-card {
    background: rgba(255,255,255,0.02) !important;
    border-color: rgba(255,255,255,0.06) !important;
}

html[data-theme="dark"] .stat-val {
    color: #FFFFFF !important;
}

html[data-theme="dark"] .stat-lbl {
    color: #B8AFEB !important;
}

html[data-theme="dark"] .payment-method-card,
html[data-theme="dark"] .transaction-history-card {
    background: rgba(255,255,255,0.02) !important;
    border-color: rgba(255,255,255,0.06) !important;
    color: #B8AFEB !important;
}

html[data-theme="dark"] .payment-method-card .form-help,
html[data-theme="dark"] .transaction-history-card .form-help {
    color: #8B87A8 !important;
}

html[data-theme="dark"] .btn-cancel {
    background: rgba(255,255,255,0.05) !important;
    color: #F5F1FC !important;
    border-color: rgba(255,255,255,0.08) !important;
}

html[data-theme="dark"] .btn-cancel:hover {
    background: rgba(255,255,255,0.1) !important;
}

html[data-theme="dark"] .theme-option {
    color: #F5F1FC !important;
}
</style>

{{-- JAVASCRIPT --}}
<script>
    // Prevent browser bfcache
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });

    // Auto hide/show navbar on scroll
    (function() {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;

        let lastScroll = 0;
        let ticking = false;
        const scrollThreshold = 100;

        function updateNavbar() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 20) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }

            if (currentScroll < scrollThreshold) {
                navbar.classList.remove('navbar-hidden');
                lastScroll = currentScroll;
                ticking = false;
                return;
            }

            if (currentScroll > lastScroll + 5) {
                navbar.classList.add('navbar-hidden');
            } else if (currentScroll < lastScroll - 5) {
                navbar.classList.remove('navbar-hidden');
            }

            lastScroll = currentScroll;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(updateNavbar);
                ticking = true;
            }
        }, { passive: true });
    })();

    // Theme switcher
    document.querySelectorAll('.theme-option').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.theme-option').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const theme = this.dataset.theme;
            const themeInput = document.getElementById('theme-input');
            if (themeInput) {
                themeInput.value = theme;
            }
            
            // Instantly apply theme preview on document
            if (theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
            
            showToast(`Theme set to ${theme}`, 'success');
        });
    });

    // Delete account modal functions
    function openDeleteModal() {
        const modal = document.getElementById('delete-modal');
        const input = document.getElementById('delete-confirm-input');
        const btnDelete = document.getElementById('btn-modal-confirm-delete');
        const error = document.getElementById('delete-error-message');
        
        input.value = '';
        btnDelete.disabled = true;
        btnDelete.classList.remove('ready');
        error.style.display = 'none';
        
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('active');
            input.focus();
        }, 10);
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    // Toast helper
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 100px;
            right: 24px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            box-shadow: 0 10px 40px rgba(30,58,95,0.15);
            z-index: 9999;
            border-left: 4px solid ${type === 'success' ? 'var(--teal)' : type === 'error' ? 'var(--orange)' : 'var(--purple)'};
            animation: slideInRight 0.3s ease;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }

    // ────────────────────────────────────────────────────────────────
    // AVATAR REAL-TIME UPLOAD
    // ────────────────────────────────────────────────────────────────
    function triggerAvatarUpload() {
        document.getElementById('avatar-file-input').click();
    }

    function uploadAvatar(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        if (!file.type.match('image.*')) {
            showToast('Hanya file gambar yang diperbolehkan!', 'error');
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            showToast('Ukuran gambar maksimal adalah 2MB!', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('avatar', file);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) return;

        const container = document.getElementById('avatar-large-container');
        const origHTML = container.innerHTML;
        container.innerHTML = `
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.3);">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; color: white;"></i>
            </div>
        `;

        showToast('Mengunggah foto profil...', 'info');

        fetch('{{ route('student.profile.avatar') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update avatar di profile settings secara instan
                container.innerHTML = `
                    <img src="${data.avatar_url}" alt="Avatar" id="avatar-large-img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <button class="avatar-upload-btn" onclick="triggerAvatarUpload()" title="Change photo"><i class="fa-solid fa-camera"></i></button>
                `;
                
                // Update avatar di navbar atas
                const navbarAvatar = document.querySelector('.navbar-wrap button img');
                const navbarAvatarDiv = document.querySelector('.navbar-wrap button div');
                if (navbarAvatar) {
                    navbarAvatar.src = data.avatar_url;
                } else if (navbarAvatarDiv) {
                    navbarAvatarDiv.innerHTML = `<img src="${data.avatar_url}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">`;
                }

                showToast('Foto profil berhasil diperbarui!', 'success');
            } else {
                container.innerHTML = origHTML;
                showToast(data.message || 'Gagal mengunggah foto.', 'error');
            }
        })
        .catch(err => {
            container.innerHTML = origHTML;
            console.error(err);
            showToast('Terjadi kesalahan koneksi saat mengunggah.', 'error');
        });
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX PROFILE FORM SUBMISSION
    // ────────────────────────────────────────────────────────────────
    const profileForm = document.getElementById('profile-settings-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear errors
            profileForm.querySelectorAll('.form-error').forEach(el => el.remove());
            profileForm.querySelectorAll('.form-input, .form-textarea').forEach(el => el.classList.remove('error'));

            const saveBtn = profileForm.querySelector('.btn-save');
            const origBtnContent = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

            const formData = new FormData(profileForm);

            fetch(profileForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = origBtnContent;

                if (data.errors) {
                    // Render validation errors
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const input = profileForm.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('error');
                            const errDiv = document.createElement('div');
                            errDiv.className = 'form-error';
                            errDiv.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${messages[0]}`;
                            input.parentNode.appendChild(errDiv);
                        }
                    }
                    showToast('Harap periksa kembali input Anda.', 'error');
                } else if (data.success) {
                    showToast(data.message || 'Profil berhasil disimpan!', 'success');

                    // Update nama & email di seluruh halaman secara real-time
                    const avatarName = document.querySelector('.avatar-name');
                    if (avatarName) avatarName.textContent = data.user.name;

                    const avatarEmail = document.querySelector('.avatar-email');
                    if (avatarEmail) avatarEmail.textContent = data.user.email;

                    // Update navbar name
                    const navName = document.querySelector('.navbar-wrap button span');
                    if (navName) navName.textContent = data.user.name.length > 10 ? data.user.name.substring(0, 10) + '...' : data.user.name;

                    // Update navbar initials if no avatar_url
                    const avatarInitial = document.getElementById('avatar-large-initial');
                    if (avatarInitial) {
                        avatarInitial.textContent = data.user.initial;
                    }
                    const navAvatarDiv = document.querySelector('.navbar-wrap button div');
                    if (navAvatarDiv && !navAvatarDiv.querySelector('img')) {
                        navAvatarDiv.textContent = data.user.initial;
                    }
                }
            })
            .catch(err => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = origBtnContent;
                console.error(err);
                showToast('Terjadi kesalahan koneksi.', 'error');
            });
        });
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX PASSWORD FORM SUBMISSION
    // ────────────────────────────────────────────────────────────────
    const passwordForm = document.getElementById('password-settings-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear errors
            passwordForm.querySelectorAll('.form-error').forEach(el => el.remove());
            passwordForm.querySelectorAll('.form-input').forEach(el => el.classList.remove('error'));

            const saveBtn = passwordForm.querySelector('.btn-save');
            const origBtnContent = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

            const formData = new FormData(passwordForm);

            fetch(passwordForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = origBtnContent;

                if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const input = passwordForm.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('error');
                            const errDiv = document.createElement('div');
                            errDiv.className = 'form-error';
                            errDiv.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${messages[0]}`;
                            // Masukkan ke parent node, tapi perhatikan jika ada input-icon wrapper
                            const targetParent = input.parentNode.classList.contains('form-input-icon') ? input.parentNode.parentNode : input.parentNode;
                            targetParent.appendChild(errDiv);
                        }
                    }
                    showToast('Harap periksa kembali password Anda.', 'error');
                } else if (data.success) {
                    showToast(data.message || 'Password berhasil diperbarui!', 'success');
                    passwordForm.reset();
                }
            })
            .catch(err => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = origBtnContent;
                console.error(err);
                showToast('Terjadi kesalahan koneksi.', 'error');
            });
        });
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX PREFERENCES FORM SUBMISSION
    // ────────────────────────────────────────────────────────────────
    const preferencesForm = document.getElementById('preferences-settings-form');
    if (preferencesForm) {
        preferencesForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear errors
            preferencesForm.querySelectorAll('.form-error').forEach(el => el.remove());
            preferencesForm.querySelectorAll('.form-select').forEach(el => el.classList.remove('error'));

            const saveBtn = preferencesForm.querySelector('.btn-save');
            const origBtnContent = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

            const formData = new FormData(preferencesForm);

            fetch(preferencesForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = origBtnContent;

                if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const input = preferencesForm.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('error');
                            const errDiv = document.createElement('div');
                            errDiv.className = 'form-error';
                            errDiv.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${messages[0]}`;
                            input.parentNode.appendChild(errDiv);
                        }
                    }
                    showToast('Harap periksa kembali input Anda.', 'error');
                } else if (data.success) {
                    showToast(data.message || 'Preferensi berhasil disimpan!', 'success');
                }
            })
            .catch(err => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = origBtnContent;
                console.error(err);
                showToast('Terjadi kesalahan koneksi.', 'error');
            });
        });
    }

    // Bind typing input to check matching phrase
    const deleteConfirmInput = document.getElementById('delete-confirm-input');
    if (deleteConfirmInput) {
        deleteConfirmInput.addEventListener('input', function() {
            const btnDelete = document.getElementById('btn-modal-confirm-delete');
            
            if (this.value.trim().toUpperCase() === 'DELETE MY ACCOUNT') {
                btnDelete.disabled = false;
                btnDelete.classList.add('ready');
                this.classList.add('valid');
            } else {
                btnDelete.disabled = true;
                btnDelete.classList.remove('ready');
                this.classList.remove('valid');
            }
        });
    }
    
    // Confirm delete trigger via AJAX and animated progress
    const btnModalConfirmDelete = document.getElementById('btn-modal-confirm-delete');
    if (btnModalConfirmDelete) {
        btnModalConfirmDelete.addEventListener('click', function() {
            const input = document.getElementById('delete-confirm-input');
            if (!input || input.value.trim().toUpperCase() !== 'DELETE MY ACCOUNT') {
                const error = document.getElementById('delete-error-message');
                if (error) error.style.display = 'block';
                return;
            }

            // Start Deletion Sequence
            const modalContent = document.querySelector('#delete-modal .modal-content');
            const mainHeader = document.querySelector('#delete-modal .modal-header');
            const mainBody = document.querySelector('#delete-modal .modal-body');
            const mainFooter = document.querySelector('#delete-modal .modal-footer');
            
            const processingView = document.getElementById('delete-processing-view');
            const successView = document.getElementById('delete-success-view');
            const progressBar = document.getElementById('delete-progress-bar');
            const progressStatus = document.getElementById('processing-status');

            // Hide standard modal blocks
            mainHeader.style.display = 'none';
            mainBody.style.display = 'none';
            mainFooter.style.display = 'none';

            // Show processing screen with custom glassmorphic styling
            modalContent.classList.add('processing-state');
            processingView.style.display = 'block';

            // Progressive statuses with custom timing
            const steps = [
                { percent: 15, msg: '<i class="fa-solid fa-lock"></i> Mengamankan sesi pengguna...' },
                { percent: 35, msg: '📚 Menghapus data pendaftaran & kemajuan kursus...' },
                { percent: 60, msg: '<i class="fa-solid fa-graduation-cap"></i> Menarik kembali sertifikat terbit...' },
                { percent: 80, msg: '💖 Membersihkan daftar keinginan & favorit...' },
                { percent: 95, msg: '<i class="fa-solid fa-trash-can"></i> Menghapus identitas akun secara permanen...' }
            ];

            let stepIdx = 0;
            const progressInterval = setInterval(() => {
                if (stepIdx < steps.length) {
                    progressBar.style.width = steps[stepIdx].percent + '%';
                    progressStatus.style.opacity = '0';
                    setTimeout(() => {
                        progressStatus.textContent = steps[stepIdx].msg;
                        progressStatus.style.opacity = '1';
                    }, 150);
                    stepIdx++;
                }
            }, 800);

            // Execute Laravel AJAX Delete Account POST Request
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            fetch("{{ route('student.profile.delete') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    confirm_phrase: 'DELETE MY ACCOUNT'
                })
            })
            .then(res => {
                if (!res.ok) throw new Error('Penghapusan gagal pada server.');
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    // Let the animation finish beautifully
                    setTimeout(() => {
                        clearInterval(progressInterval);
                        progressBar.style.width = '100%';
                        progressStatus.textContent = '🧹 Menyelesaikan pembersihan data...';
                        
                        setTimeout(() => {
                            // Fade from processing to success view
                            processingView.style.opacity = '0';
                            setTimeout(() => {
                                processingView.style.display = 'none';
                                modalContent.classList.remove('processing-state');
                                modalContent.classList.add('success-state');
                                successView.style.display = 'block';
                                successView.style.opacity = '0';
                                setTimeout(() => {
                                    successView.style.opacity = '1';
                                    showToast('Akun Anda berhasil dihapus selamanya.', 'success');
                                }, 50);
                                
                                // Redirect to home after 3.5 seconds
                                setTimeout(() => {
                                    window.location.href = '/';
                                }, 3500);
                            }, 300);
                        }, 800);
                    }, Math.max(0, (steps.length - stepIdx) * 800));
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan tidak dikenal.');
                }
            })
            .catch(err => {
                clearInterval(progressInterval);
                console.error(err);
                
                // Return modal to normal warning state
                processingView.style.display = 'none';
                modalContent.classList.remove('processing-state');
                
                mainHeader.style.display = 'flex';
                mainBody.style.display = 'block';
                mainFooter.style.display = 'flex';
                
                showToast(err.message || 'Gagal memproses penghapusan akun.', 'error');
            });
        });
    }
</script>

<!-- Custom Delete Confirmation Modal Overlay -->
<div id="delete-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <!-- Default Modal Header -->
        <div class="modal-header">
            <span class="modal-icon"><i class="fa-solid fa-triangle-exclamation"></i>️</span>
            <h3 class="modal-title">Hapus Akun?</h3>
        </div>
        
        <!-- Default Modal Body -->
        <div class="modal-body">
            <p class="modal-warning">Apakah Anda benar-benar yakin ingin menghapus akun Anda? Tindakan ini <strong>tidak dapat dibatalkan</strong>.</p>
            
            <div class="modal-data-loss">
                <h4>Seluruh data Anda akan terhapus secara permanen:</h4>
                <ul>
                    <li> Progres belajar & riwayat pendaftaran kelas</li>
                    <li> Sertifikat kelulusan yang telah diterbitkan</li>
                    <li> Kelas favorit & item wishlist tersimpan</li>
                    <li> Ulasan, feedback, & diskusi yang pernah ditulis</li>
                </ul>
            </div>
            
            <p class="modal-instruction">Untuk melanjutkan, ketik frasa konfirmasi <span class="confirm-phrase">DELETE MY ACCOUNT</span> di bawah:</p>
            
            <input type="text" id="delete-confirm-input" class="modal-input" placeholder="Ketik DELETE MY ACCOUNT untuk mengonfirmasi">
            <div id="delete-error-message" class="modal-error" style="display: none;"><i class="fa-solid fa-triangle-exclamation"></i> Frasa konfirmasi tidak cocok.</div>
        </div>
        
        <!-- Default Modal Footer -->
        <div class="modal-footer">
            <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Batal</button>
            <button type="button" id="btn-modal-confirm-delete" class="btn-modal-delete" disabled>Hapus Selamanya</button>
        </div>

        <!-- Processing View (Hidden by Default) -->
        <div id="delete-processing-view" style="display: none; text-align: center; padding: 20px 0; transition: opacity 0.3s ease;">
            <div class="processing-spinner-container">
                <div class="processing-glow-ring"></div>
                <div class="processing-icon"><i class="fa-solid fa-trash-can"></i></div>
            </div>
            <h3 style="font-family: var(--font-serif); font-size: 22px; margin-top: 24px; margin-bottom: 8px;">Menghapus Akun...</h3>
            <p id="processing-status" style="font-size: 13px; color: var(--text-soft); min-height: 20px; transition: opacity 0.3s ease;">
                Menghubungkan ke server...
            </p>
            <div class="progress-bar-container">
                <div class="progress-bar-fill" id="delete-progress-bar"></div>
            </div>
        </div>

        <!-- Success View (Hidden by Default) -->
        <div id="delete-success-view" style="display: none; text-align: center; padding: 20px 0; transition: opacity 0.3s ease;">
            <div class="success-checkmark-container">
                <div class="success-glow-ring"></div>
                <div class="success-icon">✨</div>
            </div>
            <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--teal); margin-top: 24px; margin-bottom: 8px;">Selamat Tinggal!</h3>
            <p style="font-size: 14px; color: var(--text-soft); line-height: 1.6; max-width: 320px; margin: 0 auto;">
                Akun Anda berhasil dihapus sepenuhnya dari sistem Coursify. Kami sedih melihat Anda pergi, namun kami mendoakan kesuksesan Anda di masa depan!
            </p>
            <div style="font-size: 11px; color: var(--muted); margin-top: 24px; letter-spacing: 0.05em; text-transform: uppercase; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fa-solid fa-spinner fa-spin"></i> Mengalihkan halaman...
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Delete Confirmation Modal Styles */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 8, 20, 0.65);
    backdrop-filter: blur(20px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
}

.modal-content {
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 24px;
    width: 90%;
    max-width: 500px;
    padding: 32px;
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.15);
    transform: scale(0.9);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), background 0.3s, border-color 0.3s;
    font-family: var(--font-sans);
    color: var(--text);
    position: relative;
    overflow: hidden;
}

html[data-theme="dark"] .modal-content {
    background: rgba(21, 19, 34, 0.85);
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.5);
    color: #F5F1FC;
}

.modal-content.processing-state {
    border-color: rgba(239, 68, 68, 0.3);
    box-shadow: 0 0 40px rgba(239, 68, 68, 0.15), 0 30px 70px rgba(0, 0, 0, 0.2);
}

.modal-content.success-state {
    border-color: rgba(20, 184, 166, 0.3);
    box-shadow: 0 0 40px rgba(20, 184, 166, 0.15), 0 30px 70px rgba(0, 0, 0, 0.2);
}

.modal-overlay.active .modal-content {
    transform: scale(1);
}

.modal-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.modal-icon {
    font-size: 32px;
    animation: pulseIcon 2s infinite;
}

@keyframes pulseIcon {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}

.modal-title {
    font-family: var(--font-serif);
    font-size: 26px;
    font-weight: 500;
}

.modal-warning {
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.modal-data-loss {
    background: rgba(239, 68, 68, 0.05);
    border: 1px solid rgba(239, 68, 68, 0.15);
    border-radius: 16px;
    padding: 18px;
    margin-bottom: 20px;
}

html[data-theme="dark"] .modal-data-loss {
    background: rgba(239, 68, 68, 0.08);
    border-color: rgba(239, 68, 68, 0.25);
}

.modal-data-loss h4 {
    font-size: 13px;
    font-weight: 600;
    color: var(--red);
    margin-bottom: 10px;
}

.modal-data-loss ul {
    list-style: none;
    font-size: 13px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding-left: 0;
}

.modal-instruction {
    font-size: 13px;
    margin-bottom: 10px;
}

.confirm-phrase {
    font-weight: 700;
    color: var(--red);
    background: rgba(239, 68, 68, 0.08);
    padding: 2px 6px;
    border-radius: 6px;
}

.modal-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--border);
    border-radius: 12px;
    font-size: 13px;
    background: rgba(255, 255, 255, 0.5);
    outline: none;
    transition: all 0.2s;
    margin-bottom: 12px;
}

html[data-theme="dark"] .modal-input {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.1);
    color: #F5F1FC;
}

.modal-input:focus {
    border-color: var(--red);
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
}

.modal-input.valid {
    border-color: var(--teal) !important;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12) !important;
}

.modal-error {
    font-size: 12px;
    color: var(--red);
    margin-bottom: 10px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}

.btn-modal-cancel {
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.5);
    border: 1px solid var(--border);
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    color: var(--text);
}

html[data-theme="dark"] .btn-modal-cancel {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.08);
    color: #F5F1FC;
}

.btn-modal-cancel:hover {
    background: rgba(255, 255, 255, 0.8);
}

html[data-theme="dark"] .btn-modal-cancel:hover {
    background: rgba(255, 255, 255, 0.1);
}

.btn-modal-delete {
    padding: 10px 24px;
    background: var(--red);
    color: white;
    border: none;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    cursor: not-allowed;
    transition: all 0.2s;
    opacity: 0.5;
}

.btn-modal-delete.ready {
    cursor: pointer;
    opacity: 1;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
}

.btn-modal-delete.ready:hover {
    background: #DC2626;
    transform: translateY(-1px);
}

/* Sleek Processing & Success Animations */
.processing-spinner-container, .success-checkmark-container {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.processing-glow-ring {
    position: absolute;
    inset: -4px;
    border: 4px solid rgba(239, 68, 68, 0.1);
    border-top-color: var(--red);
    border-radius: 50%;
    animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
}

.success-glow-ring {
    position: absolute;
    inset: -4px;
    border: 4px solid rgba(20, 184, 166, 0.15);
    border-radius: 50%;
    box-shadow: 0 0 20px rgba(20, 184, 166, 0.3);
    animation: pulseGlow 2s infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes pulseGlow {
    0%, 100% { transform: scale(1); box-shadow: 0 0 15px rgba(20, 184, 166, 0.2); }
    50% { transform: scale(1.08); box-shadow: 0 0 30px rgba(20, 184, 166, 0.5); }
}

.processing-icon {
    font-size: 36px;
    filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.3));
    animation: floatIcon 2s ease-in-out infinite;
}

.success-icon {
    font-size: 36px;
    filter: drop-shadow(0 0 10px rgba(20, 184, 166, 0.4));
    animation: bouncePopIcon 1.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) infinite alternate;
}

@keyframes floatIcon {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}

@keyframes bouncePopIcon {
    0% { transform: scale(0.9) rotate(-8deg); }
    100% { transform: scale(1.1) rotate(8deg); }
}

.progress-bar-container {
    width: 80%;
    height: 6px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 100px;
    margin: 20px auto 0;
    overflow: hidden;
    position: relative;
}

html[data-theme="light"] .progress-bar-container {
    background: rgba(0, 0, 0, 0.05);
}

.progress-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, var(--red), var(--pink));
    border-radius: 100px;
    transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

</body>
</html>