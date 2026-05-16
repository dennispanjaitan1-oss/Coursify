{{-- resources/views/admin/analytics.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Analytics</h1>
            <p class="text-gray-500 mt-2">Pantau statistik dan performa platform secara keseluruhan.</p>
        </div>

        {{-- TOP STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Revenue</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            Rp {{ number_format($stats['revenue'], 0, ',', '.') }}
                        </h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-500 text-xl">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Students</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['total_students']) }}
                        </h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-500 text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Courses</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['total_courses']) }}
                        </h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-500 text-xl">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Enrollments</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['total_enrollments']) }}
                        </h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-500 text-xl">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- CHART + ACTIVITY --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

            {{-- REVENUE CHART --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Revenue Growth</h2>
                        <p class="text-gray-500 text-sm">6 bulan terakhir</p>
                    </div>
                    <span class="bg-indigo-100 text-indigo-600 text-xs px-4 py-2 rounded-full font-medium">
                        {{ date('Y') }}
                    </span>
                </div>

                @php
                    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                   $maxRevenue = $revenueChart->max('total') > 0 ? $revenueChart->max('total') : 1;   
                @endphp

                <div class="h-48 flex items-end gap-3">
                    @forelse($revenueChart as $item)
                        @php $height = round(($item->total / $maxRevenue) * 100); @endphp
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <span class="text-xs text-gray-400">Rp{{ number_format($item->total/1000, 0) }}k</span>
                            <div class="w-full bg-indigo-500 rounded-t-xl" style="height: {{ $height }}%"></div>
                            <span class="text-xs text-gray-400">{{ $months[$item->month - 1] }}</span>
                        </div>
                    @empty
                        <div class="flex-1 text-center text-gray-400 text-sm">Belum ada data revenue.</div>
                    @endforelse
                </div>
            </div>

            {{-- USER ACTIVITY --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800">User Activity</h2>
                    <p class="text-gray-500 text-sm">Aktivitas pengguna platform</p>
                </div>

                <div class="space-y-6">

                    @php
                        $studentPct  = $activity['total_students']    > 0 ? round($activity['students_active']  / $activity['total_students']    * 100) : 0;
                        $enrollPct   = $activity['total_enrollments'] > 0 ? round($activity['enrollments']      / $activity['total_enrollments'] * 100) : 0;
                        $paymentPct  = $activity['total_payments']    > 0 ? round($activity['paid_payments']    / $activity['total_payments']    * 100) : 0;
                        $instrPct    = $activity['total_instructors'] > 0 ? round($activity['instructors']      / $activity['total_instructors'] * 100) : 0;
                    @endphp

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">Students Verified</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $studentPct }}%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: {{ $studentPct }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">Active Enrollments</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $enrollPct }}%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full rounded-full" style="width: {{ $enrollPct }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">Payment Success</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $paymentPct }}%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-violet-500 h-full rounded-full" style="width: {{ $paymentPct }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">Avg Rating</span>
                            <span class="text-sm font-semibold text-gray-800">⭐ {{ $stats['avg_rating'] }} / 5</span>
                        </div>
                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-orange-500 h-full rounded-full" style="width: {{ round($stats['avg_rating'] / 5 * 100) }}%"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- TOP COURSES --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">Top Courses</h2>
                <p class="text-gray-500 text-sm mt-1">Course paling populer berdasarkan enrollment</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm">
                            <th class="text-left p-4 rounded-l-2xl">#</th>
                            <th class="text-left p-4">Course</th>
                            <th class="text-left p-4">Enrollments</th>
                            <th class="text-left p-4">Rating</th>
                            <th class="text-left p-4 rounded-r-2xl">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCourses as $i => $course)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-400 font-bold">{{ $i + 1 }}</td>
                                <td class="p-4 font-semibold text-gray-800">
                                    {{ $course->title }}
                                    <p class="text-xs text-gray-400 font-normal">{{ $course->institution->name ?? '-' }}</p>
                                </td>
                                <td class="p-4 font-semibold text-gray-700">
                                    {{ number_format($course->enrollments_count) }}
                                </td>
                                <td class="p-4">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        ⭐ {{ round($course->reviews_avg_rating, 1) ?: '-' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if($course->is_published)
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Published</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-400">Belum ada data course.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
@endsection