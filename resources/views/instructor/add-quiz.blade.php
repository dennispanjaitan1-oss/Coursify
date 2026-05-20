@extends('layouts.instructor')

@section('title', 'Add Quiz')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="courses-search" class="sr-only">Search courses</label>
            <input type="text"
                   id="courses-search"
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
            <h1 class="page-title">Add Quiz</h1>
            <p class="page-subtitle">Create a quiz to test your students' knowledge</p>
        </div>
    </section>

    {{-- QUIZ FORM --}}
    <section class="card-wrap" aria-labelledby="quiz-form-title">
        <div class="card-head">
            <h2 class="card-title" id="quiz-form-title">Create New Quiz</h2>
        </div>

        <form method="POST" class="quiz-form">
            @csrf
            
            <div class="form-group">
                <label for="course-select" class="form-label">Select Course *</label>
                <select id="course-select" name="course_id" class="form-control" required>
                    <option value="">-- Choose a course --</option>
                    <option value="">Web Development 101</option>
                    <option value="">PHP Fundamentals</option>
                    <option value="">Laravel Mastery</option>
                </select>
            </div>

            <div class="form-group">
                <label for="quiz-title" class="form-label">Quiz Title *</label>
                <input type="text" id="quiz-title" name="title" class="form-control" placeholder="e.g., HTML & CSS Basics" required>
            </div>

            <div class="form-group">
                <label for="quiz-description" class="form-label">Description</label>
                <textarea id="quiz-description" name="description" class="form-control" rows="3" placeholder="What is this quiz about?"></textarea>
            </div>

            <div class="form-group">
                <label for="passing-score" class="form-label">Passing Score (%) *</label>
                <input type="number" id="passing-score" name="passing_score" class="form-control" min="0" max="100" value="60" required>
            </div>

            <div class="form-group">
                <label for="time-limit" class="form-label">Time Limit (minutes)</label>
                <input type="number" id="time-limit" name="time_limit" class="form-control" min="0" placeholder="Leave empty for no time limit">
            </div>

            <div class="form-section-title">Questions</div>

            <div class="questions-container">
                <div class="question-item">
                    <div class="question-number">Question 1</div>
                    <div class="form-group">
                        <label for="question-1" class="form-label">Question Text *</label>
                        <textarea id="question-1" class="form-control" rows="2" placeholder="Enter your question..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Question Type</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="question-1-type" value="multiple-choice" checked>
                                Multiple Choice
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="question-1-type" value="true-false">
                                True/False
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="question-1-type" value="short-answer">
                                Short Answer
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn-secondary" style="margin-bottom: 20px;">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                Add Another Question
            </button>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    Create Quiz
                </button>
                <a href="{{ route('instructor.dashboard') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

@endsection
