<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users with search, filter, and pagination.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        // Filter by status (email_verified_at as proxy for active)
        if ($status = $request->get('status')) {
            if ($status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDir   = $request->get('dir', 'desc');
        $allowedSorts = ['name', 'email', 'role', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $users = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total'       => User::count(),
            'students'    => User::where('role', 'student')->count(),
            'instructors' => User::where('role', 'instructor')->count(),
            'admins'      => User::where('role', 'admin')->count(),
        ];

        return view('admin.users', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users-create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'role'     => ['required', Rule::in(['student', 'instructor', 'admin'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        $user = User::with(['enrollments', 'coursesTaught', 'reviews', 'certificates'])
                    ->findOrFail($id);

        return view('admin.users-show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users-edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'     => ['required', Rule::in(['student', 'instructor', 'admin'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil dihapus.');
    }
}