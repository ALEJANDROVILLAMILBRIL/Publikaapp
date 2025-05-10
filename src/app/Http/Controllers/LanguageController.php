<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switch(Request $request, $lang)
    {
        if (in_array($lang, ['en', 'es'])) {
            return redirect()->back()->withCookie(cookie('locale', $lang, 60 * 24 * 30));
        }

        return redirect()->back();
    }
}
