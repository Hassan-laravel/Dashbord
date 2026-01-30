<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من وجود لغة مخزنة في الجلسة
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            // إذا لم توجد، نستخدم اللغة الافتراضية من ملف الإعدادات
            $locale = config('language.default');
        }

        // التحقق من أن اللغة مدعومة في ملف إعداداتنا
        if (!array_key_exists($locale, config('language.supported'))) {
            $locale = config('language.default');
        }

        // تعيين لغة التطبيق الحالية
        App::setLocale($locale);

        return $next($request);
    }
}
