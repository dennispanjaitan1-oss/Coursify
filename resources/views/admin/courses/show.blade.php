@extends('layouts.app')

@section('content')
<div class="p-8 max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Course Details</h1>
            <p class="text-gray-600 mt-2">Detail lengkap course untuk admin.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.courses.edit', $course) }}" class="px-4 py-2 rounded-2xl bg-indigo-600 text-white hover:bg-indigo-700">Edit</a>
            <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 rounded-2xl border border-gray-300 text-gray-700">Back</a>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold">General Information</h2>
                <div class="mt-4 space-y-3 text-sm text-gray-700">
                    <p><strong>Title:</strong> {{ $course->title }}</p>
                    <p><strong>Slug:</strong> {{ $course->slug }}</p>
                    <p><strong>Category:</strong> {{ $course->category?->name ?? '-' }}</p>
                    <p><strong>Institution:</strong> {{ $course->institution?->name ?? '-' }}</p>
                    <p><strong>Program:</strong> {{ $course->program?->title ?? 'None' }}</p>
                    <p><strong>Difficulty:</strong> {{ ucfirst($course->difficulty) }}</p>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold">Publication</h2>
                <div class="mt-4 space-y-3 text-sm text-gray-700">
                    <p><strong>Status:</strong> {{ $course->is_published ? 'Published' : 'Draft' }}</p>
                    <p><strong>Price:</strong> {{ number_format($course->price, 2) }}</p>
                    <p><strong>Order Index:</strong> {{ $course->order_index }}</p>
                    <p><strong>Created:</strong> {{ $course->created_at->format('d M Y') }}</p>
                    <p><strong>Updated:</strong> {{ $course->updated_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-3 text-sm text-gray-700">
                <h2 class="text-xl font-semibold">Media</h2>
                <p><strong>Thumbnail URL:</strong><br> {{ $course->thumbnail_url ?? '-' }}</p>
                <p><strong>Preview Video URL:</strong><br> {{ $course->preview_video_url ?? '-' }}</p>
            </div>
            <div class="space-y-3 text-sm text-gray-700">
                <h2 class="text-xl font-semibold">Summary</h2>
                <p>{{ $course->short_description ?? 'No description provided.' }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-3xl text-sm text-gray-700">
            <h2 class="text-lg font-semibold mb-3">Full Description</h2>
            <p>{{ $course->description ?? 'No longer description available.' }}</p>
        </div>
    </div>
</div>
@endsection