<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Thay đổi ngôn ngữ
     */
    public function switchLanguage($locale)
    {
        if (!in_array($locale, ['vi', 'en'])) {
            $locale = 'vi';
        }

        Session::put('locale', $locale);
        app()->setLocale($locale);

        request()->setLocale($locale);

        return redirect()->back();
    }

    /**
     * Lấy ngôn ngữ hiện tại
     */
    public static function getCurrentLocale()
    {
        return Session::get('locale', 'vi'); 
    }
}
