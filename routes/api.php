<?php

use App\Http\Controllers\Instructor\DashboardController as InstructorDashboard;

Route::middleware('web')->prefix('instructor')->group(function () {
    Route::get('/stats', [InstructorDashboard::class, 'stats']);
    Route::get('/reviews', [InstructorDashboard::class, 'reviews']);
    Route::get('/enrollments', [InstructorDashboard::class, 'enrollments']);
    Route::get('/messages', [InstructorDashboard::class, 'messagesApi']);
});

Route::get('/scrape/next', [\App\Http\Controllers\Api\ScrapeController::class, 'next']);
Route::post('/scrape/save', [\App\Http\Controllers\Api\ScrapeController::class, 'save']);