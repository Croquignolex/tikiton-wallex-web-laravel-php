<?php

namespace App\Http\Controllers;

use App\Traits\ErrorFlashMessagesTrait;

class AboutController extends Controller
{
    use ErrorFlashMessagesTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('about');
    }
}
