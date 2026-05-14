{{-- resources/views/admin/users.blade.php --}}

@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

        {{-- PAGE HEADER --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Users Management</h1>
                <p class="text-gray-500 mt-1 text-sm">Kelola seluruh pengguna platform Coursify.</p>
            </div>

            <button
                onclick="document.getElementById('modal-add-user').classList.remove('hidden')"
                class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User
            </button>
        </div>

        {{-- SUCCESS / ERROR FLASH --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-8">

            {{-- Total --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center text-xl flex-shrink-0">👥</div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total']) }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Total Users</p>
                </div>
            </div>

            {{-- Students --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-xl flex-shrink-0">🎓</div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['students']) }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Students</p>
                </div>
            </div>

            {{-- Instructors --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-xl flex-shrink-0">🧑‍🏫</div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['instructors']) }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Instructors</p>
                </div>
            </div>

            {{-- Admins --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center text-xl flex-shrink-0">🛡️</div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['admins']) }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Admins</p>
                </div>
            </div>

        </div>

        {{-- FILTER & SEARCH --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('admin.users') }}" class="flex flex-col md:flex-row gap-3">

                {{-- Search --}}
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-violet-300 focus:border-transparent outline-none"
                    >
                </div>

                {{-- Role Filter --}}
                <select name="role" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-violet-300 outline-none">
                    <option value="">Semua Role</option>
                    <option value="student"    {{ request('role') === 'student'    ? 'selected' : '' }}>Student</option>
                    <option value="instructor" {{ request('role') === 'instructor' ? 'selected' : '' }}>Instructor</option>
                    <option value="admin"      {{ request('role') === 'admin'      ? 'selected' : '' }}>Admin</option>
                </select>

                {{-- Status Filter --}}
                <select name="status" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-violet-300 outline-none">
                    <option value="">Semua Status</option>
                    <option value="verified"   {{ request('status') === 'verified'   ? 'selected' : '' }}>Verified</option>
                    <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>Unverified</option>
                </select>

                {{-- Sort --}}
                <select name="sort" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-violet-300 outline-none">
                    <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Terbaru</option>
                    <option value="name"       {{ request('sort') === 'name'       ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="email"      {{ request('sort') === 'email'      ? 'selected' : '' }}>Email</option>
                    <option value="role"       {{ request('sort') === 'role'       ? 'selected' : '' }}>Role</option>
                </select>

                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">
                    Filter
                </button>

                @if(request()->hasAny(['search', 'role', 'status', 'sort']))
                    <a href="{{ route('admin.users') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-medium transition">
                        Reset
                    </a>
                @endif

            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            {{-- Table Header Info --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <p class="text-sm text-gray-500">
                    Menampilkan <span class="font-semibold text-gray-700">{{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-gray-700">{{ $users->total() }}</span> pengguna
                </p>
                <p class="text-xs text-gray-400">Halaman {{ $users->currentPage() }} / {{ $users->lastPage() }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">

                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="text-left px-6 py-3 font-semibold">Pengguna</th>
                            <th class="text-left px-6 py-3 font-semibold">Role</th>
                            <th class="text-left px-6 py-3 font-semibold">Status</th>
                            <th class="text-left px-6 py-3 font-semibold">Bergabung</th>
                            <th class="text-left px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">

                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition group">

                            {{-- Name + Email --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    {{-- Avatar --}}
                                    @if($user->avatar_url)
                                        <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="{{ $user->name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-sm flex-shrink-0
                                            {{ $user->role === 'admin' ? 'bg-orange-500' : ($user->role === 'instructor' ? 'bg-green-500' : 'bg-violet-500') }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $user->name }}</p>
                                        <p class="text-gray-400 text-xs">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-3 py-1 rounded-full
                                    {{ $user->role === 'admin'      ? 'bg-orange-100 text-orange-700' :
                                       ($user->role === 'instructor' ? 'bg-green-100  text-green-700'  :
                                                                       'bg-blue-100   text-blue-700')  }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                        Unverified
                                    </span>
                                @endif
                            </td>

                            {{-- Joined --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">

                                    {{-- Detail --}}
                                    <a
                                        href="{{ route('admin.users.show', $user->id) }}"
                                        class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition"
                                        title="Lihat detail"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.users.edit', $user->id) }}"
                                        class="p-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-600 transition"
                                        title="Edit user"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    @if($user->id !== auth()->id())
                                    <form
                                        action="{{ route('admin.users.destroy', $user->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="p-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 transition"
                                            title="Hapus user"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="font-medium">Tidak ada pengguna ditemukan</p>
                                    <p class="text-sm">Coba ubah filter pencarian kamu.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
            @endif

        </div>

    </main>

</div>

{{-- ============================================================ --}}
{{-- MODAL: ADD USER --}}
{{-- ============================================================ --}}
<div id="modal-add-user" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg">

        <div class="flex items-center justify-between px-8 pt-8 pb-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Tambah User Baru</h2>
            <button onclick="document.getElementById('modal-add-user').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="px-8 py-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                    placeholder="Contoh: Budi Santoso">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                    placeholder="email@example.com">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                <select name="role" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none">
                    <option value="">Pilih role...</option>
                    <option value="student"    {{ old('role') === 'student'    ? 'selected' : '' }}>Student</option>
                    <option value="instructor" {{ old('role') === 'instructor' ? 'selected' : '' }}>Instructor</option>
                    <option value="admin"      {{ old('role') === 'admin'      ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                    placeholder="Minimal 8 karakter">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                    placeholder="Ulangi password">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button"
                    onclick="document.getElementById('modal-add-user').classList.add('hidden')"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-xl text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-violet-600 hover:bg-violet-700 text-white py-2.5 rounded-xl text-sm font-medium transition">
                    Simpan User
                </button>
            </div>

        </form>

    </div>
</div>

{{-- Auto-open modal if validation error on store --}}
@if($errors->any())
<script>
    document.getElementById('modal-add-user').classList.remove('hidden');
</script>
@endif

@endsection