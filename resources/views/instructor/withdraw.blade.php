@extends('layouts.instructor')

@section('title', 'Withdraw Earnings')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="search" class="sr-only">Search</label>
            <input type="text"
                   id="search"
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
            <h1 class="page-title">Withdraw Earnings</h1>
            <p class="page-subtitle">Manage your withdrawal requests and payments</p>
        </div>
    </section>

    {{-- BALANCE INFO --}}
    <section class="stats-grid" aria-label="Earnings balance">
        <article class="stat-card" aria-label="Available Balance: Rp 0">
            <div class="stat-card__icon stat-card__icon--teal" aria-hidden="true">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="stat-card__label">Available Balance</div>
            <div class="stat-card__value">Rp 0</div>
            <div class="stat-card__trend stat-card__trend--up">
                <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
                Ready to withdraw
            </div>
        </article>

        <article class="stat-card" aria-label="Pending Amount: Rp 0">
            <div class="stat-card__icon stat-card__icon--orange" aria-hidden="true">
                <i class="fa-solid fa-hourglass-end"></i>
            </div>
            <div class="stat-card__label">Pending Amount</div>
            <div class="stat-card__value">Rp 0</div>
        </article>

        <article class="stat-card" aria-label="Total Withdrawn: Rp 0">
            <div class="stat-card__icon stat-card__icon--purple" aria-hidden="true">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div class="stat-card__label">Total Withdrawn</div>
            <div class="stat-card__value">Rp 0</div>
        </article>
    </section>

    {{-- WITHDRAWAL FORM --}}
    <section class="card-wrap" aria-labelledby="withdrawal-form-title">
        <div class="card-head">
            <h2 class="card-title" id="withdrawal-form-title">Request Withdrawal</h2>
        </div>

        <form method="POST" class="withdrawal-form">
            @csrf
            
            <div class="form-group">
                <label for="amount" class="form-label">Withdrawal Amount (Rp) *</label>
                <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" required>
                <div class="form-hint">Minimum withdrawal: Rp 50,000</div>
            </div>

            <div class="form-group">
                <label for="payment-method" class="form-label">Payment Method *</label>
                <select id="payment-method" name="payment_method" class="form-control" required>
                    <option value="">-- Select payment method --</option>
                    <option value="bank-transfer">Bank Transfer</option>
                    <option value="e-wallet">E-Wallet (OVO, Gopay, Dana)</option>
                </select>
            </div>

            <div class="form-group" id="bank-info-group" style="display: none;">
                <label for="bank-name" class="form-label">Bank Name</label>
                <select id="bank-name" name="bank_name" class="form-control">
                    <option value="">-- Select bank --</option>
                    <option value="BCA">BCA</option>
                    <option value="Mandiri">Bank Mandiri</option>
                    <option value="BNI">BNI</option>
                    <option value="CIMB">CIMB Niaga</option>
                </select>
            </div>

            <div class="form-group" id="account-info-group" style="display: none;">
                <label for="account-number" class="form-label">Account Number</label>
                <input type="text" id="account-number" name="account_number" class="form-control" placeholder="1234567890">
            </div>

            <div class="form-group" id="account-holder-group" style="display: none;">
                <label for="account-holder" class="form-label">Account Holder Name</label>
                <input type="text" id="account-holder" name="account_holder" class="form-control" placeholder="Full name">
            </div>

            <div class="form-section-title">Withdrawal Summary</div>

            <div class="summary-row">
                <span>Amount:</span>
                <strong>Rp 0</strong>
            </div>
            <div class="summary-row">
                <span>Fee (5%):</span>
                <strong>Rp 0</strong>
            </div>
            <div class="summary-row summary-row--total">
                <span>You will receive:</span>
                <strong>Rp 0</strong>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary" disabled>
                    <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                    Request Withdrawal
                </button>
                <a href="{{ route('instructor.earnings') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

@endsection
