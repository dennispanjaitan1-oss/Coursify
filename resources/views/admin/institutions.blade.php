{{-- resources/views/admin/institutions.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 flex">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Institutions Management</h1>
                    <p class="text-gray-500 mt-1">Kelola institusi partner platform pembelajaran.</p>
                </div>
                <button onclick="document.getElementById('modalAdd').classList.remove('hidden')"
                    class="bg-violet-500 hover:bg-violet-600 text-white px-5 py-2.5 rounded-2xl font-medium shadow transition">
                    + Add Institution
                </button>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">Total Institutions</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $institutions->total() }}</h2>
                </div>
                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">Verified</p>
                    <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $institutions->where('is_verified', true)->count() }}</h2>
                </div>
                <div class="bg-white rounded-3xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500">Unverified</p>
                    <h2 class="text-3xl font-bold text-yellow-500 mt-2">{{ $institutions->where('is_verified', false)->count() }}</h2>
                </div>
            </div>

            {{-- SEARCH --}}
            <div class="bg-white rounded-3xl shadow-sm p-6 mb-8 border border-gray-100">
                <form method="GET" action="{{ route('admin.institutions') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari institusi..."
                        class="flex-1 border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-violet-300">
                    <select name="status" class="border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>Unverified</option>
                    </select>
                    <button type="submit" class="bg-violet-500 text-white px-6 py-3 rounded-2xl font-medium hover:bg-violet-600 transition">
                        Cari
                    </button>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-gray-500 text-sm">
                                <th class="px-6 py-4 font-semibold">Institution</th>
                                <th class="px-6 py-4 font-semibold">Website</th>
                                <th class="px-6 py-4 font-semibold">Description</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($institutions as $institution)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            @if($institution->logo_url)
                                                <img src="{{ $institution->logo_url }}" alt="{{ $institution->name }}"
                                                    class="w-10 h-10 rounded-xl object-contain bg-gray-50 border border-gray-100">
                                            @else
                                                <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center text-violet-500 font-bold text-sm">
                                                    {{ strtoupper(substr($institution->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="font-semibold text-gray-800">{{ $institution->name }}</h3>
                                                <p class="text-sm text-gray-400">{{ $institution->slug }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-600">
                                        @if($institution->website_url)
                                            <a href="{{ $institution->website_url }}" target="_blank" class="text-violet-500 hover:underline">
                                                {{ $institution->website_url }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-600 max-w-xs truncate">
                                        {{ $institution->description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($institution->is_verified)
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Verified</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Unverified</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Edit Button --}}
                                            <button onclick='openEdit(@json($institution))'
                                                class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                            {{-- Delete Button --}}
                                            <form method="POST" action="{{ route('admin.institutions.destroy', $institution) }}"
                                                onsubmit="return confirm('Hapus institusi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        Belum ada institusi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $institutions->withQueryString()->links() }}
                </div>
            </div>

        </main>
    </div>

    {{-- MODAL ADD --}}
    <div id="modalAdd" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center">
        <div class="bg-white rounded-3xl shadow-xl p-8 w-full max-w-lg">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Add Institution</h2>
            <form method="POST" action="{{ route('admin.institutions.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 mt-1 focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Website URL</label>
                        <input type="url" name="website_url"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 mt-1 focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Logo URL</label>
                        <input type="url" name="logo_url"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 mt-1 focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 mt-1 focus:outline-none focus:ring-2 focus:ring-violet-300"></textarea>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_verified" value="1" id="add_verified">
                        <label for="add_verified" class="text-sm font-medium text-gray-700">Verified</label>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('modalAdd').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-600 py-3 rounded-2xl font-medium hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-violet-500 text-white py-3 rounded-2xl font-medium hover:bg-violet-600 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="modalEdit" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center">
        <div class="bg-white rounded-3xl shadow-xl p-8 w-full max-w-lg">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Institution</h2>
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit_name" required
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 mt-1 focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Website URL</label>
                        <input type="url" name="website_url" id="edit_website_url"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 mt-1 focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Logo URL</label>
                        <input type="url" name="logo_url" id="edit_logo_url"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 mt-1 focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="edit_description" rows="3"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 mt-1 focus:outline-none focus:ring-2 focus:ring-violet-300"></textarea>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_verified" value="1" id="edit_verified">
                        <label for="edit_verified" class="text-sm font-medium text-gray-700">Verified</label>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-600 py-3 rounded-2xl font-medium hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-violet-500 text-white py-3 rounded-2xl font-medium hover:bg-violet-600 transition">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openEdit(institution) {
        document.getElementById('edit_name').value = institution.name;
        document.getElementById('edit_website_url').value = institution.website_url ?? '';
        document.getElementById('edit_logo_url').value = institution.logo_url ?? '';
        document.getElementById('edit_description').value = institution.description ?? '';
        document.getElementById('edit_verified').checked = institution.is_verified == 1;
        document.getElementById('editForm').action = '/admin/institutions/' + institution.id;
        document.getElementById('modalEdit').classList.remove('hidden');
    }
</script>
@endpush