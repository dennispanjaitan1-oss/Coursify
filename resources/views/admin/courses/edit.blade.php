@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10 px-4">

    <div class="max-w-5xl mx-auto">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-4xl font-bold text-gray-800">
                    Edit Course
                </h1>

                <p class="text-gray-500 mt-2">
                    Update informasi course dengan tampilan modern.
                </p>
            </div>

            <a href="{{ route('admin.courses.index') }}"
               class="bg-white border border-gray-300 hover:bg-gray-100 px-5 py-3 rounded-2xl transition">
                ← Kembali
            </a>

        </div>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 p-5 rounded-2xl mb-8">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 p-5 rounded-2xl mb-8">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CARD --}}
        <div class="bg-white rounded-[32px] shadow-xl overflow-hidden">

            {{-- TOP BAR --}}
            <div class="border-b px-8 py-6 bg-gradient-to-r from-indigo-500 to-blue-500">
                <h2 class="text-2xl font-bold text-white">Course Information</h2>
                <p class="text-indigo-100 mt-1">Lengkapi data course dengan benar.</p>
            </div>

            {{-- FORM --}}
            <form action="{{ route('admin.courses.update', $course) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-8 space-y-10">

                @csrf
                @method('PUT')

                {{-- BASIC INFO --}}
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- TITLE --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Course Title</label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $course->title) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>

                        {{-- CATEGORY --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                            <select name="category_id"
                                    class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- INSTITUTION --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Institution</label>
                            <select name="institution_id"
                                    class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                @foreach ($institutions as $institution)
                                    <option value="{{ $institution->id }}"
                                        {{ $course->institution_id == $institution->id ? 'selected' : '' }}>
                                        {{ $institution->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- PROGRAM --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program</label>
                            <select name="program_id"
                                    class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="">-- Pilih Program --</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}"
                                        {{ $course->program_id == $program->id ? 'selected' : '' }}>
                                        {{ $program->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- PRICE (IDR) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                <input type="number"
                                       name="price"
                                       value="{{ old('price', $course->price) }}"
                                       placeholder="0"
                                       min="0"
                                       step="1000"
                                       class="w-full border border-gray-300 rounded-2xl pl-12 pr-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Masukkan 0 untuk kursus gratis</p>
                        </div>

                        {{-- DURATION --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Duration (Weeks)</label>
                            <input type="number"
                                   name="duration_weeks"
                                   value="{{ old('duration_weeks', $course->duration_weeks) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>

                        {{-- DIFFICULTY --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Difficulty</label>
                            <select name="difficulty"
                                    class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="beginner" {{ $course->difficulty == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ $course->difficulty == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ $course->difficulty == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>

                        {{-- LANGUAGE --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
                            <input type="text"
                                   name="language"
                                   value="{{ old('language', $course->language) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>

                    </div>
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Description</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Short Description</label>
                            <textarea name="short_description"
                                      rows="2"
                                      class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('short_description', $course->short_description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Description</label>
                            <textarea name="description"
                                      rows="6"
                                      class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description', $course->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- MEDIA --}}
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Media</h3>

                    <div class="space-y-8">

                        {{-- THUMBNAIL --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Thumbnail Kursus
                            </label>

                            {{-- Current thumbnail preview --}}
                            @if($course->thumbnail_url)
                                <div class="mb-3">
                                    <img id="thumbnailPreview"
                                         src="{{ $course->thumbnail_url }}"
                                         alt="Current thumbnail"
                                         class="w-full max-h-[280px] object-cover rounded-2xl border border-gray-200">
                                    <p class="text-xs text-gray-400 mt-1">Thumbnail saat ini</p>
                                </div>
                            @else
                                <div id="thumbnailPreviewWrap" class="mb-3 hidden">
                                    <img id="thumbnailPreview"
                                         src=""
                                         alt="Thumbnail preview"
                                         class="w-full max-h-[280px] object-cover rounded-2xl border border-gray-200">
                                </div>
                            @endif

                            <label for="thumbnailFile"
                                   class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-indigo-300 rounded-2xl cursor-pointer bg-indigo-50 hover:bg-indigo-100 transition">
                                <i class="fa-solid fa-cloud-arrow-up text-indigo-400 text-2xl mb-2"></i>
                                <span class="text-sm text-indigo-500 font-medium">Klik untuk upload thumbnail baru</span>
                                <span class="text-xs text-gray-400">JPG, PNG, WEBP — maks 10 MB</span>
                            </label>
                            <input type="file"
                                   id="thumbnailFile"
                                   name="thumbnail"
                                   accept="image/*"
                                   class="hidden">
                        </div>

                        {{-- VIDEO --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Preview Video Kursus
                            </label>

                            @if($course->preview_video_url)
                                <div class="mb-3">
                                    <video id="videoPreview"
                                           src="{{ $course->preview_video_url }}"
                                           controls
                                           class="w-full max-h-[280px] rounded-2xl border border-gray-200">
                                    </video>
                                    <p class="text-xs text-gray-400 mt-1">Video preview saat ini</p>
                                </div>
                            @else
                                <div id="videoPreviewWrap" class="mb-3 hidden">
                                    <video id="videoPreview"
                                           src=""
                                           controls
                                           class="w-full max-h-[280px] rounded-2xl border border-gray-200">
                                    </video>
                                </div>
                            @endif

                            <label for="videoFile"
                                   class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-indigo-300 rounded-2xl cursor-pointer bg-indigo-50 hover:bg-indigo-100 transition">
                                <i class="fa-solid fa-film text-indigo-400 text-2xl mb-2"></i>
                                <span class="text-sm text-indigo-500 font-medium">Klik untuk upload video baru</span>
                                <span class="text-xs text-gray-400">MP4, MOV, AVI, WEBM — maks 100 MB</span>
                            </label>
                            <input type="file"
                                   id="videoFile"
                                   name="preview_video"
                                   accept="video/*"
                                   class="hidden">
                        </div>

                    </div>
                </div>

                {{-- STATUS --}}
                <div class="bg-gray-50 rounded-3xl p-6 flex items-center gap-4">
                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           id="is_published"
                           class="w-5 h-5"
                           {{ $course->is_published ? 'checked' : '' }}>
                    <div>
                        <label for="is_published" class="font-semibold text-gray-800 cursor-pointer">Published</label>
                        <p class="text-sm text-gray-500">Course akan langsung tampil kepada user.</p>
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('admin.courses.index') }}"
                       class="border border-gray-300 hover:bg-gray-100 px-6 py-3 rounded-2xl transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl shadow-lg transition">
                        Save Changes
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- FILE PREVIEW SCRIPT --}}
<script>
// Thumbnail file preview
document.getElementById('thumbnailFile')?.addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const preview = document.getElementById('thumbnailPreview');
    const wrap    = document.getElementById('thumbnailPreviewWrap');
    const url     = URL.createObjectURL(file);
    if (preview) { preview.src = url; }
    if (wrap)    { wrap.classList.remove('hidden'); }
});

// Video file preview
document.getElementById('videoFile')?.addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const preview = document.getElementById('videoPreview');
    const wrap    = document.getElementById('videoPreviewWrap');
    const url     = URL.createObjectURL(file);
    if (preview) { preview.src = url; }
    if (wrap)    { wrap.classList.remove('hidden'); }
});
</script>

@endsection
