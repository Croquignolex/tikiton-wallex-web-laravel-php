<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Testimonial;
use App\Traits\ErrorFlashMessagesTrait;

class HomeController extends Controller
{
    use ErrorFlashMessagesTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        try
        {
            $testimonials = Testimonial::all();
            $partners = Partner::all();
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view('home', compact('testimonials', 'partners'));
    }
}
