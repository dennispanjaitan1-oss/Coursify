{{-- resources/views/admin/reports.blade.php --}}
@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-[var(--admin-bg)] flex">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'Reports')
            @include('admin.partials.header')

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-8">

                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Reports Management
                    </h1>

                    <p class="text-gray-500 mt-1">
                        Kelola laporan pengguna dan pelanggaran platform.
                    </p>
                </div>

                <button
                    class="ui-btn">
                    Export Reports
                </button>

            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">Total Reports</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ number_format($stats['total']) }}
                    </h2>
                </div>

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">Pending</p>
                    <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                        {{ number_format($stats['pending']) }}
                    </h2>
                </div>

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">Resolved</p>
                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        {{ number_format($stats['resolved']) }}
                    </h2>
                </div>

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">Rejected</p>
                    <h2 class="text-3xl font-bold text-red-500 mt-2">
                        {{ number_format($stats['dismissed']) }}
                    </h2>
                </div>

            </div>

            {{-- FILTER --}}
            <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)] mb-8">

                <form method="GET" action="{{ route('admin.reports') }}" class="flex flex-col md:flex-row gap-4">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari laporan..."
                        class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-300">

                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none">

                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="dismissed" {{ request('status') === 'dismissed' ? 'selected' : '' }}>Rejected</option>

                    </select>

                </form>

            </div>

            {{-- TABLE --}}
            <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)] overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-transparent text-[var(--text-muted)] text-xs font-semibold uppercase tracking-wide">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Report ID</th>
                                <th class="px-6 py-4 font-semibold">Reporter</th>
                                <th class="px-6 py-4 font-semibold">Category</th>
                                <th class="px-6 py-4 font-semibold">Description</th>
                                <th class="px-6 py-4 font-semibold">Date</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse($reports as $report)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5 font-semibold text-gray-700">
                                    #RPT-{{ str_pad($report->id, 3, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-6 py-5">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            {{ $report->reporter?->name ?? 'Unknown User' }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $report->reporter?->email ?? '-' }}
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ class_basename($report->reported_type) }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    {{ $report->reason }}
                                </td>

                                <td class="px-6 py-5 text-gray-600">
                                    {{ $report->created_at->format('d M Y') }}
                                </td>

                                <td class="px-6 py-5">
                                    <span class="{{ $statusClassMap[$report->status] ?? 'bg-gray-100 text-gray-700' }} px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $statusLabelMap[$report->status] ?? ucfirst($report->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">

                                        @if($report->status === 'pending')
                                            <form method="POST" action="{{ route('admin.reports.update', $report) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="resolved">
                                                <button class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                                                    Resolve
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.reports.update', $report) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="dismissed">
                                                <button class="bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                                                    Reject
                                                </button>
                                            </form>
                                        @else
                                            <button class="border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                                                View
                                            </button>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada laporan.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-6">
                {{ $reports->links() }}
            </div>

        </main>

    </div>

@endsection