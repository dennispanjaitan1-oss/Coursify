{{-- resources/views/admin/settings.blade.php --}}

@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<div class="bg-white rounded-3xl shadow-md p-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            System Settings
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola pengaturan utama platform Coursify.
        </p>
    </div>

    {{-- Settings List --}}
    <div class="space-y-5">

        {{-- Email Notification --}}
        <div class="flex items-center justify-between border-b border-gray-100 pb-5">

            <div>
                <h2 class="font-semibold text-gray-800">
                    Notifikasi Email
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Kirim email otomatis kepada pengguna baru.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked class="sr-only peer">

                <div
                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"
                ></div>

                <div
                    class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"
                ></div>
            </label>

        </div>

        {{-- Maintenance Mode --}}
        <div class="flex items-center justify-between border-b border-gray-100 pb-5">

            <div>
                <h2 class="font-semibold text-gray-800">
                    Maintenance Mode
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Nonaktifkan akses publik sementara.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer">

                <div
                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"
                ></div>

                <div
                    class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"
                ></div>
            </label>

        </div>

        {{-- Open Registration --}}
        <div class="flex items-center justify-between border-b border-gray-100 pb-5">

            <div>
                <h2 class="font-semibold text-gray-800">
                    Registrasi Terbuka
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Izinkan pengguna baru membuat akun.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked class="sr-only peer">

                <div
                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"
                ></div>

                <div
                    class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"
                ></div>
            </label>

        </div>

        {{-- Auto Approval --}}
        <div class="flex items-center justify-between border-b border-gray-100 pb-5">

            <div>
                <h2 class="font-semibold text-gray-800">
                    Auto Approval Course
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Course baru langsung disetujui otomatis.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer">

                <div
                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"
                ></div>

                <div
                    class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"
                ></div>
            </label>

        </div>

        {{-- Dark Mode --}}
        <div class="flex items-center justify-between border-b border-gray-100 pb-5">

            <div>
                <h2 class="font-semibold text-gray-800">
                    Dark Mode
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Aktifkan tampilan gelap untuk dashboard admin.
                </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer">

                <div
                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"
                ></div>

                <div
                    class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"
                ></div>
            </label>

        </div>

    </div>

    {{-- Save Button --}}
    <div class="mt-8 flex justify-end">

        <button
            class="bg-violet-500 text-white px-6 py-3 rounded-2xl font-semibold hover:opacity-90 transition"
        >
            Save Changes
        </button>

    </div>

</div>

@endsection