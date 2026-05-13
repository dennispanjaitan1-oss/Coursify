{{-- resources/views/admin/users.blade.php --}}

@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div class="bg-white rounded-3xl shadow-md p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Users Management
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola seluruh pengguna platform Coursify.
            </p>
        </div>

        <button
            class="bg-violet-500 text-white px-5 py-2.5 rounded-xl font-medium hover:opacity-90 text-sm transition"
        >
            + Add User
        </button>

    </div>

    {{-- Search & Filter --}}
    <div class="flex flex-col md:flex-row gap-3 mb-6">

        <input
            type="text"
            placeholder="Cari pengguna..."
            class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-violet-300"
        >

        <select
            class="border border-gray-200 rounded-xl px-3 py-2 text-sm outline-none"
        >
            <option>Semua Role</option>
            <option>Admin</option>
            <option>Instructor</option>
            <option>Student</option>
        </select>

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm">

                    <th class="text-left p-4 rounded-l-xl">
                        Nama
                    </th>

                    <th class="text-left p-4">
                        Email
                    </th>

                    <th class="text-left p-4">
                        Role
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
                    $users = [
                        [
                            'name' => 'John Doe',
                            'email' => 'john@example.com',
                            'role' => 'Instructor',
                            'status' => 'Active',
                        ],
                        [
                            'name' => 'Sarah Smith',
                            'email' => 'sarah@example.com',
                            'role' => 'Student',
                            'status' => 'Active',
                        ],
                        [
                            'name' => 'Michael Lee',
                            'email' => 'michael@example.com',
                            'role' => 'Admin',
                            'status' => 'Pending',
                        ],
                        [
                            'name' => 'Olivia Brown',
                            'email' => 'olivia@example.com',
                            'role' => 'Student',
                            'status' => 'Blocked',
                        ],
                        [
                            'name' => 'Budi Santoso',
                            'email' => 'budi@example.com',
                            'role' => 'Instructor',
                            'status' => 'Active',
                        ],
                    ];
                @endphp

                @foreach($users as $user)

                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                    <td class="p-4 font-medium text-gray-800">
                        {{ $user['name'] }}
                    </td>

                    <td class="p-4 text-sm text-gray-500">
                        {{ $user['email'] }}
                    </td>

                    <td class="p-4 text-sm text-gray-700">
                        {{ $user['role'] }}
                    </td>

                    <td class="p-4">

                        @if($user['status'] == 'Active')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $user['status'] }}
                            </span>

                        @elseif($user['status'] == 'Pending')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $user['status'] }}
                            </span>

                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $user['status'] }}
                            </span>
                        @endif

                    </td>

                    <td class="p-4 flex gap-2">

                        <button
                            class="bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:opacity-80 transition"
                        >
                            Edit
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