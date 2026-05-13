{{-- resources/views/admin/analytics.blade.php --}}

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
                Analytics
            </h1>

            <p class="text-gray-500 mt-2">
                Pantau statistik dan performa platform secara keseluruhan.
            </p>

        </div>

        {{-- TOP STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

            {{-- CARD --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Total Revenue
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            $24,500
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                        💰
                    </div>

                </div>

                <p class="text-green-500 text-sm mt-4">
                    +18% dari bulan lalu
                </p>

            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Total Students
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            3,421
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-violet-100 flex items-center justify-center text-2xl">
                        👥
                    </div>

                </div>

                <p class="text-violet-500 text-sm mt-4">
                    +12% pengguna aktif
                </p>

            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Total Courses
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            128
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-2xl">
                        📚
                    </div>

                </div>

                <p class="text-indigo-500 text-sm mt-4">
                    14 course baru minggu ini
                </p>

            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Completion Rate
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            78%
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-2xl">
                        📈
                    </div>

                </div>

                <p class="text-orange-500 text-sm mt-4">
                    Stabil minggu ini
                </p>

            </div>

        </div>

        {{-- CHART SECTION --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

            {{-- REVENUE CHART --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between mb-6">

                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            Revenue Growth
                        </h2>

                        <p class="text-gray-500 text-sm">
                            Statistik pemasukan platform
                        </p>
                    </div>

                    <span class="bg-indigo-100 text-indigo-600 text-xs px-4 py-2 rounded-full font-medium">
                        2026
                    </span>

                </div>

                {{-- FAKE BAR CHART --}}
                <div class="h-72 flex items-end gap-4">

                    <div class="flex-1 bg-indigo-200 rounded-t-2xl h-20"></div>

                    <div class="flex-1 bg-indigo-300 rounded-t-2xl h-32"></div>

                    <div class="flex-1 bg-indigo-400 rounded-t-2xl h-40"></div>

                    <div class="flex-1 bg-indigo-500 rounded-t-2xl h-52"></div>

                    <div class="flex-1 bg-indigo-600 rounded-t-2xl h-60"></div>

                    <div class="flex-1 bg-indigo-700 rounded-t-2xl h-72"></div>

                </div>

                <div class="flex justify-between mt-4 text-sm text-gray-400">

                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>May</span>
                    <span>Jun</span>

                </div>

            </div>

            {{-- USER ACTIVITY --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="mb-6">

                    <h2 class="text-xl font-bold text-gray-800">
                        User Activity
                    </h2>

                    <p class="text-gray-500 text-sm">
                        Aktivitas pengguna platform
                    </p>

                </div>

                <div class="space-y-6">

                    {{-- ITEM --}}
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <span class="text-sm font-medium text-gray-600">
                                Students Active
                            </span>

                            <span class="text-sm font-semibold text-gray-800">
                                82%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full w-[82%] rounded-full"></div>
                        </div>

                    </div>

                    {{-- ITEM --}}
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <span class="text-sm font-medium text-gray-600">
                                Instructor Activity
                            </span>

                            <span class="text-sm font-semibold text-gray-800">
                                61%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full w-[61%] rounded-full"></div>
                        </div>

                    </div>

                    {{-- ITEM --}}
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <span class="text-sm font-medium text-gray-600">
                                Course Completion
                            </span>

                            <span class="text-sm font-semibold text-gray-800">
                                78%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-orange-500 h-full w-[78%] rounded-full"></div>
                        </div>

                    </div>

                    {{-- ITEM --}}
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <span class="text-sm font-medium text-gray-600">
                                Payment Success
                            </span>

                            <span class="text-sm font-semibold text-gray-800">
                                94%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-violet-500 h-full w-[94%] rounded-full"></div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- TOP COURSES --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm">

            <div class="flex items-center justify-between mb-6">

                <div>

                    <h2 class="text-xl font-bold text-gray-800">
                        Top Courses
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Course paling populer bulan ini
                    </p>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="bg-gray-100 text-gray-500 text-sm">

                            <th class="text-left p-4 rounded-l-2xl">
                                Course
                            </th>

                            <th class="text-left p-4">
                                Students
                            </th>

                            <th class="text-left p-4">
                                Revenue
                            </th>

                            <th class="text-left p-4 rounded-r-2xl">
                                Rating
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr class="border-b border-gray-100 hover:bg-gray-50">

                            <td class="p-4 font-semibold text-gray-800">
                                React Development
                            </td>

                            <td class="p-4">
                                1,240
                            </td>

                            <td class="p-4 text-green-600 font-semibold">
                                $8,200
                            </td>

                            <td class="p-4">
                                ⭐ 4.9
                            </td>

                        </tr>

                        <tr class="border-b border-gray-100 hover:bg-gray-50">

                            <td class="p-4 font-semibold text-gray-800">
                                UI/UX Design
                            </td>

                            <td class="p-4">
                                980
                            </td>

                            <td class="p-4 text-green-600 font-semibold">
                                $6,450
                            </td>

                            <td class="p-4">
                                ⭐ 4.8
                            </td>

                        </tr>

                        <tr class="hover:bg-gray-50">

                            <td class="p-4 font-semibold text-gray-800">
                                Laravel Masterclass
                            </td>

                            <td class="p-4">
                                820
                            </td>

                            <td class="p-4 text-green-600 font-semibold">
                                $5,120
                            </td>

                            <td class="p-4">
                                ⭐ 4.7
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

@endsection