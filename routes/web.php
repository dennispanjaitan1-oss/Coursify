<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\WishlistController;

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

Route::get('/courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::get('/courses/{course:slug}', [CourseController::class, 'show'])
    ->name('courses.show');

Route::get('/payment', [PaymentController::class, 'index'])
    ->name('payment.index');

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

        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        Route::view('/analytics', 'admin.analytics')->name('analytics');

        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');  
        Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/courses', [App\Http\Controllers\Admin\CourseController::class, 'index'])->name('courses.index');
Route::post('/courses', [App\Http\Controllers\Admin\CourseController::class, 'store'])->name('courses.store');
Route::put('/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'update'])->name('courses.update');
Route::delete('/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('courses.destroy');
Route::patch('/courses/{course}/toggle-publish', [App\Http\Controllers\Admin\CourseController::class, 'togglePublish'])->name('courses.toggle-publish');


    

        Route::view('/institutions', 'admin.institutions')->name('institutions');

        Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');
        Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::view('/approvals', 'admin.approvals')->name('approvals');

        Route::view('/reviews', 'admin.reviews')->name('reviews');

        Route::view('/reports', 'admin.reports')->name('reports');

        Route::view('/transactions', 'admin.transactions')->name('transactions');

        Route::view('/payouts', 'admin.payouts')->name('payouts');

        Route::view('/settings', 'admin.settings')->name('settings');

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


Route::get('/admin/institutions', [App\Http\Controllers\Admin\InstitutionController::class, 'index'])->name('admin.institutions');
Route::post('/admin/institutions', [App\Http\Controllers\Admin\InstitutionController::class, 'store'])->name('admin.institutions.store');
Route::put('/admin/institutions/{institution}', [App\Http\Controllers\Admin\InstitutionController::class, 'update'])->name('admin.institutions.update');
Route::delete('/admin/institutions/{institution}', [App\Http\Controllers\Admin\InstitutionController::class, 'destroy'])->name('admin.institutions.destroy');

Route::get('/admin/approvals', [App\Http\Controllers\Admin\ApprovalController::class, 'index'])->name('admin.approvals');
Route::post('/admin/approvals/{course}/approve', [App\Http\Controllers\Admin\ApprovalController::class, 'approve'])->name('admin.approvals.approve');
Route::delete('/admin/approvals/{course}/reject', [App\Http\Controllers\Admin\ApprovalController::class, 'reject'])->name('admin.approvals.reject');

Route::get('/admin/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions');
Route::delete('/admin/transactions/{payment}', [App\Http\Controllers\Admin\TransactionController::class, 'destroy'])->name('admin.transactions.destroy');

Route::get('/admin/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews');
Route::delete('/admin/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
Route::patch('/admin/reviews/{review}/toggle', [App\Http\Controllers\Admin\ReviewController::class, 'toggleVisibility'])->name('admin.reviews.toggle');

// Analytics
Route::get('/admin/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics');

Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');