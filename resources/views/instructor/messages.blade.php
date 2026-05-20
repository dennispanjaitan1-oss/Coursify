@extends('layouts.instructor')

@section('title', 'Messages')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="messages-search" class="sr-only">Search messages</label>
            <input type="text"
                   id="messages-search"
                   class="topbar__search-input"
                   placeholder="Search messages..."
                   aria-label="Search messages">
        </div>

        <div class="topbar__actions">
            <button class="icon-btn"
                    aria-label="Notifications - 2 new"
                    title="Notifications">
                <i class="fa-solid fa-bell" aria-hidden="true"></i>
                <span class="icon-btn__dot" aria-hidden="true"></span>
            </button>
        </div>
    </header>

    {{-- PAGE TITLE --}}
    <section class="page-header" aria-label="Page title">
        <div>
            <h1 class="page-title">Messages</h1>
            <p class="page-subtitle">Communicate with your students and colleagues</p>
        </div>
    </section>

    {{-- MESSAGES SECTION --}}
    <section class="card-wrap" aria-labelledby="messages-title">
        <div class="card-head">
            <h2 class="card-title" id="messages-title">Conversations</h2>
        </div>

        <div class="empty-state" role="status">
            <div class="empty-state__icon">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <h3 class="empty-state__title">Belum ada pesan</h3>
            <p class="empty-state__desc">Pesan dari siswa akan muncul di sini setelah mereka mendaftar di kursus Anda.</p>
        </div>
    </section>

@endsection
