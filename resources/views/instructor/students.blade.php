@extends('layouts.instructor')

@section('title', 'My Students')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="students-search" class="sr-only">Search students by name or email</label>
            <input type="text"
                   id="students-search"
                   class="topbar__search-input"
                   placeholder="Search students by name or email..."
                   aria-label="Search students by name or email">
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
            <h1 class="page-title">My Students</h1>
            <p class="page-subtitle">Manage and track your {{ $totalStudents }} enrolled students</p>
        </div>
    </section>

    {{-- STUDENTS TABLE --}}
    <section class="card-wrap" aria-labelledby="students-table-title">
        <div class="card-head">
            <h2 class="card-title" id="students-table-title">Students <em>list</em></h2>
        </div>

        @if($students->isNotEmpty())
            <div class="table-responsive">
                <table class="table" role="grid" aria-label="Students data">
                    <thead>
                        <tr>
                            <th scope="col">Student Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Courses Enrolled</th>
                            <th scope="col">Joined</th>
                            <th scope="col" style="width:80px;">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <div class="student-cell">
                                        <div class="student-avatar" aria-hidden="true">
                                            {{ strtoupper(substr($student['name'], 0, 1)) }}
                                        </div>
                                        <div class="student-info">
                                            <div class="student-name">{{ $student['name'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $student['email'] }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $student['courses_enrolled'] }}</span>
                                </td>
                                <td>
                                    <time datetime="{{ $student['joined_at']->toDateTimeString() }}">
                                        {{ $student['joined_at']->format('d M Y') }}
                                    </time>
                                </td>
                                <td>
                                    <button class="action-btn" aria-label="Actions for {{ $student['name'] }}">
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
                    <i class="fa-regular fa-users"></i>
                </div>
                <h3 class="empty-state__title">Belum ada siswa</h3>
                <p class="empty-state__desc">Buat kursus pertama Anda untuk mulai menerima siswa.</p>
            </div>
        @endif
    </section>

@endsection
