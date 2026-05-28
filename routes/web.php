<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProgramController;

use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\LearningController;

use App\Http\Controllers\Instructor\DashboardController as InstructorDashboard;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// ═══════════════════════════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::middleware('auth')->get('/courses/{course:slug}/choose-path', [CourseController::class, 'choosePath'])
    ->name('courses.choose-path');

Route::get('/courses/{course:slug}', [CourseController::class, 'show'])
    ->name('courses.show');

Route::middleware('auth')->group(function () {
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/confirmation/{payment}', [PaymentController::class, 'confirmation'])->name('payment.confirmation');
});

Route::get('/verify/{certificateNumber}', [CertificateController::class, 'verify'])
    ->name('certificates.verify');

Route::get('/verify', function (\Illuminate\Http\Request $req) {
    if ($req->has('number')) {
        return redirect()->route('certificates.verify', $req->number);
    }
    return redirect()->route('home');
})->name('certificates.verify.form');

// ═══════════════════════════════════════════════════════════
// AUTH
// ═══════════════════════════════════════════════════════════
use App\Http\Controllers\Auth\GoogleAuthController;

Route::get('/auth/google',          [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
Route::get('/auth/google/complete-profile', [GoogleAuthController::class, 'showCompleteProfile'])->name('auth.google.complete');
Route::post('/auth/google/complete-profile', [GoogleAuthController::class, 'completeProfile'])->name('auth.google.complete.post');

require __DIR__.'/auth.php';

// ═══════════════════════════════════════════════════════════
// AUTHENTICATED ROUTES
// ═══════════════════════════════════════════════════════════
Route::middleware('auth')->group(function () {

    // Enrollment
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])
        ->name('enroll');

    // Review
    Route::post('/courses/{course}/review', [EnrollmentController::class, 'submitReview'])
        ->name('review');

    // Unenroll
    Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'unenroll'])
        ->name('student.unenroll');

});

// ═══════════════════════════════════════════════════════════
// STUDENT ROUTES (prefix /dashboard, name 'student.*')
// ═══════════════════════════════════════════════════════════
// ─── Wishlist toggle — standalone route (accessible from any page, e.g. courses/index, courses/show)
Route::middleware('auth')
    ->post('/wishlist/toggle/{course}', [WishlistController::class, 'toggle'])
    ->name('wishlist.toggle');

