{{-- resources/views/admin/courses.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <div class="p-8 space-y-6 flex-1 min-w-0">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Courses Management</h1>
                <p class="text-gray-500 mt-1">Kelola semua course pada platform.</p>
            </div>
            <button
                onclick="document.getElementById('createModal').classList.remove('hidden')"
                class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-3 rounded-2xl shadow-lg transition"
            >
                + Tambah Course
            </button>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTER --}}
        <div class="bg-white rounded-3xl shadow-md p-6">
            <form method="GET" action="{{ route('admin.courses.index') }}"
                  class="grid grid-cols-1 md:grid-cols-5 gap-4">

                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari course..."
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">

                <select name="category_id"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="difficulty"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">Semua Level</option>
                    <option value="beginner"     {{ request('difficulty') == 'beginner'     ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced"     {{ request('difficulty') == 'advanced'     ? 'selected' : '' }}>Advanced</option>
                </select>

                <select name="status"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft"     {{ request('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
                </select>

                <button type="submit" class="w-full bg-gray-800 hover:bg-black text-white px-4 py-3 rounded-2xl">
                    Filter
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1100px]">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left">Thumbnail</th>
                            <th class="px-6 py-4 text-left">Course</th>
                            <th class="px-6 py-4 text-left">Category</th>
                            <th class="px-6 py-4 text-left">Institution</th>
                            <th class="px-6 py-4 text-left">Price</th>
                            <th class="px-6 py-4 text-left">Level</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr class="border-b hover:bg-gray-50 transition">

                                {{-- THUMBNAIL --}}
                                <td class="px-6 py-4">
                                    @if($course->thumbnail_url)
                                        <img src="{{ $course->thumbnail_url }}"
                                             class="w-20 h-14 rounded-xl object-cover">
                                    @else
                                        <div class="w-20 h-14 rounded-xl bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                            No Image
                                        </div>
                                    @endif
                                </td>

                                {{-- TITLE --}}
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">{{ $course->title }}</div>
                                    <div class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $course->short_description }}</div>
                                    <div class="text-xs text-gray-400 mt-2">
                                        {{ $course->sections_count }} sections •
                                        {{ $course->enrollments_count }} students
                                    </div>
                                </td>

                                {{-- CATEGORY --}}
                                <td class="px-6 py-4">{{ $course->category?->name ?? '-' }}</td>

                                {{-- INSTITUTION --}}
                                <td class="px-6 py-4">{{ $course->institution?->name ?? '-' }}</td>

                                {{-- PRICE --}}
                                <td class="px-6 py-4 font-semibold text-orange-600">
                                    Rp {{ number_format($course->price, 0, ',', '.') }}
                                </td>

                                {{-- LEVEL --}}
                                <td class="px-6 py-4 capitalize">{{ $course->difficulty }}</td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4">
                                    @if($course->is_published)
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Published</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                                    @endif
                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- TOGGLE STATUS --}}
                                        <form action="{{ route('admin.courses.toggle-publish', $course->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded-xl text-sm">
                                                Toggle
                                            </button>
                                        </form>

                                        {{-- EDIT — kirim semua data via json_encode (aman untuk spasi & kutip) --}}
                                        <button
                                            onclick="openEditModal({{ json_encode([
                                                'id'                => $course->id,
                                                'title'             => $course->title,
                                                'category_id'       => $course->category_id,
                                                'institution_id'    => $course->institution_id,
                                                'program_id'        => $course->program_id,
                                                'price'             => $course->price,
                                                'duration_weeks'    => $course->duration_weeks,
                                                'difficulty'        => $course->difficulty,
                                                'language'          => $course->language,
                                                'thumbnail_url'     => $course->thumbnail_url,
                                                'preview_video_url' => $course->preview_video_url,
                                                'short_description' => $course->short_description,
                                                'description'       => $course->description,
                                                'is_published'      => $course->is_published,
                                            ]) }})"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-xl text-sm"
                                        >
                                            Edit
                                        </button>

                                        {{-- DELETE --}}
                                        <form action="{{ route('admin.courses.destroy', $course->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus course ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-sm">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12 text-gray-500">
                                    Belum ada course.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="p-6 border-t">
                {{ $courses->links() }}
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════════════ --}}
{{-- CREATE MODAL                                              --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div id="createModal"
     class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-6"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="bg-white w-full max-w-4xl rounded-3xl p-8 overflow-y-auto max-h-[95vh]">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Tambah Course</h2>
            <button onclick="document.getElementById('createModal').classList.add('hidden')"
                    class="text-gray-500 hover:text-black text-2xl leading-none">×</button>
        </div>

        <form action="{{ route('admin.courses.store') }}" method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            {{-- TITLE --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" required
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- CATEGORY --}}
            <div>
                <label class="block font-semibold mb-2">Category <span class="text-red-500">*</span></label>
                <select name="category_id" required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    <option value="">Pilih Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- INSTITUTION --}}
            <div>
                <label class="block font-semibold mb-2">Institution <span class="text-red-500">*</span></label>
                <select name="institution_id" required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    <option value="">Pilih Institution</option>
                    @foreach($institutions as $institution)
                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- PROGRAM --}}
            <div>
                <label class="block font-semibold mb-2">Program</label>
                <select name="program_id"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    <option value="">Pilih Program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- PRICE --}}
            <div>
                <label class="block font-semibold mb-2">Price <span class="text-red-500">*</span></label>
                <input type="number" name="price" required min="0"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- DURATION --}}
            <div>
                <label class="block font-semibold mb-2">Duration (Weeks) <span class="text-red-500">*</span></label>
                <input type="number" name="duration_weeks" required min="1"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- DIFFICULTY --}}
            <div>
                <label class="block font-semibold mb-2">Difficulty <span class="text-red-500">*</span></label>
                <select name="difficulty" required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>

            {{-- LANGUAGE --}}
            <div>
                <label class="block font-semibold mb-2">Language <span class="text-red-500">*</span></label>
                <input type="text" name="language" value="id" required
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- THUMBNAIL --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Thumbnail URL</label>
                <input type="url" name="thumbnail_url"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- VIDEO --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Preview Video URL</label>
                <input type="url" name="preview_video_url"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- SHORT DESCRIPTION --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Short Description</label>
                <textarea name="short_description" rows="3"
                          placeholder="Ringkasan singkat kursus..."
                          class="w-full border border-gray-300 rounded-2xl px-4 py-3 resize-y"></textarea>
            </div>

            {{-- DESCRIPTION --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Description</label>
                <textarea name="description" rows="6"
                          placeholder="Deskripsi lengkap kursus, materi yang dipelajari, prasyarat, dll..."
                          class="w-full border border-gray-300 rounded-2xl px-4 py-3 resize-y"></textarea>
            </div>

            {{-- PUBLISHED --}}
            <div class="md:col-span-2 flex items-center gap-3">
                <input type="checkbox" name="is_published" value="1" id="create_is_published">
                <label for="create_is_published">Publish sekarang</label>
            </div>

            {{-- BUTTON --}}
            <div class="md:col-span-2 flex justify-end">
                <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-2xl">
                    Simpan Course
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════ --}}
{{-- EDIT MODAL                                                --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div id="editModal"
     class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-6"
     onclick="if(event.target===this) closeEditModal()">

    <div class="bg-white w-full max-w-4xl rounded-3xl p-8 overflow-y-auto max-h-[95vh]">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Edit Course</h2>
            <button onclick="closeEditModal()"
                    class="text-gray-500 hover:text-black text-2xl leading-none">×</button>
        </div>

        <form id="editForm" method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            {{-- TITLE --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="edit_title" required
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- CATEGORY --}}
            <div>
                <label class="block font-semibold mb-2">Category <span class="text-red-500">*</span></label>
                <select name="category_id" id="edit_category_id" required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    <option value="">Pilih Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- INSTITUTION --}}
            <div>
                <label class="block font-semibold mb-2">Institution <span class="text-red-500">*</span></label>
                <select name="institution_id" id="edit_institution_id" required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    <option value="">Pilih Institution</option>
                    @foreach($institutions as $institution)
                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- PROGRAM --}}
            <div>
                <label class="block font-semibold mb-2">Program</label>
                <select name="program_id" id="edit_program_id"
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    <option value="">Pilih Program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- PRICE --}}
            <div>
                <label class="block font-semibold mb-2">Price <span class="text-red-500">*</span></label>
                <input type="number" name="price" id="edit_price" required min="0"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- DURATION --}}
            <div>
                <label class="block font-semibold mb-2">Duration (Weeks) <span class="text-red-500">*</span></label>
                <input type="number" name="duration_weeks" id="edit_duration_weeks" required min="1"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- DIFFICULTY --}}
            <div>
                <label class="block font-semibold mb-2">Difficulty <span class="text-red-500">*</span></label>
                <select name="difficulty" id="edit_difficulty" required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>

            {{-- LANGUAGE --}}
            <div>
                <label class="block font-semibold mb-2">Language <span class="text-red-500">*</span></label>
                <input type="text" name="language" id="edit_language" required
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- THUMBNAIL --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Thumbnail URL</label>
                <input type="url" name="thumbnail_url" id="edit_thumbnail_url"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- VIDEO --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Preview Video URL</label>
                <input type="url" name="preview_video_url" id="edit_preview_video_url"
                       class="w-full border border-gray-300 rounded-2xl px-4 py-3">
            </div>

            {{-- SHORT DESCRIPTION --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Short Description</label>
                <textarea name="short_description" id="edit_short_description" rows="3"
                          placeholder="Ringkasan singkat kursus..."
                          class="w-full border border-gray-300 rounded-2xl px-4 py-3 resize-y"></textarea>
            </div>

            {{-- DESCRIPTION — textarea bisa panjang & spasi --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-2">Description</label>
                <textarea name="description" id="edit_description" rows="8"
                          placeholder="Deskripsi lengkap kursus..."
                          class="w-full border border-gray-300 rounded-2xl px-4 py-3 resize-y"></textarea>
            </div>

            {{-- IS PUBLISHED --}}
            <div class="md:col-span-2 flex items-center gap-3">
                <input type="checkbox" name="is_published" id="edit_is_published" value="1">
                <label for="edit_is_published">Publish sekarang</label>
            </div>

            {{-- BUTTONS --}}
            <div class="md:col-span-2 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()"
                        class="px-6 py-3 rounded-2xl border border-gray-300 text-gray-600 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-2xl">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
/**
 * Buka modal edit — terima object JSON dari blade (json_encode).
 * Aman untuk teks panjang, spasi, tanda kutip, newline.
 */
function openEditModal(data) {
    const form = document.getElementById('editForm');

    // Set action URL ke route update course yang benar
    form.action = '/admin/courses/' + data.id;

    // Isi input fields
    document.getElementById('edit_title').value             = data.title             ?? '';
    document.getElementById('edit_price').value             = data.price             ?? 0;
    document.getElementById('edit_duration_weeks').value    = data.duration_weeks    ?? 1;
    document.getElementById('edit_language').value          = data.language          ?? '';
    document.getElementById('edit_thumbnail_url').value     = data.thumbnail_url     ?? '';
    document.getElementById('edit_preview_video_url').value = data.preview_video_url ?? '';

    // Textarea — gunakan .value bukan .innerHTML supaya spasi & newline tetap ada
    document.getElementById('edit_short_description').value = data.short_description ?? '';
    document.getElementById('edit_description').value       = data.description       ?? '';

    // Checkbox published
    document.getElementById('edit_is_published').checked = !!data.is_published;

    // Select fields
    setSelect('edit_category_id',    data.category_id);
    setSelect('edit_institution_id', data.institution_id);
    setSelect('edit_program_id',     data.program_id);
    setSelect('edit_difficulty',     data.difficulty);

    // Tampilkan modal
    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function setSelect(id, value) {
    const el = document.getElementById(id);
    if (!el || value == null) return;
    for (const opt of el.options) {
        opt.selected = (String(opt.value) === String(value));
    }
}
</script>

@endsection