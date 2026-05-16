<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        $query = Institution::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_verified', $request->status === 'verified' ? true : false);
        }

        $institutions = $query->orderBy('name')->paginate(10);

        return view('admin.institutions', compact('institutions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'website_url' => 'nullable|url',
            'logo_url'    => 'nullable|url',
            'description' => 'nullable|string',
            'is_verified' => 'boolean',
        ]);

        Institution::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'website_url' => $request->website_url,
            'logo_url'    => $request->logo_url,
            'description' => $request->description,
            'is_verified' => $request->boolean('is_verified'),
        ]);

        return redirect()->route('admin.institutions')->with('success', 'Institution berhasil ditambahkan.');
    }

    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'website_url' => 'nullable|url',
            'logo_url'    => 'nullable|url',
            'description' => 'nullable|string',
            'is_verified' => 'boolean',
        ]);

        $institution->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'website_url' => $request->website_url,
            'logo_url'    => $request->logo_url,
            'description' => $request->description,
            'is_verified' => $request->boolean('is_verified'),
        ]);

        return redirect()->route('admin.institutions')->with('success', 'Institution berhasil diupdate.');
    }

    public function destroy(Institution $institution)
    {
        $institution->delete();
        return redirect()->route('admin.institutions')->with('success', 'Institution berhasil dihapus.');
    }
}