{{-- resources/views/admin/users-show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail User')

@section('content')

<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'User Detail')
            @include('admin.partials.header')

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('admin.users') }}" class="hover:text-violet-600 transition">Users</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-800 font-medium">{{ $user->name }}</span>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- LEFT: Profile Card --}}
            <div class="xl:col-span-1 space-y-6">

                {{-- Profile --}}
                <div class="bg-white rounded-3xl shadow-sm p-8 flex flex-col items-center text-center">

                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" class="w-24 h-24 rounded-full object-cover mb-4" alt="{{ $user->name }}">
                    @else
                        <div class="w-24 h-24 rounded-full flex items-center justify-center font-bold text-white text-3xl mb-4
                            {{ $user->role === 'admin' ? 'bg-orange-500' : ($user->role === 'instructor' ? 'bg-green-500' : 'bg-violet-500') }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-400 text-sm mt-1">{{ $user->email }}</p>

                    <span class="mt-3 text-xs font-semibold px-4 py-1.5 rounded-full
                        {{ $user->role === 'admin' ? 'bg-orange-100 text-orange-700' : ($user->role === 'instructor' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }}">
                        {{ ucfirst($user->role) }}
                    </span>

                    @if($user->headline)
                        <p class="text-gray-500 text-sm mt-4 italic">"{{ $user->headline }}"</p>
                    @endif

                    @if($user->bio)
                        <p class="text-gray-600 text-sm mt-3 leading-relaxed">{{ $user->bio }}</p>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="flex gap-3 mt-6 w-full">
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                            class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-medium transition">
                            Edit User
                        </a>

                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                            onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>

                </div>

                {{-- Info Card --}}
                <div class="bg-white rounded-3xl shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider">Informasi Akun</h3>

                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Status Email</span>
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                Unverified
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Bergabung</span>
                        <span class="text-sm font-medium text-gray-700">{{ $user->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-500">Terakhir Update</span>
                        <span class="text-sm font-medium text-gray-700">{{ $user->updated_at->format('d M Y') }}</span>
                    </div>
                </div>

            </div>

            {{-- RIGHT: Stats & Activity --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Stats Cards --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 text-center">
                        <p class="text-3xl font-bold text-violet-600">{{ $user->enrollments->count() }}</p>
                        <p class="text-gray-500 text-xs mt-1">Enrollments</p>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $user->coursesTaught->count() }}</p>
                        <p class="text-gray-500 text-xs mt-1">Kursus Diajar</p>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 text-center">
                        <p class="text-3xl font-bold text-yellow-500">{{ $user->reviews->count() }}</p>
                        <p class="text-gray-500 text-xs mt-1">Reviews</p>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $user->certificates->count() }}</p>
                        <p class="text-gray-500 text-xs mt-1">Sertifikat</p>
                    </div>

                </div>

                {{-- Enrolled Courses --}}
                @if($user->enrollments->count() > 0)
                <div class="bg-white rounded-3xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Kursus yang Diikuti</h3>
                    <div class="space-y-3">
                        @foreach($user->enrollments->take(5) as $enrollment)
                        <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center text-sm">📚</div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $enrollment->course->title ?? 'Kursus tidak ditemukan' }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $enrollment->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                {{ $enrollment->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($enrollment->status ?? 'active') }}
                            </span>
                        </div>
                        @endforeach

                        @if($user->enrollments->count() > 5)
                            <p class="text-xs text-gray-400 text-center pt-2">
                                +{{ $user->enrollments->count() - 5 }} enrollment lainnya
                            </p>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Courses Taught (for instructors) --}}
                @if($user->coursesTaught->count() > 0)
                <div class="bg-white rounded-3xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Kursus yang Diajarkan</h3>
                    <div class="space-y-3">
                        @foreach($user->coursesTaught->take(5) as $course)
                        <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-sm">🧑‍🏫</div>
                                <p class="text-sm font-medium text-gray-800">{{ $course->title }}</p>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">
                                {{ ucfirst($course->status ?? 'active') }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Recent Reviews --}}
                @if($user->reviews->count() > 0)
                <div class="bg-white rounded-3xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Review Terakhir</h3>
                    <div class="space-y-4">
                        @foreach($user->reviews->take(3) as $review)
                        <div class="py-3 border-b border-gray-50 last:border-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-medium text-gray-700">
                                    {{ $review->course->title ?? 'Kursus tidak ditemukan' }}
                                </p>
                                <span class="text-xs text-yellow-500 font-semibold">⭐ {{ $review->rating ?? '-' }}</span>
                            </div>
                            @if($review->comment)
                                <p class="text-xs text-gray-500 italic">"{{ Str::limit($review->comment, 100) }}"</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

        </div>

    </main>
</div>

@endsection