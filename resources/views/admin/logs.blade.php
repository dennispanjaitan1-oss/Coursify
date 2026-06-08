{{-- resources/views/admin/logs.blade.php --}}
@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-[var(--admin-bg)] flex">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'Logs')
            @include('admin.partials.header')

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

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">
                        Total Logs
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ number_format($stats['total']) }}
                    </h2>
                </div>

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">
                        Info Logs
                    </p>

                    <h2 class="text-3xl font-bold text-blue-600 mt-2">
                        {{ number_format($stats['info']) }}
                    </h2>
                </div>

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">
                        Warning
                    </p>

                    <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                        {{ number_format($stats['warning']) }}
                    </h2>
                </div>

                <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)]">
                    <p class="text-sm text-gray-500">
                        Errors
                    </p>

                    <h2 class="text-3xl font-bold text-red-500 mt-2">
                        {{ number_format($stats['error']) }}
                    </h2>
                </div>

            </div>

            {{-- FILTER --}}
            <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)] mb-8">

                <form method="GET" action="{{ route('admin.logs') }}" class="flex flex-col md:flex-row gap-4">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari logs..."
                        class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-300">

                    <select
                        name="level"
                        onchange="this.form.submit()"
                        class="border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none">

                        <option value="">Semua Level</option>
                        <option value="info" {{ request('level') === 'info' ? 'selected' : '' }}>INFO</option>
                        <option value="warning" {{ request('level') === 'warning' ? 'selected' : '' }}>WARNING</option>
                        <option value="error" {{ request('level') === 'error' ? 'selected' : '' }}>ERROR</option>

                    </select>

                </form>

            </div>

            {{-- LOGS TABLE --}}
            <div class="glass rounded-3xl p-6 shadow-sm border border-[var(--glass-border)] overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-transparent text-[var(--text-muted)] text-xs font-semibold uppercase tracking-wide">

                            <tr class="text-[var(--text-muted)] text-xs font-semibold uppercase tracking-wide">

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

                            @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-5 text-sm text-gray-600">
                                    {{ $log->created_at?->format('Y-m-d H:i:s') }}
                                </td>

                                <td class="px-6 py-5">
                                    <span class="{{ $levelClassMap[strtolower($log->display_level)] ?? 'bg-gray-100 text-gray-700' }} px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $log->display_level }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-gray-700">
                                    {{ $log->description }}
                                </td>

                                <td class="px-6 py-5 text-gray-600 text-sm">
                                    {{ $log->display_ip }}
                                </td>

                                <td class="px-6 py-5">
                                    <span class="{{ $statusClassMap[strtolower($log->display_status)] ?? 'bg-gray-100 text-gray-700' }} px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ ucfirst(strtolower($log->display_status)) }}
                                    </span>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada log aktivitas.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-6">
                {{ $logs->links() }}
            </div>

        </main>

    </div>
@endsection
