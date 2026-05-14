{{-- resources/views/admin/transactions.blade.php --}}

@extends('layouts.app')

@section('title', 'Transactions')

@section('content')

<div class="bg-white rounded-3xl shadow-md p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Transactions
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola seluruh transaksi pembayaran course.
            </p>
        </div>

        <button
            class="bg-violet-500 text-white px-5 py-2.5 rounded-xl font-medium hover:opacity-90 text-sm transition"
        >
            Export Data
        </button>

    </div>

    {{-- Search & Filter --}}
    <div class="flex flex-col md:flex-row gap-3 mb-6">

        <input
            type="text"
            placeholder="Cari transaksi..."
            class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-violet-300"
        >

        <select
            class="border border-gray-200 rounded-xl px-3 py-2 text-sm outline-none"
        >
            <option>Semua Status</option>
            <option>Sukses</option>
            <option>Pending</option>
            <option>Gagal</option>
        </select>

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm">

                    <th class="text-left p-4 rounded-l-xl">
                        ID Transaksi
                    </th>

                    <th class="text-left p-4">
                        Pengguna
                    </th>

                    <th class="text-left p-4">
                        Course
                    </th>

                    <th class="text-left p-4">
                        Metode
                    </th>

                    <th class="text-left p-4">
                        Jumlah
                    </th>

                    <th class="text-left p-4">
                        Status
                    </th>

                    <th class="text-left p-4 rounded-r-xl">
                        Aksi
                    </th>

                </tr>
            </thead>

            <tbody>

                @php
                    $transactions = [
                        [
                            'id' => '#TRX-001',
                            'user' => 'John Doe',
                            'course' => 'React Development',
                            'method' => 'Bank Transfer',
                            'amount' => '$49',
                            'status' => 'Sukses',
                        ],
                        [
                            'id' => '#TRX-002',
                            'user' => 'Sarah Smith',
                            'course' => 'UI/UX Design',
                            'method' => 'PayPal',
                            'amount' => '$39',
                            'status' => 'Pending',
                        ],
                        [
                            'id' => '#TRX-003',
                            'user' => 'Michael Lee',
                            'course' => 'Laravel Masterclass',
                            'method' => 'Credit Card',
                            'amount' => '$59',
                            'status' => 'Sukses',
                        ],
                        [
                            'id' => '#TRX-004',
                            'user' => 'Olivia Brown',
                            'course' => 'Machine Learning',
                            'method' => 'E-Wallet',
                            'amount' => '$79',
                            'status' => 'Gagal',
                        ],
                        [
                            'id' => '#TRX-005',
                            'user' => 'Budi Santoso',
                            'course' => 'Python for Beginners',
                            'method' => 'Bank Transfer',
                            'amount' => '$29',
                            'status' => 'Pending',
                        ],
                    ];
                @endphp

                @foreach($transactions as $transaction)

                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                    <td class="p-4 text-gray-400 text-sm font-mono">
                        {{ $transaction['id'] }}
                    </td>

                    <td class="p-4 font-medium text-gray-800">
                        {{ $transaction['user'] }}
                    </td>

                    <td class="p-4 text-sm text-gray-600">
                        {{ $transaction['course'] }}
                    </td>

                    <td class="p-4 text-sm text-gray-500">
                        {{ $transaction['method'] }}
                    </td>

                    <td class="p-4 font-semibold text-gray-800">
                        {{ $transaction['amount'] }}
                    </td>

                    <td class="p-4">

                        @if($transaction['status'] == 'Sukses')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $transaction['status'] }}
                            </span>

                        @elseif($transaction['status'] == 'Pending')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $transaction['status'] }}
                            </span>

                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $transaction['status'] }}
                            </span>
                        @endif

                    </td>

                    <td class="p-4 flex gap-2">

                        <button
                            class="bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:opacity-80 transition"
                        >
                            Detail
                        </button>

                        <button
                            class="bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:opacity-80 transition"
                        >
                            Hapus
                        </button>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection