@extends('layouts.app')

@section('content')

<div class="p-8 max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">Create Course</h1>
                <p class="text-gray-600 mt-2">Tambah course baru ke panel admin.</p>
            </div>
            <a href="{{ route('admin.courses.index') }}" class="text-indigo-600 hover:text-indigo-800">Back to courses</a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block mb-2 font-medium">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-2xl p-4" required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Short Description</label>
                    <textarea name="short_description" rows="4" class="w-full border rounded-2xl p-4">{{ old('short_description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block mb-2 font-medium">Category</label>
                        <select name="category_id" class="w-full border rounded-2xl p-4" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Institution</label>
                        <select name="institution_id" class="w-full border rounded-2xl p-4" required>
                            <option value="">Pilih institusi</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}" {{ old('institution_id') == $institution->id ? 'selected' : '' }}>{{ $institution->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Program</label>
                        <select name="program_id" class="w-full border rounded-2xl p-4">
                            <option value="">Tidak ada / Pilih program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 font-medium">Price</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="w-full border rounded-2xl p-4" min="0" step="0.01" required>
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Difficulty</label>
                        <select name="difficulty" class="w-full border rounded-2xl p-4" required>
                            <option value="">Pilih tingkat kesulitan</option>
                            <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 font-medium">Thumbnail URL</label>
                        <input type="url" name="thumbnail_url" value="{{ old('thumbnail_url') }}" class="w-full border rounded-2xl p-4">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">Preview Video URL</label>
                        <input type="url" name="preview_video_url" value="{{ old('preview_video_url') }}" class="w-full border rounded-2xl p-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 font-medium">Order Index</label>
                        <input type="number" name="order_index" value="{{ old('order_index', 0) }}" class="w-full border rounded-2xl p-4" min="0">
                    </div>
                    <div class="flex items-center gap-3 pt-6">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        <label for="is_published" class="font-medium">Publish langsung</label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-xl transition">Save Course</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection