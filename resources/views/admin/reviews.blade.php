{{-- resources/views/admin/reviews.blade.php --}}
@extends('layouts.app')

@section('title', 'Reviews')

@section('content')
<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'Reviews')
            @include('admin.partials.header')

        {{-- HEADER --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Reviews Management</h1>
                    <p class="text-gray-500 mt-1">Kelola seluruh ulasan course dari pengguna.</p>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <p class="text-sm text-gray-500">Total Reviews</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <p class="text-sm text-gray-500">Visible</p>
                <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $stats['visible'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <p class="text-sm text-gray-500">Hidden</p>
                <h2 class="text-3xl font-bold text-yellow-500 mt-2">{{ $stats['hidden'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <p class="text-sm text-gray-500">Rata-rata Rating</p>
                <h2 class="text-3xl font-bold text-violet-600 mt-2">⭐ {{ $stats['avg'] }}</h2>
            </div>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 mb-6">
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
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                    Cari
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wide">
                        <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wide">
                            <th class="px-6 py-4 font-semibold">Pengguna</th>
                            <th class="px-6 py-4 font-semibold">Course</th>
                            <th class="px-6 py-4 font-semibold">Rating</th>
                            <th class="px-6 py-4 font-semibold">Komentar</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($reviews as $review)
                            <tr class="hover:bg-gray-50/60 transition group">
                                {{-- PENGGUNA --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-white text-xs bg-gradient-to-tr from-violet-500 to-indigo-600 flex-shrink-0 shadow-sm">
                                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm leading-none">
                                                {{ $review->user->name ?? 'Pengguna Terhapus' }}
                                            </p>
                                            <p class="text-gray-400 text-xs mt-1 leading-none">
                                                {{ $review->user->email ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- COURSE --}}
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800 max-w-[220px]">
                                    <div class="truncate" title="{{ $review->course->title ?? '-' }}">
                                        {{ $review->course->title ?? '-' }}
                                    </div>
                                </td>

                                {{-- RATING --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-600 border border-amber-200/60 px-2.5 py-1 rounded-full text-xs font-bold shadow-sm">
                                        <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
                                        <span>{{ $review->rating }}</span>
                                    </span>
                                </td>

                                {{-- KOMENTAR --}}
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-[280px]">
                                    <p class="line-clamp-2" title="{{ $review->comment }}">
                                        {{ $review->comment ?? '-' }}
                                    </p>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4">
                                    @if($review->is_visible)
                                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200/50 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Visible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-gray-50 text-gray-500 border border-gray-200/50 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Hidden
                                        </span>
                                    @endif
                                </td>

                                {{-- TANGGAL --}}
                                <td class="px-6 py-4 text-xs font-medium text-gray-400">
                                    {{ $review->created_at->format('d M Y') }}
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Toggle Visibility --}}
                                        <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="border border-gray-200 hover:bg-violet-50 text-gray-600 hover:text-violet-600 text-xs font-semibold px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm bg-white">
                                                <i class="fa-solid {{ $review->is_visible ? 'fa-eye-slash' : 'fa-eye' }} text-[11px]"></i>
                                                <span>{{ $review->is_visible ? 'Hide' : 'Show' }}</span>
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                                            onsubmit="return confirm('Hapus review ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                                                <i class="fa-solid fa-trash text-[11px]"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400">
                                        <i class="fa-solid fa-star-half-stroke text-4xl"></i>
                                        <p class="font-medium">Belum ada review ditemukan</p>
                                    </div>
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