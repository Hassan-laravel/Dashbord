<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetApiLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. الأولوية للغة القادمة من الرابط (?locale=en)
        // 2. إذا لم توجد، نرى الهيدر
        // 3. إذا لم يوجد، نأخذ اللغة الافتراضية 'ar'
        $locale = $request->query('locale') ?? $request->header('Accept-Language') ?? 'ar';

        // قائمة اللغات المدعومة في نظامك
        $supportedLocales = ['ar', 'en']; // تأكد أن هذه تطابق config/language.php

        // إذا كانت اللغة المطلوبة مدعومة، نعتمدها
        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
        } else {
            App::setLocale('ar'); // Fallback
        }

        return $next($request);
    }
}
