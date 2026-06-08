{{-- resources/views/admin/users-edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'Edit User')
            @include('admin.partials.header')

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('admin.users') }}" class="hover:text-violet-600 transition">Users</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-800 font-medium">Edit User</span>
        </div>

        <div class="max-w-2xl">
            <div class="bg-white rounded-3xl shadow-sm p-8">

                <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit User</h1>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Avatar preview --}}
                    <div class="flex items-center gap-4 pb-6 border-b border-gray-100">
                        @if($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" class="w-16 h-16 rounded-full object-cover" alt="{{ $user->name }}">
                        @else
                            <div class="w-16 h-16 rounded-full flex items-center justify-center font-bold text-white text-2xl
                                {{ $user->role === 'admin' ? 'bg-orange-500' : ($user->role === 'instructor' ? 'bg-green-500' : 'bg-violet-500') }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                            <p class="text-gray-400 text-xs mt-0.5">Bergabung {{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                        <select name="role" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none">
                            <option value="student"    {{ old('role', $user->role) === 'student'    ? 'selected' : '' }}>Student</option>
                            <option value="instructor" {{ old('role', $user->role) === 'instructor' ? 'selected' : '' }}>Instructor</option>
                            <option value="admin"      {{ old('role', $user->role) === 'admin'      ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-sm font-medium text-gray-700 mb-1">Ganti Password <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                        <input type="password" name="password"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                            placeholder="Minimal 8 karakter">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                            placeholder="Ulangi password baru">
                    </div>

                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('admin.users') }}"
                            class="flex-1 text-center border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-violet-600 hover:bg-violet-700 text-white py-3 rounded-xl text-sm font-medium transition">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </main>
</div>

@endsection