{{-- resources/views/admin/reviews.blade.php --}}

@extends('layouts.app')

@section('title', 'Reviews')

@section('content')

<div class="bg-white rounded-3xl shadow-md p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Reviews Management
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola seluruh ulasan course dari pengguna.
            </p>
        </div>

        <button
            class="bg-violet-500 text-white px-5 py-2.5 rounded-xl font-medium hover:opacity-90 text-sm transition"
        >
            Export Reviews
        </button>
    </div>

    {{-- Filter --}}
    <div class="flex flex-col md:flex-row gap-3 mb-6">

        <input
            type="text"
            placeholder="Cari review..."
            class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-violet-300"
        >

        <select
            class="border border-gray-200 rounded-xl px-3 py-2 text-sm outline-none"
        >
            <option>Semua Rating</option>
            <option>⭐ 5</option>
            <option>⭐ 4</option>
            <option>⭐ 3</option>
            <option>⭐ 2</option>
            <option>⭐ 1</option>
        </select>

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">

            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm">

                    <th class="text-left p-4 rounded-l-xl">
                        Pengguna
                    </th>

                    <th class="text-left p-4">
                        Course
                    </th>

                    <th class="text-left p-4">
                        Rating
                    </th>

                    <th class="text-left p-4">
                        Komentar
                    </th>

                    <th class="text-left p-4">
                        Tanggal
                    </th>

                    <th class="text-left p-4 rounded-r-xl">
                        Aksi
                    </th>

                </tr>
            </thead>

            <tbody>

                @php
                    $reviews = [
                        [
                            'user' => 'John Doe',
                            'course' => 'React Development',
                            'rating' => '⭐ 5',
                            'comment' => 'Materinya sangat lengkap dan mudah dipahami.',
                            'date' => '13 Mei 2026',
                        ],
                        [
                            'user' => 'Sarah Smith',
                            'course' => 'UI/UX Design',
                            'rating' => '⭐ 4',
                            'comment' => 'Desain course bagus dan interaktif.',
                            'date' => '12 Mei 2026',
                        ],
                        [
                            'user' => 'Michael Lee',
                            'course' => 'Laravel Masterclass',
                            'rating' => '⭐ 3',
                            'comment' => 'Penjelasan cukup baik namun kurang detail.',
                            'date' => '11 Mei 2026',
                        ],
                        [
                            'user' => 'Olivia Brown',
                            'course' => 'Python for Beginners',
                            'rating' => '⭐ 5',
                            'comment' => 'Cocok untuk pemula.',
                            'date' => '10 Mei 2026',
                        ],
                        [
                            'user' => 'Budi Santoso',
                            'course' => 'Machine Learning',
                            'rating' => '⭐ 2',
                            'comment' => 'Video terlalu cepat dijelaskan.',
                            'date' => '9 Mei 2026',
                        ],
                    ];
                @endphp

                @foreach($reviews as $review)

                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                    <td class="p-4 font-medium text-gray-800">
                        {{ $review['user'] }}
                    </td>

                    <td class="p-4 text-sm text-gray-600">
                        {{ $review['course'] }}
                    </td>

                    <td class="p-4">
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $review['rating'] }}
                        </span>
                    </td>

                    <td class="p-4 text-sm text-gray-500 max-w-sm">
                        {{ $review['comment'] }}
                    </td>

                    <td class="p-4 text-sm text-gray-400">
                        {{ $review['date'] }}
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