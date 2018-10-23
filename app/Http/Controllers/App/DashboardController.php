<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Traits\ErrorFlashMessagesTrait;

class DashboardController extends Controller
{
    use ErrorFlashMessagesTrait;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('app.dashboard');
    }
}
