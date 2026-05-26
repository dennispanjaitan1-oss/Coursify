{{-- resources/views/admin/courses.blade.php --}}

@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <div class="flex-1 p-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Courses Management
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola semua course pada platform.
                </p>
            </div>

            <button
                onclick="document.getElementById('createModal').classList.remove('hidden')"
                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-2xl shadow-lg transition"
            >
                + Tambah Course
            </button>

        </div>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>
        @endif

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

                                    <img
                                        src="{{ $course->thumbnail_url }}"
                                        class="w-24 h-16 rounded-xl object-cover"
                                    >

                                @else

                                    <div class="w-24 h-16 rounded-xl bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                        No Image
                                    </div>

                                @endif

                            </td>

                            {{-- COURSE --}}
                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-800">
                                    {{ $course->title }}
                                </div>

                                <div class="text-sm text-gray-500 mt-1 line-clamp-2">
                                    {{ $course->short_description }}
                                </div>

                            </td>

                            {{-- CATEGORY --}}
                            <td class="px-6 py-4">
                                {{ $course->category?->name ?? '-' }}
                            </td>

                            {{-- INSTITUTION --}}
                            <td class="px-6 py-4">
                                {{ $course->institution?->name ?? '-' }}
                            </td>

                            {{-- PRICE --}}
                            <td class="px-6 py-4 font-semibold text-orange-600">
                                {{ $course->formatted_price }}
                            </td>

                            {{-- LEVEL --}}
                            <td class="px-6 py-4 capitalize">
                                {{ $course->difficulty }}
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">

                                @if($course->is_published)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Published
                                    </span>

                                @else

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Draft
                                    </span>

                                @endif

                            </td>

                            {{-- ACTION --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- EDIT --}}
                                    <button
                                        onclick="openEditModal(
                                            '{{ route('admin.courses.update', $course) }}',
                                            '{{ $course->title }}',
                                            '{{ $course->short_description }}',
                                            '{{ $course->price }}',
                                            '{{ $course->category_id }}',
                                            '{{ $course->institution_id }}',
                                            '{{ $course->difficulty }}',
                                            '{{ $course->thumbnail_url }}',
                                            '{{ $course->is_published }}'
                                        )"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm"
                                    >
                                        Edit
                                    </button>

                                    {{-- DELETE --}}
                                    <form
                                        action="{{ route('admin.courses.destroy', $course) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus course ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm"
                                        >
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

{{-- ================================================= --}}
{{-- CREATE MODAL --}}
{{-- ================================================= --}}
<div
    id="createModal"
    class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-6"
>

    <div class="bg-white w-full max-w-4xl rounded-3xl p-8 overflow-y-auto max-h-[95vh]">

        <div class="flex items-center justify-between mb-6">

            <h2 class="text-2xl font-bold">
                Tambah Course
            </h2>

            <button
                onclick="document.getElementById('createModal').classList.add('hidden')"
                class="text-3xl text-gray-500 hover:text-black"
            >
                ×
            </button>

        </div>

        <form
            action="{{ route('admin.courses.store') }}"
            method="POST"
            class="grid grid-cols-1 md:grid-cols-2 gap-6"
        >

            @csrf

            {{-- TITLE --}}
            <div class="md:col-span-2">
                <label class="block mb-2 font-semibold">Title</label>

                <input
                    type="text"
                    name="title"
                    required
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >
            </div>

            {{-- CATEGORY --}}
            <div>
                <label class="block mb-2 font-semibold">Category</label>

                <select
                    name="category_id"
                    required
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- INSTITUTION --}}
            <div>
                <label class="block mb-2 font-semibold">Institution</label>

                <select
                    name="institution_id"
                    required
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >

                    @foreach($institutions as $institution)
                        <option value="{{ $institution->id }}">
                            {{ $institution->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- PRICE --}}
            <div>
                <label class="block mb-2 font-semibold">Price</label>

                <input
                    type="number"
                    name="price"
                    required
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >
            </div>

            {{-- LEVEL --}}
            <div>
                <label class="block mb-2 font-semibold">Difficulty</label>

                <select
                    name="difficulty"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>

            {{-- THUMBNAIL --}}
            <div class="md:col-span-2">
                <label class="block mb-2 font-semibold">Thumbnail URL</label>

                <input
                    type="text"
                    name="thumbnail_url"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >
            </div>

            {{-- DESCRIPTION --}}
            <div class="md:col-span-2">
                <label class="block mb-2 font-semibold">Short Description</label>

                <textarea
                    name="short_description"
                    rows="4"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                ></textarea>
            </div>

            {{-- PUBLISH --}}
            <div class="md:col-span-2 flex items-center gap-3">

                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                >

                <label>Publish sekarang</label>

            </div>

            {{-- BUTTON --}}
            <div class="md:col-span-2 flex justify-end">

                <button
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-2xl"
                >
                    Simpan Course
                </button>

            </div>

        </form>

    </div>

