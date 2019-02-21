<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait DashboardTrait
{
    /**
     * @param Category $category
     * @return Collection
     */
    private function currentYearMonthsData(Category $category)
    {
        $perMonths = collect();
        for($i = 1; $i <= 12; $i++)
        {
            $month = now(session('timezone'))->startOfYear()->addMonth($i - 1);
            $transactions = Auth::user()->transactions
                ->where('category_id', $category->id)
                ->where('created_at', '>=', $month->startOfMonth())
                ->where('created_at', '<=', $month->endOfMonth());
            $perMonths->push([
                'label' => trans('month.' . $i),
                'amount' => $this->transactionsAmount($transactions)
            ]);
        }
        return $perMonths;
    }

    /**
     * @param Category $category
     * @return Collection
     */
    private function currentWeekDaysData(Category $category)
    {
        $perDays = collect();
        for($i = 1; $i <= 7; $i++)
        {
            $day = now(session('timezone'))->startOfWeek()->addDay($i - 1);
            $transactions = Auth::user()->transactions
                ->where('category_id', $category->id)
                ->where('created_at', '>=', $day->startOfDay())
                ->where('created_at', '<=', $day->endOfDay());
            $perDays->push([
                'label' => trans('day.' . $i),
                'amount' => $this->transactionsAmount($transactions)
            ]);
        }
        return $perDays;
    }

    /**
     * @param $category_type
     * @return Collection
     */
    private function currentYearMonthsCategoryTypeData($category_type)
    {
        $current_year_months_category_type_data = collect();
        for($i = 1; $i <= 12; $i++)
        {
            $month = now(session('timezone'))->startOfYear()->addMonth($i - 1);
            $transactions = $this->filterTransactionsPerCategoryType(Auth::user()->transactions
                ->where('created_at', '>=', $month->startOfMonth())
                ->where('created_at', '<=', $month->endOfMonth()), $category_type);
            $current_year_months_category_type_data->push([
                'label' => trans('month.' . $i),
                'amount' => $this->transactionsAmount($transactions)
            ]);
        }
        return $current_year_months_category_type_data;
    }

    /**
     * @param $category_type
     * @return Collection
     */
    private function currentWeekDaysCategoryTypeData($category_type)
    {
        $perDays = collect();
        for($i = 1; $i <= 7; $i++)
        {
            $day = now(session('timezone'))->startOfWeek()->addDay($i - 1);
            $transactions = $this->filterTransactionsPerCategoryType(Auth::user()->transactions
                ->where('created_at', '>=', $day->startOfDay())
                ->where('created_at', '<=', $day->endOfDay()), $category_type);
            $perDays->push([
                'label' => trans('day.' . $i),
                'amount' => $this->transactionsAmount($transactions)
            ]);
        }
        return $perDays;
    }

    /**
     * @param Collection $transactions
     * @param $category_type
     * @return Collection
     */
    private function filterTransactionsPerCategoryType(Collection $transactions, $category_type)
    {
        return $transactions->filter(function (Transaction $transaction) use ($category_type) {
            if($transaction->category->type === $category_type) return true;
            return false;
        });
    }

    /**
     *
     */
    private function getCurrency()
    {
        return Auth::user()->currencies
            ->where('is_current', true)->first();
    }

    /**
     * @param $transaction_period_range
     * @return mixed
     */
    private function transactionsIntoPeriodRange($transaction_period_range)
    {
        if($transaction_period_range === Transaction::DAILY)
            return Auth::user()->transactions
                ->where('created_at', '>=', now(session('timezone'))->startOfDay())
                ->where('created_at', '<=', now(session('timezone'))->endOfDay());
        else if($transaction_period_range === Transaction::WEEKLY)
            return Auth::user()->transactions
                ->where('created_at', '>=', now(session('timezone'))->startOfWeek())
                ->where('created_at', '<=', now(session('timezone'))->endOfWeek());
        else if($transaction_period_range === Transaction::MONTHLY)
            return Auth::user()->transactions
                ->where('created_at', '>=', now(session('timezone'))->startOfMonth())
                ->where('created_at', '<=', now(session('timezone'))->endOfMonth());
        else
            return Auth::user()->transactions
                ->where('created_at', '>=', now(session('timezone'))->startOfYear())
                ->where('created_at', '<=', now(session('timezone'))->endOfYear());
    }

    /**
     * @param $transaction_period_range
     * @param $category_type
     * @return float|int
     */
    private function transactionsIntoPeriodRangePerCategoryTypeAmount($transaction_period_range, $category_type)
    {
        $transactions = $this->filterTransactionsPerCategoryType($this->transactionsIntoPeriodRange($transaction_period_range), $category_type);
        return $this->transactionsAmount($transactions);
    }

    /**
     * @param $transaction_period_range
     * @param Category $category
     * @return float|int
     */
    private function transactionsIntoPeriodRangePerCategoryAmount($transaction_period_range, Category $category)
    {
        $transactions = $this->transactionsIntoPeriodRange($transaction_period_range)->where('category_id', $category->id);
        return $this->transactionsAmount($transactions);
    }

    /**
     * @param Collection $transactions
     * @return string
     */
    private function transactionsAmount(Collection $transactions)
    {
        $transactions_amount = $transactions->sum(function (Transaction $transaction) {
                if($transaction->is_stated) return $transaction->amount;
                return 0;
            }) / $this->getCurrency()->devaluation;

        return round($transactions_amount, 2);
    }

}