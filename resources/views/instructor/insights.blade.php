@extends('layouts.instructor')

@section('title', 'Insights')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="insights-search" class="sr-only">Search</label>
            <input type="text"
                   id="insights-search"
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
            <h1 class="page-title">Insights</h1>
            <p class="page-subtitle">Get actionable insights to improve your courses</p>
        </div>
    </section>

    {{-- INSIGHTS SUMMARY --}}
    <section class="stats-grid" aria-label="Insights summary">
        <article class="stat-card" aria-label="Total Courses: {{ $total_courses }}">
            <div class="stat-card__icon stat-card__icon--purple" aria-hidden="true">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="stat-card__label">Total Courses</div>
            <div class="stat-card__value">{{ $total_courses }}</div>
        </article>

        <article class="stat-card" aria-label="Total Students: {{ number_format($total_students) }}">
            <div class="stat-card__icon stat-card__icon--teal" aria-hidden="true">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-card__label">Total Students</div>
            <div class="stat-card__value">{{ number_format($total_students) }}</div>
        </article>

        <article class="stat-card" aria-label="Average Rating: {{ round($avg_rating, 1) }}">
            <div class="stat-card__icon stat-card__icon--gold" aria-hidden="true">
                <i class="fa-solid fa-star"></i>
            </div>
            <div class="stat-card__label">Avg Rating</div>
            <div class="stat-card__value">{{ round($avg_rating, 1) }}/5</div>
        </article>

        <article class="stat-card" aria-label="Total Reviews: {{ number_format($total_reviews) }}">
            <div class="stat-card__icon stat-card__icon--orange" aria-hidden="true">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div class="stat-card__label">Total Reviews</div>
            <div class="stat-card__value">{{ number_format($total_reviews) }}</div>
        </article>
    </section>

    {{-- KEY RECOMMENDATIONS --}}
    <section class="card-wrap" aria-labelledby="recommendations-title">
        <div class="card-head">
            <h2 class="card-title" id="recommendations-title">Recommendations</h2>
        </div>

        <div class="recommendations-list">
            <div class="recommendation-item">
                <div class="recommendation-icon recommendation-icon--primary" aria-hidden="true">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <div class="recommendation-content">
                    <h3 class="recommendation-title">Add Video Introductions</h3>
                    <p class="recommendation-text">Courses with video introductions get 3x more enrollments. Consider adding intro videos to your courses.</p>
                </div>
            </div>

            <div class="recommendation-item">
                <div class="recommendation-icon recommendation-icon--success" aria-hidden="true">
                    <i class="fa-solid fa-trending-up"></i>
                </div>
                <div class="recommendation-content">
                    <h3 class="recommendation-title">Engagement is Strong</h3>
                    <p class="recommendation-text">Keep up the great work! Your student engagement rate is above average.</p>
                </div>
            </div>

            <div class="recommendation-item">
                <div class="recommendation-icon recommendation-icon--warning" aria-hidden="true">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="recommendation-content">
                    <h3 class="recommendation-title">Update Your Course Content</h3>
                    <p class="recommendation-text">It's been a while since you updated some courses. Regular updates keep students interested.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
