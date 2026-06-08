{{-- resources/views/admin/payouts.blade.php --}}
@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-[var(--admin-bg)] flex">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'Payouts')
            @include('admin.partials.header')

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
                    class="ui-btn">
                    + Create Payout
                </button>

            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">
                        Total Payouts
                    </p>

                    <h2 class="text-3xl font-bold text-[var(--text-strong)] mt-2">
                        Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}
                    </h2>
                </div>

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">
                        Pending
                    </p>

                    <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                        {{ number_format($stats['pending']) }}
                    </h2>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                    <p class="text-sm text-gray-500">
                        Success
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        {{ number_format($stats['paid']) }}
                    </h2>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                    <p class="text-sm text-gray-500">
                        Failed
                    </p>

                    <h2 class="text-3xl font-bold text-red-500 mt-2">
                        {{ number_format($stats['rejected']) }}
                    </h2>
                </div>

            </div>

            {{-- FILTER --}}
            <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)] mb-8">

                <form method="GET" action="{{ route('admin.payouts') }}" class="flex flex-col md:flex-row gap-4">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari instructor..."
                        class="flex-1 bg-[var(--panel)] border border-[var(--glass-border)] rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-50">

                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="bg-[var(--panel)] border border-[var(--glass-border)] rounded-2xl px-5 py-3 focus:outline-none">

                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Success</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Failed</option>

                    </select>

                </form>

            </div>

            {{-- TABLE --}}
            <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)] overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-transparent text-[var(--text-muted)] text-xs font-semibold uppercase tracking-wide">

                            <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wide">

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

                        <tbody class="divide-y divide-[rgba(15,23,42,0.04)]">

                            @forelse($payouts as $payout)
                                <tr class="hover:bg-[var(--panel)] transition">

                                <td class="px-6 py-5">

                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            {{ $payout->instructor?->name ?? 'Unknown Instructor' }}
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            {{ $payout->instructor?->email ?? '-' }}
                                        </p>
                                    </div>

                                </td>

                                <td class="px-6 py-5 font-bold text-gray-800">
                                    Rp {{ number_format($payout->amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    {{ $payout->note ?: 'Manual' }}
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    {{ optional($payout->paid_at ?? $payout->created_at)->format('d M Y') }}
                                </td>

                                <td class="px-6 py-5">

                                    <span class="{{ $statusClassMap[$payout->status] ?? 'bg-gray-100 text-gray-700' }} px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $statusLabelMap[$payout->status] ?? ucfirst($payout->status) }}
                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-center gap-2">

                                        @if($payout->status === 'pending')
                                            <form method="POST" action="{{ route('admin.payouts.update', $payout) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="paid">
                                                <button class="ui-btn">
                                                    Approve
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.payouts.update', $payout) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button class="border border-red-200 hover:bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                                                    Reject
                                                </button>
                                            </form>
                                        @else
                                            <button
                                                class="border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                                                Detail
                                            </button>
                                        @endif

                                    </div>

                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada data payout.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-6">
                {{ $payouts->links() }}
            </div>

        </main>

    </div>

    @endsection
