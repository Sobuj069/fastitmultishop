<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param string $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    {
        if (in_array($lang, ['en', 'bn'])) {
            Session::put('applocale', $lang);
            Session::save();
            App::setLocale($lang);
        }
        return redirect()->back();
    }
}
