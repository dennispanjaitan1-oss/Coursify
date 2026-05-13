{{-- resources/views/admin/logs.blade.php --}}
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
                    System Logs
                </h1>

                <p class="text-gray-500 mt-1">
                    Monitor aktivitas dan kejadian sistem secara real-time.
                </p>
            </div>

            {{-- STATISTICS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">
                        Total Logs
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        12.4K
                    </h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">
                        Info Logs
                    </p>

                    <h2 class="text-3xl font-bold text-blue-600 mt-2">
                        10.8K
                    </h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">
                        Warning
                    </p>

                    <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                        1.1K
                    </h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">
                        Errors
                    </p>

                    <h2 class="text-3xl font-bold text-red-500 mt-2">
                        532
                    </h2>
                </div>

            </div>

            {{-- FILTER --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-8">

                <div class="flex flex-col md:flex-row gap-4">

                    <input
                        type="text"
                        placeholder="Cari logs..."
                        class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-300">

                    <select
                        class="border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none">

                        <option>Semua Level</option>
                        <option>INFO</option>
                        <option>WARNING</option>
                        <option>ERROR</option>

                    </select>

                </div>

            </div>

            {{-- LOGS TABLE --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-gray-50">

                            <tr class="text-left text-gray-500 text-sm">

                                <th class="px-6 py-4 font-semibold">
                                    Time
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Level
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Message
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    IP Address
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Status
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            {{-- LOG ITEM --}}
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5 text-sm text-gray-600">
                                    2026-05-13 10:21:33
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        INFO
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    Admin berhasil login ke dashboard.
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    192.168.1.12
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Success
                                    </span>
                                </td>

                            </tr>

                            {{-- LOG ITEM --}}
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5 text-sm text-gray-600">
                                    2026-05-13 09:50:11
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        WARNING
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    Percobaan login gagal sebanyak 3 kali.
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    192.168.1.55
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Warning
                                    </span>
                                </td>

                            </tr>

                            {{-- LOG ITEM --}}
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5 text-sm text-gray-600">
                                    2026-05-13 08:33:42
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        ERROR
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    Database connection timeout detected.
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    192.168.1.77
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Failed
                                    </span>
                                </td>

                            </tr>

                            {{-- LOG ITEM --}}
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5 text-sm text-gray-600">
                                    2026-05-12 22:11:09
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        INFO
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    Backup sistem berhasil dibuat otomatis.
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    127.0.0.1
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Success
                                    </span>
                                </td>

                            </tr>

                            {{-- LOG ITEM --}}
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5 text-sm text-gray-600">
                                    2026-05-12 20:45:18
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        ERROR
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    Payment gateway API tidak merespon.
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    192.168.1.100
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Failed
                                    </span>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>
@endsection