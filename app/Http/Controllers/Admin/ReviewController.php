<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'course']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhereHas('course', fn($c) => $c->where('title', 'like', '%' . $request->search . '%'))
                  ->orWhere('comment', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total'   => Review::count(),
            'visible' => Review::where('is_visible', true)->count(),
            'hidden'  => Review::where('is_visible', false)->count(),
            'avg'     => round(Review::avg('rating'), 1),
        ];

        return view('admin.reviews', compact('reviews', 'stats'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews')
            ->with('success', 'Review berhasil dihapus.');
    }

    public function toggleVisibility(Review $review)
    {
        $review->update(['is_visible' => !$review->is_visible]);

        return redirect()->route('admin.reviews')
            ->with('success', 'Visibilitas review berhasil diubah.');
    }
}