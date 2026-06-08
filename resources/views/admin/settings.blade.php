{{-- resources/views/admin/settings.blade.php --}}

@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<div class="min-h-screen bg-gray-100 flex" id="settingsPage">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'Settings')
            @include('admin.partials.header')

        {{-- HEADER --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 mb-6" id="settingsHeader">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">System Settings</h1>
                    <p class="text-gray-500 mt-1">Kelola pengaturan utama platform Coursify.</p>
                </div>
                <div class="w-12 h-12 bg-violet-100 rounded-2xl flex items-center justify-center">
                    <i class="fa-solid fa-gear text-violet-500 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- SUCCESS ALERT --}}
        @if(session('success'))
            <div id="successAlert" class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6 flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- SETTINGS --}}
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 divide-y divide-gray-100" id="settingsCard">

            {{-- Email Notification --}}
            <div class="flex items-center justify-between px-8 py-6">
                <div>
                    <h2 class="font-semibold text-gray-800">Notifikasi Email</h2>
                    <p class="text-sm text-gray-500 mt-1">Kirim email otomatis kepada pengguna baru.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="email_notification" name="email_notification" value="1" class="sr-only peer" {{ $settings['email_notification'] ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"></div>
                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"></div>
                </label>
            </div>

            {{-- Maintenance Mode --}}
            <div class="flex items-center justify-between px-8 py-6">
                <div>
                    <h2 class="font-semibold text-gray-800">Maintenance Mode</h2>
                    <p class="text-sm text-gray-500 mt-1">Nonaktifkan akses publik sementara.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" class="sr-only peer" {{ $settings['maintenance_mode'] ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"></div>
                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"></div>
                </label>
            </div>

            {{-- Open Registration --}}
            <div class="flex items-center justify-between px-8 py-6">
                <div>
                    <h2 class="font-semibold text-gray-800">Registrasi Terbuka</h2>
                    <p class="text-sm text-gray-500 mt-1">Izinkan pengguna baru membuat akun.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="open_registration" name="open_registration" value="1" class="sr-only peer" {{ $settings['open_registration'] ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"></div>
                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"></div>
                </label>
            </div>

            {{-- Auto Approval --}}
            <div class="flex items-center justify-between px-8 py-6">
                <div>
                    <h2 class="font-semibold text-gray-800">Auto Approval Course</h2>
                    <p class="text-sm text-gray-500 mt-1">Course baru langsung disetujui otomatis.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="auto_approval" name="auto_approval" value="1" class="sr-only peer" {{ $settings['auto_approval'] ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"></div>
                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"></div>
                </label>
            </div>

            {{-- Dark Mode --}}
            <div class="flex items-center justify-between px-8 py-6">
                <div>
                    <h2 class="font-semibold text-gray-800">Dark Mode</h2>
                    <p class="text-sm text-gray-500 mt-1">Aktifkan tampilan gelap untuk dashboard admin.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="dark_mode" name="dark_mode" value="1" class="sr-only peer" {{ $settings['dark_mode'] ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"></div>
                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"></div>
                </label>
            </div>

        </div>

        {{-- SAVE BUTTON --}}
        <div class="mt-6 flex justify-end">
            <button
                type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-4 py-2 rounded-xl transition"
            >
                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Save Changes
            </button>
        </div>

        </form>

    </main>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        applyDarkMode();
    });

    function applyDarkMode() {
        var isDark = document.getElementById('dark_mode')?.checked === true;
        var page    = document.getElementById('settingsPage');
        var card    = document.getElementById('settingsCard');
        var header  = document.getElementById('settingsHeader');

        if (isDark) {
            page.style.background   = '#1e1e2e';
            card.style.background   = '#2a2a3e';
            card.style.borderColor  = '#3a3a5e';
            header.style.background = '#2a2a3e';
            document.body.style.background = '#1e1e2e';
            // Teks jadi putih
            card.querySelectorAll('h2').forEach(function(el){ el.style.color = '#e0e0f0'; });
            card.querySelectorAll('p').forEach(function(el){ el.style.color = '#9090b0'; });
        } else {
            page.style.background   = '';
            card.style.background   = '';
            card.style.borderColor  = '';
            header.style.background = '';
            document.body.style.background = '';
            card.querySelectorAll('h2').forEach(function(el){ el.style.color = ''; });
            card.querySelectorAll('p').forEach(function(el){ el.style.color = ''; });
        }
    }
</script>
@endpush

@endsection
