<?php

namespace App\Http\Controllers\App;

use App\Models\Category;
use App\Traits\LocaleAmountTrait;
use App\Traits\DashboardTypeTrait;
use App\Http\Controllers\Controller;
use App\Traits\ErrorFlashMessagesTrait;

class DashboardTransfersController extends Controller
{
    use ErrorFlashMessagesTrait, LocaleAmountTrait, DashboardTypeTrait;
    private $category_type; private $view_name;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->except(['index']);
        $this->category_type = Category::TRANSFER;
        $this->view_name = 'app.dashboard.transfers';
    }
}