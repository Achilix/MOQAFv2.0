<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function setLanguage($language)
    {
        if (in_array($language, ['en', 'fr', 'ar'])) {
            session()->put('locale', $language);
            app()->setLocale($language);
        }

        return redirect()->back();
    }
}
