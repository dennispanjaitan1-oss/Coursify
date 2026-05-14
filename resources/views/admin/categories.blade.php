{{-- resources/views/admin/categories.blade.php --}}

@extends('layouts.app')

@section('title', 'Categories')

@section('content')

<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

        {{-- PAGE HEADER --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Categories</h1>
                <p class="text-gray-500 mt-1 text-sm">Kelola kategori kursus pembelajaran.</p>
            </div>

            <button
                onclick="document.getElementById('modal-add-category').classList.remove('hidden')"
                class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kategori
            </button>
        </div>

        {{-- FLASH MESSAGES --}}
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

            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center text-xl flex-shrink-0">🗂️</div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total']) }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Total Kategori</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-xl flex-shrink-0">📚</div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_courses']) }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Total Kursus</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-xl flex-shrink-0">📂</div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['parent']) }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Parent Category</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center text-xl flex-shrink-0">📄</div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['sub']) }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Sub Category</p>
                </div>
            </div>

        </div>

        {{-- SEARCH & FILTER --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('admin.categories') }}" class="flex flex-col md:flex-row gap-3">

                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari kategori..."
                        class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                    >
                </div>

                <select name="type" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-violet-300 outline-none">
                    <option value="">Semua Tipe</option>
                    <option value="parent" {{ request('type') === 'parent' ? 'selected' : '' }}>Parent Only</option>
                </select>

                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">
                    Filter
                </button>

                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('admin.categories') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-medium transition">
                        Reset
                    </a>
                @endif

            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <p class="text-sm text-gray-500">
                    Menampilkan <span class="font-semibold text-gray-700">{{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-gray-700">{{ $categories->total() }}</span> kategori
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">

                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="text-left px-6 py-3 font-semibold">Kategori</th>
                            <th class="text-left px-6 py-3 font-semibold">Slug</th>
                            <th class="text-left px-6 py-3 font-semibold">Parent</th>
                            <th class="text-left px-6 py-3 font-semibold">Total Kursus</th>
                            <th class="text-left px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">

                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- Name + Icon --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center text-lg flex-shrink-0">
                                        {{ $category->icon ?? '📁' }}
                                    </div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ $category->name }}</p>
                                </div>
                            </td>

                            {{-- Slug --}}
                            <td class="px-6 py-4">
                                <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-lg">{{ $category->slug }}</code>
                            </td>

                            {{-- Parent --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($category->parent)
                                    <span class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1 rounded-full bg-blue-50 text-blue-600">
                                        {{ $category->parent->icon ?? '📁' }} {{ $category->parent->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic">— Parent</span>
                                @endif
                            </td>

                            {{-- Course Count --}}
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-800">{{ $category->courses_count }}</span>
                                <span class="text-xs text-gray-400 ml-1">kursus</span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">

                                    {{-- Edit --}}
                                    <button
                                        onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->icon ?? '') }}', '{{ $category->parent_id ?? '' }}')"
                                        class="p-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-600 transition"
                                        title="Edit kategori"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.categories.destroy', $category->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus kategori \'{{ addslashes($category->name) }}\'?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="p-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 transition"
                                            title="Hapus kategori"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                    </svg>
                                    <p class="font-medium">Belum ada kategori</p>
                                    <p class="text-sm">Klik "Tambah Kategori" untuk menambahkan yang pertama.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $categories->links() }}
            </div>
            @endif

        </div>

    </main>

</div>

{{-- ============================================================ --}}
{{-- MODAL: ADD CATEGORY --}}
{{-- ============================================================ --}}
<div id="modal-add-category" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md">

        <div class="flex items-center justify-between px-8 pt-8 pb-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Tambah Kategori</h2>
            <button onclick="document.getElementById('modal-add-category').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="px-8 py-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                    placeholder="Contoh: Web Development">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Icon Emoji</label>
                <input type="text" name="icon" value="{{ old('icon', '📁') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none"
                    placeholder="Contoh: 💻">
                <p class="text-gray-400 text-xs mt-1">Gunakan satu karakter emoji sebagai ikon.</p>
                @error('icon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Parent Kategori <span class="text-gray-400 font-normal">(opsional)</span></label>
                <select name="parent_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none">
                    <option value="">— Tidak ada (jadikan parent) —</option>
                    @foreach(\App\Models\Category::whereNull('parent_id')->orderBy('name')->get() as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->icon ?? '📁' }} {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button"
                    onclick="document.getElementById('modal-add-category').classList.add('hidden')"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-xl text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-violet-600 hover:bg-violet-700 text-white py-2.5 rounded-xl text-sm font-medium transition">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

{{-- ============================================================ --}}
{{-- MODAL: EDIT CATEGORY --}}
{{-- ============================================================ --}}
<div id="modal-edit-category" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md">

        <div class="flex items-center justify-between px-8 pt-8 pb-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Edit Kategori</h2>
            <button onclick="document.getElementById('modal-edit-category').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="form-edit-category" action="" method="POST" class="px-8 py-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori</label>
                <input type="text" id="edit-name" name="name" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Icon Emoji</label>
                <input type="text" id="edit-icon" name="icon"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Parent Kategori <span class="text-gray-400 font-normal">(opsional)</span></label>
                <select id="edit-parent" name="parent_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-violet-300 outline-none">
                    <option value="">— Tidak ada (jadikan parent) —</option>
                    @foreach(\App\Models\Category::whereNull('parent_id')->orderBy('name')->get() as $parent)
                        <option value="{{ $parent->id }}">
                            {{ $parent->icon ?? '📁' }} {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button"
                    onclick="document.getElementById('modal-edit-category').classList.add('hidden')"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-xl text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-violet-600 hover:bg-violet-700 text-white py-2.5 rounded-xl text-sm font-medium transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

{{-- Auto-open modal if validation error --}}
@if($errors->any())
<script>
    document.getElementById('modal-add-category').classList.remove('hidden');
</script>
@endif

<script>
    function openEditModal(id, name, icon, parentId) {
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-icon').value = icon;
        document.getElementById('edit-parent').value = parentId || '';
        document.getElementById('form-edit-category').action = '/admin/categories/' + id;
        document.getElementById('modal-edit-category').classList.remove('hidden');
    }
</script>

@endsection