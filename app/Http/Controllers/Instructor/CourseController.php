<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::whereHas('instructors', function ($q) {
                        $q->where('user_id', Auth::id());
                    })
                    ->withCount(['enrollments', 'reviews'])
                    ->withAvg('reviews', 'rating')
                    ->latest()
                    ->paginate(12);

        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('instructor.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'category_id'         => 'required|exists:categories,id',
            'short_description'   => 'nullable|string|max:500',
            'description'         => 'nullable|string',
            'prerequisites'       => 'nullable|string|max:2000',
            'price'               => 'required|numeric|min:0',
            'certificate_price'   => 'nullable|numeric|min:0',
            'difficulty'          => 'required|in:beginner,intermediate,advanced',
            'duration_weeks'      => 'required|integer|min:1|max:200',
            'language'            => 'required|string|max:50',
            'thumbnail'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'preview_video'       => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:102400',
            'has_audit_track'     => 'nullable|boolean',
            'audit_access_weeks'  => 'nullable|integer|min:1|max:52',
            'upgrade_deadline'    => 'nullable|date|after:today',
            'is_self_paced'       => 'nullable|boolean',
            'has_certificate'     => 'nullable|boolean',
            'hours_per_week'      => 'nullable|string|max:50',
            'start_date'          => 'nullable|date',
            'enroll_deadline'     => 'nullable|date',
            'translations'        => 'nullable|string|max:255',
            'transcripts'         => 'nullable|string|max:255',
        ]);

        $validated['slug']            = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['has_audit_track'] = $request->boolean('has_audit_track');
        $validated['is_self_paced']   = $request->boolean('is_self_paced');
        $validated['has_certificate'] = $request->boolean('has_certificate');
        $validated['is_published']    = $request->input('action') === 'publish';

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $validated['thumbnail_url'] = asset('storage/' . $path);
        }
        if ($request->hasFile('preview_video')) {
            $path = $request->file('preview_video')->store('courses/videos', 'public');
            $validated['preview_video_url'] = asset('storage/' . $path);
        }

        $institutionId = Auth::user()->institution_id
            ?? Institution::query()->value('id');

        if (!$institutionId) {
            return back()->withInput()->with('error', 'Belum ada institution yang tersedia.');
        }

        $validated['institution_id'] = $institutionId;

        $course = Course::create($validated);
        $course->instructors()->attach(Auth::id(), ['role' => 'lead']);

        return redirect()
            ->route('instructor.courses.show', $course)
            ->with('success', 'Kursus berhasil dibuat! Sekarang tambahkan curriculum dan konten kursus.');
    }

    public function show(Course $course)
    {
        $this->authorizeInstructor($course);

        $course->load([
            'category',
            'sections.lessons.quizzes',
            'syllabus',
            'enrollments',
        ])->loadCount(['enrollments', 'reviews'])
          ->loadAvg('reviews', 'rating');

        $totalLessons  = $course->sections->flatMap->lessons->count();
        $totalDuration = $course->sections->flatMap->lessons->sum('duration_seconds');

        return view('instructor.courses.show', compact('course', 'totalLessons', 'totalDuration'));
    }

    public function edit(Course $course)
    {
        $this->authorizeInstructor($course);
        $categories = Category::orderBy('name')->get();
        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeInstructor($course);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'category_id'         => 'required|exists:categories,id',
            'short_description'   => 'nullable|string|max:500',
            'description'         => 'nullable|string',
            'prerequisites'       => 'nullable|string|max:2000',
            'price'               => 'required|numeric|min:0',
            'certificate_price'   => 'nullable|numeric|min:0',
            'difficulty'          => 'required|in:beginner,intermediate,advanced',
            'duration_weeks'      => 'required|integer|min:1|max:200',
            'language'            => 'required|string|max:50',
            'thumbnail'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'preview_video'       => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:102400',
            'has_audit_track'     => 'nullable|boolean',
            'audit_access_weeks'  => 'nullable|integer|min:1|max:52',
            'upgrade_deadline'    => 'nullable|date',
            'is_self_paced'       => 'nullable|boolean',
            'has_certificate'     => 'nullable|boolean',
            'hours_per_week'      => 'nullable|string|max:50',
            'start_date'          => 'nullable|date',
            'enroll_deadline'     => 'nullable|date',
            'translations'        => 'nullable|string|max:255',
            'transcripts'         => 'nullable|string|max:255',
        ]);

        $validated['has_audit_track'] = $request->boolean('has_audit_track');
        $validated['is_self_paced']   = $request->boolean('is_self_paced');
        $validated['has_certificate'] = $request->boolean('has_certificate');

        if ($request->has('action')) {
            $validated['is_published'] = $request->input('action') === 'publish';
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $validated['thumbnail_url'] = asset('storage/' . $path);
        }
        if ($request->hasFile('preview_video')) {
            $path = $request->file('preview_video')->store('courses/videos', 'public');
            $validated['preview_video_url'] = asset('storage/' . $path);
        }

        $course->update($validated);

        return redirect()
            ->route('instructor.courses.show', $course)
            ->with('success', 'Kursus berhasil diperbarui!');
    }

    public function destroy(Course $course)
    {
        $this->authorizeInstructor($course);
        $course->delete();
        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Kursus berhasil dihapus.');
    }

    private function authorizeInstructor(Course $course): void
    {
        $isOwner = $course->instructors()->where('user_id', Auth::id())->exists();
        abort_if(Auth::user()->role !== 'admin' && !$isOwner, 403, 'Anda tidak punya akses ke kursus ini.');
    }
}
