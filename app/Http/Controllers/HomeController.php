<?php

namespace App\Http\Controllers;

use App\Traits\ErrorFlashMessagesTrait;

class HomeController extends Controller
{
    use ErrorFlashMessagesTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        /*
        try
        { }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }
        */

        return view('home');
    }
}
