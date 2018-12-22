<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Transaction;
use App\Traits\DashboardTrait;
use App\Traits\LocaleAmountTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ErrorFlashMessagesTrait;

class DashboardController extends Controller
{
    use ErrorFlashMessagesTrait, LocaleAmountTrait, DashboardTrait;

    const PIE = 'pie'; const LINE = 'line';
    const BAR = 'bar'; const POLAR = 'polar';

    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin.auth');
        //$this->middleware('ajax')->only(['accountsAjax', 'categoriesAjax']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try
        {
            //--
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view('admin.dashboard.index');
    }
}