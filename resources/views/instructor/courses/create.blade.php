@extends('layouts.instructor')

@section('title', 'Create Course')

@section('content')

    {{-- BACK LINK --}}
    <a href="{{ route('instructor.courses.index') }}" style="color: var(--muted); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13.5px; margin-bottom: 24px; transition: var(--transition-fast);" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--muted)'">
        <i class="fa-solid fa-arrow-left"></i> Back to Courses
    </a>

    {{-- HEADER --}}
    <div style="margin-bottom: 32px;">
        <h1 style="font-family: var(--font-serif); font-size: 36px; font-weight: 400; color: var(--text);">
            Create a new <em>course</em>
        </h1>
        <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Share your knowledge. Fill in the course details below.</p>
    </div>

    @if($errors->any())
        <div class="card-wrap" style="background: rgba(255, 138, 91, 0.1); border: 1.5px solid var(--orange); margin-bottom: 28px; padding: 18px 24px; border-radius: var(--radius-md);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; color: var(--orange);">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
                <h4 style="font-weight: 700; font-size: 14.5px;">Form Validation Failed:</h4>
            </div>
            <ul style="color: var(--text-soft); font-size: 13px; padding-left: 20px; line-height: 1.6;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- STUNNING SIDE-BY-SIDE FORM --}}
    <form action="{{ route('instructor.courses.store') }}" method="POST" style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 28px; align-items: start; margin-bottom: 48px;">
        @csrf

        {{-- LEFT MAIN PANEL --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            {{-- General Information Card --}}
            <div class="card-wrap" style="display: flex; flex-direction: column; gap: 20px;">
                <h2 style="font-size: 16px; font-weight: 700; color: var(--text); border-bottom: 1.5px solid var(--border); padding-bottom: 12px; margin-bottom: 4px;">
                    <i class="fa-solid fa-circle-info" style="color: var(--purple); margin-right: 8px;"></i> General Information
                </h2>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="title" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Course Title <span style="color: var(--orange);">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Mastering Advanced Web Development" style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="slug" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">URL Slug <span style="color: var(--orange);">*</span></label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required placeholder="e.g. mastering-advanced-web-development" style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none; background: #FAF9FD;" onfocus="this.style.borderColor='var(--purple)'; this.style.background='white';" onblur="this.style.borderColor='var(--border)'; this.style.background='#FAF9FD';">
                    <span style="font-size: 11.5px; color: var(--muted);">Unique URL for this course. Automatically generated from title, but customizable.</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="short_description" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Short Description <span style="color: var(--orange);">*</span></label>
                    <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}" required placeholder="A brief one-sentence hook that captures the main goal of the course." style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="description" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Full Course Description</label>
                    <textarea name="description" id="description" rows="8" placeholder="Provide a detailed outline, targets, curriculum description, and prerequisites..." style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none; resize: vertical;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Media URLs Card --}}
            <div class="card-wrap" style="display: flex; flex-direction: column; gap: 20px;">
                <h2 style="font-size: 16px; font-weight: 700; color: var(--text); border-bottom: 1.5px solid var(--border); padding-bottom: 12px; margin-bottom: 4px;">
                    <i class="fa-solid fa-photo-film" style="color: var(--teal); margin-right: 8px;"></i> Course Media (URLs)
                </h2>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="thumbnail_url" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Course Cover Thumbnail URL</label>
                    <input type="url" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url') }}" placeholder="https://images.unsplash.com/... or your custom asset image URL" style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="preview_video_url" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Course Intro Video URL</label>
                    <input type="url" name="preview_video_url" id="preview_video_url" value="{{ old('preview_video_url') }}" placeholder="https://www.youtube.com/watch?v=... or direct mp4 url" style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                </div>
            </div>
        </div>

        {{-- RIGHT SETTINGS SIDEBAR PANEL --}}
        <div style="display: flex; flex-direction: column; gap: 24px; position: sticky; top: 24px;">
            
            {{-- Course Settings Card --}}
            <div class="card-wrap" style="display: flex; flex-direction: column; gap: 20px;">
                <h2 style="font-size: 16px; font-weight: 700; color: var(--text); border-bottom: 1.5px solid var(--border); padding-bottom: 12px; margin-bottom: 4px;">
                    <i class="fa-solid fa-sliders" style="color: var(--orange); margin-right: 8px;"></i> Course Settings
                </h2>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="category_id" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Category <span style="color: var(--orange);">*</span></label>
                    <select name="category_id" id="category_id" required style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none; background: white;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                        <option value="" disabled selected>Select category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="price" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Price (IDR) <span style="color: var(--orange);">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0" required placeholder="0 for free" style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="difficulty" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Difficulty <span style="color: var(--orange);">*</span></label>
                    <select name="difficulty" id="difficulty" required style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none; background: white;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                        <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('difficulty', 'intermediate') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="duration_weeks" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Duration (Weeks)</label>
                    <input type="number" name="duration_weeks" id="duration_weeks" value="{{ old('duration_weeks') }}" min="1" max="104" placeholder="e.g. 8" style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="language" style="font-weight: 600; font-size: 13px; color: var(--text-soft);">Language</label>
                    <input type="text" name="language" id="language" value="{{ old('language', 'ID') }}" placeholder="ID or EN" style="width: 100%; padding: 11px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-family: var(--font-sans); transition: var(--transition-fast); outline: none;" onfocus="this.style.borderColor='var(--purple)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1.5px solid var(--border); padding-top: 18px; margin-top: 8px;">
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 700; font-size: 13.5px; color: var(--text);">Publish Immediately</span>
                        <span style="font-size: 11px; color: var(--muted);">Visible to all prospective students</span>
                    </div>
                    <label class="switch" style="position: relative; display: inline-block; width: 44px; height: 24px;">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;" onchange="toggleSwitch(this)">
                        <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .3s; border-radius: 24px;"></span>
                    </label>
                </div>
            </div>

            {{-- Submit Panel --}}
            <div class="card-wrap" style="display: flex; flex-direction: column; gap: 14px; background: var(--lav-1); border-color: var(--lav-3);">
                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 12px; font-size: 14px;">
                    <i class="fa-solid fa-circle-check"></i> Create Course
                </button>
                <a href="{{ route('instructor.courses.index') }}" style="text-align: center; font-size: 13px; font-weight: 600; color: var(--text-soft); text-decoration: none; padding: 8px; border-radius: var(--radius-sm); transition: var(--transition-fast);" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--text-soft)'">
                    Cancel and Return
                </a>
            </div>
        </div>
    </form>

    {{-- SWITCH TOGGLE CSS AND JS SLUG DYNAMICS --}}
    <style>
        .switch input:checked + .slider {
            background-color: var(--teal) !important;
        }
        .switch input:focus + .slider {
            box-shadow: 0 0 1px var(--teal);
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }
        .switch input:checked + .slider:before {
            transform: translateX(20px);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            titleInput.addEventListener('input', function() {
                const titleValue = this.value;
                const slugValue = titleValue
                    .toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes
                
                slugInput.value = slugValue;
            });
        });

        function toggleSwitch(checkbox) {
            // Can add subtle haptics or console updates here if desired
        }
    </script>

@endsection
