<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\GcsTestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. Language Switcher Route ---
Route::get('switch-language/{lang}', function ($lang) {
    if (array_key_exists($lang, config('language.supported'))) {
        session()->put('locale', $lang);
    }
    return redirect()->back();
})->name('switch.language');

Route::get('/check-version', function() { return "Version 2.0 - DD should work"; });

// --- 2. Authentication Routes (Login/Logout) ---
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');


// --- 3. Frontend (Homepage) ---
Route::get('/', function () {
    return view('admin.auth.login'); // Or your dedicated home page
})->name('home');


// --- 4. Admin Panel ---
// Use prefix('admin') so routes start with /admin
// Use name('admin.') so route names are admin.users.index, etc.
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // A) General Routes (Available to Admin and Editor)
    // ---------------------------------------------------
    Route::get('/', function () {
        return view('admin.index');
    })->name('dashboard');

    // Post Management (CRUD) - Accessible by Editor and Admin
    // (Deletion and granular access are controlled via Permissions in Controller or Blade)
    Route::resource('posts', PostController::class);
    Route::delete('posts/image/{id}', [PostController::class, 'deleteImage'])->name('posts.image.destroy');

    // B) Super Admin Only Routes
    // ---------------------------------------------------
    Route::middleware(['role:Super Admin'])->group(function () {

        // User Management
        Route::resource('users', UserController::class);

        // Category Management
        Route::resource('categories', CategoryController::class);

        // System Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Page Management
        Route::resource('pages', PageController::class);

    });
});
