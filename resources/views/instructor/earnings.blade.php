@extends('layouts.instructor')

@section('title', 'Earnings')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="earnings-search" class="sr-only">Search</label>
            <input type="text"
                   id="earnings-search"
                   class="topbar__search-input"
                   placeholder="Search..."
                   aria-label="Search">
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
            <h1 class="page-title">Earnings</h1>
            <p class="page-subtitle">Track your revenue and withdrawals</p>
        </div>
    </section>

    {{-- EARNINGS STATS --}}
    <section class="stats-grid" aria-label="Earnings statistics">
        <article class="stat-card" aria-label="Total Revenue: Rp {{ number_format($totalRevenue) }}">
            <div class="stat-card__icon stat-card__icon--teal" aria-hidden="true">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="stat-card__label">Total Revenue</div>
            <div class="stat-card__value">Rp {{ number_format($totalRevenue) }}</div>
        </article>

        <article class="stat-card" aria-label="Monthly Revenue: Rp {{ number_format($monthlyRevenue) }}">
            <div class="stat-card__icon stat-card__icon--purple" aria-hidden="true">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div class="stat-card__label">This Month</div>
            <div class="stat-card__value">Rp {{ number_format($monthlyRevenue) }}</div>
        </article>

        <article class="stat-card" aria-label="Weekly Revenue: Rp {{ number_format($weeklyRevenue) }}">
            <div class="stat-card__icon stat-card__icon--orange" aria-hidden="true">
                <i class="fa-solid fa-chart-bar"></i>
            </div>
            <div class="stat-card__label">This Week</div>
            <div class="stat-card__value">Rp {{ number_format($weeklyRevenue) }}</div>
        </article>

        <article class="stat-card" aria-label="Pending Payout: Rp {{ number_format($pendingPayout) }}">
            <div class="stat-card__icon stat-card__icon--gold" aria-hidden="true">
                <i class="fa-solid fa-hourglass-end"></i>
            </div>
            <div class="stat-card__label">Pending Payout</div>
            <div class="stat-card__value">Rp {{ number_format($pendingPayout) }}</div>
        </article>
    </section>

    {{-- EARNINGS CHART --}}
    <section class="card-wrap" aria-labelledby="earnings-chart-title">
        <div class="card-head">
            <h2 class="card-title" id="earnings-chart-title">Earnings <em>trend</em></h2>
            <div class="chart-controls">
                <button class="chart-period-btn active">Month</button>
                <button class="chart-period-btn">Year</button>
            </div>
        </div>

        <div class="chart-placeholder" style="height: 300px; display: flex; align-items: center; justify-content: center; background: #F5F1FC; border-radius: 8px; color: #999;">
            <span>Chart visualization will be displayed here</span>
        </div>
    </section>

    {{-- WITHDRAWAL SECTION --}}
    <section class="card-wrap" aria-labelledby="withdrawal-title">
        <div class="card-head">
            <h2 class="card-title" id="withdrawal-title">Withdrawal History</h2>
        </div>

        <div class="empty-state" role="status">
            <div class="empty-state__icon">
                <i class="fa-regular fa-credit-card"></i>
            </div>
            <h3 class="empty-state__title">No withdrawals yet</h3>
            <p class="empty-state__desc">Your first withdrawal will appear here once you have earnings available.</p>
            <button class="btn-primary" style="margin-top: 16px;">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                Request Withdrawal
            </button>
        </div>
    </section>

@endsection
