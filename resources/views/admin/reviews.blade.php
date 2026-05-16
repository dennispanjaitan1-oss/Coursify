{{-- resources/views/admin/reviews.blade.php --}}
@extends('layouts.app')

@section('title', 'Reviews')

@section('content')
<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">

        {{-- HEADER --}}
        <div class="bg-white rounded-3xl shadow-md p-8 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Reviews Management</h1>
                    <p class="text-gray-500 mt-1">Kelola seluruh ulasan course dari pengguna.</p>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                <p class="text-sm text-gray-500">Total Reviews</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                <p class="text-sm text-gray-500">Visible</p>
                <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $stats['visible'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                <p class="text-sm text-gray-500">Hidden</p>
                <h2 class="text-3xl font-bold text-yellow-500 mt-2">{{ $stats['hidden'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                <p class="text-sm text-gray-500">Rata-rata Rating</p>
                <h2 class="text-3xl font-bold text-violet-600 mt-2">⭐ {{ $stats['avg'] }}</h2>
            </div>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6 border border-gray-100">
            <form method="GET" action="{{ route('admin.reviews') }}" class="flex flex-col md:flex-row gap-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari user, course, atau komentar..."
                    class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-300">
                <select name="rating" class="border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none">
                    <option value="">Semua Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>⭐ {{ $i }}</option>
                    @endfor
                </select>
                <button type="submit"
                    class="bg-violet-500 text-white px-6 py-3 rounded-2xl font-medium hover:bg-violet-600 transition">
                    Cari
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-gray-500 text-sm">
                            <th class="px-6 py-4 font-semibold">Pengguna</th>
                            <th class="px-6 py-4 font-semibold">Course</th>
                            <th class="px-6 py-4 font-semibold">Rating</th>
                            <th class="px-6 py-4 font-semibold">Komentar</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reviews as $review)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5 font-medium text-gray-800">
                                    {{ $review->user->name ?? '-' }}
                                    <p class="text-xs text-gray-400">{{ $review->user->email ?? '' }}</p>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600">
                                    {{ $review->course->title ?? '-' }}
                                </td>
                                <td class="px-6 py-5">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        ⭐ {{ $review->rating }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $review->comment ?? '-' }}
                                </td>
                                <td class="px-6 py-5">
                                    @if($review->is_visible)
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Visible</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-semibold">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-400">
                                    {{ $review->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Toggle Visibility --}}
                                        <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                                <i class="fa-solid {{ $review->is_visible ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                {{ $review->is_visible ? 'Hide' : 'Show' }}
                                            </button>
                                        </form>
                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                                            onsubmit="return confirm('Hapus review ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                                    Belum ada review.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $reviews->withQueryString()->links() }}
            </div>
        </div>

    </main>
</div>
@endsection