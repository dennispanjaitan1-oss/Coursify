{{-- resources/views/admin/transactiton.blade.php --}}
@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'Transactions')
            @include('admin.partials.header')

        {{-- HEADER --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Transactions</h1>
                    <p class="text-gray-500 mt-1">Kelola seluruh transaksi pembayaran course.</p>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <p class="text-sm text-gray-500">Total Transaksi</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <p class="text-sm text-gray-500">Sukses</p>
                <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $stats['paid'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <p class="text-sm text-gray-500">Pending</p>
                <h2 class="text-3xl font-bold text-yellow-500 mt-2">{{ $stats['pending'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                <p class="text-sm text-gray-500">Total Revenue</p>
                <h2 class="text-2xl font-bold text-violet-600 mt-2">
                    Rp {{ number_format($stats['revenue'], 0, ',', '.') }}
                </h2>
            </div>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 mb-6">
            <form method="GET" action="{{ route('admin.transactions') }}" class="flex flex-col md:flex-row gap-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama user atau ID transaksi..."
                    class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-300">
                <select name="status" class="border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="paid"     {{ request('status') === 'paid'     ? 'selected' : '' }}>Sukses</option>
                    <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="failed"   {{ request('status') === 'failed'   ? 'selected' : '' }}>Gagal</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                    Cari
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wide">
                        <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wide">
                            <th class="px-6 py-4 font-semibold">ID Transaksi</th>
                            <th class="px-6 py-4 font-semibold">Pengguna</th>
                            <th class="px-6 py-4 font-semibold">Course</th>
                            <th class="px-6 py-4 font-semibold">Billing</th>
                            <th class="px-6 py-4 font-semibold">Metode</th>
                            <th class="px-6 py-4 font-semibold">Jumlah</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5 text-gray-400 text-sm font-mono">
                                    {{ $trx->transaction_id ?? '#TRX-' . str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-5 font-medium text-gray-800">
                                    {{ $trx->user->name ?? '-' }}
                                    <p class="text-xs text-gray-400">{{ $trx->user->email ?? '' }}</p>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600">
                                    {{ $trx->items->pluck('course.title')->filter()->join(', ') ?: '-' }}
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600">
                                    @if($trx->first_name || $trx->last_name)
                                        <strong>{{ trim(($trx->first_name ?? '') . ' ' . ($trx->last_name ?? '')) }}</strong>
                                        <p class="text-xs text-gray-400">{{ $trx->country ?? '-' }}</p>
                                        @if($trx->coupon_code)
                                            <p class="text-xs text-green-600">Coupon: {{ $trx->coupon_code }}</p>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-500">
                                    <span class="font-medium">{{ str_replace('_', ' ', $trx->method ?? '-') }}</span>
                                    @if($trx->card_last4)
                                        <p class="text-xs text-gray-400">{{ strtoupper($trx->card_brand ?? 'CARD') }} **** {{ $trx->card_last4 }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5 font-semibold text-gray-800">
                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    @if($trx->discount_amount > 0)
                                        <p class="text-xs text-green-600">Diskon Rp {{ number_format($trx->discount_amount, 0, ',', '.') }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    @if($trx->status === 'paid')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Sukses</span>
                                    @elseif($trx->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                    @elseif($trx->status === 'failed')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Gagal</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">{{ $trx->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-400">
                                    {{ $trx->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center">
                                        <form method="POST" action="{{ route('admin.transactions.destroy', $trx) }}"
                                            onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-400">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>

    </main>
</div>
@endsection
