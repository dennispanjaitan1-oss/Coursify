{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = null)
            @include('admin.partials.header')

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
            <p class="text-gray-500 mt-2">Selamat datang di halaman admin dashboard.</p>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Users</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['total_users']) }}
                        </h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-500 text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Courses</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['total_courses']) }}
                        </h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-500 text-xl">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pending Approvals</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['pending_courses']) }}
                        </h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-500 text-xl">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
                <p class="text-orange-500 text-sm mt-4">Perlu ditinjau admin</p>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Revenue</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            Rp {{ number_format($stats['revenue'], 0, ',', '.') }}
                        </h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-500 text-xl">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- CONTENT GRID --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- LEFT --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- RECENT USERS --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">User Terbaru</h2>
                            <p class="text-gray-500 text-sm mt-1">User yang baru mendaftar</p>
                        </div>
                        <a href="{{ route('admin.users') }}"
                            class="text-violet-500 text-sm font-medium hover:underline">
                            Lihat semua
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentUsers as $user)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-500 font-bold text-lg">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full font-medium">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm">Belum ada user.</p>
                        @endforelse
                    </div>
                </div>

                {{-- TOP COURSES --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Top Courses</h2>
                        <p class="text-gray-500 text-sm mt-1">Course paling populer berdasarkan enrollment</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wide">
                                <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wide">
                                    <th class="text-left p-4 rounded-l-2xl">Course</th>
                                    <th class="text-left p-4">Enrollments</th>
                                    <th class="text-left p-4 rounded-r-2xl">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topCourses as $course)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                        <td class="p-4 font-semibold text-gray-800">
                                            {{ $course->title }}
                                            <p class="text-xs text-gray-400 font-normal">{{ $course->institution->name ?? '-' }}</p>
                                        </td>
                                        <td class="p-4 text-gray-700 font-semibold">
                                            {{ number_format($course->enrollments_count) }}
                                        </td>
                                        <td class="p-4">
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                ⭐ {{ round($course->reviews_avg_rating, 1) ?: '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center text-gray-400">Belum ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="space-y-6">

                {{-- PROFILE --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-full bg-indigo-500 text-white flex items-center justify-center text-4xl font-bold mb-4">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-500 text-sm mt-1">{{ auth()->user()->email }}</p>
                        <span class="mt-4 bg-indigo-100 text-indigo-600 text-xs font-semibold px-4 py-2 rounded-full">
                            ADMINISTRATOR
                        </span>
                    </div>
                </div>

                {{-- QUICK ACTIONS --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users') }}"
                            class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 transition rounded-2xl p-4">
                            <i class="fa-solid fa-users text-violet-500"></i>
                            <span class="font-medium text-gray-700">Manage Users</span>
                        </a>
                        <a href="{{ route('admin.courses.index') }}"
                            class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 transition rounded-2xl p-4">
                            <i class="fa-solid fa-book-open text-indigo-500"></i>
                            <span class="font-medium text-gray-700">Manage Courses</span>
                        </a>
                        <a href="{{ route('admin.analytics') }}"
                            class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 transition rounded-2xl p-4">
                            <i class="fa-solid fa-chart-line text-green-500"></i>
                            <span class="font-medium text-gray-700">View Analytics</span>
                        </a>
                        <a href="{{ route('admin.approvals') }}"
                            class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 transition rounded-2xl p-4">
                            <i class="fa-solid fa-circle-check text-orange-500"></i>
                            <span class="font-medium text-gray-700">Approvals</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </main>
</div>
@endsection