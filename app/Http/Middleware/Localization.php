<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Determine system default language (BusinessSetting DB > APP_DEFAULT_LANG .env > config > 'en')
        $defaultLang = 'en';
        if (function_exists('get_setting')) {
            try {
                $dbLang = get_setting('default_language');
                if (in_array($dbLang, ['en', 'bn'])) {
                    $defaultLang = $dbLang;
                }
            } catch (\Throwable $e) {}
        }
        if ($defaultLang === 'en') {
            $envLang = env('APP_DEFAULT_LANG') ?: config('app.locale');
            if (in_array($envLang, ['en', 'bn'])) {
                $defaultLang = $envLang;
            }
        }

        // 2. Check if active session already has a valid locale preference
        if (Session::has('applocale')) {
            $locale = Session::get('applocale');
            if (in_array($locale, ['en', 'bn'])) {
                App::setLocale($locale);
                return $next($request);
            }
        }

        // 3. Fallback to system default language and save in session
        App::setLocale($defaultLang);
        Session::put('applocale', $defaultLang);

        return $next($request);
    }
}
