<?php

namespace App\Http\Controllers;

class PolicyController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('policy');
    }
}
