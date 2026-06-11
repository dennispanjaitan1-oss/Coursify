<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    // ═══════════════════════════════════════════════════
    // DASHBOARD UTAMA
    // ═══════════════════════════════════════════════════
    public function index()
    {
        $user = Auth::user();

        // ── Last enrollment (for "Continue Learning" section) ──────────────
        $lastEnrollment = Enrollment::with(['course.lessons.progresses'])
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if ($lastEnrollment && $lastEnrollment->course) {
            $totalLessons = $lastEnrollment->course->lessons->count();

            $completedLessons = $lastEnrollment->course->lessons
                ->filter(fn($lesson) => $lesson->progresses
                    ->where('user_id', $user->id)
                    ->count() > 0
                )->count();

            $completedLessons = min($completedLessons, $totalLessons);

            $progressPercent = $totalLessons > 0
                ? round(($completedLessons / $totalLessons) * 100)
                : 0;

            // Expose with consistent naming used in the blade
            $lastEnrollment->real_total_lessons     = $totalLessons;
            $lastEnrollment->real_completed_lessons = $completedLessons;
            $lastEnrollment->real_progress_percent  = $progressPercent;
        }

        // ── Stats strip ────────────────────────────────────────────────────
        $stats = [
            'enrolled'     => Enrollment::where('user_id', $user->id)->count(),
            'in_progress'  => Enrollment::where('user_id', $user->id)->where('status', 'active')->count(),
            'completed'    => Enrollment::where('user_id', $user->id)->where('status', 'completed')->count(),
            'certificates' => Certificate::where('user_id', $user->id)->count(),
            'study_hours'  => 0, // Replace with real tracking logic when available
        ];

        // ── My Courses (up to 6, for dashboard grid) ───────────────────────
        $allEnrollments = Enrollment::where('user_id', $user->id)
            ->with(['course.category', 'course.instructors', 'course.lessons.progresses'])
            ->latest()
            ->get();

        $myCourses = $allEnrollments->take(6)->map(function ($enrollment) use ($user) {
            $course       = $enrollment->course;
            $totalLessons = $course?->lessons?->count() ?? 0;

            $completedCount = $course?->lessons
                ->filter(fn($l) => $l->progresses->where('user_id', $user->id)->count() > 0)
                ->count() ?? 0;

            $completedCount = min($completedCount, $totalLessons);
            $progress       = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0;

            // Attach helpers directly to enrollment object for easy blade access
            $enrollment->slug            = $course?->slug;
            $enrollment->progress        = $progress;
            $enrollment->completed_count = $completedCount;
            $enrollment->total_lessons   = $totalLessons;

            return $enrollment;
        });

        // ── Weekly activity (last 7 days) ──────────────────────────────────
        // Replace the stub below with real DB queries if you have a
        // study_sessions / lesson_progresses table with timestamps.
        $weekActivity = collect(range(0, 6))->map(function ($i) {
            $day = Carbon::now()->startOfWeek()->addDays($i);
            return [
                'day'        => $day->format('D'),
                'seconds'    => 0,
                'percentage' => 0,
                'label'      => '0m',
                'is_today'   => $day->isToday(),
            ];
        });

        $weekTotalHours = 0;
        $weekTrend      = null; // Set to int (%) when real data is available
        $weekBreakdown  = ['video' => 0, 'exercise' => 0, 'reading' => 0];

        // ── Up Next (next unfinished lesson per enrolled course) ───────────
        $upNext = $allEnrollments
            ->filter(fn($e) => $e->status !== 'completed')
            ->map(function ($enrollment) use ($user) {
                $course = $enrollment->course;
                if (!$course) return null;

                // Find first lesson the student hasn't completed yet
                $nextLesson = $course->lessons
                    ->first(fn($l) => $l->progresses->where('user_id', $user->id)->count() === 0);

                if (!$nextLesson) return null;

                return [
                    'course_slug'  => $course->slug,
                    'course_title' => $course->title,
                    'lesson_title' => $nextLesson->title,
                    'lesson_type'  => $nextLesson->type ?? 'video', // video|quiz|project|reading
                    'duration'     => $nextLesson->duration
                        ? gmdate('i:s', $nextLesson->duration)
                        : '—',
                ];
            })
            ->filter()
            ->values()
            ->take(5);

        // ── Achievements ──────────────────────────────────────────────────
        $achievements = $this->buildAchievements($user);

        // ── Recommended courses (not yet enrolled) ────────────────────────
        $enrolledCourseIds = $allEnrollments->pluck('course_id');

        $recommended = Course::with(['category', 'instructors', 'institution'])
            ->whereNotIn('id', $enrolledCourseIds)
            ->inRandomOrder()
            ->take(4)
            ->get()
            ->map(function ($course) {
                $instructor = $course->instructors->first();
                $price      = $course->price ?? 0;

                return [
                    'slug'             => $course->slug,
                    'title'            => $course->title,
                    'thumbnail'        => $course->thumbnail_url ?? $course->thumbnail ?? null,
                    'category'         => optional($course->category)->name ?? 'Course',
                    'instructor'       => $instructor?->name ?? 'Instructor',
                    'rating'           => number_format($course->rating ?? 0, 1),
                    'students_count'   => number_format($course->enrollments_count ?? 0),
                    'price'            => $price > 0 ? 'Rp ' . number_format($price, 0, ',', '.') : 'Free',
                    'is_free'          => $price == 0,
                    'emoji'            => '📚',
                    'institution_name' => optional($course->institution)->name ?? 'Coursify',
                    'institution_logo' => optional($course->institution)->logo_url ?? null,
                    'duration_weeks'   => $course->duration_weeks ?? 1,
                    'difficulty'       => ucfirst($course->difficulty ?? 'beginner'),
                ];
            });

        return view('student.index', compact(
            'user',
            'lastEnrollment',
            'stats',
            'myCourses',
            'weekActivity',
            'weekTotalHours',
            'weekTrend',
            'weekBreakdown',
            'upNext',
            'achievements',
            'recommended',
        ));
    }

    // ── Achievement builder ────────────────────────────────────────────────
    private function buildAchievements($user): array
    {
        $achievements = [];

        $completedCount = Enrollment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $enrolledCount = Enrollment::where('user_id', $user->id)->count();

        if ($enrolledCount >= 1) {
            $achievements[] = [
                'icon'        => 'fa-solid fa-rocket',
                'color'       => 'indigo',
                'title'       => 'First Step',
                'description' => 'Enrolled in your first course.',
                'date_label'  => 'Achieved',
            ];
        }

        if ($completedCount >= 1) {
            $achievements[] = [
                'icon'        => 'fa-solid fa-graduation-cap',
                'color'       => 'green',
                'title'       => 'Graduate',
                'description' => 'Completed your first course.',
                'date_label'  => 'Achieved',
            ];
        }

        if ($completedCount >= 3) {
            $achievements[] = [
                'icon'        => 'fa-solid fa-trophy',
                'color'       => 'gold',
                'title'       => 'Hat-trick',
                'description' => 'Completed 3 courses.',
                'date_label'  => 'Achieved',
            ];
        }

        $certCount = Certificate::where('user_id', $user->id)->count();
        if ($certCount >= 1) {
            $achievements[] = [
                'icon'        => 'fa-solid fa-certificate',
                'color'       => 'sky',
                'title'       => 'Certified',
                'description' => 'Earned your first certificate.',
                'date_label'  => 'Achieved',
            ];
        }

        return $achievements;
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
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'bio'          => ['nullable', 'string', 'max:500'],
            'headline'     => ['nullable', 'string', 'max:100'],
            'website_url'  => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
        ]);

        $user->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!',
                'user'    => [
                    'name'         => $user->name,
                    'email'        => $user->email,
                    'initial'      => strtoupper(substr($user->name, 0, 1)),
                    'headline'     => $user->headline,
                    'bio'          => $user->bio,
                    'website_url'  => $user->website_url,
                    'linkedin_url' => $user->linkedin_url,
                ],
            ]);
        }

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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diperbarui!',
            ]);
        }

        return redirect()->route('student.profile')
            ->with('success', 'Password berhasil diperbarui!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');

            // Hapus file avatar lama
            if ($user->avatar_url) {
                $oldPath = str_replace('storage/', '', $user->avatar_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                // Juga hapus dari lokasi lama (public/uploads/avatars/)
                $oldLegacy = public_path($user->avatar_url);
                if (file_exists($oldLegacy)) {
                    @unlink($oldLegacy);
                }
            }

            $avatarUrl = 'storage/' . $path;
            $user->update(['avatar_url' => $avatarUrl]);

            Cache::forget('home_featured_courses');
            Cache::forget('home_promo_courses');
            Cache::forget('home_latest_courses');

            if ($request->expectsJson()) {
                return response()->json([
                    'success'    => true,
                    'message'    => 'Foto profil berhasil diperbarui!',
                    'avatar_url' => asset($avatarUrl),
                ]);
            }

            return back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Gagal mengunggah foto.'], 400);
        }
        return back()->with('error', 'Gagal mengunggah foto.');
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'language'       => ['required', 'string', Rule::in(['id', 'en', 'ja', 'ko'])],
            'timezone'       => ['required', 'string', Rule::in(['Asia/Jakarta', 'Asia/Makassar', 'Asia/Jayapura', 'UTC'])],
            'theme'          => ['required', 'string', Rule::in(['light', 'dark', 'auto'])],
            'playback_speed' => ['required', 'string', Rule::in(['0.5', '0.75', '1', '1.25', '1.5', '2'])],
            'video_quality'  => ['required', 'string', Rule::in(['auto', '1080p', '720p', '480p'])],
        ]);

        $user->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Preferensi berhasil disimpan!',
                'user'    => $user
            ]);
        }

        return redirect()->route('student.profile')
            ->with('success', 'Preferensi berhasil disimpan!');
    }

    /**
     * Permanent user account deletion.
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi tidak valid. Silakan login ulang.'
            ], 401);
        }

        if (!$request->has('confirm_phrase') || trim(strtoupper($request->input('confirm_phrase'))) !== 'DELETE MY ACCOUNT') {
            return response()->json([
                'success' => false,
                'message' => 'Frasa konfirmasi tidak cocok. Harap ketik "DELETE MY ACCOUNT".'
            ], 422);
        }

        $userId = $user->id;
        $userEmail = $user->email;

        try {
            // Log out FIRST to release the session lock
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Clean up any remaining sessions for this user
            DB::table('sessions')->where('user_id', $userId)->delete();

            // Hard delete the user row using Query Builder (bypasses Eloquent issues)
            $deleted = DB::table('users')->where('id', $userId)->delete();

            if ($deleted) {
                Log::info("Account permanently deleted: user_id={$userId}, email={$userEmail}");
            } else {
                Log::warning("Delete account: no rows affected for user_id={$userId}, email={$userEmail}");
            }

            return response()->json([
                'success' => true,
                'message' => 'Akun Anda berhasil dihapus secara permanen. Semua data Anda telah dibersihkan.'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to delete account user_id={$userId}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus akun: ' . $e->getMessage()
            ], 500);
        }
    }
}