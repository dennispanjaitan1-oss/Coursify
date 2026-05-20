@extends('layouts.instructor')

@section('title', 'Create Course')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="search" class="sr-only">Search</label>
            <input type="text"
                   id="search"
                   class="topbar__search-input"
                   placeholder="Search your courses, students, messages..."
                   aria-label="Search">
        </div>

        <div class="topbar__actions">
            <button class="icon-btn"
                    aria-label="Notifications"
                    title="Notifications">
                <i class="fa-solid fa-bell" aria-hidden="true"></i>
                <span class="icon-btn__dot" aria-hidden="true"></span>
            </button>
            <a href="{{ route('instructor.messages') }}" class="icon-btn" aria-label="Messages">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            </a>
        </div>
    </header>

    {{-- PAGE HEADER --}}
    <section class="page-header" aria-label="Page title">
        <div style="display:flex; align-items:center; gap:16px; justify-content:space-between; flex-wrap:wrap;">
            <div>
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                    <a href="{{ route('instructor.courses.index') }}"
                       style="color:var(--muted); font-size:13px; text-decoration:none; display:flex; align-items:center; gap:5px;">
                        <i class="fa-solid fa-arrow-left" style="font-size:11px;"></i>
                        My Courses
                    </a>
                    <span style="color:var(--lav-3);">/</span>
                    <span style="color:var(--purple); font-size:13px; font-weight:600;">Create New</span>
                </div>
                <h1 class="page-title">Create New <em style="font-style:italic; font-family:var(--font-serif);">Course</em></h1>
                <p class="page-subtitle">Share your knowledge with thousands of learners</p>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-size:12px; color:var(--muted);">
                    <i class="fa-solid fa-circle-info"></i> Fill all required fields to publish
                </span>
            </div>
        </div>
    </section>

    {{-- SUCCESS / ERROR ALERTS --}}
    @if(session('success'))
        <div style="background:var(--teal-light); border:1px solid var(--teal); border-radius:var(--radius-md); padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:12px;">
            <i class="fa-solid fa-circle-check" style="color:var(--teal);"></i>
            <span style="font-size:14px; color:#065F46;">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div style="background:#FEF2F2; border:1px solid #FCA5A5; border-radius:var(--radius-md); padding:14px 18px; margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <i class="fa-solid fa-circle-exclamation" style="color:#EF4444;"></i>
                <span style="font-size:14px; font-weight:600; color:#991B1B;">Please fix the errors below</span>
            </div>
            <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:4px;">
                @foreach($errors->all() as $error)
                    <li style="font-size:13px; color:#B91C1C; padding-left:20px;">• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('instructor.courses.store') }}" enctype="multipart/form-data">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">

            {{-- LEFT COLUMN: Main Form --}}
            <div style="display:flex; flex-direction:column; gap:20px;">

                {{-- Basic Info --}}
                <section class="card-wrap" aria-labelledby="basic-info-title">
                    <div class="card-head">
                        <h2 class="card-title" id="basic-info-title">
                            <span style="display:inline-flex; align-items:center; gap:10px;">
                                <span style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg,var(--purple),var(--purple-dark)); color:white; display:inline-flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0;">1</span>
                                Basic <em>Information</em>
                            </span>
                        </h2>
                    </div>

                    <div class="form-group">
                        <label for="title" class="form-label">Course Title <span style="color:#EF4444;">*</span></label>
                        <input type="text" id="title" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="e.g., Complete Web Development Bootcamp 2025"
                               required value="{{ old('title') }}">
                        <span style="font-size:12px; color:var(--muted);">Write a clear, specific title that describes what students will learn</span>
                        @error('title')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="category_id" class="form-label">Category <span style="color:#EF4444;">*</span></label>
                            <select id="category_id" name="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <label for="difficulty" class="form-label">Difficulty Level <span style="color:#EF4444;">*</span></label>
                            <select id="difficulty" name="difficulty"
                                    class="form-control @error('difficulty') is-invalid @enderror" required>
                                <option value="">-- Select Level --</option>
                                <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>🟢 Beginner</option>
                                <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>🟡 Intermediate</option>
                                <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>🔴 Advanced</option>
                            </select>
                            @error('difficulty')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Description --}}
                <section class="card-wrap" aria-labelledby="description-title">
                    <div class="card-head">
                        <h2 class="card-title" id="description-title">
                            <span style="display:inline-flex; align-items:center; gap:10px;">
                                <span style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg,var(--teal),#00a87a); color:white; display:inline-flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0;">2</span>
                                Course <em>Description</em>
                            </span>
                        </h2>
                    </div>

                    <div class="form-group">
                        <label for="short_description" class="form-label">Short Description <span style="color:#EF4444;">*</span></label>
                        <textarea id="short_description" name="short_description"
                                  class="form-control @error('short_description') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Brief summary shown in course cards (max 200 chars)" required>{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label for="description" class="form-label">Full Description <span style="color:#EF4444;">*</span></label>
                        <textarea id="description" name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="8"
                                  placeholder="What will students learn? What are the prerequisites? What's included?&#10;&#10;Tip: Use bullet points and clear sections to structure your description." required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </section>

                {{-- Pricing & Duration --}}
                <section class="card-wrap" aria-labelledby="pricing-title">
                    <div class="card-head">
                        <h2 class="card-title" id="pricing-title">
                            <span style="display:inline-flex; align-items:center; gap:10px;">
                                <span style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg,var(--gold),#e6a800); color:white; display:inline-flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0;">3</span>
                                Pricing & <em>Duration</em>
                            </span>
                        </h2>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="price" class="form-label">Price <span style="color:#EF4444;">*</span></label>
                            <div style="position:relative;">
                                <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:13px; font-weight:600; color:var(--muted);">Rp</span>
                                <input type="number" id="price" name="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       placeholder="150000" min="0" step="1000"
                                       style="padding-left:36px;"
                                       required value="{{ old('price') }}">
                            </div>
                            <span style="font-size:12px; color:var(--muted);">Set to 0 for a free course</span>
                            @error('price')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <label for="duration_weeks" class="form-label">Duration (weeks) <span style="color:#EF4444;">*</span></label>
                            <input type="number" id="duration_weeks" name="duration_weeks"
                                   class="form-control @error('duration_weeks') is-invalid @enderror"
                                   placeholder="4" min="1" required value="{{ old('duration_weeks') }}">
                            @error('duration_weeks')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <label for="language" class="form-label">Language <span style="color:#EF4444;">*</span></label>
                            <select id="language" name="language"
                                    class="form-control @error('language') is-invalid @enderror" required>
                                <option value="">-- Select Language --</option>
                                <option value="Indonesian" {{ old('language') == 'Indonesian' ? 'selected' : '' }}>🇮🇩 Indonesian</option>
                                <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>🇬🇧 English</option>
                            </select>
                            @error('language')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </section>

            </div>

            {{-- RIGHT COLUMN: Media & Actions --}}
            <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:24px;">

                {{-- Publish Action --}}
                <section class="card-wrap" style="background:linear-gradient(135deg, #F5F1FC, #EDE8F9); border:1px solid var(--lav-3);">
                    <div style="text-align:center; padding:8px 0 16px;">
                        <div style="width:56px; height:56px; border-radius:16px; background:linear-gradient(135deg,var(--purple),var(--purple-dark)); color:white; display:flex; align-items:center; justify-content:center; font-size:22px; margin:0 auto 14px; box-shadow:0 8px 20px rgba(123,111,232,0.3);">
                            <i class="fa-solid fa-rocket"></i>
                        </div>
                        <div style="font-family:var(--font-serif); font-size:20px; color:var(--text); margin-bottom:6px;">Ready to publish?</div>
                        <p style="font-size:13px; color:var(--text-soft); line-height:1.6; margin-bottom:20px;">
                            Your course will be reviewed and go live within 24 hours after submission.
                        </p>

                        <button type="submit" name="action" value="publish"
                                class="btn-primary" style="width:100%; justify-content:center; margin-bottom:10px;">
                            <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                            Create & Publish
                        </button>

                        <button type="submit" name="action" value="draft"
                                style="width:100%; display:flex; align-items:center; justify-content:center; gap:8px; padding:10px 20px; border-radius:var(--radius-pill); font-size:13px; font-weight:600; cursor:pointer; border:1.5px solid var(--lav-3); background:white; color:var(--text-soft); transition:all 0.2s ease;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Save as Draft
                        </button>

                        <a href="{{ route('instructor.courses.index') }}"
                           style="display:block; margin-top:10px; font-size:12px; color:var(--muted); text-decoration:none;">
                            Cancel &amp; go back
                        </a>
                    </div>
                </section>

                {{-- Thumbnail --}}
                <section class="card-wrap" aria-labelledby="thumbnail-title">
                    <div class="card-head">
                        <h2 class="card-title" id="thumbnail-title">Course <em>Thumbnail</em></h2>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label for="thumbnail_url" class="form-label">Thumbnail URL</label>
                        <input type="url" id="thumbnail_url" name="thumbnail_url"
                               class="form-control @error('thumbnail_url') is-invalid @enderror"
                               placeholder="https://example.com/image.jpg"
                               value="{{ old('thumbnail_url') }}">
                        <span style="font-size:12px; color:var(--muted);">Recommended: 1280×720px (16:9)</span>
                        @error('thumbnail_url')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Preview --}}
                    <div id="thumbnail-preview" style="display:none; margin-top:12px; border-radius:var(--radius-md); overflow:hidden; border:1px solid var(--border);">
                        <img id="preview-img" src="" alt="Thumbnail preview" style="width:100%; height:120px; object-fit:cover;">
                    </div>
                </section>

                {{-- Preview Video --}}
                <section class="card-wrap" aria-labelledby="video-title">
                    <div class="card-head">
                        <h2 class="card-title" id="video-title">Preview <em>Video</em></h2>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="preview_video_url" class="form-label">YouTube / Video URL</label>
                        <input type="url" id="preview_video_url" name="preview_video_url"
                               class="form-control @error('preview_video_url') is-invalid @enderror"
                               placeholder="https://youtube.com/watch?v=..."
                               value="{{ old('preview_video_url') }}">
                        <span style="font-size:12px; color:var(--muted);">2–5 minute course preview video</span>
                        @error('preview_video_url')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </section>

                {{-- Checklist --}}
                <section class="card-wrap" style="background:var(--lav-1); border:1px solid var(--lav-2);">
                    <div class="card-head" style="border-bottom:none; padding-bottom:0;">
                        <h2 class="card-title">Completion <em>checklist</em></h2>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:10px; margin-top:8px;">
                        @php
                            $checks = [
                                ['label'=>'Course title', 'done'=>old('title')],
                                ['label'=>'Category & difficulty', 'done'=>old('category_id') && old('difficulty')],
                                ['label'=>'Short description', 'done'=>old('short_description')],
                                ['label'=>'Full description', 'done'=>old('description')],
                                ['label'=>'Price & duration', 'done'=>old('price') !== null && old('duration_weeks')],
                                ['label'=>'Thumbnail URL (optional)', 'done'=>old('thumbnail_url')],
                            ];
                        @endphp
                        @foreach($checks as $check)
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px;">
                                <span style="width:20px; height:20px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:11px;
                                    {{ $check['done'] ? 'background:var(--teal); color:white;' : 'background:var(--lav-3); color:var(--muted);' }}">
                                    <i class="fa-solid {{ $check['done'] ? 'fa-check' : 'fa-minus' }}"></i>
                                </span>
                                <span style="color:{{ $check['done'] ? 'var(--text)' : 'var(--muted)' }}; {{ $check['done'] ? 'font-weight:500;' : '' }}">
                                    {{ $check['label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </section>

            </div>
        </div>
    </form>

    <script>
        // Thumbnail preview
        document.getElementById('thumbnail_url')?.addEventListener('input', function() {
            const preview = document.getElementById('thumbnail-preview');
            const img = document.getElementById('preview-img');
            if (this.value && this.value.startsWith('http')) {
                img.src = this.value;
                preview.style.display = 'block';
                img.onerror = () => { preview.style.display = 'none'; };
            } else {
                preview.style.display = 'none';
            }
        });
    </script>

@endsection