Route::middleware(['auth', 'role:student,instructor,admin'])
    ->prefix('dashboard')
    ->name('student.')
    ->group(function () {

        Route::get('/', [StudentDashboard::class, 'index'])->name('index');
        Route::get('/my-courses', [StudentDashboard::class, 'myCourses'])->name('courses');
        Route::get('/certificates', [StudentDashboard::class, 'certificates'])->name('certificates');
        Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
        Route::get('/certificates/{certificate}/preview', [CertificateController::class, 'preview'])->name('certificates.preview');
        Route::post('/certificates/{course}/generate', [CertificateController::class, 'generate'])->name('certificates.generate');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');

        // Learning & Progress
        Route::get('/learn/{slug}', [LearningController::class, 'index'])->name('learn');
        Route::get('/learn/{slug}/{lesson}', [LearningController::class, 'lesson'])->name('learn.lesson');
        Route::post('/progress/{lesson}', [LearningController::class, 'updateProgress'])->name('learn.progress');

        // Review Course
        Route::post('/course/review/{course}', [EnrollmentController::class, 'submitReview'])->name('course.review.submit');

        // Profile Settings
        Route::get('/profile', [StudentDashboard::class, 'profile'])->name('profile');
        Route::post('/profile/update', [StudentDashboard::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/password', [StudentDashboard::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/avatar', [StudentDashboard::class, 'updateAvatar'])->name('profile.avatar');
        Route::post('/profile/preferences', [StudentDashboard::class, 'updatePreferences'])->name('profile.preferences');
        Route::post('/profile/delete', [StudentDashboard::class, 'deleteAccount'])->name('profile.delete');

        // Wishlist (delete only — toggle is at standalone route above)
        Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    });

// ═══════════════════════════════════════════════════════════
// INSTRUCTOR ROUTES
// ═══════════════════════════════════════════════════════════
Route::middleware(['auth', 'role:instructor,admin'])
    ->prefix('instructor')
    ->name('instructor.')
    ->group(function () {

        Route::get('/dashboard', [InstructorDashboard::class, 'index'])
            ->name('dashboard');

        // Teaching Navigation
        Route::get('/courses', [InstructorCourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [InstructorCourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [InstructorCourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [InstructorCourseController::class, 'update'])->name('courses.update');
        Route::get('/courses/{course}', [InstructorCourseController::class, 'show'])->name('courses.show');
        Route::delete('/courses/{course}', [InstructorCourseController::class, 'destroy'])->name('courses.destroy');

        Route::get('/students', [InstructorDashboard::class, 'students'])->name('students');
        Route::get('/messages', [InstructorDashboard::class, 'messagesView'])->name('messages');
        Route::get('/reviews', [InstructorDashboard::class, 'reviewsView'])->name('reviews');

        // Analytics Navigation
        Route::get('/earnings', [InstructorDashboard::class, 'earnings'])->name('earnings');
        Route::get('/performance', [InstructorDashboard::class, 'performance'])->name('performance');
        Route::get('/insights', [InstructorDashboard::class, 'insights'])->name('insights');

        // Quick Actions
        Route::get('/courses/new', [InstructorCourseController::class, 'create'])->name('create-course');
        Route::get('/upload-video', [InstructorDashboard::class, 'uploadVideo'])->name('upload-video');
        Route::get('/add-quiz', [InstructorDashboard::class, 'addQuiz'])->name('add-quiz');
        Route::get('/broadcast', [InstructorDashboard::class, 'broadcast'])->name('broadcast');
        Route::get('/withdraw', [InstructorDashboard::class, 'withdraw'])->name('withdraw');
        Route::get('/reports', [InstructorDashboard::class, 'reports'])->name('reports');
    });

// ═══════════════════════════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════════════════════════
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');

        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');  
        Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

       Route::get('/courses', [App\Http\Controllers\Admin\CourseController::class, 'index'])
    ->name('courses.index');

Route::get('/courses/create', [App\Http\Controllers\Admin\CourseController::class, 'create'])
    ->name('courses.create');

Route::post('/courses', [App\Http\Controllers\Admin\CourseController::class, 'store'])
    ->name('courses.store');

Route::get('/courses/{course}/edit', [App\Http\Controllers\Admin\CourseController::class, 'edit'])
    ->name('courses.edit');

Route::put('/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'update'])
    ->name('courses.update');

Route::get('/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'show'])
    ->name('courses.show');

Route::delete('/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'destroy'])
    ->name('courses.destroy');

Route::patch('/courses/{course}/toggle-publish', [App\Http\Controllers\Admin\CourseController::class, 'togglePublish'])
    ->name('courses.toggle-publish');

        Route::get('/institutions', [App\Http\Controllers\Admin\InstitutionController::class, 'index'])->name('institutions');
        Route::post('/institutions', [App\Http\Controllers\Admin\InstitutionController::class, 'store'])->name('institutions.store');
        Route::put('/institutions/{institution}', [App\Http\Controllers\Admin\InstitutionController::class, 'update'])->name('institutions.update');
        Route::delete('/institutions/{institution}', [App\Http\Controllers\Admin\InstitutionController::class, 'destroy'])->name('institutions.destroy');

        Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');
        Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/approvals', [App\Http\Controllers\Admin\ApprovalController::class, 'index'])->name('approvals');
        Route::post('/approvals/{course}/approve', [App\Http\Controllers\Admin\ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::delete('/approvals/{course}/reject', [App\Http\Controllers\Admin\ApprovalController::class, 'reject'])->name('approvals.reject');

        Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews');
        Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::patch('/reviews/{review}/toggle', [App\Http\Controllers\Admin\ReviewController::class, 'toggleVisibility'])->name('reviews.toggle');

        Route::view('/reports', 'admin.reports')->name('reports');

        Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions');
        Route::delete('/transactions/{payment}', [App\Http\Controllers\Admin\TransactionController::class, 'destroy'])->name('transactions.destroy');

        Route::view('/payouts', 'admin.payouts')->name('payouts');

        Route::view('/settings', 'admin.settings')->name('settings');

        Route::get('/quick-curriculum', [App\Http\Controllers\Admin\QuickCurriculumController::class, 'index'])->name('quick-curriculum.index');
        Route::post('/quick-curriculum', [App\Http\Controllers\Admin\QuickCurriculumController::class, 'store'])->name('quick-curriculum.store');

        Route::view('/logs', 'admin.logs')->name('logs');
    });

// ═══════════════════════════════════════════════════════════
// OTHER ROUTES
// ═══════════════════════════════════════════════════════════
Route::post('/student/course/{course}/review', [EnrollmentController::class, 'submitReview'])
    ->name('student.course.review.submit')
    ->middleware('auth');

Route::get('/universities', [App\Http\Controllers\UniversityController::class, 'index'])
    ->name('universities');
    
Route::get('/universities/{slug}', [App\Http\Controllers\UniversityController::class, 'show'])
    ->name('universities.show');

Route::view('/about', 'about')->name('about');

Route::view('/contact', 'contact')->name('contact');

Route::view('/blog', 'blog')->name('blog');

Route::view('/privacy', 'legal.privacy')->name('privacy');

Route::view('/terms', 'legal.terms')->name('terms');

Route::view('/cookies', 'legal.cookies')->name('cookies');

Route::view('/security', 'legal.security')->name('security');

Route::view('/faq', 'faq')->name('faq');

Route::view('/forum', 'forum')->name('forum');

Route::view('/pusat-bantuan', 'pusat-bantuan')->name('pusat-bantuan');

Route::view('/sitemap', 'sitemap')->name('sitemap');



