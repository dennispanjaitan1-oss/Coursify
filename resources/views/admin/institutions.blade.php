{{-- resources/views/admin/institutions.blade.php --}}
@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-gray-100 flex">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Institutions Management
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Kelola institusi partner platform pembelajaran.
                    </p>
                </div>

                <button
                    class="bg-violet-500 hover:bg-violet-600 text-white px-5 py-2.5 rounded-2xl font-medium shadow transition">
                    + Add Institution
                </button>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">Total Institutions</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">24</h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">Active</p>
                    <h2 class="text-3xl font-bold text-green-600 mt-2">19</h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">Pending</p>
                    <h2 class="text-3xl font-bold text-yellow-500 mt-2">3</h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">Blocked</p>
                    <h2 class="text-3xl font-bold text-red-500 mt-2">2</h2>
                </div>

            </div>

            {{-- SEARCH --}}
            <div class="bg-white rounded-3xl shadow-sm p-6 mb-8 border border-gray-100">
                <div class="flex flex-col md:flex-row gap-4">

                    <input
                        type="text"
                        placeholder="Cari institusi..."
                        class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-300">

                    <select
                        class="border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none">
                        <option>Semua Status</option>
                        <option>Active</option>
                        <option>Pending</option>
                        <option>Blocked</option>
                    </select>

                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full">

                        <thead class="bg-gray-50">
                            <tr class="text-left text-gray-500 text-sm">

                                <th class="px-6 py-4 font-semibold">
                                    Institution
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Email
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Location
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Courses
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Students
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Status
                                </th>

                                <th class="px-6 py-4 font-semibold text-center">
                                    Action
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            {{-- ITEM --}}
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            Universitas Indonesia
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            ui.ac.id
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    admin@ui.ac.id
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    Jakarta
                                </td>

                                <td class="px-6 py-5 font-semibold text-gray-700">
                                    34
                                </td>

                                <td class="px-6 py-5 font-semibold text-gray-700">
                                    12.4K
                                </td>

                                <td class="px-6 py-5">
                                    <span
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Active
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">

                                        <button
                                            class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Edit
                                        </button>

                                        <button
                                            class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Delete
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            {{-- ITEM --}}
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            Institut Teknologi Bandung
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            itb.ac.id
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    admin@itb.ac.id
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    Bandung
                                </td>

                                <td class="px-6 py-5 font-semibold text-gray-700">
                                    21
                                </td>

                                <td class="px-6 py-5 font-semibold text-gray-700">
                                    8.9K
                                </td>

                                <td class="px-6 py-5">
                                    <span
                                        class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Pending
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">

                                        <button
                                            class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Edit
                                        </button>

                                        <button
                                            class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Delete
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            {{-- ITEM --}}
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            Universitas Gadjah Mada
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            ugm.ac.id
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    admin@ugm.ac.id
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    Yogyakarta
                                </td>

                                <td class="px-6 py-5 font-semibold text-gray-700">
                                    27
                                </td>

                                <td class="px-6 py-5 font-semibold text-gray-700">
                                    10.2K
                                </td>

                                <td class="px-6 py-5">
                                    <span
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Active
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">

                                        <button
                                            class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Edit
                                        </button>

                                        <button
                                            class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Delete
                                        </button>

                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>

            </div>

        </main>

    </div>
@endsection