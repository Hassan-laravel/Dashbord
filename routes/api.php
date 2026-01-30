<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Support\Facades\Route;
// استدعاء الميدل وير الذي أنشأناه
use App\Http\Middleware\SetApiLocale;

Route::post('/contact/send', [ContactController::class, 'store'])
     ->middleware('throttle:5,1'); // يسمح بـ 5 رسائل فقط كل دقيقة لكل IP
Route::middleware([SetApiLocale::class])->group(function () {
// 1. رابط الإعدادات العامة
    Route::get('/settings', [SettingController::class, 'index']);
    // الرابط النهائي سيكون: /api/posts
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{slug}', [PostController::class, 'show']);
    // رابط جلب مقالات تصنيف معين
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);
     Route::get('/categories', [CategoryController::class, 'index']);
    // 2. روابط الصفحات
    Route::get('/pages', [PageController::class, 'index']);      // قائمة الصفحات
    Route::get('/pages/{slug}', [PageController::class, 'show']); // صفحة مفردة
});
