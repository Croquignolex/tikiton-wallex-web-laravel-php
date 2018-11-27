<?php

namespace App\Http\Controllers\App;

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
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only(['accountsAjax', 'categoriesAjax']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try
        {
            $currency = $this->getCurrency();
            $accounts = Auth::user()->wallets->where('is_stated', true);
            $accounts_balance = $this->formatNumber(
                $accounts->sum(function (Wallet $wallet) {
                    return $wallet->balance;
                }) / $currency->devaluation
            );
            $accounts_nbr = $accounts->count();
            $all_categories = Auth::user()->categories->count();
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view('app.dashboard.index', compact('currency',
            'accounts_balance', 'accounts_nbr', 'all_categories'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function accountsAjax()
    {
        $yLabel = trans('general.balance') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.accounts');
        $wallets = Auth::user()->wallets->where('is_stated', true);
        $chartData = collect(); 
		foreach ($wallets as $wallet)
		{
			$chartData->push([
				'name' => $wallet->name,
				'color' => $wallet->color,
				'data' => collect([[
					'label' => '',
					'amount' => round($wallet->balance / $this->getCurrency()->devaluation, 2)
				]]),
			]);
		} 
        return response()->json(compact('chartData', 
			'yLabel', 'xLabel'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoriesAjax()
    {
        $chartData = $this->chartTypeData(DashboardController::POLAR);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function dailyCategoryAjax()
    {
        $chartData = $this->getTypeBarChartData(Transaction::DAILY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function weeklyCategoryAjax()
    {
        $chartData = $this->getTypeBarChartData(Transaction::WEEKLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthlyCategoryAjax()
    {
        $chartData = $this->getTypeBarChartData(Transaction::MONTHLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function yearlyCategoryAjax()
    {
        $chartData = $this->getTypeBarChartData(Transaction::YEARLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function daysCategoryAjax()
    {
        $yLabel = trans('general.amount') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.days');
        $chartData = $this->getTypeLineChartData(Transaction::DAILY);
        return response()->json(compact('chartData',
            'xLabel', 'yLabel'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthsCategoryAjax()
    {
        $yLabel = trans('general.amount') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.months');
        $chartData = $this->getTypeLineChartData(Transaction::YEARLY);
        return response()->json(compact('chartData',
            'xLabel', 'yLabel'));
    }


    /**
     * @param $transaction_type
     * @return \Illuminate\Support\Collection
     */
    private function getTypeBarChartData($transaction_type)
    {
        return $this->chartTypeData(DashboardController::BAR, $transaction_type);
    }

    /**
     * @param $transaction_type
     * @return \Illuminate\Support\Collection
     */
    private function getTypeLineChartData($transaction_type)
    {
        return $this->chartTypeData(DashboardController::LINE, $transaction_type);
    }

    /**
     * @param $chart_type
     * @param $transaction_type
     * @return \Illuminate\Support\Collection
     */
    private function chartTypeData($chart_type, $transaction_type = '')
    {
        if($chart_type === DashboardController::BAR)
        {
            $incomes_data = $this->category_type_amount($transaction_type, Category::INCOME);
            $transfers_data = $this->category_type_amount($transaction_type, Category::TRANSFER);
            $expenses_data = $this->category_type_amount($transaction_type, Category::EXPENSE);
        }
        else if($chart_type === DashboardController::LINE)
        {
            $incomes_data = $transaction_type === Transaction::DAILY ? $this->daysTypeData(Category::INCOME) : $this->monthsTypeData(Category::INCOME);
            $transfers_data = $transaction_type === Transaction::DAILY ? $this->daysTypeData(Category::TRANSFER) : $this->monthsTypeData(Category::TRANSFER);
            $expenses_data = $transaction_type === Transaction::DAILY ? $this->daysTypeData(Category::EXPENSE) : $this->monthsTypeData(Category::EXPENSE);
        }
        else
        {
            $incomes_data = $this->getTypeCategories(Category::INCOME)->count();
            $transfers_data = $this->getTypeCategories(Category::TRANSFER)->count();
            $expenses_data = $this->getTypeCategories(Category::EXPENSE)->count();
        }

        $chartData = collect();
        $chartData->push([
            'name' => trans('general.incomes'),
            'data' => $incomes_data, 'color' => '#00c292',
        ]);
        $chartData->push([
            'name' => trans('general.transfers'),
            'data' => $transfers_data, 'color' => '#2196F3',
        ]);
        $chartData->push([
            'name' => trans('general.expenses'),
            'data' => $expenses_data, 'color' => '#F44336',
        ]);

        return $chartData;
    }

    /**
     * @param $type
     * @return mixed
     */
    private function getTypeCategories($type)
    {
        return Auth::user()->categories->where('type', $type);
    }
}