</div>

{{-- ================================================= --}}
{{-- EDIT MODAL --}}
{{-- ================================================= --}}
<div
    id="editModal"
    class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-6"
>

    <div class="bg-white w-full max-w-4xl rounded-3xl p-8 overflow-y-auto max-h-[95vh]">

        <div class="flex items-center justify-between mb-6">

            <h2 class="text-2xl font-bold">
                Edit Course
            </h2>

            <button
                onclick="document.getElementById('editModal').classList.add('hidden')"
                class="text-3xl text-gray-500 hover:text-black"
            >
                ×
            </button>

        </div>

        <form
            id="editForm"
            method="POST"
            class="grid grid-cols-1 md:grid-cols-2 gap-6"
        >

            @csrf
            @method('PUT')

            {{-- TITLE --}}
            <div class="md:col-span-2">
                <label class="block mb-2 font-semibold">Title</label>

                <input
                    type="text"
                    name="title"
                    id="editTitle"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >
            </div>

            {{-- CATEGORY --}}
            <div>
                <label class="block mb-2 font-semibold">Category</label>

                <select
                    name="category_id"
                    id="editCategory"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- INSTITUTION --}}
            <div>
                <label class="block mb-2 font-semibold">Institution</label>

                <select
                    name="institution_id"
                    id="editInstitution"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >

                    @foreach($institutions as $institution)
                        <option value="{{ $institution->id }}">
                            {{ $institution->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- PRICE --}}
            <div>
                <label class="block mb-2 font-semibold">Price</label>

                <input
                    type="number"
                    name="price"
                    id="editPrice"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >
            </div>

            {{-- LEVEL --}}
            <div>
                <label class="block mb-2 font-semibold">Difficulty</label>

                <select
                    name="difficulty"
                    id="editDifficulty"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>

            {{-- THUMBNAIL --}}
            <div class="md:col-span-2">
                <label class="block mb-2 font-semibold">Thumbnail URL</label>

                <input
                    type="text"
                    name="thumbnail_url"
                    id="editThumbnail"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                >
            </div>

            {{-- DESCRIPTION --}}
            <div class="md:col-span-2">
                <label class="block mb-2 font-semibold">Short Description</label>

                <textarea
                    name="short_description"
                    id="editDescription"
                    rows="4"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                ></textarea>
            </div>

            {{-- PUBLISHED --}}
            <div class="md:col-span-2 flex items-center gap-3">

                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    id="editPublished"
                >

                <label>Published</label>

            </div>

            {{-- BUTTON --}}
            <div class="md:col-span-2 flex justify-end">

                <button
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-2xl"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

{{-- ================================================= --}}
{{-- SCRIPT --}}
{{-- ================================================= --}}
<script>

function openEditModal(
    url,
    title,
    description,
    price,
    category,
    institution,
    difficulty,
    thumbnail,
    published
) {

    document.getElementById('editModal').classList.remove('hidden');

    document.getElementById('editForm').action = url;

    document.getElementById('editTitle').value = title;
    document.getElementById('editDescription').value = description;
    document.getElementById('editPrice').value = price;

    document.getElementById('editCategory').value = category;
    document.getElementById('editInstitution').value = institution;
    document.getElementById('editDifficulty').value = difficulty;

    document.getElementById('editThumbnail').value = thumbnail;

    document.getElementById('editPublished').checked = published == 1;
}

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

document.getElementById('createModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

</script>

@endsection