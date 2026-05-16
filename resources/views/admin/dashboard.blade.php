{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

        {{-- HEADER --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard Overview
            </h1>

            <p class="text-gray-500 mt-2">
                Selamat datang di halaman admin dashboard.
            </p>

        </div>

        {{-- STATISTICS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

            {{-- CARD 1 --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Total Users
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            3,421
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-violet-100 flex items-center justify-center text-2xl">
                        👥
                    </div>

                </div>

                <p class="text-green-500 text-sm mt-4">
                    +12% dari bulan lalu
                </p>

            </div>

            {{-- CARD 2 --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Total Courses
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            128
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-2xl">
                        📚
                    </div>

                </div>

                <p class="text-blue-500 text-sm mt-4">
                    14 course baru minggu ini
                </p>

            </div>

            {{-- CARD 3 --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Pending Reviews
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            12
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-2xl">
                        ⭐
                    </div>

                </div>

                <p class="text-orange-500 text-sm mt-4">
                    Perlu ditinjau admin
                </p>

            </div>

            {{-- CARD 4 --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Revenue
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            $24.5K
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                        💰
                    </div>

                </div>

                <p class="text-green-500 text-sm mt-4">
                    +18% dari bulan lalu
                </p>

            </div>

        </div>

        {{-- CONTENT GRID --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- LEFT SECTION --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- RECENT ACTIVITIES --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm">

                    <div class="flex items-center justify-between mb-6">

                        <div>
                            <h2 class="text-xl font-bold text-gray-800">
                                Aktivitas Terbaru
                            </h2>

                            <p class="text-gray-500 text-sm mt-1">
                                Aktivitas terbaru dari sistem
                            </p>
                        </div>

                    </div>

                    <div class="space-y-4">

                        {{-- ITEM --}}
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">

                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center text-xl">
                                    👤
                                </div>

                                <div>
                                    <h3 class="font-semibold text-gray-800">
                                        User baru terdaftar
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        rina@email.com
                                    </p>
                                </div>

                            </div>

                            <span class="text-sm text-gray-400">
                                10 menit lalu
                            </span>

                        </div>

                        {{-- ITEM --}}
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">

                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-xl">
                                    📖
                                </div>

                                <div>
                                    <h3 class="font-semibold text-gray-800">
                                        Course baru menunggu approval
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Flutter Basics
                                    </p>
                                </div>

                            </div>

                            <span class="text-sm text-gray-400">
                                25 menit lalu
                            </span>

                        </div>

                        {{-- ITEM --}}
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">

                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center text-xl">
                                    🚩
                                </div>

                                <div>
                                    <h3 class="font-semibold text-gray-800">
                                        Laporan baru diterima
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Node.js Pro dilaporkan
                                    </p>
                                </div>

                            </div>

                            <span class="text-sm text-gray-400">
                                1 jam lalu
                            </span>

                        </div>

                        {{-- ITEM --}}
                        <div class="flex items-center justify-between">

                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-xl">
                                    💳
                                </div>

                                <div>
                                    <h3 class="font-semibold text-gray-800">
                                        Payout berhasil
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        $320 ke instructor@email.com
                                    </p>
                                </div>

                            </div>

                            <span class="text-sm text-gray-400">
                                2 jam lalu
                            </span>

                        </div>

                    </div>

                </div>

                {{-- TOP COURSES --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm">

                    <div class="mb-6">

                        <h2 class="text-xl font-bold text-gray-800">
                            Top Courses
                        </h2>

                        <p class="text-gray-500 text-sm mt-1">
                            Course paling populer bulan ini
                        </p>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead>

                                <tr class="bg-gray-100 text-gray-500 text-sm">

                                    <th class="text-left p-4 rounded-l-2xl">
                                        Course
                                    </th>

                                    <th class="text-left p-4">
                                        Students
                                    </th>

                                    <th class="text-left p-4">
                                        Revenue
                                    </th>

                                    <th class="text-left p-4 rounded-r-2xl">
                                        Rating
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr class="border-b border-gray-100">

                                    <td class="p-4 font-semibold text-gray-800">
                                        React Development
                                    </td>

                                    <td class="p-4">
                                        1,240
                                    </td>

                                    <td class="p-4 text-green-600 font-semibold">
                                        $8,200
                                    </td>

                                    <td class="p-4">
                                        ⭐ 4.9
                                    </td>

                                </tr>

                                <tr class="border-b border-gray-100">

                                    <td class="p-4 font-semibold text-gray-800">
                                        UI/UX Design
                                    </td>

                                    <td class="p-4">
                                        980
                                    </td>

                                    <td class="p-4 text-green-600 font-semibold">
                                        $6,450
                                    </td>

                                    <td class="p-4">
                                        ⭐ 4.8
                                    </td>

                                </tr>

                                <tr>

                                    <td class="p-4 font-semibold text-gray-800">
                                        Laravel Masterclass
                                    </td>

                                    <td class="p-4">
                                        820
                                    </td>

                                    <td class="p-4 text-green-600 font-semibold">
                                        $5,120
                                    </td>

                                    <td class="p-4">
                                        ⭐ 4.7
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            {{-- RIGHT SECTION --}}
            <div class="space-y-6">

                {{-- PROFILE --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm">

                    <div class="flex flex-col items-center text-center">

                        <div class="w-24 h-24 rounded-full bg-indigo-500 text-white flex items-center justify-center text-4xl font-bold mb-4">
                            A
                        </div>

                        <h2 class="text-xl font-bold text-gray-800">
                            Admin Coursify
                        </h2>

                        <p class="text-gray-500 text-sm mt-1">
                            administrator@coursify.com
                        </p>

                        <span class="mt-4 bg-indigo-100 text-indigo-600 text-xs font-semibold px-4 py-2 rounded-full">
                            ADMINISTRATOR
                        </span>

                    </div>

                </div>

                {{-- QUICK ACTIONS --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm">

                    <h2 class="text-xl font-bold text-gray-800 mb-6">
                        Quick Actions
                    </h2>

                    <div class="space-y-3">

                        <a href="{{ route('admin.users') }}"
                           class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 transition rounded-2xl p-4">

                            <span class="text-xl">👥</span>

                            <span class="font-medium text-gray-700">
                                Manage Users
                            </span>

                        </a>

                        <a href="{{ route('admin.courses.index') }}"
                           class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 transition rounded-2xl p-4">

                            <span class="text-xl">📚</span>

                            <span class="font-medium text-gray-700">
                                Manage Courses
                            </span>

                        </a>

                        <a href="{{ route('admin.analytics') }}"
                           class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 transition rounded-2xl p-4">

                            <span class="text-xl">📈</span>

                            <span class="font-medium text-gray-700">
                                View Analytics
                            </span>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

@endsection