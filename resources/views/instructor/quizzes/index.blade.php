@extends('layouts.instructor')

@section('title', 'Quiz Management')

@section('content')
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="quiz-search" class="sr-only">Search quizzes</label>
            <input type="text" id="quiz-search" class="topbar__search-input" placeholder="Search quizzes..." aria-label="Search quizzes">
        </div>

        <div class="topbar__actions">
            <a href="{{ route('instructor.add-quiz') }}" class="icon-btn" aria-label="Add quiz" title="Add quiz">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
    </header>

    <section class="page-header" aria-label="Page title">
        <div>
            <h1 class="page-title">Quiz Management</h1>
            <p class="page-subtitle">Edit, review, and manage all quiz lessons in your courses.</p>
        </div>
    </section>

    <section class="card-wrap">
        <div class="card-head">
            <h2 class="card-title">All Quiz Lessons</h2>
        </div>

        @if($quizzes->isEmpty())
            <div class="no-content-box" style="padding: 32px;">
                <div class="no-content-icon">🎲</div>
                <div class="no-content-title">Belum ada quiz</div>
                <p class="no-content-desc">Belum ada lesson bertipe quiz yang dibuat. Tambahkan quiz melalui tombol Add Quiz.</p>
            </div>
        @else
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Section</th>
                        <th>Lesson</th>
                        <th>Questions</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $lesson)
                        <tr>
                            <td>{{ $lesson->section->course->title }}</td>
                            <td>{{ $lesson->section->title }}</td>
                            <td>{{ $lesson->title }}</td>
                            <td>{{ $lesson->quizzes->count() }}</td>
                            <td>{{ $lesson->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('instructor.quizzes.edit', $lesson) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection
