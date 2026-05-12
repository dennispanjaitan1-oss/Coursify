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
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// ═══════════════════════════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');

Route::get('/verify/{certificateNumber}', [CertificateController::class, 'verify'])
     ->name('certificates.verify');

// ═══════════════════════════════════════════════════════════
// BREEZE AUTH ROUTES
// ═══════════════════════════════════════════════════════════
require __DIR__.'/auth.php';

// ═══════════════════════════════════════════════════════════
// AUTHENTICATED ROUTES (General)
// ═══════════════════════════════════════════════════════════
Route::middleware('auth')->group(function () {

    // Enrollment & Review
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])
         ->name('enroll');
    Route::post('/courses/{course}/review', [EnrollmentController::class, 'submitReview'])
         ->name('review');

    // Wishlist AJAX (toggle add/remove dari halaman catalog/detail)
    Route::post('/wishlist/toggle/{course}', [WishlistController::class, 'toggle'])
         ->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])
         ->name('wishlist.destroy');
});

// ═══════════════════════════════════════════════════════════
// STUDENT ROUTES (prefix /dashboard, name 'student.*')
// ═══════════════════════════════════════════════════════════
Route::middleware(['auth', 'role:student,instructor,admin'])
    ->prefix('dashboard')
    ->name('student.')
    ->group(function () {

        // Dashboard & Pages
        Route::get('/', [StudentDashboard::class, 'index'])->name('index');
        Route::get('/my-courses', [StudentDashboard::class, 'myCourses'])->name('courses');
        Route::get('/certificates', [StudentDashboard::class, 'certificates'])->name('certificates');

        // Wishlist page (pakai WishlistController::index)
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');

        // Learning (video player page)
        Route::get('/learn/{slug}', [LearningController::class, 'index'])->name('learn');
        Route::get('/learn/{slug}/{lesson}', [LearningController::class, 'lesson'])->name('learn.lesson');
        Route::post('/progress/{lesson}', [LearningController::class, 'updateProgress'])->name('learn.progress');

        // Profile Settings (BARU)
        Route::get('/profile', [StudentDashboard::class, 'profile'])->name('profile');
        Route::post('/profile/update', [StudentDashboard::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/password', [StudentDashboard::class, 'updatePassword'])->name('profile.password');
    });

// ═══════════════════════════════════════════════════════════
// INSTRUCTOR ROUTES
// ═══════════════════════════════════════════════════════════
Route::middleware(['auth', 'role:instructor,admin'])
    ->prefix('instructor')
    ->name('instructor.')
    ->group(function () {
        Route::get('/dashboard', [InstructorDashboard::class, 'index'])->name('dashboard');
        Route::resource('/courses', InstructorCourseController::class);
    });

// ═══════════════════════════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════════════════════════
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('/users', AdminUserController::class);
        Route::resource('/courses', AdminCourseController::class);
    });

Route::post('/student/course/{course}/review', [EnrollmentController::class, 'submitReview'])
    ->name('student.course.review.submit')
    ->middleware('auth');

Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'unenroll'])
    ->name('student.unenroll');

Route::get('/universities', fn() => view('pages.universities'))->name('universities');