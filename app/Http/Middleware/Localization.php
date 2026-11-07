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
        $defaultLang = env('APP_DEFAULT_LANG') ?: (function_exists('get_setting') ? get_setting('default_language') : null) ?: 'en';
        if (!in_array($defaultLang, ['en', 'bn'])) {
            $defaultLang = 'en';
        }

        if (Session::has('applocale') && Session::get('manual_locale_switch')) {
            $locale = Session::get('applocale');
            if (in_array($locale, ['en', 'bn'])) {
                App::setLocale($locale);
            } else {
                App::setLocale($defaultLang);
            }
        } else {
            App::setLocale($defaultLang);
            Session::put('applocale', $defaultLang);
        }

        return $next($request);
    }
}
