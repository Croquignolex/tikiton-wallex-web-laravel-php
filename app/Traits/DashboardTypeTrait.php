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
            $daily = $this->transactions_amount(Transaction::DAILY, $this->type);
            $weekly = $this->transactions_amount(Transaction::WEEKLY, $this->type);
            $monthly = $this->transactions_amount(Transaction::MONTHLY, $this->type);
            $yearly= $this->transactions_amount(Transaction::YEARLY, $this->type);
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
    public function dailyAjax()
    {
        $chartData = $this->getPieChartData(Transaction::DAILY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function weeklyAjax()
    {
        $chartData = $this->getPieChartData(Transaction::WEEKLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthlyAjax()
    {
        $chartData = $this->getPieChartData(Transaction::MONTHLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function yearlyAjax()
    {
        $chartData = $this->getPieChartData(Transaction::YEARLY);
        return response()->json(compact('chartData'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthsAjax()
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
    public function daysAjax()
    {
        $yLabel = trans('general.amount') . ' (' . $this->getCurrency()->symbol . ')';
        $xLabel = trans('general.days');
        $chartData = $this->getLineChartData(Transaction::DAILY);
        return response()->json(compact('chartData',
            'xLabel', 'yLabel'));
    }

    /**
     * @param $transaction_type
     * @return \Illuminate\Support\Collection
     */
    private function getPieChartData($transaction_type)
    {
        return $this->chartData(DashboardController::PIE, $transaction_type);
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
    private function chartData($chart_type, $transaction_type)
    {
        $categories = $this->getCategories(); $chartData = collect();
        foreach ($categories as $category)
        {
            if($chart_type === DashboardController::PIE) $data = $this->category_amount($transaction_type, $category);
            else $data = $transaction_type === Transaction::DAILY ? $this->daysData($category) : $this->monthsData($category);
            $chartData->push([
                'name' => text_format($category->name, 10),
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
        return Auth::user()->categories->where('type', $this->type);
    }
}