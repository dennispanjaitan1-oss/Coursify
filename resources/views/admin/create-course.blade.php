@extends('layouts.admin')

@section('content')

<div class="p-8 max-w-3xl mx-auto">

    <div class="bg-white rounded-3xl shadow-md p-10">

        <h1 class="text-3xl font-bold mb-8">
            Create Course
        </h1>

        <form action="{{ route('admin.courses.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-5">
                <label class="block mb-2 font-medium">Title</label>

                <input type="text"
                       name="title"
                        class="w-full border rounded-2xl p-4">
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-medium">Description</label>

                <textarea name="description"
                          rows="5"
                          class="w-full border rounded-2xl p-4"></textarea>
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-medium">Category</label>

                <input type="text"
                       name="category"
                       class="w-full border rounded-2xl p-4">
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-medium">Price</label>

                <input type="number"
                       name="price"
                       class="w-full border rounded-2xl p-4">
            </div>

            <div class="mb-8">
                <label class="block mb-2 font-medium">Thumbnail</label>

                <input type="file"
                       name="thumbnail"
                       class="w-full border rounded-2xl p-4">
            </div>

            <button class="bg-indigo-500 text-white px-6 py-3 rounded-2xl">
                Save Course
            </button>

        </form>

    </div>

</div>

@endsection