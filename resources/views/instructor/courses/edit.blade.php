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

        <form method="POST" action="{{ route('instructor.courses.update', $course) }}" class="course-form" enctype="multipart/form-data">
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
                    <label for="is_self_paced" class="form-label">Pacing Method *</label>
                    <select id="is_self_paced" name="is_self_paced" class="form-control @error('is_self_paced') is-invalid @enderror" required>
                        <option value="1" {{ old('is_self_paced', $course->is_self_paced) ? 'selected' : '' }}>Self-paced (Belajar Mandiri)</option>
                        <option value="0" {{ !old('is_self_paced', $course->is_self_paced) ? 'selected' : '' }}>Instructor-paced (Terjadwal)</option>
                    </select>
                    @error('is_self_paced')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hours_per_week" class="form-label">Study Hours per Week</label>
                    <input type="text" id="hours_per_week" name="hours_per_week" class="form-control @error('hours_per_week') is-invalid @enderror" 
                           placeholder="e.g. 3-5 hours per week" value="{{ old('hours_per_week', $course->hours_per_week) }}">
                    @error('hours_per_week')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="has_certificate" class="form-label">Earn Certificate Credentials *</label>
                    <select id="has_certificate" name="has_certificate" class="form-control @error('has_certificate') is-invalid @enderror" required>
                        <option value="1" {{ old('has_certificate', $course->has_certificate) ? 'selected' : '' }}>Yes (Dapat Sertifikat)</option>
                        <option value="0" {{ !old('has_certificate', $course->has_certificate) ? 'selected' : '' }}>No (Tidak Ada Sertifikat)</option>
                    </select>
                    @error('has_certificate')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                           value="{{ old('start_date', $course->start_date ? $course->start_date->format('Y-m-d') : '') }}">
                    @error('start_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="enroll_deadline" class="form-label">Enroll Deadline</label>
                    <input type="date" id="enroll_deadline" name="enroll_deadline" class="form-control @error('enroll_deadline') is-invalid @enderror" 
                           value="{{ old('enroll_deadline', $course->enroll_deadline ? $course->enroll_deadline->format('Y-m-d') : '') }}">
                    @error('enroll_deadline')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="translations" class="form-label">Translations</label>
                    <input type="text" id="translations" name="translations" class="form-control @error('translations') is-invalid @enderror" 
                           placeholder="e.g. English, Chinese (or None)" value="{{ old('translations', $course->translations) }}">
                    @error('translations')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="transcripts" class="form-label">Transcripts</label>
                    <input type="text" id="transcripts" name="transcripts" class="form-control @error('transcripts') is-invalid @enderror" 
                           placeholder="e.g. Indonesian, English" value="{{ old('transcripts', $course->transcripts) }}">
                    @error('transcripts')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="prerequisites" class="form-label">Prerequisites (Prasyarat)</label>
                <textarea id="prerequisites" name="prerequisites" class="form-control @error('prerequisites') is-invalid @enderror" 
                          rows="2" placeholder="e.g. Basic programming logic, math knowledge..." >{{ old('prerequisites', $course->prerequisites) }}</textarea>
                @error('prerequisites')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Thumbnail Kursus</label>

                    @if($course->thumbnail_url)
                        <div id="thumb-cur" style="margin-bottom:10px;border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--border);">
                            <img id="preview-img" src="{{ $course->thumbnail_url }}" alt="Thumbnail saat ini" style="width:100%;max-height:180px;object-fit:cover;">
                            <p style="font-size:11px;color:var(--muted);padding:6px 10px;">Thumbnail saat ini</p>
                        </div>
                    @else
                        <div id="thumb-cur" style="display:none;margin-bottom:10px;border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--border);">
                            <img id="preview-img" src="" alt="Preview" style="width:100%;max-height:180px;object-fit:cover;">
                        </div>
                    @endif

                    <label for="thumbnail" id="thumb-dropzone"
                           style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;padding:20px;border:2px dashed var(--lav-3);border-radius:var(--radius-md);cursor:pointer;background:var(--lav-1);transition:background 0.2s;">
                        <i class="fa-solid fa-cloud-arrow-up" style="font-size:24px;color:var(--purple);"></i>
                        <span style="font-size:13px;font-weight:600;color:var(--purple);">Klik untuk upload thumbnail baru</span>
                        <span style="font-size:11px;color:var(--muted);">JPG, PNG, WEBP — maks 10 MB</span>
                    </label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" style="display:none;">
                    @error('thumbnail')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Preview Video Kursus</label>

                    @if($course->preview_video_url)
                        <div id="video-cur" style="margin-bottom:10px;border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--border);">
                            <video id="preview-vid" src="{{ $course->preview_video_url }}" controls style="width:100%;max-height:180px;"></video>
                            <p style="font-size:11px;color:var(--muted);padding:6px 10px;">Video saat ini</p>
                        </div>
                    @else
                        <div id="video-cur" style="display:none;margin-bottom:10px;border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--border);">
                            <video id="preview-vid" controls style="width:100%;max-height:180px;"></video>
                        </div>
                    @endif

                    <label for="preview_video" id="video-dropzone"
                           style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;padding:20px;border:2px dashed var(--lav-3);border-radius:var(--radius-md);cursor:pointer;background:var(--lav-1);transition:background 0.2s;">
                        <i class="fa-solid fa-film" style="font-size:24px;color:var(--purple);"></i>
                        <span style="font-size:13px;font-weight:600;color:var(--purple);">Klik untuk upload video baru</span>
                        <span style="font-size:11px;color:var(--muted);">MP4, MOV, AVI, WEBM — maks 100 MB</span>
                    </label>
                    <input type="file" id="preview_video" name="preview_video" accept="video/*" style="display:none;">
                    @error('preview_video')
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

<script>
// Thumbnail file upload preview
document.getElementById('thumbnail')?.addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const img      = document.getElementById('preview-img');
    const cur      = document.getElementById('thumb-cur');
    const dropzone = document.getElementById('thumb-dropzone');
    img.src        = URL.createObjectURL(file);
    if (cur) cur.style.display = 'block';
    dropzone.style.border     = '2px solid var(--purple)';
    dropzone.style.background = 'var(--lav-2)';
    const p = cur?.querySelector('p');
    if (p) p.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
});

// Video file upload preview
document.getElementById('preview_video')?.addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const vid      = document.getElementById('preview-vid');
    const cur      = document.getElementById('video-cur');
    const dropzone = document.getElementById('video-dropzone');
    vid.src        = URL.createObjectURL(file);
    if (cur) cur.style.display = 'block';
    dropzone.style.border     = '2px solid var(--purple)';
    dropzone.style.background = 'var(--lav-2)';
    const p = cur?.querySelector('p');
    if (p) p.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
});
</script>

@endsection
