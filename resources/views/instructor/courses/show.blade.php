@extends('layouts.instructor')

@section('title', $course->title)

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

    {{-- PAGE HEADER WITH ACTIONS --}}
    <header style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
        <div>
            <h1 class="page-title">{{ $course->title }}</h1>
            <p class="page-subtitle">{{ $course->category->name ?? 'Uncategorized' }} · {{ ucfirst($course->difficulty) }}</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('instructor.courses.edit', $course) }}" class="btn-secondary">
                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                Edit
            </a>
            <a href="{{ route('instructor.courses.index') }}" class="btn-secondary">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                Back
            </a>
        </div>
    </header>

    {{-- COURSE INFO --}}
    <div class="two-col-equal">
        {{-- LEFT COLUMN --}}
        <section class="card-wrap" aria-labelledby="course-details-title">
            <div class="card-head">
                <h2 class="card-title" id="course-details-title">Course Details</h2>
            </div>

            <div class="course-details">
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="status-badge status-{{ $course->is_published ? 'published' : 'draft' }}">
                        {{ $course->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Price:</span>
                    <span class="detail-value">Rp {{ number_format($course->price) }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span class="detail-value">{{ $course->duration_weeks }} weeks</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Language:</span>
                    <span class="detail-value">{{ $course->language }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Difficulty:</span>
                    <span class="detail-value">{{ ucfirst($course->difficulty) }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Created:</span>
                    <span class="detail-value">{{ $course->created_at->format('d M Y') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Updated:</span>
                    <span class="detail-value">{{ $course->updated_at->format('d M Y') }}</span>
                </div>
            </div>
        </section>

        {{-- RIGHT COLUMN --}}
        <section class="card-wrap" aria-labelledby="course-stats-title">
            <div class="card-head">
                <h2 class="card-title" id="course-stats-title">Statistics</h2>
            </div>

            <div class="course-stats">
                <div class="stat-box">
                    <div class="stat-label">Enrollments</div>
                    <div class="stat-value">{{ $course->enrollments_count ?? 0 }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">Reviews</div>
                    <div class="stat-value">{{ $course->reviews_count ?? 0 }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">Avg Rating</div>
                    <div class="stat-value">
                        {{ round($course->reviews_avg_rating ?? 0, 1) }}
                        <span style="font-size: 12px; color: #999;">/5</span>
                    </div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">Revenue</div>
                    <div class="stat-value">Rp 0</div>
                </div>
            </div>
        </section>
    </div>

    {{-- DESCRIPTION --}}
    <section class="card-wrap" aria-labelledby="description-title">
        <div class="card-head">
            <h2 class="card-title" id="description-title">Description</h2>
        </div>

        <div style="line-height: 1.6; color: #666;">
            <h3 style="color: #333; margin-bottom: 12px; font-size: 14px; font-weight: 600;">Short Description</h3>
            <p style="margin-bottom: 20px;">{{ $course->short_description }}</p>

            <h3 style="color: #333; margin-bottom: 12px; font-size: 14px; font-weight: 600;">Full Description</h3>
            <p>{{ $course->description }}</p>
        </div>
    </section>

    {{-- THUMBNAIL & PREVIEW --}}
    <div class="two-col-equal">
        @if($course->thumbnail_url)
            <section class="card-wrap">
                <div class="card-head">
                    <h2 class="card-title">Thumbnail</h2>
                </div>
                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" style="width: 100%; border-radius: 8px;">
            </section>
        @endif

        @if($course->preview_video_url)
            <section class="card-wrap">
                <div class="card-head">
                    <h2 class="card-title">Preview Video</h2>
                </div>
                <div style="background: #000; border-radius: 8px; aspect-ratio: 16/9; display: flex; align-items: center; justify-content: center;">
                    <a href="{{ $course->preview_video_url }}" target="_blank" rel="noopener noreferrer" class="btn-primary">
                        <i class="fa-solid fa-play" aria-hidden="true"></i>
                        Watch Preview
                    </a>
                </div>
            </section>
        @endif
    </div>

@endsection

<style>
    .course-details {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #eee;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #666;
        font-size: 13px;
    }

    .detail-value {
        color: #333;
        font-weight: 500;
    }

    .course-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .stat-box {
        padding: 16px;
        background: #F5F1FC;
        border-radius: 8px;
        text-align: center;
    }

    .stat-label {
        font-size: 12px;
        color: #999;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }

    .two-col-equal {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }
</style>
