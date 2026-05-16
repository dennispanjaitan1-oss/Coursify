{{-- resources/views/admin/settings.blade.php --}}

@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<div class="min-h-screen bg-gray-100 flex" id="settingsPage">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">

        {{-- HEADER --}}
        <div class="bg-white rounded-3xl shadow-md p-8 mb-6" id="settingsHeader">
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
        <div id="successAlert" style="display:none;" class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            Pengaturan berhasil disimpan.
        </div>

        {{-- SETTINGS --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 divide-y divide-gray-100" id="settingsCard">

            {{-- Email Notification --}}
            <div class="flex items-center justify-between px-8 py-6">
                <div>
                    <h2 class="font-semibold text-gray-800">Notifikasi Email</h2>
                    <p class="text-sm text-gray-500 mt-1">Kirim email otomatis kepada pengguna baru.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="email_notification" class="sr-only peer">
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
                    <input type="checkbox" id="maintenance_mode" class="sr-only peer">
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
                    <input type="checkbox" id="open_registration" class="sr-only peer">
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
                    <input type="checkbox" id="auto_approval" class="sr-only peer">
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
                    <input type="checkbox" id="dark_mode" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-violet-500 transition"></div>
                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"></div>
                </label>
            </div>

        </div>

        {{-- SAVE BUTTON --}}
        <div class="mt-6 flex justify-end">
            <button
                onclick="saveSettings()"
                class="bg-violet-500 text-white px-8 py-3 rounded-2xl font-semibold hover:bg-violet-600 transition shadow"
            >
                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Save Changes
            </button>
        </div>

    </main>
</div>

@push('scripts')
<script>
    const SETTING_KEYS = ['email_notification', 'maintenance_mode', 'open_registration', 'auto_approval', 'dark_mode'];

    // Load saved settings saat halaman dibuka
    document.addEventListener('DOMContentLoaded', function () {
        SETTING_KEYS.forEach(function(key) {
            var el = document.getElementById(key);
            if (!el) return;
            var saved = localStorage.getItem('coursify_setting_' + key);
            // Default values
            if (saved === null) {
                if (key === 'email_notification' || key === 'open_registration') {
                    el.checked = true;
                } else {
                    el.checked = false;
                }
            } else {
                el.checked = (saved === 'true');
            }
        });

        applyDarkMode();
    });

    function saveSettings() {
        SETTING_KEYS.forEach(function(key) {
            var el = document.getElementById(key);
            if (el) {
                localStorage.setItem('coursify_setting_' + key, el.checked ? 'true' : 'false');
            }
        });

        applyDarkMode();

        // Tampilkan alert sukses
        var alert = document.getElementById('successAlert');
        alert.style.display = 'flex';
        setTimeout(function() {
            alert.style.display = 'none';
        }, 3000);
    }

    function applyDarkMode() {
        var isDark = localStorage.getItem('coursify_setting_dark_mode') === 'true';
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