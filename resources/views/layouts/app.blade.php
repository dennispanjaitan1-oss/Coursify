<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Coursify') — Learn Anything, Anytime</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --navy: #1E3A5F;
            --navy-dark: #152B48;
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
            position: relative;
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

        .container { max-width: 1160px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 1; }

        /* ═══ LOGO ═══ */
        .logo-img {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(30,58,95,0.25);
            transition: all 0.3s;
        }
        .logo:hover .logo-img {
            transform: scale(1.08) rotate(-3deg);
        }
        .logo-img-sm { width: 26px; height: 26px; border-radius: 6px; }

        /* ═══ NAVBAR ═══ */
        .navbar-wrap {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 100;
    padding: 20px 20px 0;
    animation: slideDown 0.6s ease-out;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
}

/* Hide state when scrolling down */
.navbar-wrap.navbar-hidden {
    transform: translateY(-120%);
}

/* Navbar compact style when scrolled */
.navbar-wrap.navbar-scrolled .navbar {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(40px) saturate(180%);
    -webkit-backdrop-filter: blur(40px) saturate(180%);
    box-shadow: 0 10px 40px rgba(30,58,95,0.1);
}

/* Add padding top ke body supaya content tidak ketiban navbar */
body {
    padding-top: 90px;
}

@media (max-width: 500px) {
    body {
        padding-top: 80px;
    }
}
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .navbar {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 100px;
            padding: 8px 8px 8px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 40px rgba(30,58,95,0.08);
        }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text); }
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
        .nav-link:active { transform: scale(0.95); }
        .nav-link.active { background: rgba(123,111,232,0.15); color: var(--purple-dark); }

        /* ═══ BUTTONS ═══ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-sans);
            font-weight: 500;
            font-size: 14px;
            padding: 10px 22px;
            border-radius: 100px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }
        .btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.3);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn:active::after { opacity: 1; }
        .btn:active { transform: scale(0.96); }

        .btn-dark {
            background: #1A1825;
            color: white;
            box-shadow: 0 4px 14px rgba(26,24,37,0.3);
        }
        .btn-dark:hover {
            background: #2A2840;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26,24,37,0.4);
        }
        .btn-light {
            background: rgba(255,255,255,0.7);
            color: var(--text);
            border: 1px solid rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
        }
        .btn-light:hover {
            background: rgba(255,255,255,0.95);
            transform: translateY(-2px);
        }

        /* ═══ FLASH ═══ */
        .flash-wrap {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 200;
            max-width: 400px;
        }
        .flash {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 16px;
            padding: 14px 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 10px 40px rgba(30,58,95,0.15);
            animation: slideInRight 0.4s ease-out;
        }
        .flash-success { border-left: 4px solid var(--teal); color: var(--text); }
        .flash-error { border-left: 4px solid var(--orange); color: var(--text); }
        .flash-info { border-left: 4px solid var(--purple); color: var(--text); }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* ═══ FOOTER ═══ */
        .footer-main {
            margin: 40px 20px 20px;
            background: rgba(255,255,255,0.5);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 24px;
            padding: 40px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
        }
        .footer-col-title {
            font-family: var(--font-serif);
            font-size: 15px;
            margin-bottom: 14px;
            color: var(--text);
        }
        .footer-links-col { display: flex; flex-direction: column; gap: 10px; }
        .footer-link {
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-link:hover { color: var(--purple); }
        .footer-brand-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
            margin: 12px 0 20px;
        }
        .footer-social { display: flex; gap: 8px; }
        .footer-social a {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(30,58,95,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--text-soft);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .footer-social a:hover {
            background: var(--navy);
            color: white;
            transform: translateY(-2px);
        }
        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid rgba(30,58,95,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: var(--muted);
        }

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
        .user-btn:hover { background: rgba(255,255,255,0.95); }
        .user-avatar {
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
        }
        .user-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 16px;
            padding: 8px;
            min-width: 220px;
            box-shadow: 0 20px 50px rgba(30,58,95,0.15);
            z-index: 100;
        }
        .dropdown-header {
            padding: 10px 12px;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            margin-bottom: 6px;
        }
        .dropdown-name { font-size: 13px; font-weight: 600; }
        .dropdown-email { font-size: 11px; color: var(--muted); margin-top: 2px; }
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
        .dropdown-item:hover { background: rgba(123,111,232,0.08); color: var(--text); }
        .dropdown-item-danger { color: var(--orange); }
        .dropdown-item-danger:hover { background: rgba(255,138,91,0.08); color: var(--orange); }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .footer-main { padding: 24px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <div class="navbar-wrap" id ="mainNavbar">
        <nav class="navbar">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
                <span class="logo-text">Coursify</span>
            </a>

            <div class="nav-links">
                <a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">Courses</a>
                <a href="{{ route('home') }}#how" class="nav-link">How It Works</a>
                <a href="{{ route('home') }}#pricing" class="nav-link">Pricing</a>
            </div>

            @guest
                <a href="{{ route('login') }}" class="btn btn-dark">Get Started</a>
            @else
                <div style="position:relative;" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" class="user-btn">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                    </button>

                    <div x-show="userOpen" @click.away="userOpen = false" x-transition class="user-dropdown">

    {{-- User Info Header --}}
    <div class="dropdown-header">
        <div class="dropdown-name">{{ auth()->user()->name }}</div>
        <div class="dropdown-email">{{ auth()->user()->email }}</div>
        <div style="margin-top:6px;">
            @php
                $roleColors = [
                    'admin' => ['bg' => 'linear-gradient(135deg,#1E3A5F,#2D4D7A)', 'text' => 'white', 'label' => '⚙️ Administrator'],
                    'instructor' => ['bg' => 'rgba(0,200,150,0.15)', 'text' => '#00805F', 'label' => '👨‍🏫 Instructor'],
                    'student' => ['bg' => 'rgba(123,111,232,0.15)', 'text' => '#5B4FD4', 'label' => '🎓 Student'],
                ];
                $userRole = auth()->user()->role;
                $roleStyle = $roleColors[$userRole] ?? $roleColors['student'];
            @endphp
            <span style="display:inline-block; padding:3px 10px; background:{{ $roleStyle['bg'] }}; color:{{ $roleStyle['text'] }}; border-radius:100px; font-size:10px; font-weight:700; letter-spacing:0.05em; text-transform:uppercase;">
                {{ $roleStyle['label'] }}
            </span>
        </div>
    </div>

    {{-- ═══ ADMIN MENU ═══ --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
            📊 Dashboard
        </a>
        <a href="#" class="dropdown-item">
            👥 Manage Users
        </a>
        <a href="#" class="dropdown-item">
            📚 Manage Courses
        </a>
        <a href="#" class="dropdown-item">
            ✅ Pending Approvals
        </a>
        <a href="#" class="dropdown-item">
            💰 Transactions
        </a>
        <a href="#" class="dropdown-item">
            ⚙️ Settings
        </a>
    @endif

    {{-- ═══ INSTRUCTOR MENU ═══ --}}
    @if(auth()->user()->role === 'instructor')
        <a href="{{ route('instructor.dashboard') }}" class="dropdown-item">
            📊 Dashboard
        </a>
        <a href="#" class="dropdown-item">
            📚 My Courses
        </a>
        <a href="#" class="dropdown-item">
            👥 My Students
        </a>
        <a href="#" class="dropdown-item">
            ✏️ Create Course
        </a>
        <a href="#" class="dropdown-item">
            💰 Earnings
        </a>
        <a href="#" class="dropdown-item">
            👤 Profile Settings
        </a>
    @endif

    {{-- ═══ STUDENT MENU ═══ --}}
    @if(auth()->user()->role === 'student')
        <a href="{{ route('student.index') }}" class="dropdown-item">
            🎓 My Dashboard
        </a>
        <a href="{{ route('student.courses') }}" class="dropdown-item">
            📖 My Courses
        </a>
        <a href="{{ route('student.wishlist') }}" class="dropdown-item">❤️ Wishlist</a>
        </a>
        <a href="{{ route('student.certificates') }}" class="dropdown-item">
            🏆 Certificates
        </a>
        <a href="{{ route('student.profile') }}" class="dropdown-item">
            👤 Profile Settings
        </a>
    @endif

    {{-- Logout (semua role) --}}
    <div style="border-top: 1px solid rgba(0,0,0,0.06); margin-top: 6px; padding-top: 6px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item dropdown-item-danger">
                🚪 Sign Out
            </button>
        </form>
    </div>
</div>
                </div>
            @endguest
        </nav>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success') || session('error') || session('info'))
        <div class="flash-wrap">
            @if(session('success'))
                <div class="flash flash-success" x-data x-init="setTimeout(() => $el.remove(), 4000)">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash flash-error" x-data x-init="setTimeout(() => $el.remove(), 4000)">
                    ✕ {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="flash flash-info" x-data x-init="setTimeout(() => $el.remove(), 4000)">
                    ℹ {{ session('info') }}
                </div>
            @endif
        </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main style="position:relative;z-index:1;">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="footer-main">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img logo-img-sm">
                    <span class="logo-text">Coursify</span>
                </a>
                <p class="footer-brand-desc">Modern learning platform helping you master new skills with world-class instructors. Anytime, anywhere.</p>
                <div class="footer-social">
                    <a href="#">𝕏</a>
                    <a href="#">f</a>
                    <a href="#">in</a>
                    <a href="#">ig</a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">Platform</div>
                <div class="footer-links-col">
                    <a href="{{ route('courses.index') }}" class="footer-link">All Courses</a>
                    <a href="#" class="footer-link">Categories</a>
                    <a href="#" class="footer-link">Instructors</a>
                    <a href="{{ route('home') }}#pricing" class="footer-link">Pricing</a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">Company</div>
                <div class="footer-links-col">
                    <a href="#" class="footer-link">About Us</a>
                    <a href="#" class="footer-link">Blog</a>
                    <a href="#" class="footer-link">Careers</a>
                    <a href="#" class="footer-link">Contact</a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">Support</div>
                <div class="footer-links-col">
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Terms of Service</a>
                    <a href="#" class="footer-link">Become Instructor</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div>© {{ date('Y') }} Coursify. All Rights Reserved.</div>
            <div>Supporting SDG 4 · 8 · 10 🌱</div>
        </div>
    </footer>

        @stack('scripts')

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- JAVASCRIPT: Fix bfcache + Auto-hide Navbar          --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <script>
        // Fix browser bfcache (back button stale UI)
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
    </script>
</body>
</html>