{{-- FONT AWESOME --}}
@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    /* ══ ADMIN SIDEBAR ══════════════════════════════════════════ */
    .admin-sidebar {
        width: 260px;
        background: #0F1623;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        padding: 0;
        flex-shrink: 0;
        border-right: 1px solid rgba(255,255,255,0.06);
    }

    /* Logo */
    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 22px 20px 18px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        text-decoration: none;
    }
    .sidebar-logo img {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        object-fit: cover;
        box-shadow: 0 2px 10px rgba(0,0,0,0.4);
    }
    .sidebar-logo-text {
        font-size: 17px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #fff;
    }
    .sidebar-logo-badge {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: rgba(123,111,232,0.25);
        color: #B8AFEB;
        padding: 2px 7px;
        border-radius: 100px;
        border: 1px solid rgba(123,111,232,0.3);
    }

    /* Nav */
    .sidebar-nav {
        flex: 1;
        padding: 12px 12px;
        overflow-y: auto;
    }
    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

    .nav-group-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.25);
        padding: 16px 10px 6px;
    }
    .nav-group-label:first-child { padding-top: 6px; }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        color: rgba(255,255,255,0.5);
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 1px;
    }
    .nav-item i {
        width: 18px;
        text-align: center;
        font-size: 12px;
        opacity: 0.8;
        flex-shrink: 0;
    }
    .nav-item:hover {
        background: rgba(255,255,255,0.07);
        color: rgba(255,255,255,0.85);
    }
    .nav-item.active {
        background: rgba(123,111,232,0.2);
        color: #B8AFEB;
        font-weight: 600;
    }
    .nav-item.active i { opacity: 1; color: #B8AFEB; }

    /* User card at bottom */
    .sidebar-user {
        padding: 12px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }
    .sidebar-user-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        text-decoration: none;
        transition: background 0.2s;
    }
    .sidebar-user-card:hover { background: rgba(255,255,255,0.08); }
    .sidebar-user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7B6FE8, #5B4FD4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        color: white;
        flex-shrink: 0;
    }
    .sidebar-user-name {
        font-size: 13px;
        font-weight: 600;
        color: rgba(255,255,255,0.8);
        line-height: 1.3;
    }
    .sidebar-user-role {
        font-size: 11px;
        color: rgba(255,255,255,0.3);
    }
    .sidebar-user-chevron {
        margin-left: auto;
        font-size: 10px;
        color: rgba(255,255,255,0.2);
    }
</style>
@endpush

@php
    $current = request()->route()->getName();
    function sidebarActive($routeName, $current) {
        return $routeName === $current ? 'nav-item active' : 'nav-item';
    }
@endphp

<aside class="admin-sidebar">

    {{-- Logo --}}
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Coursify">
        <span class="sidebar-logo-text">Coursify</span>
        <span class="sidebar-logo-badge">Admin</span>
    </a>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        {{-- Overview --}}
        <div class="nav-group-label">Overview</div>

        <a href="{{ route('admin.dashboard') }}"
           class="{{ sidebarActive('admin.dashboard', $current) }}">
            <i class="fa-solid fa-chart-line"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.analytics') }}"
           class="{{ sidebarActive('admin.analytics', $current) }}">
            <i class="fa-solid fa-chart-pie"></i>
            Analytics
        </a>

        {{-- Content --}}
        <div class="nav-group-label">Content</div>

        <a href="{{ route('admin.courses.index') }}"
           class="{{ sidebarActive('admin.courses.index', $current) }}">
            <i class="fa-solid fa-book-open"></i>
            Courses
        </a>

        <a href="{{ route('admin.categories') }}"
           class="{{ sidebarActive('admin.categories', $current) }}">
            <i class="fa-solid fa-layer-group"></i>
            Categories
        </a>

        <a href="{{ route('admin.quick-curriculum.index') }}"
           class="{{ sidebarActive('admin.quick-curriculum.index', $current) }}">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
            Quick Curriculum
        </a>

        {{-- Community --}}
        <div class="nav-group-label">Community</div>

        <a href="{{ route('admin.users') }}"
           class="{{ str_starts_with($current, 'admin.users') ? 'nav-item active' : 'nav-item' }}">
            <i class="fa-solid fa-users"></i>
            Users
        </a>

        <a href="{{ route('admin.institutions') }}"
           class="{{ sidebarActive('admin.institutions', $current) }}">
            <i class="fa-solid fa-school"></i>
            Institutions
        </a>

        <a href="{{ route('admin.approvals') }}"
           class="{{ sidebarActive('admin.approvals', $current) }}">
            <i class="fa-solid fa-circle-check"></i>
            Approvals
        </a>

        <a href="{{ route('admin.reviews') }}"
           class="{{ sidebarActive('admin.reviews', $current) }}">
            <i class="fa-solid fa-star"></i>
            Reviews
        </a>

        <a href="{{ route('admin.reports') }}"
           class="{{ sidebarActive('admin.reports', $current) }}">
            <i class="fa-solid fa-flag"></i>
            Reports
        </a>

        {{-- Finance --}}
        <div class="nav-group-label">Finance</div>

        <a href="{{ route('admin.transactions') }}"
           class="{{ sidebarActive('admin.transactions', $current) }}">
            <i class="fa-solid fa-credit-card"></i>
            Transactions
        </a>

        <a href="{{ route('admin.payouts') }}"
           class="{{ sidebarActive('admin.payouts', $current) }}">
            <i class="fa-solid fa-wallet"></i>
            Payouts
        </a>

        {{-- System --}}
        <div class="nav-group-label">System</div>

        <a href="{{ route('admin.settings') }}"
           class="{{ sidebarActive('admin.settings', $current) }}">
            <i class="fa-solid fa-gear"></i>
            Settings
        </a>

        <a href="{{ route('admin.logs') }}"
           class="{{ sidebarActive('admin.logs', $current) }}">
            <i class="fa-solid fa-file-lines"></i>
            Logs
        </a>

    </nav>

    {{-- Admin user card at bottom --}}
    <div class="sidebar-user">
        <a href="{{ route('admin.settings') }}" class="sidebar-user-card">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="sidebar-user-name">{{ Str::limit(auth()->user()->name ?? 'Admin', 18) }}</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
            <i class="fa-solid fa-ellipsis sidebar-user-chevron"></i>
        </a>
    </div>

</aside>
