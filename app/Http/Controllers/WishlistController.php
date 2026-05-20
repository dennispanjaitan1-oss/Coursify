<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display wishlist page
     */
    public function index(Request $request)
{
    $user   = Auth::user();
    $filter = $request->get('filter', 'all');
    $search = $request->get('search');
    $sort   = $request->get('sort', 'newest');

    // Satu query untuk semua keperluan
    $all = Wishlist::where('user_id', $user->id)
        ->with(['course.category', 'course.instructors'])
        ->latest()
        ->get();

    // Hitung stats dari collection — tidak perlu query kedua
    $stats = [
        'total'       => $all->count(),
        'free'        => $all->filter(fn($w) => optional($w->course)->price == 0)->count(),
        'premium'     => $all->filter(fn($w) => optional($w->course)->price > 0)->count(),
        'saved_value' => $all->sum(fn($w) => optional($w->course)->price ?? 0),
    ];

    // Filter dari collection yang sudah ada
    $wishlists = $all->when($filter === 'free', fn($c) =>
            $c->filter(fn($w) => optional($w->course)->price == 0)
        )
        ->when($filter === 'premium', fn($c) =>
            $c->filter(fn($w) => optional($w->course)->price > 0)
        )
        ->when($search, fn($c) =>
            $c->filter(fn($w) =>
                str_contains(
                    strtolower(optional($w->course)->title ?? ''),
                    strtolower($search)
                )
            )
        );

    // Sort dari collection
    $wishlists = match($sort) {
        'oldest'     => $wishlists->sortBy('created_at'),
        'price_low'  => $wishlists->sortBy(fn($w) => optional($w->course)->price ?? 0),
        'price_high' => $wishlists->sortByDesc(fn($w) => optional($w->course)->price ?? 0),
        'rating'     => $wishlists->sortByDesc(fn($w) => optional($w->course)->rating ?? 0),
        default      => $wishlists->sortByDesc('created_at'), // newest
    };

    return view('student.wishlist', compact('wishlists', 'stats'));
}

    /**
     * Toggle wishlist (add/remove)
     */
    public function toggle(Request $request, $courseId)
{
    $user = Auth::user();

    if (!$user) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized', 'redirect' => route('login')], 401);
        }
        return redirect()->route('login');
    }

    // Validasi course benar-benar ada di database
    $course = Course::findOrFail($courseId);

    $existing = Wishlist::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->withTrashed()
        ->first();

    if ($existing) {
        if ($existing->trashed()) {
            // Restore jika sebelumnya soft-deleted
            $existing->restore();
            return response()->json([
                'status'  => 'added',
                'message' => 'Ditambahkan ke wishlist',
            ]);
        }
        $existing->delete();
        return response()->json([
            'status'  => 'removed',
            'message' => 'Dihapus dari wishlist',
        ]);
    }

    Wishlist::create([
        'user_id'   => $user->id,
        'course_id' => $course->id,
    ]);

    return response()->json([
        'status'  => 'added',
        'message' => 'Ditambahkan ke wishlist',
    ]);
}

    /**
     * Remove from wishlist (AJAX fetch atau form submit)
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();

        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $wishlist->delete();

        // Kalau request dari fetch (AJAX), return JSON
        if ($request->expectsJson() || $request->hasHeader('X-HTTP-Method-Override')) {
            return response()->json([
                'status'  => 'deleted',
                'message' => 'Kursus berhasil dihapus dari wishlist',
            ]);
        }

        return redirect()
            ->route('student.wishlist')
            ->with('success', 'Kursus berhasil dihapus dari wishlist');
    }
}