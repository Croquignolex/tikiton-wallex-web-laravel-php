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
                    return $wallet->balance * $wallet->currency->devaluation;
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
                'name' => text_format($wallet->name, 10),
                'color' => $wallet->color,
                'data' => collect([['label' => '', 'amount' => $wallet->balance]]),
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
        $chartData = $this->chartData(DashboardController::POLAR);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function dailyCategoryAjax()
    {
        $chartData = $this->getBarChartData(Transaction::DAILY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function weeklyCategoryAjax()
    {
        $chartData = $this->getBarChartData(Transaction::WEEKLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthlyCategoryAjax()
    {
        $chartData = $this->getBarChartData(Transaction::MONTHLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function yearlyCategoryAjax()
    {
        $chartData = $this->getBarChartData(Transaction::YEARLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function daysCategoryAjax()
    {
        $yLabel = trans('general.amount') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.days');
        $chartData = $this->getLineChartData(Transaction::DAILY);
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
        $chartData = $this->getLineChartData(Transaction::YEARLY);
        return response()->json(compact('chartData',
            'xLabel', 'yLabel'));
    }


    /**
     * @param $transaction_type
     * @return \Illuminate\Support\Collection
     */
    private function getBarChartData($transaction_type)
    {
        return $this->chartData(DashboardController::BAR, $transaction_type);
    }

    /**
     * @param $transaction_type
     * @return \Illuminate\Support\Collection
     */
    private function getLineChartData($transaction_type)
    {
        return $this->chartData(DashboardController::LINE, $transaction_type);
    }

    /**
     * @param $chart_type
     * @param $transaction_type
     * @return \Illuminate\Support\Collection
     */
    private function chartData($chart_type, $transaction_type = '')
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
            $incomes_data = $this->getCategories(Category::INCOME)->count();
            $transfers_data = $this->getCategories(Category::TRANSFER)->count();
            $expenses_data = $this->getCategories(Category::EXPENSE)->count();
        }

        $chartData = collect();
        $chartData->push([
            'name' => text_format(trans('general.incomes'), 10),
            'data' => $incomes_data, 'color' => '#00c292',
        ]);
        $chartData->push([
            'name' => text_format(trans('general.transfers'), 10),
            'data' => $transfers_data, 'color' => '#2196F3',
        ]);
        $chartData->push([
            'name' => text_format(trans('general.expenses'), 10),
            'data' => $expenses_data, 'color' => '#F44336',
        ]);

        return $chartData;
    }

    /**
     * @param $type
     * @return mixed
     */
    private function getCategories($type)
    {
        return Auth::user()->categories->where('type', $type);
    }
}