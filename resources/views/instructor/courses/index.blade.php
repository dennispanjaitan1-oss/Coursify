@extends('layouts.instructor')

@section('title', 'My Courses')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="courses-search" class="sr-only">Search courses</label>
            <input type="text"
                   id="courses-search"
                   class="topbar__search-input"
                   placeholder="Search your courses..."
                   aria-label="Search your courses">
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

    {{-- PAGE HEADER WITH ACTION --}}
    <header style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 24px;">
        <a href="{{ route('instructor.courses.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus" aria-hidden="true"></i>
            New Course
        </a>
    </header>

    {{-- COURSES TABLE --}}
    <section class="card-wrap" aria-labelledby="courses-table-title">
        <div class="card-head">
            <h2 class="card-title" id="courses-table-title">Your Courses</h2>
        </div>

        @if($courses->isNotEmpty())
            <div class="courses-table-wrap">
                <table class="courses-table" role="grid" aria-label="Courses data">
                    <thead>
                        <tr>
                            <th scope="col">Course</th>
                            <th scope="col">Enrollments</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="width:100px;">
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
                                            <div class="course-cell-cat">{{ $course->category->name ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cell-value">{{ number_format($course->enrollments_count ?? 0) }}</div>
                                    <div class="cell-label">enrolled</div>
                                </td>
                                <td>
                                    <div class="rating-badge">
                                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                                        {{ round($course->reviews_avg_rating ?? 0, 1) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $course->is_published ? 'published' : 'draft' }}">
                                        <span class="status-dot" aria-hidden="true"></span>
                                        {{ $course->is_published ? 'Published' : 'Draft' }}
                                    </span>
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
                                            <a href="{{ route('instructor.courses.show', $course) }}" class="actions-menu__item" role="menuitem">
                                                <i class="fa-solid fa-eye" aria-hidden="true"></i> View
                                            </a>
                                            <a href="{{ route('instructor.courses.edit', $course) }}" class="actions-menu__item" role="menuitem">
                                                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Edit
                                            </a>
                                            <a href="{{ route('instructor.performance') }}" class="actions-menu__item" role="menuitem">
                                                <i class="fa-solid fa-chart-simple" aria-hidden="true"></i> Analytics
                                            </a>
                                            <div class="actions-menu__divider" role="separator"></div>
                                            <form method="POST" action="{{ route('instructor.courses.destroy', $course) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="actions-menu__item actions-menu__item--danger" role="menuitem" onclick="return confirm('Are you sure?')">
                                                    <i class="fa-solid fa-trash" aria-hidden="true"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrapper" style="margin-top: 20px;">
                {{ $courses->links() }}
            </div>
        @else
            <div class="empty-state" role="status">
                <div class="empty-state__icon">
                    <i class="fa-regular fa-book"></i>
                </div>
                <h3 class="empty-state__title">Belum ada kursus</h3>
                <p class="empty-state__desc">Buat kursus pertama Anda dan mulai mengajar!</p>
                <a href="{{ route('instructor.courses.create') }}" class="btn-primary" style="margin-top: 16px;">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    Create Your First Course
                </a>
            </div>
        @endif
    </section>

@endsection
