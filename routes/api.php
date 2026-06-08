<?php

use App\Http\Controllers\Instructor\DashboardController as InstructorDashboard;

Route::middleware('web')->prefix('instructor')->group(function () {
    Route::get('/stats', [InstructorDashboard::class, 'stats']);
    Route::get('/reviews', [InstructorDashboard::class, 'reviews']);
    Route::get('/enrollments', [InstructorDashboard::class, 'enrollments']);
    Route::get('/messages', [InstructorDashboard::class, 'messagesApi']);
});

// ⚠️ Rate limiting untuk mencegah abuse pada scraper API
// Limit: 60 requests per 1 minute per IP
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/scrape/next', [\App\Http\Controllers\Api\ScrapeController::class, 'next']);
    Route::post('/scrape/save', [\App\Http\Controllers\Api\ScrapeController::class, 'save']);
});