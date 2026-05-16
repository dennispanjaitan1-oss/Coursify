{{-- resources/views/admin/users-create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('admin.users') }}" class="hover:text-indigo-600 transition">Users</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Tambah User</span>
        </div>

        <div class="max-w-2xl">
            <div class="bg-white rounded-3xl shadow-sm p-8">

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-user-plus text-indigo-500"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Tambah User Baru</h1>
                        <p class="text-gray-400 text-sm">Isi data pengguna yang akan ditambahkan.</p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm">
                        <div class="flex items-center gap-2 font-medium mb-1">
                            <i class="fas fa-circle-exclamation"></i> Terdapat kesalahan:
                        </div>
                        <ul class="list-disc list-inside space-y-1 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-300 outline-none"
                                placeholder="Contoh: Budi Santoso">
                        </div>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-300 outline-none"
                                placeholder="email@example.com">
                        </div>
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <select name="role" required
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-300 outline-none appearance-none">
                                <option value="">Pilih role...</option>
                                <option value="student"    {{ old('role') === 'student'    ? 'selected' : '' }}>Student</option>
                                <option value="instructor" {{ old('role') === 'instructor' ? 'selected' : '' }}>Instructor</option>
                                <option value="admin"      {{ old('role') === 'admin'      ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-sm font-semibold text-gray-700 mb-4">
                            <i class="fas fa-lock text-indigo-400 mr-1"></i> Password
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password" required
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-300 outline-none"
                                placeholder="Minimal 8 karakter">
                        </div>
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password_confirmation" required
                                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-300 outline-none"
                                placeholder="Ulangi password">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('admin.users') }}"
                            class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl text-sm font-medium transition">
                            <i class="fas fa-arrow-left mr-1"></i> Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white py-3 rounded-xl text-sm font-medium transition">
                            <i class="fas fa-user-plus mr-1"></i> Tambah User
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </main>
</div>

@endsection