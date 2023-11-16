<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TryCSSController extends Controller
{
    public function __invoke(Request $request)
    {
        // tailwindなどCSSを試すためのページ
        return view('try');
    }
}
