<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetApiLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Priority goes to the locale from the query string (?locale=en)
        // 2. If not present, check the 'Accept-Language' header
        // 3. If neither exists, fall back to the default language 'en'
        $locale = $request->query('locale') ?? $request->header('Accept-Language') ?? 'en';

        // List of supported locales in your system
        // Ensure these match your config/language.php settings
        $supportedLocales = ['ar', 'en', 'nl'];

        // If the requested locale is supported, set it as the app locale
        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
        } else {
            // Fallback to English if the requested locale is not supported
            App::setLocale('en');
        }

        return $next($request);
    }
}
