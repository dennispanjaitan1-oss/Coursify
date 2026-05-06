<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    // ═══════════════════════════════════════════════════
    // DASHBOARD UTAMA
    // ═══════════════════════════════════════════════════
    public function index()
    {
        $user = Auth::user();

        $enrollments = Enrollment::where('user_id', $user->id)
            ->with(['course.category', 'course.instructors'])
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'enrolled'     => Enrollment::where('user_id', $user->id)->count(),
            'in_progress'  => Enrollment::where('user_id', $user->id)->where('status', 'active')->count(),
            'completed'    => Enrollment::where('user_id', $user->id)->where('status', 'completed')->count(),
            'certificates' => Certificate::where('user_id', $user->id)->count(),
        ];

        return view('student.index', compact('enrollments', 'stats'));
    }

    // ═══════════════════════════════════════════════════
    // MY COURSES
    // ═══════════════════════════════════════════════════
    public function myCourses(Request $request)
    {
        $user = Auth::user();

        $query = Enrollment::where('user_id', $user->id)
            ->with(['course.category', 'course.instructors']);

        $filter = $request->get('filter', 'all');
        if ($filter === 'in_progress') {
            $query->where('status', 'active')->where('progress_percent', '>', 0);
        } elseif ($filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($filter === 'not_started') {
            $query->where('progress_percent', 0);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('course', fn($q) => $q->where('title', 'LIKE', "%{$search}%"));
        }

        $enrollments = $query->latest()->paginate(12);

        $allEnrollments = Enrollment::where('user_id', $user->id)->get();
        $stats = [
            'total'       => $allEnrollments->count(),
            'in_progress' => $allEnrollments->where('status', 'active')->where('progress_percent', '>', 0)->count(),
            'completed'   => $allEnrollments->where('status', 'completed')->count(),
            'not_started' => $allEnrollments->where('progress_percent', 0)->count(),
        ];

        return view('student.courses', compact('enrollments', 'stats'));
    }

    // ═══════════════════════════════════════════════════
    // CERTIFICATES
    // ═══════════════════════════════════════════════════
    public function certificates(Request $request)
    {
        $user = Auth::user();

        $query = Certificate::where('user_id', $user->id)
            ->with(['course.category', 'course.instructors']);

        $filter = $request->get('filter', 'all');
        if ($filter === 'this_year') {
            $query->whereYear('issued_at', now()->year);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('course', fn($q) => $q->where('title', 'LIKE', "%{$search}%"));
        }

        $certificates = $query->latest('issued_at')->get();

        $allCerts = Certificate::where('user_id', $user->id)->with('course')->get();
        $stats = [
            'total'         => $allCerts->count(),
            'this_year'     => $allCerts->filter(fn($c) => $c->issued_at && $c->issued_at->year == now()->year)->count(),
            'hours_learned' => $allCerts->sum(fn($c) => ($c->course->duration_weeks ?? 0) * 5),
            'avg_score'     => 92,
        ];

        return view('student.certificates', compact('certificates', 'stats'));
    }

    // ═══════════════════════════════════════════════════
    // WISHLIST
    // ═══════════════════════════════════════════════════
    public function wishlist(Request $request)
    {
        $user = Auth::user();

        $query = Wishlist::where('user_id', $user->id)
            ->with(['course.category', 'course.instructors']);

        $filter = $request->get('filter', 'all');
        if ($filter === 'free') {
            $query->whereHas('course', fn($q) => $q->where('price', 0));
        } elseif ($filter === 'premium') {
            $query->whereHas('course', fn($q) => $q->where('price', '>', 0));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('course', fn($q) => $q->where('title', 'LIKE', "%{$search}%"));
        }

        $wishlists = $query->latest()->get();

        $allWishlists = Wishlist::where('user_id', $user->id)->with('course')->get();
        $stats = [
            'total'       => $allWishlists->count(),
            'free'        => $allWishlists->filter(fn($w) => optional($w->course)->price == 0)->count(),
            'premium'     => $allWishlists->filter(fn($w) => optional($w->course)->price > 0)->count(),
            'saved_value' => $allWishlists->sum(fn($w) => optional($w->course)->price ?? 0),
        ];

        return view('student.wishlist', compact('wishlists', 'stats'));
    }

    // ═══════════════════════════════════════════════════
    // PROFILE SETTINGS
    // ═══════════════════════════════════════════════════
    public function profile()
    {
        return view('student.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'bio'      => ['nullable', 'string', 'max:500'],
            'headline' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($validated);

        return redirect()->route('student.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('student.profile')
            ->with('success', 'Password berhasil diperbarui!');
    }
}