<?php

namespace App\Traits;

use Exception;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\App\DashboardController;

trait DashboardTypeTrait
{
    use DashboardTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try
        {
            $currency = $this->getCurrency();
            $daily = $this->formattedTransactionsIntoPeriodRangePerCategoryAmount(Transaction::DAILY);
            $weekly = $this->formattedTransactionsIntoPeriodRangePerCategoryAmount(Transaction::WEEKLY);
            $monthly = $this->formattedTransactionsIntoPeriodRangePerCategoryAmount(Transaction::MONTHLY);
            $yearly= $this->formattedTransactionsIntoPeriodRangePerCategoryAmount(Transaction::YEARLY);
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view($this->view_name, compact('currency',
            'weekly', 'monthly', 'yearly', 'daily'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentDayAjax()
    {
        $chartData = $this->getPieChartData(Transaction::DAILY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentWeekAjax()
    {
        $chartData = $this->getPieChartData(Transaction::WEEKLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentMonthAjax()
    {
        $chartData = $this->getPieChartData(Transaction::MONTHLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentYearAjax()
    {
        $chartData = $this->getPieChartData(Transaction::YEARLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentYearMonthsAjax()
    {
        $yLabel = trans('general.amount') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.months');
        $chartData = $this->getLineChartData(Transaction::MONTHLY);
        return response()->json(compact('chartData',
            'xLabel', 'yLabel'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentWeekDaysAjax()
    {
        $yLabel = trans('general.amount') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.days');
        $chartData = $this->getLineChartData(Transaction::DAILY);
        return response()->json(compact('chartData',
            'xLabel', 'yLabel'));
    }

    /**
     * @param $transaction_period_range
     * @return \Illuminate\Support\Collection
     */
    private function getPieChartData($transaction_period_range)
    {
        return $this->chartData(DashboardController::PIE, $transaction_period_range);
    }

    /**
     * @param $transaction_period_range
     * @return \Illuminate\Support\Collection
     */
    private function getLineChartData($transaction_period_range)
    {
        return $this->chartData(DashboardController::LINE, $transaction_period_range);
    }

    /**
     * @param $chart_type
     * @param $transaction_period_range
     * @return \Illuminate\Support\Collection
     */
    private function chartData($chart_type, $transaction_period_range)
    {
        $categories = $this->getCategories(); $chartData = collect();
        foreach ($categories as $category)
        {
            if($chart_type === DashboardController::PIE) $data = $this->transactionsIntoPeriodRangePerCategoryAmount($transaction_period_range, $category);
            else $data = $transaction_period_range === Transaction::DAILY ? $this->currentWeekDaysData($category) : $this->currentYearMonthsData($category);
            $chartData->push([
                'name' => $category->name,
                'color' => $category->color, 'data' => $data,
            ]);
        }
        return $chartData;
    }

    /**
     * @return mixed
     */
    private function getCategories()
    {
        return Auth::user()->categories->where('type', $this->category_type);
    }

    /**
     * @param $transaction_period_range
     * @return mixed
     */
    private function formattedTransactionsIntoPeriodRangePerCategoryAmount($transaction_period_range)
    {
        return $this->formatNumber($this->transactionsIntoPeriodRangePerCategoryTypeAmount($transaction_period_range, $this->category_type));
    }
}