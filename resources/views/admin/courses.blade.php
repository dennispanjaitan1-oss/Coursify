{{-- resources/views/admin/courses.blade.php --}}

@extends('layouts.app')

@section('content')


    <div class="min-h-screen bg-gray-100 flex">

        {{-- SIDEBAR --}}
        <aside class="w-72 bg-white shadow-lg p-5 flex flex-col justify-between">

            <div>

                {{-- LOGO --}}
                <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100">

                    <img src="{{ asset('images/logo.png') }}"
                         class="w-11 h-11 rounded-xl"
                         alt="Logo">

                    <div>
                        <h1 class="text-lg font-bold text-gray-800">
                            Coursify
                        </h1>

                        <p class="text-xs text-gray-400">
                            ADMIN PANEL
                        </p>
                    </div>

                </div>

                {{-- MENU --}}
                <div class="space-y-2">

                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>📚</span>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.analytics') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>📈</span>
                        <span class="font-medium text-sm">Analytics</span>
                    </a>

                    <a href="{{ route('admin.users') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>👥</span>
                        <span class="font-medium text-sm">Users</span>
                    </a>

                    {{-- ACTIVE MENU --}}
                    <a href="{{ route('admin.courses') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl bg-gradient-to-r from-violet-500 to-indigo-500 text-white shadow-md">

                        <div class="flex items-center gap-3">
                            <span>📖</span>
                            <span class="font-medium text-sm">Courses</span>
                        </div>

                        <span class="bg-orange-400 text-white text-xs px-2 py-0.5 rounded-full">
                            128
                        </span>

                    </a>

                    <a href="{{ route('admin.categories') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>🗂️</span>
                        <span class="font-medium text-sm">Categories</span>
                    </a>

                    <a href="{{ route('admin.approvals') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>✅</span>
                        <span class="font-medium text-sm">Approvals</span>
                    </a>

                    <a href="{{ route('admin.reviews') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>⭐</span>
                        <span class="font-medium text-sm">Reviews</span>
                    </a>

                    <a href="{{ route('admin.reports') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>🚩</span>
                        <span class="font-medium text-sm">Reports</span>
                    </a>

                    <a href="{{ route('admin.transactions') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>💰</span>
                        <span class="font-medium text-sm">Transactions</span>
                    </a>

                    <a href="{{ route('admin.settings') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-gray-100 text-gray-600 transition">
                        <span>⚙️</span>
                        <span class="font-medium text-sm">Settings</span>
                    </a>

                </div>

            </div>

            {{-- PROFILE --}}
            <div class="border border-gray-200 rounded-2xl p-4 flex items-center gap-3 shadow-sm">

                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold">
                    A
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">
                        Admin Coursify
                    </h3>

                    <p class="text-violet-500 text-xs font-medium">
                        ADMINISTRATOR
                    </p>
                </div>

            </div>

        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto">

            {{-- HEADER --}}
            <div class="bg-white rounded-3xl shadow-md p-8 mb-6">

                <div class="flex items-center justify-between">

                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">
                            Courses Library
                        </h1>

                        <p class="text-gray-500 mt-2">
                            Kelola seluruh course pembelajaran platform.
                        </p>
                    </div>

                    <button class="bg-indigo-500 text-white px-5 py-3 rounded-2xl font-medium hover:opacity-90 transition">
                        + Create Course
                    </button>

                </div>

            </div>

            {{-- SEARCH --}}
            <div class="bg-white rounded-3xl shadow-md p-6 mb-6">

                <div class="flex gap-4">

                    <input type="text"
                           placeholder="Cari course..."
                           class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 outline-none focus:ring-2 focus:ring-violet-300">

                    <select class="border border-gray-200 rounded-2xl px-5 py-3 outline-none">
                        <option>Semua Kategori</option>
                        <option>Development</option>
                        <option>Design</option>
                        <option>Business</option>
                    </select>

                </div>

            </div>

            {{-- COURSE GRID --}}
            <div class="grid md:grid-cols-3 gap-6">

                {{-- CARD 1 --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition">

                    <div class="h-44 bg-gradient-to-r from-violet-400 to-indigo-500"></div>

                    <div class="p-6">

                        <div class="flex items-center justify-between mb-3">

                            <span class="bg-violet-100 text-violet-600 px-3 py-1 rounded-full text-xs font-medium">
                                Development
                            </span>

                            <span class="text-sm text-gray-400">
                                ⭐ 4.9
                            </span>

                        </div>

                        <h2 class="text-xl font-bold text-gray-800">
                            React Development
                        </h2>

                        <p class="text-gray-500 text-sm mt-2">
                            Pelajari React.js dari dasar hingga mahir.
                        </p>

                        <div class="flex items-center justify-between mt-5">

                            <div>
                                <p class="text-sm text-gray-400">
                                    Students
                                </p>

                                <p class="font-bold text-gray-800">
                                    98
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-400">
                                    Price
                                </p>

                                <p class="font-bold text-indigo-600">
                                    $49
                                </p>
                            </div>

                        </div>

                        <div class="flex gap-2 mt-6">

                            <button class="flex-1 bg-indigo-500 text-white py-2.5 rounded-xl text-sm font-medium hover:opacity-90 transition">
                                Manage
                            </button>

                            <button class="bg-red-100 text-red-600 px-4 rounded-xl text-sm hover:bg-red-200 transition">
                                Delete
                            </button>

                        </div>

                    </div>

                </div>

                {{-- CARD 2 --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition">

                    <div class="h-44 bg-gradient-to-r from-pink-400 to-rose-500"></div>

                    <div class="p-6">

                        <div class="flex items-center justify-between mb-3">

                            <span class="bg-pink-100 text-pink-600 px-3 py-1 rounded-full text-xs font-medium">
                                Design
                            </span>

                            <span class="text-sm text-gray-400">
                                ⭐ 4.8
                            </span>

                        </div>

                        <h2 class="text-xl font-bold text-gray-800">
                            UI/UX Design
                        </h2>

                        <p class="text-gray-500 text-sm mt-2">
                            Belajar membuat desain modern dan profesional.
                        </p>

                        <div class="flex items-center justify-between mt-5">

                            <div>
                                <p class="text-sm text-gray-400">
                                    Students
                                </p>

                                <p class="font-bold text-gray-800">
                                    142
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-400">
                                    Price
                                </p>

                                <p class="font-bold text-pink-600">
                                    $39
                                </p>
                            </div>

                        </div>

                        <div class="flex gap-2 mt-6">

                            <button class="flex-1 bg-pink-500 text-white py-2.5 rounded-xl text-sm font-medium hover:opacity-90 transition">
                                Manage
                            </button>

                            <button class="bg-red-100 text-red-600 px-4 rounded-xl text-sm hover:bg-red-200 transition">
                                Delete
                            </button>

                        </div>

                    </div>

                </div>

                {{-- CARD 3 --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition">

                    <div class="h-44 bg-gradient-to-r from-emerald-400 to-teal-500"></div>

                    <div class="p-6">

                        <div class="flex items-center justify-between mb-3">

                            <span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full text-xs font-medium">
                                Data Science
                            </span>

                            <span class="text-sm text-gray-400">
                                ⭐ 4.7
                            </span>

                        </div>

                        <h2 class="text-xl font-bold text-gray-800">
                            Python for Beginners
                        </h2>

                        <p class="text-gray-500 text-sm mt-2">
                            Belajar Python dari dasar untuk data science.
                        </p>

                        <div class="flex items-center justify-between mt-5">

                            <div>
                                <p class="text-sm text-gray-400">
                                    Students
                                </p>

                                <p class="font-bold text-gray-800">
                                    210
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-400">
                                    Price
                                </p>

                                <p class="font-bold text-emerald-600">
                                    $59
                                </p>
                            </div>

                        </div>

                        <div class="flex gap-2 mt-6">

                            <button class="flex-1 bg-emerald-500 text-white py-2.5 rounded-xl text-sm font-medium hover:opacity-90 transition">
                                Manage
                            </button>

                            <button class="bg-red-100 text-red-600 px-4 rounded-xl text-sm hover:bg-red-200 transition">
                                Delete
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

@endsection