@extends('layouts.instructor')

@section('title', 'Reviews')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="reviews-search" class="sr-only">Search reviews</label>
            <input type="text"
                   id="reviews-search"
                   class="topbar__search-input"
                   placeholder="Search reviews..."
                   aria-label="Search reviews">
        </div>

        <div class="topbar__actions">
            <button class="icon-btn"
                    aria-label="Notifications - 2 new"
                    title="Notifications">
                <i class="fa-solid fa-bell" aria-hidden="true"></i>
                <span class="icon-btn__dot" aria-hidden="true"></span>
            </button>
            <a href="{{ route('instructor.messages') }}" class="icon-btn" aria-label="Messages">
                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
            </a>
        </div>
    </header>

    {{-- PAGE TITLE --}}
    <section class="page-header" aria-label="Page title">
        <div>
            <h1 class="page-title">Reviews & Ratings</h1>
            <p class="page-subtitle">See what your students think about your courses</p>
        </div>
    </section>

    {{-- REVIEWS SECTION --}}
    <section class="card-wrap" aria-labelledby="reviews-title">
        <div class="card-head">
            <h2 class="card-title" id="reviews-title">Student Reviews</h2>
        </div>

        @if($reviews->isNotEmpty())
            <div class="reviews-list" role="list" aria-label="Student reviews">
                @foreach($reviews as $review)
                    <article class="review-item" role="listitem">
                        <div class="review-header">
                            <div class="review-avatar" aria-hidden="true">
                                {{ strtoupper(substr($review->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div class="review-meta">
                                <div class="review-student">{{ $review->user->name ?? 'Anonymous' }}</div>
                                <div class="review-course">{{ $review->course->title ?? 'Unknown Course' }}</div>
                            </div>
                            <div class="review-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}" aria-hidden="true"></i>
                                    @endfor
                                </div>
                                <span class="rating-text">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        <p class="review-comment">{{ $review->comment }}</p>
                        <div class="review-footer">
                            <time class="review-time" datetime="{{ $review->created_at->toDateTimeString() }}">
                                {{ $review->created_at->diffForHumans() }}
                            </time>
                            <button class="review-reply">
                                <i class="fa-solid fa-reply" aria-hidden="true"></i>
                                Reply
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="empty-state" role="status">
                <div class="empty-state__icon">
                    <i class="fa-regular fa-star"></i>
                </div>
                <h3 class="empty-state__title">Belum ada review</h3>
                <p class="empty-state__desc">Saat siswa memberikan review pada kursus Anda, akan muncul di sini.</p>
            </div>
        @endif
    </section>

@endsection
