<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\GcsTestController;
use Illuminate\Support\Facades\Route;
// Import the middleware we created
use App\Http\Middleware\SetApiLocale;

Route::post('/test-gcs-upload', [GcsTestController::class, 'uploadTest']);
Route::get('/test-gcs-connection', [GcsTestController::class, 'testConnection']);

Route::post('/contact/send', [ContactController::class, 'store'])
     // Allows only 5 messages per minute per IP address
     ->middleware('throttle:5,1');

Route::middleware([SetApiLocale::class])->group(function () {

    // 1. Global Settings Route
    Route::get('/settings', [SettingController::class, 'index']);

    // Final route will be: /api/posts
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{slug}', [PostController::class, 'show']);

    // Route to fetch posts by a specific category
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);

    // 2. Page Routes
    Route::get('/pages', [PageController::class, 'index']);      // List of pages
    Route::get('/pages/{slug}', [PageController::class, 'show']); // Single page content
});
