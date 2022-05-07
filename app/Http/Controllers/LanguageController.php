<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        if (array_key_exists($locale, Config::get('languages'))) {
            App::setLocale($locale);
        }
        Session::put('locale', $locale);

        return redirect()->back();
    }
}
