@extends('layouts.instructor')

@section('title', 'Instructor Dashboard')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="dashboard-search" class="sr-only">Search courses, students, messages</label>
            <input type="text"
                   id="dashboard-search"
                   class="topbar__search-input"
                   placeholder="Search your courses, students, messages..."
                   aria-label="Search your courses, students, messages">
        </div>

        <div class="topbar__actions">
            <button class="icon-btn"
                    aria-label="Notifications - 2 new"
                    title="Notifications">
                <i class="fa-solid fa-bell" aria-hidden="true"></i>
                <span class="icon-btn__dot" aria-hidden="true"></span>
            </button>
            <a href="{{ route('instructor.messages') }}" class="icon-btn"
                    aria-label="Messages"
                    title="Messages">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            </a>
            <a href="#" class="btn-primary" aria-label="Create a new course">
                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                Create Course
            </a>
        </div>
    </header>

    {{-- SEMUA KONTEN DALAM SATU x-data="dashboard" --}}
    <div x-data="dashboard">

    {{-- WELCOME HERO --}}
    <section class="welcome-card" aria-label="Welcome summary">
        <div class="welcome-card__content">
            <div class="welcome-card__greeting">
                {{ now()->format('l, d F Y') }} · Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}
            </div>
            <h1 class="welcome-card__title">
                Welcome back, <em>{{ explode(' ', $instructor->name ?? 'Instructor')[0] }}</em>
            </h1>
            <p class="welcome-card__subtitle">
                Your courses are making a difference. {{ $enrollments->count() }} students enrolled recently, keep up the great work!
            </p>
            <div class="welcome-card__actions">
                <a href="#" class="btn-welcome btn-welcome--primary">
                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                    Create New Course
                </a>
                <a href="#" class="btn-welcome btn-welcome--ghost">
                    <i class="fa-solid fa-chart-bar" aria-hidden="true"></i>
                    View Analytics
                </a>
            </div>
        </div>

        <div class="welcome-card__visual">
            <div class="welcome-earnings" role="status" aria-label="Monthly earnings summary">
                <div class="welcome-earnings__label">This Month</div>
                <div class="welcome-earnings__amount">
                    Rp <em>{{ number_format($monthlyRevenue / 1000000, 1) }}M</em>
                </div>
                <div class="welcome-earnings__trend">
                    <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
                    18% vs last month
                </div>
            </div>
        </div>
    </section>

    {{-- STATS GRID --}}
    <section class="stats-grid" aria-label="Key statistics">
        <article class="stat-card" aria-label="Published Courses: {{ $publishedCount }}">
            <div class="stat-card__icon stat-card__icon--purple" aria-hidden="true">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="stat-card__label">Published Courses</div>
            <div class="stat-card__value">{{ $publishedCount }}</div>
            <div class="stat-card__trend stat-card__trend--up">
                <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
                2 this quarter
            </div>
        </article>

        <article class="stat-card" aria-label="Total Students: {{ number_format($studentsCount) }}">
            <div class="stat-card__icon stat-card__icon--teal" aria-hidden="true">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-card__label">Total Students</div>
            <div class="stat-card__value">{{ number_format($studentsCount) }}</div>
            <div class="stat-card__trend stat-card__trend--up">
                <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
                247 this week
            </div>
        </article>

        <article class="stat-card" aria-label="Average Rating: {{ number_format($avgRating, 1) }}">
            <div class="stat-card__icon stat-card__icon--gold" aria-hidden="true">
                <i class="fa-solid fa-star"></i>
            </div>
            <div class="stat-card__label">Average Rating</div>
            <div class="stat-card__value">{{ number_format($avgRating, 1) }}</div>
            <div class="stat-card__trend stat-card__trend--up">
                <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
                0.2 this month
            </div>
        </article>

        <article class="stat-card" aria-label="New Reviews: {{ $reviewsCount }}">
            <div class="stat-card__icon stat-card__icon--orange" aria-hidden="true">
                <i class="fa-solid fa-comment-dots"></i>
            </div>
            <div class="stat-card__label">New Reviews</div>
            <div class="stat-card__value">{{ $reviewsCount }}</div>
            <div class="stat-card__trend stat-card__trend--neutral">
                Last 7 days
            </div>
        </article>
    </section>

    {{-- REVENUE CHART + TOP COURSES --}}
    <div class="two-col-grid">

        {{-- Revenue Chart --}}
        <section class="card-wrap" aria-labelledby="revenue-title">
            <div class="card-head">
                <h2 class="card-title" id="revenue-title">Revenue <em>overview</em></h2>
                <div class="card-tabs" role="tablist" aria-label="Revenue time period">
                    <button class="card-tab" role="tab" aria-selected="false" aria-controls="revenue-7d">7D</button>
                    <button class="card-tab active" role="tab" aria-selected="true" aria-controls="revenue-30d">30D</button>
                    <button class="card-tab" role="tab" aria-selected="false" aria-controls="revenue-1y">1Y</button>
                </div>
            </div>

            <div class="revenue-summary" role="group" aria-label="Revenue summary numbers">
                <div>
                    <div class="revenue-item-label">Total Revenue</div>
                    <div class="revenue-item-value">
                        Rp <em>{{ number_format($totalRevenue / 1000000, 1) }}M</em>
                    </div>
                </div>
                <div>
                    <div class="revenue-item-label">This Month</div>
                    <div class="revenue-item-value">
                        Rp {{ number_format($monthlyRevenue / 1000000, 1) }}M
                    </div>
                </div>
                <div>
                    <div class="revenue-item-label">Pending Payout</div>
                    <div class="revenue-item-value">
                        Rp {{ number_format($pendingPayout / 1000000, 1) }}M
                    </div>
                </div>
            </div>

            <div class="chart-line-container" role="img" aria-label="Revenue chart showing upward trend over 4 weeks">
                <svg class="chart-svg" viewBox="0 0 400 180" preserveAspectRatio="none" aria-hidden="true">
                    <defs>
                        <linearGradient id="lineGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#7B6FE8" stop-opacity="0.3"/>
                            <stop offset="100%" stop-color="#7B6FE8" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <line x1="0" y1="45" x2="400" y2="45" stroke="#E8E1F3" stroke-dasharray="4,4"/>
                    <line x1="0" y1="90" x2="400" y2="90" stroke="#E8E1F3" stroke-dasharray="4,4"/>
                    <line x1="0" y1="135" x2="400" y2="135" stroke="#E8E1F3" stroke-dasharray="4,4"/>
                    <path d="M 0,130 L 40,110 L 80,85 L 120,95 L 160,70 L 200,60 L 240,50 L 280,65 L 320,40 L 360,25 L 400,30 L 400,180 L 0,180 Z"
                          fill="url(#lineGrad)"/>
                    <path d="M 0,130 L 40,110 L 80,85 L 120,95 L 160,70 L 200,60 L 240,50 L 280,65 L 320,40 L 360,25 L 400,30"
                          stroke="#7B6FE8" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                    <circle cx="320" cy="40" r="5" fill="white" stroke="#7B6FE8" stroke-width="2.5"/>
                    <circle cx="360" cy="25" r="5" fill="white" stroke="#7B6FE8" stroke-width="2.5"/>
                    <circle cx="400" cy="30" r="6" fill="#7B6FE8"/>
                </svg>
            </div>

            <div class="chart-labels" aria-hidden="true">
                @foreach($revenueChart as $week)
                    <span class="chart-label">{{ $week['label'] }}</span>
                @endforeach
            </div>
        </section>

        {{-- Top Courses --}}
        <section class="card-wrap" aria-labelledby="top-courses-title">
            <div class="card-head">
                <h2 class="card-title" id="top-courses-title">Top <em>courses</em></h2>
                <a href="#" class="section-link">
                    All <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            <div class="top-courses-list" role="list" aria-label="Top performing courses">
                @foreach($topCourses as $course)
                    <div class="top-course-item" role="listitem">
                        <div class="top-course-rank {{ $course['rank'] === 1 ? 'gold' : '' }}"
                             aria-label="Rank {{ $course['rank'] }}">
                            {{ $course['rank'] }}
                        </div>
                        <div class="top-course-thumb top-course-thumb--{{ $course['gradient'] }}" aria-hidden="true">
                            <i class="fa-solid {{ $course['icon'] }}"></i>
                        </div>
                        <div class="top-course-info">
                            <div class="top-course-title">{{ $course['title'] }}</div>
                            <div class="top-course-meta">
                                <i class="fa-solid fa-users" aria-hidden="true"></i>
                                {{ $course['students'] }} students
                            </div>
                        </div>
                        <div>
                            <div class="top-course-stat">Rp {{ number_format($course['revenue'] / 1000000, 1) }}M</div>
                            <div class="top-course-stat-label">Revenue</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    {{-- COURSES MANAGEMENT TABLE --}}
    <section aria-labelledby="courses-management-title">
        <div class="section-header">
            <h2 class="section-title" id="courses-management-title">Courses <em>management</em></h2>
            <div style="display:flex;gap:10px;align-items:center;">
                <div class="filter-tabs" role="tablist" aria-label="Filter courses by status">
                    <button class="filter-tab active" role="tab" aria-selected="true">All ({{ $manageCourses->count() }})</button>
                    <button class="filter-tab" role="tab" aria-selected="false">Published ({{ $manageCourses->where('status', 'published')->count() }})</button>
                    <button class="filter-tab" role="tab" aria-selected="false">Draft ({{ $manageCourses->where('status', 'draft')->count() }})</button>
                </div>
                <a href="#" class="section-link">
                    View all <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="courses-table-wrap">
            <table class="courses-table" aria-label="Courses management table">
                <caption class="sr-only">List of your courses with enrollment, rating, revenue and status information</caption>
                <thead>
                    <tr>
                        <th scope="col" style="width:40%;">Course</th>
                        <th scope="col">Students</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Revenue</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width:80px;">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($manageCourses as $course)
                        <tr>
                            <td>
                                <div class="course-cell">
                                    <div class="course-cell-thumb course-thumb-{{ $loop->iteration }}" aria-hidden="true">
                                        <i class="fa-solid {{ $course->icon ?? 'fa-book' }}"></i>
                                    </div>
                                    <div class="course-cell-info">
                                        <div class="course-cell-title">{{ $course->title }}</div>
                                        <div class="course-cell-cat">{{ $course->category->name ?? 'Uncategorized' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-value">{{ number_format($course->enrollments_count) }}</div>
                                <div class="cell-label">enrolled</div>
                            </td>
                            <td>
                                @if($course->reviews_avg_rating > 0)
                                    <div class="rating-wrap">
                                        <span class="rating-star" aria-hidden="true">
                                            <i class="fa-solid fa-star"></i>
                                        </span>
                                        <span class="cell-value">{{ number_format($course->reviews_avg_rating, 1) }}</span>
                                    </div>
                                    <div class="cell-label">{{ $course->reviews_count }} reviews</div>
                                @else
                                    <div class="cell-value" style="color:var(--muted);">—</div>
                                    <div class="cell-label">No ratings</div>
                                @endif
                            </td>
                            <td>
                                <div class="cell-value">Rp {{ number_format(($course->enrollments_sum_amount ?? 0) / 1000000, 1) }}M</div>
                                <div class="cell-label">lifetime</div>
                            </td>
                            <td>
                                @if($course->status === 'published')
                                    <span class="status-badge status-published">
                                        <span class="status-dot status-dot-teal" aria-hidden="true"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="status-badge status-draft">
                                        <span class="status-dot status-dot-orange" aria-hidden="true"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-wrap"
                                     x-data="{ open: false }"
                                     @keydown.escape="open = false">
                                    <button class="action-btn"
                                            @click="open = !open"
                                            :aria-expanded="open.toString()"
                                            aria-haspopup="true"
                                            aria-label="Actions for {{ $course->title }}">
                                        <i class="fa-solid fa-ellipsis" aria-hidden="true"></i>
                                    </button>
                                    <div x-show="open"
                                         x-transition
                                         @click.away="open = false"
                                         @keydown.tab.shift="open = false"
                                         class="actions-menu"
                                         role="menu"
                                         aria-label="Course actions">
                                        <a href="#" class="actions-menu__item" role="menuitem">
                                            <i class="fa-solid fa-eye" aria-hidden="true"></i> View
                                        </a>
                                        <a href="#" class="actions-menu__item" role="menuitem">
                                            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Edit
                                        </a>
                                        <a href="#" class="actions-menu__item" role="menuitem">
                                            <i class="fa-solid fa-chart-simple" aria-hidden="true"></i> Analytics
                                        </a>
                                        <a href="#" class="actions-menu__item" role="menuitem">
                                            <i class="fa-solid fa-copy" aria-hidden="true"></i> Duplicate
                                        </a>
                                        <div class="actions-menu__divider" role="separator"></div>
                                        <a href="#" class="actions-menu__item actions-menu__item--danger" role="menuitem">
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- ENROLLMENTS + REVIEWS --}}
    <div class="two-col-equal">

        {{-- Recent Enrollments --}}
        <section class="card-wrap" aria-labelledby="enrollments-title">
            <div class="card-head">
                <h2 class="card-title" id="enrollments-title">New <em>enrollments</em></h2>
                <a href="#" class="section-link">
                    All <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            <div class="enrollment-list" role="list" aria-label="Recent student enrollments">
                <template x-for="enroll in enrollments" :key="enroll.student_name + enroll.created_at">
                    <div class="enrollment-item" role="listitem">
                        <div class="enroll-avatar enroll-avatar-purple" aria-hidden="true"
                             x-text="enroll.student_name.charAt(0).toUpperCase()">
                        </div>
                        <div class="enroll-info">
                            <div class="enroll-name">
                                <strong x-text="enroll.student_name"></strong> enrolled in
                            </div>
                            <div class="enroll-course" x-text="enroll.course_title"></div>
                        </div>
                        <time class="enroll-time" x-text="enroll.created_at"></time>
                    </div>
                </template>
                <div x-show="enrollments.length === 0" class="empty-state" role="status">
                    <div class="empty-state__icon">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <h3 class="empty-state__title">Belum ada enrollment</h3>
                    <p class="empty-state__desc">Enrollment terbaru akan muncul di sini.</p>
                </div>
            </div>
        </section>

        {{-- Recent Reviews --}}
        <section class="card-wrap" aria-labelledby="reviews-title">
            <div class="card-head">
                <h2 class="card-title" id="reviews-title">Recent <em>reviews</em></h2>
                <a href="#" class="section-link">
                    All <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            <div class="reviews-list" role="list" aria-label="Recent course reviews"
                 x-show="reviews.length > 0">
                <template x-for="review in reviews" :key="review.user_name + review.created_at">
                    <article class="review-item" role="listitem">
                        <div class="review-header">
                            <div class="review-avatar" aria-hidden="true"
                                 x-text="review.user_name.charAt(0).toUpperCase()">
                            </div>
                            <div class="review-meta">
                                <div class="review-name" x-text="review.user_name"></div>
                                <div class="review-course" x-text="'on ' + review.course_title"></div>
                            </div>
                            <div class="review-stars">
                                <template x-for="i in 5" :key="i">
                                    <i :class="i <= review.rating ? 'fa-solid fa-star' : 'fa-regular fa-star'" aria-hidden="true"></i>
                                </template>
                            </div>
                        </div>
                        <p class="review-comment" x-text="'&quot;' + review.comment + '&quot;'"></p>
                        <div class="review-footer">
                            <time class="review-time" x-text="review.created_at"></time>
                            <a href="#" class="review-reply">
                                Reply <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                </template>
            </div>

            <div class="empty-state" role="status" x-show="reviews.length === 0">
                <div class="empty-state__icon">
                    <i class="fa-regular fa-star"></i>
                </div>
                <h3 class="empty-state__title">Belum ada review</h3>
                <p class="empty-state__desc">Saat siswa memberikan review pada kursus Anda, akan muncul di sini.</p>
            </div>
        </section>

    </div>{{-- end two-col-equal --}}

    {{-- MESSAGES + QUICK ACTIONS --}}
    <div class="two-col-grid" style="margin-bottom: 40px;">

        {{-- Student Messages --}}
        <section class="card-wrap" aria-labelledby="messages-title">
            <div class="card-head">
                <h2 class="card-title" id="messages-title">Student <em>messages</em></h2>
                <div style="display:flex;gap:8px;align-items:center;">
                    @if($unreadCount > 0)
                        <span class="unread-badge" aria-label="{{ $unreadCount }} unread messages">{{ $unreadCount }} unread</span>
                    @endif
                    <a href="#" class="section-link">
                        Inbox <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="empty-state" role="status">
                <div class="empty-state__icon">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <h3 class="empty-state__title">Tidak ada pesan</h3>
                <p class="empty-state__desc">Pesan dari siswa akan muncul di sini. Mulai buat kursus untuk berinteraksi dengan siswa!</p>
            </div>
        </section>

        {{-- Quick Actions --}}
        <section class="card-wrap quick-actions-wrap" aria-labelledby="quick-actions-title">
            <div class="card-head">
                <h2 class="card-title" id="quick-actions-title">Quick <em>actions</em></h2>
            </div>

            <nav class="actions-grid" aria-label="Quick actions">
                <a href="{{ route('instructor.courses.create') }}" class="quick-action" aria-label="Create a new course">
                    <div class="quick-icon quick-icon-purple" aria-hidden="true">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div class="quick-label">Create Course</div>
                </a>
                <a href="{{ route('instructor.upload-video') }}" class="quick-action" aria-label="Upload video content">
                    <div class="quick-icon quick-icon-teal" aria-hidden="true">
                        <i class="fa-solid fa-video"></i>
                    </div>
                    <div class="quick-label">Upload Video</div>
                </a>
                <a href="{{ route('instructor.add-quiz') }}" class="quick-action" aria-label="Add a quiz to course">
                    <div class="quick-icon quick-icon-orange" aria-hidden="true">
                        <i class="fa-solid fa-clipboard-question"></i>
                    </div>
                    <div class="quick-label">Add Quiz</div>
                </a>
                <a href="{{ route('instructor.broadcast') }}" class="quick-action" aria-label="Broadcast message to students">
                    <div class="quick-icon quick-icon-gold" aria-hidden="true">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="quick-label">Broadcast</div>
                </a>
                <a href="{{ route('instructor.withdraw') }}" class="quick-action" aria-label="Withdraw earnings">
                    <div class="quick-icon quick-icon-blue" aria-hidden="true">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div class="quick-label">Withdraw</div>
                </a>
                <a href="{{ route('instructor.reports') }}" class="quick-action" aria-label="View reports and analytics">
                    <div class="quick-icon quick-icon-pink" aria-hidden="true">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <div class="quick-label">Reports</div>
                </a>
            </nav>

            {{-- Tips card --}}
            <div class="tips-card" role="complementary" aria-label="Pro tip">
                <div class="tips-icon" aria-hidden="true">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <div class="tips-content">
                    <div class="tips-title">Pro Tip</div>
                    <div class="tips-text">Courses with video intro get 3x more enrollments. Add one to your drafts!</div>
                </div>
            </div>
        </section>

    </div>{{-- end two-col-grid --}}

    </div>{{-- end x-data="dashboard" --}}

@endsection