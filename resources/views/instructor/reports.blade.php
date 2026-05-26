@extends('layouts.instructor')

@section('title', 'Reports')

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
            <h1 class="page-title">Reports & Analytics</h1>
            <p class="page-subtitle">Detailed analytics and performance reports for your courses</p>
        </div>
    </section>

    {{-- REPORT FILTERS --}}
    <section class="card-wrap" aria-labelledby="filters-title">
        <div class="card-head">
            <h2 class="card-title" id="filters-title">Generate Report</h2>
        </div>

        <form method="GET" class="report-filters">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="report-type" class="form-label">Report Type</label>
                    <select id="report-type" name="type" class="form-control">
                        <option value="overview">Course Overview</option>
                        <option value="enrollments">Enrollments Report</option>
                        <option value="revenue">Revenue Report</option>
                        <option value="reviews">Reviews Report</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="course-filter" class="form-label">Course</label>
                    <select id="course-filter" name="course_id" class="form-control">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="date-range" class="form-label">Date Range</label>
                    <select id="date-range" name="date_range" class="form-control">
                        <option value="7days">Last 7 Days</option>
                        <option value="30days">Last 30 Days</option>
                        <option value="90days">Last 90 Days</option>
                        <option value="yearly">This Year</option>
                        <option value="all">All Time</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary" style="align-self: flex-end;">
                    <i class="fa-solid fa-filter" aria-hidden="true"></i>
                    Generate Report
                </button>
            </div>
        </form>
    </section>

    {{-- COURSES REPORT TABLE --}}
    <section class="card-wrap" aria-labelledby="courses-report-title">
        <div class="card-head">
            <h2 class="card-title" id="courses-report-title">Course Reports</h2>
            <button class="btn-secondary" style="gap: 8px;">
                <i class="fa-solid fa-download" aria-hidden="true"></i>
                Export CSV
            </button>
        </div>

        @if($courses->isNotEmpty())
            <div class="table-responsive">
                <table class="table" role="grid" aria-label="Courses report data">
                    <thead>
                        <tr>
                            <th scope="col">Course</th>
                            <th scope="col">Enrollments</th>
                            <th scope="col">Completions</th>
                            <th scope="col">Reviews</th>
                            <th scope="col">Avg Rating</th>
                            <th scope="col">Revenue</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>
                                    <div class="course-cell">
                                        <div class="course-cell-info">
                                            <div class="course-cell-title">{{ $course->title }}</div>
                                            <div class="course-cell-cat">{{ $course->category->name ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($course->enrollments_count ?? 0) }}</td>
                                <td>0</td>
                                <td>{{ number_format($course->reviews_count ?? 0) }}</td>
                                <td>
                                    <div class="rating-badge">
                                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                                        {{ round($course->reviews_avg_rating ?? 0, 1) }}
                                    </div>
                                </td>
                                <td>Rp 0</td>
                                <td>
                                    <span class="status-badge status-{{ $course->is_published ? 'published' : 'draft' }}">
                                        {{ $course->is_published ? 'Published' : 'Draft' }}
                                    </span>
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
                <h3 class="empty-state__title">No data available</h3>
                <p class="empty-state__desc">Create a course to start generating reports.</p>
            </div>
        @endif
    </section>

@endsection
