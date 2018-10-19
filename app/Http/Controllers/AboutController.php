<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Team;
use App\Traits\ErrorFlashMessagesTrait;

class AboutController extends Controller
{
    use ErrorFlashMessagesTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        try
        {
            $teams = Team::where('is_visible', true)->get();
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view('about', compact('teams'));
    }
}
