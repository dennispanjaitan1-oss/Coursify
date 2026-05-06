<nav class="navbar-wrap" id="mainNavbar">
    <div class="navbar">
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
            <a href="{{ route('login') }}" class="btn-nav">Get Started</a>
        @else
            <div style="position:relative;" x-data="{ userOpen: false }">
                <button @click="userOpen = !userOpen" class="user-btn">
                    <div class="user-avatar-nav">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="user-name-nav">{{ Str::limit(auth()->user()->name, 10) }}</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" :style="userOpen ? 'transform:rotate(180deg)' : ''" style="transition: transform 0.2s;">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div x-show="userOpen"
                     @click.away="userOpen = false"
                     x-transition
                     class="user-dropdown">

                    <div class="dropdown-header">
                        <div class="dropdown-name">{{ auth()->user()->name }}</div>
                        <div class="dropdown-email">{{ auth()->user()->email }}</div>
                        <div style="margin-top:6px;">
                            @php
                                $userRole = auth()->user()->role ?? 'student';
                                $roleConfig = [
                                    'admin' => ['bg' => 'linear-gradient(135deg,#1E3A5F,#2D4D7A)', 'text' => 'white', 'label' => '⚙️ ADMIN'],
                                    'instructor' => ['bg' => 'rgba(0,200,150,0.15)', 'text' => '#00805F', 'label' => '👨‍🏫 INSTRUCTOR'],
                                    'student' => ['bg' => 'rgba(123,111,232,0.15)', 'text' => '#5B4FD4', 'label' => '🎓 STUDENT'],
                                ];
                                $rs = $roleConfig[$userRole] ?? $roleConfig['student'];
                            @endphp
                            <span style="display:inline-block;padding:3px 10px;background:{{ $rs['bg'] }};color:{{ $rs['text'] }};border-radius:100px;font-size:10px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;">
                                {{ $rs['label'] }}
                            </span>
                        </div>
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">⚙️ Admin Panel</a>
                        <a href="#" class="dropdown-item">👥 Manage Users</a>
                        <a href="#" class="dropdown-item">📚 Manage Courses</a>
                        <a href="#" class="dropdown-item">💰 Transactions</a>
                    @elseif(auth()->user()->role === 'instructor')
                        <a href="{{ route('instructor.dashboard') }}" class="dropdown-item">📊 Dashboard</a>
                        <a href="{{ route('instructor.courses.index') }}" class="dropdown-item">📚 My Courses</a>
                        <a href="#" class="dropdown-item">✏️ Create Course</a>
                        <a href="#" class="dropdown-item">💰 Earnings</a>
                    @else
                        <a href="{{ route('student.index') }}" class="dropdown-item"> My Dashboard</a>
                        <a href="{{ route('student.courses') }}" class="dropdown-item"> My Courses</a>
                        <a href="{{ route('student.wishlist') }}" class="dropdown-item"> Wishlist</a>
                        <a href="{{ route('student.certificates') }}" class="dropdown-item"> Certificates</a>
                        <a href="{{ route('student.profile') }}" class="dropdown-item"> Profile Settings</a>
                    @endif

                    <div style="border-top:1px solid rgba(0,0,0,0.06);margin-top:6px;padding-top:6px;">
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-item-danger">
                                 Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</nav>