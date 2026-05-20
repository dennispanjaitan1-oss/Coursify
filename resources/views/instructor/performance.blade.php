@extends('layouts.instructor')

@section('title', 'Performance')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="performance-search" class="sr-only">Search courses</label>
            <input type="text"
                   id="performance-search"
                   class="topbar__search-input"
                   placeholder="Search courses..."
                   aria-label="Search courses">
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
            <h1 class="page-title">Performance</h1>
            <p class="page-subtitle">Monitor your course performance metrics</p>
        </div>
    </section>

    {{-- COURSES PERFORMANCE --}}
    <section class="card-wrap" aria-labelledby="courses-performance-title">
        <div class="card-head">
            <h2 class="card-title" id="courses-performance-title">Course <em>performance</em></h2>
        </div>

        @if($courses->isNotEmpty())
            <div class="table-responsive">
                <table class="table" role="grid" aria-label="Courses performance data">
                    <thead>
                        <tr>
                            <th scope="col">Course</th>
                            <th scope="col">Enrollments</th>
                            <th scope="col">Reviews</th>
                            <th scope="col">Avg Rating</th>
                            <th scope="col" style="width:80px;">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>
                                    <div class="course-cell">
                                        <div class="course-cell-info">
                                            <div class="course-cell-title">{{ $course->title }}</div>
                                            <div class="course-cell-cat">{{ $course->category->name ?? 'Uncategorized' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cell-value">{{ number_format($course->enrollments_count) }}</div>
                                </td>
                                <td>
                                    <div class="cell-value">{{ number_format($course->reviews_count) }}</div>
                                </td>
                                <td>
                                    <div class="rating-badge">
                                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                                        {{ round($course->reviews_avg_rating, 1) ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <button class="action-btn" aria-label="Actions for {{ $course->title }}">
                                        <i class="fa-solid fa-ellipsis" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state" role="status">
                <div class="empty-state__icon">
                    <i class="fa-regular fa-chart-bar"></i>
                </div>
                <h3 class="empty-state__title">Belum ada kursus</h3>
                <p class="empty-state__desc">Buat kursus pertama Anda untuk melihat metrik performa.</p>
                <a href="{{ route('instructor.courses.create') }}" class="btn-primary" style="margin-top: 16px;">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    Create Course
                </a>
            </div>
        @endif
    </section>

@endsection
