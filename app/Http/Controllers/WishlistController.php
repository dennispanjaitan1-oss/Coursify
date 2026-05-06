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
        $user = Auth::user();

        $wishlists = collect();
        $stats = [
            'total'   => 0,
            'free'    => 0,
            'premium' => 0,
            'saved_value' => 0,
        ];

        try {
            $query = Wishlist::where('user_id', $user->id)
                ->with(['course.category', 'course.instructors']);

            // Filter
            $filter = $request->get('filter', 'all');
            if ($filter === 'free') {
                $query->whereHas('course', function($q) {
                    $q->where('price', 0);
                });
            } elseif ($filter === 'premium') {
                $query->whereHas('course', function($q) {
                    $q->where('price', '>', 0);
                });
            }

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('course', function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            }

            $wishlists = $query->latest()->get();

            // Stats
            $allWishlists = Wishlist::where('user_id', $user->id)
                ->with('course')->get();

            $stats['total']       = $allWishlists->count();
            $stats['free']        = $allWishlists->filter(fn($w) => optional($w->course)->price == 0)->count();
            $stats['premium']     = $allWishlists->filter(fn($w) => optional($w->course)->price > 0)->count();
            $stats['saved_value'] = $allWishlists->sum(fn($w) => optional($w->course)->price ?? 0);

        } catch (\Exception $e) {
            $wishlists = collect();
        }

        return view('student.wishlist', compact('wishlists', 'stats'));
    }

    /**
     * Toggle wishlist (add/remove)
     */
    public function toggle(Request $request, $courseId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $existing = Wishlist::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();

            if ($existing) {
                $existing->delete();
                return response()->json([
                    'status' => 'removed',
                    'message' => 'Removed from wishlist',
                ]);
            }

            Wishlist::create([
                'user_id'   => $user->id,
                'course_id' => $courseId,
            ]);

            return response()->json([
                'status' => 'added',
                'message' => 'Added to wishlist',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove from wishlist (form submit)
     */
    public function destroy($id)
    {
        $user = Auth::user();

        try {
            Wishlist::where('id', $id)
                ->where('user_id', $user->id)
                ->delete();

            return redirect()
                ->route('student.wishlist')
                ->with('success', 'Course removed from wishlist');
        } catch (\Exception $e) {
            return redirect()
                ->route('student.wishlist')
                ->with('error', 'Failed to remove course');
        }
    }
}