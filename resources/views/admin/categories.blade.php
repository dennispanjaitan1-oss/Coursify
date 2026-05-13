{{-- resources/views/admin/categories.blade.php --}}

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
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
                        <span>📚</span>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.analytics') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
                        <span>📈</span>
                        <span class="font-medium text-sm">Analytics</span>
                    </a>

                    <a href="{{ route('admin.users') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
                        <span>👥</span>
                        <span class="font-medium text-sm">Users</span>
                    </a>

                    <a href="{{ route('admin.courses') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
                        <span>📖</span>
                        <span class="font-medium text-sm">Courses</span>
                    </a>

                    {{-- ACTIVE --}}
                    <a href="{{ route('admin.categories') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl bg-gradient-to-r from-violet-500 to-indigo-500 text-white shadow-md">

                        <div class="flex items-center gap-3">
                            <span>🗂️</span>
                            <span class="font-medium text-sm">Categories</span>
                        </div>

                        <span class="bg-orange-400 text-white text-xs px-2 py-0.5 rounded-full">
                            5
                        </span>
                    </a>

                    <a href="{{ route('admin.approvals') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
                        <span>✅</span>
                        <span class="font-medium text-sm">Approvals</span>
                    </a>

                    <a href="{{ route('admin.reviews') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
                        <span>⭐</span>
                        <span class="font-medium text-sm">Reviews</span>
                    </a>

                    <a href="{{ route('admin.reports') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
                        <span>🚩</span>
                        <span class="font-medium text-sm">Reports</span>
                    </a>

                    <a href="{{ route('admin.transactions') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
                        <span>💰</span>
                        <span class="font-medium text-sm">Transactions</span>
                    </a>

                    <a href="{{ route('admin.settings') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-100">
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
                            Categories
                        </h1>

                        <p class="text-gray-500 mt-2">
                            Kelola kategori course pembelajaran.
                        </p>
                    </div>

                    <button class="bg-violet-500 text-white px-5 py-3 rounded-2xl font-medium hover:opacity-90 transition">
                        + Add Category
                    </button>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-3xl shadow-md p-6">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm">

                                <th class="text-left p-4 rounded-l-2xl">
                                    Category
                                </th>

                                <th class="text-left p-4">
                                    Total Courses
                                </th>

                                <th class="text-left p-4">
                                    Status
                                </th>

                                <th class="text-left p-4 rounded-r-2xl">
                                    Actions
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            {{-- ROW 1 --}}
                            <tr class="border-b border-gray-100 hover:bg-gray-50">

                                <td class="p-4 font-semibold text-gray-800">
                                    Web Development
                                </td>

                                <td class="p-4 text-gray-500">
                                    42 Courses
                                </td>

                                <td class="p-4">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                                        Active
                                    </span>
                                </td>

                                <td class="p-4 flex gap-2">

                                    <button class="bg-blue-100 text-blue-600 px-4 py-2 rounded-xl text-xs font-medium hover:bg-blue-200 transition">
                                        Edit
                                    </button>

                                    <button class="bg-red-100 text-red-600 px-4 py-2 rounded-xl text-xs font-medium hover:bg-red-200 transition">
                                        Delete
                                    </button>

                                </td>

                            </tr>

                            {{-- ROW 2 --}}
                            <tr class="border-b border-gray-100 hover:bg-gray-50">

                                <td class="p-4 font-semibold text-gray-800">
                                    UI/UX Design
                                </td>

                                <td class="p-4 text-gray-500">
                                    18 Courses
                                </td>

                                <td class="p-4">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                                        Active
                                    </span>
                                </td>

                                <td class="p-4 flex gap-2">

                                    <button class="bg-blue-100 text-blue-600 px-4 py-2 rounded-xl text-xs font-medium hover:bg-blue-200 transition">
                                        Edit
                                    </button>

                                    <button class="bg-red-100 text-red-600 px-4 py-2 rounded-xl text-xs font-medium hover:bg-red-200 transition">
                                        Delete
                                    </button>

                                </td>

                            </tr>

                            {{-- ROW 3 --}}
                            <tr class="border-b border-gray-100 hover:bg-gray-50">

                                <td class="p-4 font-semibold text-gray-800">
                                    Data Science
                                </td>

                                <td class="p-4 text-gray-500">
                                    15 Courses
                                </td>

                                <td class="p-4">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">
                                        Pending
                                    </span>
                                </td>

                                <td class="p-4 flex gap-2">

                                    <button class="bg-blue-100 text-blue-600 px-4 py-2 rounded-xl text-xs font-medium hover:bg-blue-200 transition">
                                        Edit
                                    </button>

                                    <button class="bg-red-100 text-red-600 px-4 py-2 rounded-xl text-xs font-medium hover:bg-red-200 transition">
                                        Delete
                                    </button>

                                </td>

                            </tr>

                            {{-- ROW 4 --}}
                            <tr class="border-b border-gray-100 hover:bg-gray-50">

                                <td class="p-4 font-semibold text-gray-800">
                                    Mobile Development
                                </td>

                                <td class="p-4 text-gray-500">
                                    21 Courses
                                </td>

                                <td class="p-4">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                                        Active
                                    </span>
                                </td>

                                <td class="p-4 flex gap-2">

                                    <button class="bg-blue-100 text-blue-600 px-4 py-2 rounded-xl text-xs font-medium hover:bg-blue-200 transition">
                                        Edit
                                    </button>

                                    <button class="bg-red-100 text-red-600 px-4 py-2 rounded-xl text-xs font-medium hover:bg-red-200 transition">
                                        Delete
                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>
@endsection