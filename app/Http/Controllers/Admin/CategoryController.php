<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with search and course count.
     */
    public function index(Request $request)
    {
        $query = Category::withCount('courses');

        // Search by name
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter parent only or all
        if ($request->get('type') === 'parent') {
            $query->whereNull('parent_id');
        }

        $categories = $query->orderBy('name')->paginate(15)->withQueryString();

        $stats = [
            'total'        => Category::count(),
            'total_courses' => \App\Models\Course::count(),
            'parent'       => Category::whereNull('parent_id')->count(),
            'sub'          => Category::whereNotNull('parent_id')->count(),
        ];

        return view('admin.categories', compact('categories', 'stats'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255', 'unique:categories,name'],
            'icon'      => ['nullable', 'string', 'max:10'],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ]);

        Category::create([
            'name'      => $validated['name'],
            'slug'      => Str::slug($validated['name']),
            'icon'      => $validated['icon'] ?? '📁',
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255', 'unique:categories,name,' . $id],
            'icon'      => ['nullable', 'string', 'max:10'],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ]);

        // Prevent category from being its own parent
        if ($validated['parent_id'] == $id) {
            return back()->with('error', 'Kategori tidak bisa menjadi parent dirinya sendiri.');
        }

        $category->update([
            'name'      => $validated['name'],
            'slug'      => Str::slug($validated['name']),
            'icon'      => $validated['icon'] ?? $category->icon,
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(string $id)
    {
        $category = Category::withCount('courses')->findOrFail($id);

        if ($category->courses_count > 0) {
            return back()->with('error', "Tidak bisa menghapus kategori \"{$category->name}\" karena masih memiliki {$category->courses_count} kursus.");
        }

        $category->delete();

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}