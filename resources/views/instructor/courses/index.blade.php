@extends('layouts.instructor')

@section('title', 'My Courses')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <input type="text"
                   id="courses-search"
                   class="topbar__search-input"
                   placeholder="Search courses..."
                   aria-label="Search courses">
        </div>

        <div class="topbar__actions">
            <a href="{{ route('instructor.courses.create') }}" class="btn-primary" aria-label="Create a new course">
                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                Create Course
            </a>
        </div>
    </header>

    @if(session('success'))
        <div class="card-wrap" style="background: var(--teal-light); border-color: var(--teal); margin-bottom: 24px; padding: 16px 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-circle-check" style="color: var(--teal); font-size: 20px;"></i>
            <div style="color: var(--navy); font-weight: 600; font-size: 14px;">{{ session('success') }}</div>
        </div>
    @endif

    {{-- COURSES LIST SECTION --}}
    <section aria-labelledby="my-courses-title">
        <div class="section-header" style="margin-bottom: 20px;">
            <h1 class="section-title" id="my-courses-title" style="font-family: var(--font-serif); font-size: 32px; font-weight: 400;">
                My <em>courses</em>
            </h1>
            <div class="filter-tabs" role="tablist" aria-label="Filter courses">
                <button class="filter-tab active" role="tab" aria-selected="true">All ({{ $courses->total() }})</button>
            </div>
        </div>

        <div class="courses-table-wrap">
            <table class="courses-table" aria-label="My Courses list">
                <thead>
                    <tr>
                        <th scope="col" style="width:40%;">Course</th>
                        <th scope="col">Students</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width:120px;">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>
                                <div class="course-cell">
                                    <div class="course-cell-thumb course-thumb-{{ $loop->iteration % 5 + 1 }}" aria-hidden="true" style="width: 48px; height: 48px; border-radius: var(--radius-md); background: linear-gradient(135deg, var(--lav-2), var(--lav-3)); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--purple);">
                                        <i class="fa-solid {{ $course->icon ?? 'fa-book' }}"></i>
                                    </div>
                                    <div class="course-cell-info">
                                        <div class="course-cell-title" style="font-weight: 600; color: var(--text); font-size: 14px;">{{ $course->title }}</div>
                                        <div class="course-cell-cat" style="font-size: 12px; color: var(--muted);">{{ $course->category->name ?? 'Uncategorized' }} · Rp {{ number_format($course->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-value" style="font-weight: 600; color: var(--text); font-size: 14px;">{{ number_format($course->enrollments_count) }}</div>
                                <div class="cell-label" style="font-size: 12px; color: var(--muted);">enrolled</div>
                            </td>
                            <td>
                                @if($course->reviews()->avg('rating') > 0)
                                    <div class="rating-wrap" style="display: flex; align-items: center; gap: 4px; color: var(--gold);">
                                        <span class="rating-star" aria-hidden="true">
                                            <i class="fa-solid fa-star"></i>
                                        </span>
                                        <span class="cell-value" style="font-weight: 600; color: var(--text); font-size: 14px;">{{ number_format($course->reviews()->avg('rating'), 1) }}</span>
                                    </div>
                                    <div class="cell-label" style="font-size: 12px; color: var(--muted);">{{ $course->reviews()->count() }} reviews</div>
                                @else
                                    <div class="cell-value" style="color:var(--muted); font-size: 14px;">—</div>
                                    <div class="cell-label" style="font-size: 12px; color: var(--muted);">No reviews</div>
                                @endif
                            </td>
                            <td>
                                @if($course->is_published)
                                    <span class="status-badge status-published" style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 600; background: var(--teal-light); color: var(--teal);">
                                        <span class="status-dot status-dot-teal" aria-hidden="true" style="width: 6px; height: 6px; border-radius: 50%; background: var(--teal);"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="status-badge status-draft" style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 600; background: var(--orange-light); color: var(--orange);">
                                        <span class="status-dot status-dot-orange" aria-hidden="true" style="width: 6px; height: 6px; border-radius: 50%; background: var(--orange);"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-wrap"
                                     x-data="{ open: false }"
                                     @keydown.escape="open = false"
                                     style="position: relative;">
                                    <button class="action-btn"
                                            @click="open = !open"
                                            :aria-expanded="open.toString()"
                                            aria-haspopup="true"
                                            aria-label="Actions for {{ $course->title }}"
                                            style="background: transparent; border: 1px solid var(--border); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-soft); transition: var(--transition-fast);">
                                        <i class="fa-solid fa-ellipsis" aria-hidden="true"></i>
                                    </button>
                                    <div x-show="open"
                                         x-transition
                                         @click.away="open = false"
                                         @keydown.tab.shift="open = false"
                                         class="actions-menu"
                                         role="menu"
                                         aria-label="Course actions"
                                         style="position: absolute; right: 0; top: 36px; background: white; border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-md); z-index: 100; min-width: 150px; display: flex; flex-direction: column; padding: 6px; gap: 2px;">
                                        <a href="{{ route('courses.show', $course->slug) }}" class="actions-menu__item" role="menuitem" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; font-size: 13px; color: var(--text-soft); text-decoration: none; border-radius: 6px; transition: var(--transition-fast);">
                                            <i class="fa-solid fa-eye" aria-hidden="true" style="width: 14px; text-align: center;"></i> View Course
                                        </a>
                                        <a href="{{ route('instructor.courses.show', $course->id) }}" class="actions-menu__item" role="menuitem" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; font-size: 13px; color: var(--text-soft); text-decoration: none; border-radius: 6px; transition: var(--transition-fast);">
                                            <i class="fa-solid fa-folder-open" aria-hidden="true" style="width: 14px; text-align: center;"></i> Content / Syllabus
                                        </a>
                                        <a href="{{ route('instructor.courses.edit', $course->id) }}" class="actions-menu__item" role="menuitem" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; font-size: 13px; color: var(--text-soft); text-decoration: none; border-radius: 6px; transition: var(--transition-fast);">
                                            <i class="fa-solid fa-pen-to-square" aria-hidden="true" style="width: 14px; text-align: center;"></i> Edit Details
                                        </a>
                                        <div class="actions-menu__divider" role="separator" style="height: 1px; background: var(--border); margin: 4px 0;"></div>
                                        <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')" style="display:block; width: 100%;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="actions-menu__item actions-menu__item--danger" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; font-size: 13px; color: var(--orange); text-decoration: none; border-radius: 6px; transition: var(--transition-fast); background: transparent; border: none; width: 100%; text-align: left; cursor: pointer;" role="menuitem">
                                                <i class="fa-solid fa-trash" aria-hidden="true" style="width: 14px; text-align: center;"></i> Delete Course
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state" style="text-align: center; padding: 48px 24px;">
                                    <div class="empty-state__icon" style="font-size: 40px; color: var(--muted); margin-bottom: 16px;">
                                        <i class="fa-solid fa-book-open"></i>
                                    </div>
                                    <h3 class="empty-state__title" style="font-weight: 600; font-size: 18px; color: var(--text); margin-bottom: 6px;">Belum ada kursus</h3>
                                    <p class="empty-state__desc" style="color: var(--muted); font-size: 14px; margin-bottom: 16px;">Mulai buat kursus pertama Anda untuk membagikan ilmu Anda!</p>
                                    <a href="{{ route('instructor.courses.create') }}" class="btn-primary">
                                        <i class="fa-solid fa-plus"></i> Create First Course
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 24px;">
            {{ $courses->links() }}
        </div>
    </section>

@endsection
