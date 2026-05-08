{{-- NAVBAR --}}
{{-- Tambahkan ini di <head> jika belum ada: --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> 

<nav class="navbar-wrap" id="mainNavbar" x-data="{ userOpen: false }">
    <div class="navbar">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
            <span class="logo-text">Coursify</span>
        </a>

        {{-- Nav Links --}}
        <div class="nav-links">
    <a href="{{ route('courses.index') }}" 
       class="nav-link {{ request()->routeIs('courses.index') || request()->routeIs('courses.show') ? 'active' : '' }}">
        <i class="fa-solid fa-graduation-cap" style="margin-right:5px;"></i>Courses
    </a>
    <a href="{{ route('home') }}#how" 
       class="nav-link">
        <i class="fa-solid fa-circle-info" style="margin-right:5px;"></i>How It Works
    </a>
    <a href="{{ route('home') }}#pricing" 
       class="nav-link">
        <i class="fa-solid fa-tag" style="margin-right:5px;"></i>Pricing
    </a>
</div>

        {{-- Auth --}}
        @guest
            <a href="{{ route('login') }}" class="btn-nav">
                <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right:6px;"></i>Get Started
            </a>
        @else
            <div style="position:relative;">

                {{-- Avatar Button --}}
                <button
                    @click="userOpen = !userOpen"
                    style="
                        display:flex;align-items:center;gap:8px;
                        background:white;border:none;
                        padding:4px 10px 4px 4px;
                        border-radius:100px;cursor:pointer;
                        box-shadow:0 2px 10px rgba(30,58,95,0.1);
                        transition:all 0.2s;
                    "
                    onmouseover="this.style.boxShadow='0 4px 16px rgba(30,58,95,0.15)'"
                    onmouseout="this.style.boxShadow='0 2px 10px rgba(30,58,95,0.1)'"
                >
                    <div style="
                        width:28px;height:28px;border-radius:50%;
                        background:#153759;color:white;
                        font-size:12px;font-weight:700;
                        display:flex;align-items:center;justify-content:center;
                        flex-shrink:0;
                    ">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#1A1825;">
                        {{ Str::limit(auth()->user()->name, 10) }}
                    </span>
                    <i class="fa-solid fa-chevron-down" style="font-size:10px;color:#8B87A8;margin-left:2px;"></i>
                </button>

                {{-- Dropdown --}}
                <div
                    x-show="userOpen"
                    @click.away="userOpen = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    style="
                        display:none;
                        position:absolute;top:calc(100% + 12px);right:0;
                        background:white;border-radius:20px;
                        box-shadow:0 20px 60px rgba(30,58,95,0.15);
                        padding:16px;min-width:240px;
                        border:1px solid rgba(30,58,95,0.08);
                        z-index:200;
                    "
                    x-cloak
                >
                    {{-- User Info --}}
                    <div style="padding:4px 8px 14px;border-bottom:1px solid rgba(30,58,95,0.08);margin-bottom:8px;">
                        <div style="font-size:15px;font-weight:700;color:#1A1825;margin-bottom:2px;">
                            {{ auth()->user()->name }}
                        </div>
                        <div style="font-size:12px;color:#8B87A8;margin-bottom:10px;">
                            {{ auth()->user()->email }}
                        </div>
                        <span style="
                            display:inline-flex;align-items:center;gap:6px;
                            background:rgba(123,111,232,0.12);color:#5B4FD4;
                            font-size:11px;font-weight:700;letter-spacing:0.08em;
                            text-transform:uppercase;padding:4px 12px;border-radius:100px;
                        ">
                            <i class="fa-solid fa-user-graduate" style="font-size:10px;"></i>
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>

                    {{-- Admin Panel (jika admin) --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;" onmouseover="this.style.background='#F5F1FC'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-screwdriver-wrench" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span>Admin Panel</span>
                        </a>
                    @endif

                    {{-- Instructor Dashboard (jika instructor) --}}
                    @if(auth()->user()->role === 'instructor')
                        <a href="{{ route('instructor.dashboard') }}" style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;" onmouseover="this.style.background='#F5F1FC'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-chalkboard-user" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span>Instructor Dashboard</span>
                        </a>
                    @endif

                    {{-- Menu Items --}}
                    @php
                        $menuItems = [
                            [
                                'icon'  => 'fa-gauge-high',
                                'label' => 'My Dashboard',
                                'route' => 'student.index',
                            ],
                            [
                                'icon'  => 'fa-book-open',
                                'label' => 'My Courses',
                                'route' => 'student.courses',
                            ],
                            [
                                'icon'  => 'fa-heart',
                                'label' => 'Wishlist',
                                'route' => 'student.wishlist',
                            ],
                            [
                                'icon'  => 'fa-trophy',
                                'label' => 'Certificates',
                                'route' => 'student.certificates',
                            ],
                        ];
                    @endphp

                    @foreach($menuItems as $item)
                        <a href="{{ route($item['route']) }}"
                            style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;"
                            onmouseover="this.style.background='#F5F1FC'"
                            onmouseout="this.style.background='transparent'"
                        >
                            <i class="fa-solid {{ $item['icon'] }}" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach

                    {{-- Profile Settings --}}
                    <a href="{{ route('student.profile') }}"
                        style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;"
                        onmouseover="this.style.background='#F5F1FC'"
                        onmouseout="this.style.background='transparent'"
                    >
                        <i class="fa-solid fa-user-pen" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                        <span>Profile Settings</span>
                    </a>

                    {{-- Sign Out --}}
                    <div style="border-top:1px solid rgba(30,58,95,0.08);margin-top:8px;padding-top:8px;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                style="display:flex;align-items:center;gap:12px;width:100%;padding:10px 8px;border-radius:10px;background:none;border:none;color:#FF6B35;font-size:14px;font-weight:600;cursor:pointer;transition:background 0.2s;"
                                onmouseover="this.style.background='#FFF0E8'"
                                onmouseout="this.style.background='transparent'"
                            >
                                <i class="fa-solid fa-right-from-bracket" style="width:16px;text-align:center;font-size:13px;"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endguest
    </div>
</nav>