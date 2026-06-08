<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;

class ApprovalController extends Controller
{
    public function index()
    {
        $pending = Course::with(['instructors', 'category', 'institution'])
            ->pendingApproval()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $pendingCount = Course::pendingApproval()->count();

        return view('admin.approvals', compact('pending', 'pendingCount'));
    }

    public function approve(Course $course)
    {
        $course->update(['is_published' => true]);

        return redirect()->route('admin.approvals')
            ->with('success', "Course \"{$course->title}\" berhasil di-approve.");
    }

    public function reject(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.approvals')
            ->with('success', "Course \"{$course->title}\" berhasil di-reject.");
    }
}
