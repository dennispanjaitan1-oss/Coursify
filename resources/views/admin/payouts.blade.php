{{-- resources/views/admin/payouts.blade.php --}}
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
                        Payout Management
                    </h1>

                    <p class="text-gray-500 mt-1">
                        Kelola pembayaran instructor dan partner platform.
                    </p>
                </div>

                <button
                    class="bg-violet-500 hover:bg-violet-600 text-white px-5 py-3 rounded-2xl shadow font-medium transition">
                    + Create Payout
                </button>

            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">
                        Total Payouts
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        $24.8K
                    </h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">
                        Pending
                    </p>

                    <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                        18
                    </h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">
                        Success
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        142
                    </h2>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">
                        Failed
                    </p>

                    <h2 class="text-3xl font-bold text-red-500 mt-2">
                        4
                    </h2>
                </div>

            </div>

            {{-- FILTER --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-8">

                <div class="flex flex-col md:flex-row gap-4">

                    <input
                        type="text"
                        placeholder="Cari instructor..."
                        class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-300">

                    <select
                        class="border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none">

                        <option>Semua Status</option>
                        <option>Pending</option>
                        <option>Success</option>
                        <option>Failed</option>

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
                                    Instructor
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Amount
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Method
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Date
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
                                            Budi Santoso
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            budi@coursify.com
                                        </p>
                                    </div>

                                </td>

                                <td class="px-6 py-5 font-bold text-gray-800">
                                    $1,250
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    Bank Transfer
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    13 May 2026
                                </td>

                                <td class="px-6 py-5">

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Pending
                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-center gap-2">

                                        <button
                                            class="bg-green-100 hover:bg-green-200 text-green-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Approve
                                        </button>

                                        <button
                                            class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Reject
                                        </button>

                                    </div>

                                </td>

                            </tr>

                            {{-- ITEM --}}
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5">

                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            Sari Dewi
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            sari@coursify.com
                                        </p>
                                    </div>

                                </td>

                                <td class="px-6 py-5 font-bold text-gray-800">
                                    $980
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    PayPal
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    12 May 2026
                                </td>

                                <td class="px-6 py-5">

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Success
                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-center gap-2">

                                        <button
                                            class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Detail
                                        </button>

                                    </div>

                                </td>

                            </tr>

                            {{-- ITEM --}}
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5">

                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            Andi Pratama
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            andi@coursify.com
                                        </p>
                                    </div>

                                </td>

                                <td class="px-6 py-5 font-bold text-gray-800">
                                    $1,540
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    Bank Transfer
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    11 May 2026
                                </td>

                                <td class="px-6 py-5">

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Failed
                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-center gap-2">

                                        <button
                                            class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Retry
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