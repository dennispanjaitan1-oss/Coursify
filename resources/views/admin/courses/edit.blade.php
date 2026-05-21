```blade
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

                <h2 class="text-2xl font-bold text-white">
                    Course Information
                </h2>

                <p class="text-indigo-100 mt-1">
                    Lengkapi data course dengan benar.
                </p>

            </div>

            {{-- FORM --}}
            <form action="{{ route('admin.courses.update', $course) }}"
                  method="POST"
                  class="p-8 space-y-10">

                @csrf
                @method('PUT')

                {{-- BASIC INFO --}}
                <div>

                    <h3 class="text-xl font-semibold text-gray-800 mb-6">
                        Basic Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- TITLE --}}
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Course Title
                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $course->title) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        </div>

                        {{-- CATEGORY --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Category
                            </label>

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

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Institution
                            </label>

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

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Program
                            </label>

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

                        {{-- PRICE --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Price
                            </label>

                            <input type="number"
                                   name="price"
                                   value="{{ old('price', $course->price) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        </div>

                        {{-- DURATION --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Duration (Weeks)
                            </label>

                            <input type="number"
                                   name="duration_weeks"
                                   value="{{ old('duration_weeks', $course->duration_weeks) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        </div>

                        {{-- DIFFICULTY --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Difficulty
                            </label>

                            <select name="difficulty"
                                    class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                                <option value="beginner"
                                    {{ $course->difficulty == 'beginner' ? 'selected' : '' }}>
                                    Beginner
                                </option>

                                <option value="intermediate"
                                    {{ $course->difficulty == 'intermediate' ? 'selected' : '' }}>
                                    Intermediate
                                </option>

                                <option value="advanced"
                                    {{ $course->difficulty == 'advanced' ? 'selected' : '' }}>
                                    Advanced
                                </option>

                            </select>

                        </div>

                        {{-- LANGUAGE --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Language
                            </label>

                            <input type="text"
                                   name="language"
                                   value="{{ old('language', $course->language) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        </div>

                    </div>

                </div>

                {{-- DESCRIPTION --}}
                <div>

                    <h3 class="text-xl font-semibold text-gray-800 mb-6">
                        Description
                    </h3>

                    <div class="space-y-6">

                        {{-- SHORT DESC --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="6"
                                      class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description', $course->description) }}</textarea>

                        </div>

                    </div>

                </div>

                {{-- MEDIA --}}
                <div>

                    <h3 class="text-xl font-semibold text-gray-800 mb-6">
                        Media
                    </h3>

                    <div class="space-y-6">

                        {{-- THUMBNAIL --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Thumbnail URL
                            </label>

                            <input type="text"
                                   id="thumbnailInput"
                                   name="thumbnail_url"
                                   value="{{ old('thumbnail_url', $course->thumbnail_url) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        </div>

                        {{-- IMAGE PREVIEW --}}
                        <div>

                            <img id="thumbnailPreview"
                                 src="{{ $course->thumbnail_url }}"
                                 class="w-full max-h-[350px] object-cover rounded-3xl border">

                        </div>

                        {{-- VIDEO --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Preview Video URL
                            </label>

                            <input type="text"
                                   name="preview_video_url"
                                   value="{{ old('preview_video_url', $course->preview_video_url) }}"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        </div>

                    </div>

                </div>

                {{-- STATUS --}}
                <div class="bg-gray-50 rounded-3xl p-6 flex items-center gap-4">

                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           class="w-5 h-5"
                           {{ $course->is_published ? 'checked' : '' }}>

                    <div>

                        <h4 class="font-semibold text-gray-800">
                            Published
                        </h4>

                        <p class="text-sm text-gray-500">
                            Course akan langsung tampil kepada user.
                        </p>

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

{{-- PREVIEW SCRIPT --}}
<script>

document.getElementById('thumbnailInput')
.addEventListener('input', function() {

    document.getElementById('thumbnailPreview')
        .src = this.value;

});

</script>

@endsection
```
