{{-- resources/views/admin/approvals.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 flex">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto">

            {{-- HEADER --}}
            <div class="bg-white rounded-3xl shadow-md p-8 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Approvals</h1>
                        <p class="text-gray-500 mt-2">Kelola course yang menunggu persetujuan.</p>
                    </div>
                    <div class="bg-orange-100 text-orange-600 px-4 py-2 rounded-2xl font-semibold text-sm">
                        {{ $pendingCount }} Pending
                    </div>
                </div>
            </div>

            {{-- APPROVAL LIST --}}
            <div class="space-y-4">

                @forelse($pending as $course)
                    <div class="bg-white rounded-3xl shadow-md p-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">

                            {{-- Thumbnail --}}
                            @if($course->thumbnail_url)
                                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}"
                                    class="w-16 h-16 rounded-2xl object-cover bg-gray-100">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-500 text-xl">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                            @endif

                            <div>
                                <h2 class="text-lg font-bold text-gray-800">{{ $course->title }}</h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    Oleh
                                    <span class="font-semibold text-gray-700">
                                        {{ $course->instructors->pluck('name')->join(', ') ?: '-' }}
                                    </span>
                                    @if($course->category)
                                        · <span class="text-violet-500">{{ $course->category->name }}</span>
                                    @endif
                                    @if($course->institution)
                                        · <span class="text-gray-500">{{ $course->institution->name }}</span>
                                    @endif
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $course->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            {{-- Approve --}}
                            <form method="POST" action="{{ route('admin.approvals.approve', $course) }}">
                                @csrf
                                <button type="submit"
                                    class="bg-green-100 text-green-700 px-5 py-2 rounded-xl text-sm font-medium hover:bg-green-200 transition">
                                    <i class="fa-solid fa-check"></i> Approve
                                </button>
                            </form>

                            {{-- Reject --}}
                            <form method="POST" action="{{ route('admin.approvals.reject', $course) }}"
                                onsubmit="return confirm('Yakin reject course ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-100 text-red-600 px-5 py-2 rounded-xl text-sm font-medium hover:bg-red-200 transition">
                                    <i class="fa-solid fa-xmark"></i> Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl shadow-md p-12 text-center text-gray-400">
                        <i class="fa-solid fa-circle-check text-4xl text-green-300 mb-3"></i>
                        <p class="font-medium">Semua course sudah disetujui!</p>
                    </div>
                @endforelse

            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $pending->links() }}
            </div>

        </main>
    </div>
@endsection