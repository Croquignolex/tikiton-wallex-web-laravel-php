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
    const POLAR = 'polar';

    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->except(['index']);
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
            $currency = Auth::user()->currencies->first();
            $accounts_balance = 0; $accounts_nbr = 0; $all_categories = 0;
            $this->databaseError($exception);
        }

        return view('app.dashboard.index', compact('currency',
            'accounts_balance', 'accounts_nbr', 'all_categories'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function accountsBalanceAjax()
    {
        $currency = $this->getCurrency();
        $yLabel = trans('general.balance') . ' (' . $currency->symbol . ')';
        $xLabel = trans('general.stated_accounts');
        $wallets = Auth::user()->wallets->where('is_stated', true);
        $chartData = collect(); 
		foreach ($wallets as $wallet)
		{
			$chartData->push([
				'name' => $wallet->name,
				'color' => $wallet->color,
				'data' => collect([[
					'label' => '',
					'amount' => round($wallet->balance / $currency->devaluation, 2)
				]]),
			]);
		} 
        return response()->json(compact('chartData', 
			'yLabel', 'xLabel'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentDayCategoryAjax()
    {
        $chartData = $this->getCategoryTypePolarChartData(Transaction::DAILY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentWeekCategoryAjax()
    {
        $chartData = $this->getCategoryTypePolarChartData(Transaction::WEEKLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentMonthCategoryAjax()
    {
        $chartData = $this->getCategoryTypePolarChartData(Transaction::MONTHLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentYearCategoryAjax()
    {
        $chartData = $this->getCategoryTypePolarChartData(Transaction::YEARLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentWeekDaysCategoryAjax()
    {
        $yLabel = trans('general.amount') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.days');
        $chartData = $this->getCategoryTypeLineChartData(Transaction::DAILY);
        return response()->json(compact('chartData',
            'xLabel', 'yLabel'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentYearMonthsCategoryAjax()
    {
        $yLabel = trans('general.amount') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.months');
        $chartData = $this->getCategoryTypeLineChartData(Transaction::YEARLY);
        return response()->json(compact('chartData',
            'xLabel', 'yLabel'));
    }


    /**
     * @param $transaction_period_range
     * @return \Illuminate\Support\Collection
     */
    private function getCategoryTypePolarChartData($transaction_period_range)
    {
        return $this->chartTypeData(DashboardController::POLAR, $transaction_period_range);
    }

    /**
     * @param $transaction_period_range
     * @return \Illuminate\Support\Collection
     */
    private function getCategoryTypeLineChartData($transaction_period_range)
    {
        return $this->chartTypeData(DashboardController::LINE, $transaction_period_range);
    }

    /**
     * @param $chart_type
     * @param $transaction_period_range
     * @return \Illuminate\Support\Collection
     */
    private function chartTypeData($chart_type, $transaction_period_range)
    {
        $incomes_data = 0; $expenses_data = 0;
        if($chart_type === DashboardController::POLAR)
        {
            $incomes_data = $this->transactionsIntoPeriodRangePerCategoryTypeAmount($transaction_period_range, Category::INCOME);
            // $transfers_data = $this->category_type_amount($transaction_type, Category::TRANSFER);
            $expenses_data = $this->transactionsIntoPeriodRangePerCategoryTypeAmount($transaction_period_range, Category::EXPENSE);
        }
        else if($chart_type === DashboardController::LINE)
        {
            $incomes_data = $transaction_period_range === Transaction::DAILY ? $this->currentWeekDaysCategoryTypeData(Category::INCOME) : $this->currentYearMonthsCategoryTypeData(Category::INCOME);
            // $transfers_data = $transaction_type === Transaction::DAILY ? $this->daysTypeData(Category::TRANSFER) : $this->monthsTypeData(Category::TRANSFER);
            $expenses_data = $transaction_period_range === Transaction::DAILY ? $this->currentWeekDaysCategoryTypeData(Category::EXPENSE) : $this->currentYearMonthsCategoryTypeData(Category::EXPENSE);
        }

        $chart_type_data = collect();
        $chart_type_data->push([
            'name' => trans('general.incomes'),
            'data' => $incomes_data, 'color' => '#00c292',
        ]);
        /*$chartData->push([
            'name' => trans('general.transfers'),
            'data' => $transfers_data, 'color' => '#2196F3',
        ]);*/
        $chart_type_data->push([
            'name' => trans('general.expenses'),
            'data' => $expenses_data, 'color' => '#F44336',
        ]);

        return $chart_type_data;
    }
}