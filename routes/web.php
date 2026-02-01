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

// --- 1. مسار تبديل اللغة ---
Route::get('switch-language/{lang}', function ($lang) {
    if (array_key_exists($lang, config('language.supported'))) {
        session()->put('locale', $lang);
    }
    return redirect()->back();
})->name('switch.language');

Route::get('/check-version', function() { return "Version 2.0 - DD should work"; });
// --- 2. مسارات المصادقة (تسجيل الدخول/الخروج) ---
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
//


// --- 3. الواجهة الأمامية (Homepage) ---
Route::get('/', function () {
    return view('admin.auth.login'); // أو الصفحة الرئيسية الخاصة بك
})->name('home');


// --- 4. لوحة التحكم (Admin Panel) ---
// نستخدم prefix('admin') لتبدأ الروابط بـ /admin
// نستخدم name('admin.') لتكون أسماء الروابط admin.users.index وهكذا
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // أ) مسارات عامة (للمدير والمحرر)
    // ---------------------------------------------------
    Route::get('/', function () {
        return view('admin.index');
    })->name('dashboard');

    // إدارة المقالات (CRUD) - متاحة للمحرر والمدير
    // (يتم التحكم بالحذف والوصول الدقيق عبر الصلاحيات داخل Controller أو Blade)
    Route::resource('posts', PostController::class);


    // ب) مسارات خاصة بالمدير العام فقط (Super Admin)
    // ---------------------------------------------------
    Route::middleware(['role:Super Admin'])->group(function () {

        // إدارة المستخدمين
        Route::resource('users', UserController::class);

        // إدارة التصنيفات
        Route::resource('categories', CategoryController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        Route::resource('pages', PageController::class);


    });
});
