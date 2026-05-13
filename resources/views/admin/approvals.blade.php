{{-- resources/views/admin/approvals.blade.php --}}
@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-gray-100 flex">

        {{-- SIDEBAR --}}
        <aside class="w-72 bg-white shadow-lg p-5 flex flex-col justify-between">

            <div>

                {{-- Logo --}}
                <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-11 h-11 rounded-xl">

                    <div>
                        <h1 class="text-lg font-bold text-gray-800">Coursify</h1>
                        <p class="text-xs text-gray-400">ADMIN PANEL</p>
                    </div>
                </div>

                {{-- MENU --}}
                <div class="space-y-2">

                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition">
                        <span>📚</span>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.analytics') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition">
                        <span>📈</span>
                        <span class="font-medium text-sm">Analytics</span>
                    </a>

                    <a href="{{ route('admin.users') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition">
                        <span>👥</span>
                        <span class="font-medium text-sm">Users</span>
                    </a>

                    <a href="{{ route('admin.courses') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition">
                        <span>📖</span>
                        <span class="font-medium text-sm">Courses</span>
                    </a>

                    <a href="{{ route('admin.approvals') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl bg-gradient-to-r from-violet-500 to-indigo-500 text-white shadow-md">

                        <div class="flex items-center gap-3">
                            <span>✅</span>
                            <span class="font-medium text-sm">Approvals</span>
                        </div>

                        <span class="bg-orange-400 text-white text-xs px-2 py-0.5 rounded-full">
                            5
                        </span>
                    </a>

                    <a href="{{ route('admin.reviews') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition">
                        <span>⭐</span>
                        <span class="font-medium text-sm">Reviews</span>
                    </a>

                    <a href="{{ route('admin.reports') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition">
                        <span>🚩</span>
                        <span class="font-medium text-sm">Reports</span>
                    </a>

                    <a href="{{ route('admin.transactions') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition">
                        <span>💰</span>
                        <span class="font-medium text-sm">Transactions</span>
                    </a>

                    <a href="{{ route('admin.settings') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100 transition">
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
                            Approvals
                        </h1>

                        <p class="text-gray-500 mt-2">
                            Kelola course dan institusi yang menunggu persetujuan.
                        </p>
                    </div>

                    <div class="bg-orange-100 text-orange-600 px-4 py-2 rounded-2xl font-semibold text-sm">
                        5 Pending
                    </div>
                </div>

            </div>

            {{-- APPROVAL LIST --}}
            <div class="space-y-4">

                {{-- ITEM 1 --}}
                <div class="bg-white rounded-3xl shadow-md p-6 flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Flutter Basics
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Course baru oleh
                            <span class="font-semibold text-gray-700">
                                Budi Santoso
                            </span>
                        </p>

                        <p class="text-xs text-gray-400 mt-2">
                            10 menit lalu
                        </p>
                    </div>

                    <div class="flex gap-3">

                        <button class="bg-green-100 text-green-700 px-5 py-2 rounded-xl text-sm font-medium hover:bg-green-200 transition">
                            ✓ Approve
                        </button>

                        <button class="bg-red-100 text-red-600 px-5 py-2 rounded-xl text-sm font-medium hover:bg-red-200 transition">
                            ✕ Reject
                        </button>

                    </div>

                </div>

                {{-- ITEM 2 --}}
                <div class="bg-white rounded-3xl shadow-md p-6 flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Advanced SQL
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Course baru oleh
                            <span class="font-semibold text-gray-700">
                                Rina Wijaya
                            </span>
                        </p>

                        <p class="text-xs text-gray-400 mt-2">
                            25 menit lalu
                        </p>
                    </div>

                    <div class="flex gap-3">

                        <button class="bg-green-100 text-green-700 px-5 py-2 rounded-xl text-sm font-medium hover:bg-green-200 transition">
                            ✓ Approve
                        </button>

                        <button class="bg-red-100 text-red-600 px-5 py-2 rounded-xl text-sm font-medium hover:bg-red-200 transition">
                            ✕ Reject
                        </button>

                    </div>

                </div>

                {{-- ITEM 3 --}}
                <div class="bg-white rounded-3xl shadow-md p-6 flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Digital Marketing
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Institution baru oleh
                            <span class="font-semibold text-gray-700">
                                PT Edukasi
                            </span>
                        </p>

                        <p class="text-xs text-gray-400 mt-2">
                            1 jam lalu
                        </p>
                    </div>

                    <div class="flex gap-3">

                        <button class="bg-green-100 text-green-700 px-5 py-2 rounded-xl text-sm font-medium hover:bg-green-200 transition">
                            ✓ Approve
                        </button>

                        <button class="bg-red-100 text-red-600 px-5 py-2 rounded-xl text-sm font-medium hover:bg-red-200 transition">
                            ✕ Reject
                        </button>

                    </div>

                </div>

                {{-- ITEM 4 --}}
                <div class="bg-white rounded-3xl shadow-md p-6 flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            UI Kit Pro
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Course baru oleh
                            <span class="font-semibold text-gray-700">
                                Dedi Kurniawan
                            </span>
                        </p>

                        <p class="text-xs text-gray-400 mt-2">
                            2 jam lalu
                        </p>
                    </div>

                    <div class="flex gap-3">

                        <button class="bg-green-100 text-green-700 px-5 py-2 rounded-xl text-sm font-medium hover:bg-green-200 transition">
                            ✓ Approve
                        </button>

                        <button class="bg-red-100 text-red-600 px-5 py-2 rounded-xl text-sm font-medium hover:bg-red-200 transition">
                            ✕ Reject
                        </button>

                    </div>

                </div>

            </div>

        </main>

    </div>
@endsection