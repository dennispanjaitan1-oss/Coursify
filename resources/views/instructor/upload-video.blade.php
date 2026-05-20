@extends('layouts.instructor')

@section('title', 'Upload Video')

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
            <h1 class="page-title">Upload Video</h1>
            <p class="page-subtitle">Add video content to your courses</p>
        </div>
    </section>

    {{-- UPLOAD FORM --}}
    <section class="card-wrap" aria-labelledby="upload-form-title">
        <div class="card-head">
            <h2 class="card-title" id="upload-form-title">Select Course & Upload</h2>
        </div>

        <form method="POST" enctype="multipart/form-data" class="upload-form">
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
                <label for="video-file" class="form-label">Video File *</label>
                <div class="file-upload-zone" id="upload-zone">
                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                    <div class="upload-text">
                        <strong>Click to upload</strong> or drag and drop
                    </div>
                    <div class="upload-hint">MP4, WebM or Ogg (max. 500MB)</div>
                </div>
                <input type="file" id="video-file" name="video" accept="video/*" class="sr-only" required>
            </div>

            <div class="form-group">
                <label for="video-title" class="form-label">Video Title *</label>
                <input type="text" id="video-title" name="title" class="form-control" placeholder="e.g., Introduction to Web Development" required>
            </div>

            <div class="form-group">
                <label for="video-description" class="form-label">Description</label>
                <textarea id="video-description" name="description" class="form-control" rows="4" placeholder="Describe what this video covers..."></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                    Upload Video
                </button>
                <a href="{{ route('instructor.dashboard') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

@endsection
