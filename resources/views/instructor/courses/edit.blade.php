@extends('layouts.instructor')

@section('title', 'Edit Course')

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
            <h1 class="page-title">Edit Course</h1>
            <p class="page-subtitle">Update your course information</p>
        </div>
    </section>

    {{-- EDIT FORM --}}
    <section class="card-wrap" aria-labelledby="edit-form-title">
        <div class="card-head">
            <h2 class="card-title" id="edit-form-title">Course Information</h2>
        </div>

        <form method="POST" action="{{ route('instructor.courses.update', $course) }}" class="course-form">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group">
                    <label for="title" class="form-label">Course Title *</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                           placeholder="e.g., Complete Web Development Bootcamp" required value="{{ old('title', $course->title) }}">
                    @error('title')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category_id" class="form-label">Category *</label>
                    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="difficulty" class="form-label">Difficulty Level *</label>
                    <select id="difficulty" name="difficulty" class="form-control @error('difficulty') is-invalid @enderror" required>
                        <option value="">-- Select Level --</option>
                        <option value="beginner" {{ old('difficulty', $course->difficulty) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('difficulty', $course->difficulty) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ old('difficulty', $course->difficulty) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                    @error('difficulty')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="short_description" class="form-label">Short Description *</label>
                <textarea id="short_description" name="short_description" class="form-control @error('short_description') is-invalid @enderror" 
                          rows="2" placeholder="Brief summary of your course (max 500 chars)" required>{{ old('short_description', $course->short_description) }}</textarea>
                @error('short_description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Full Description *</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="6" placeholder="Detailed description of what students will learn..." required>{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price" class="form-label">Price (Rp) *</label>
                    <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" 
                           placeholder="0" min="0" step="1000" required value="{{ old('price', $course->price) }}">
                    @error('price')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration_weeks" class="form-label">Duration (weeks) *</label>
                    <input type="number" id="duration_weeks" name="duration_weeks" class="form-control @error('duration_weeks') is-invalid @enderror" 
                           placeholder="4" min="1" required value="{{ old('duration_weeks', $course->duration_weeks) }}">
                    @error('duration_weeks')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="language" class="form-label">Language *</label>
                    <select id="language" name="language" class="form-control @error('language') is-invalid @enderror" required>
                        <option value="">-- Select Language --</option>
                        <option value="Indonesian" {{ old('language', $course->language) == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                        <option value="English" {{ old('language', $course->language) == 'English' ? 'selected' : '' }}>English</option>
                    </select>
                    @error('language')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="thumbnail_url" class="form-label">Thumbnail URL</label>
                    <input type="url" id="thumbnail_url" name="thumbnail_url" class="form-control @error('thumbnail_url') is-invalid @enderror" 
                           placeholder="https://..." value="{{ old('thumbnail_url', $course->thumbnail_url) }}">
                    @error('thumbnail_url')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="preview_video_url" class="form-label">Preview Video URL</label>
                    <input type="url" id="preview_video_url" name="preview_video_url" class="form-control @error('preview_video_url') is-invalid @enderror" 
                           placeholder="https://youtube.com/..." value="{{ old('preview_video_url', $course->preview_video_url) }}">
                    @error('preview_video_url')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions" style="margin-top: 24px;">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    Update Course
                </button>
                <a href="{{ route('instructor.courses.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

@endsection
