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
    protected function monthsData(Category $category)
    {
        $perMonths = collect();
        for($i = 1; $i <= 12; $i++)
        {
            $month = now()->startOfYear()->addMonth($i - 1);
            $transactions = Auth::user()->transactions
                ->where('category_id', $category->id)
                ->where('created_at', '>=', $month->startOfMonth())
                ->where('created_at', '<=', $month->endOfMonth());
            $perMonths->push([
                'label' => trans('month.' . $i),
                'amount' => $this->transactions_category_amount($transactions, $category->type)
            ]);
        }
        return $perMonths;
    }

    /**
     * @param Category $category
     * @return Collection
     */
    protected function daysData(Category $category)
    {
        $perDays = collect();
        for($i = 1; $i <= 7; $i++)
        {
            $day = now()->startOfWeek()->addDay($i - 1);
            $transactions = Auth::user()->transactions
                ->where('category_id', $category->id)
                ->where('created_at', '>=', $day->startOfDay())
                ->where('created_at', '<=', $day->endOfDay());
            $perDays->push([
                'label' => trans('day.' . $i),
                'amount' => $this->transactions_category_amount($transactions, $category->type)
            ]);
        }
        return $perDays;
    }

    /**
     * @param $category_type
     * @return Collection
     */
    protected function monthsTypeData($category_type)
    {
        $perMonths = collect();
        for($i = 1; $i <= 12; $i++)
        {
            $month = now()->startOfYear()->addMonth($i - 1);
            $transactions = $this->filterTransactionsPerCategoryType(Auth::user()->transactions
                ->where('created_at', '>=', $month->startOfMonth())
                ->where('created_at', '<=', $month->endOfMonth()), $category_type);
            $perMonths->push([
                'label' => trans('month.' . $i),
                'amount' => $this->transactions_category_amount($transactions, $category_type)
            ]);
        }
        return $perMonths;
    }

    /**
     * @param $category_type
     * @return Collection
     */
    protected function daysTypeData($category_type)
    {
        $perDays = collect();
        for($i = 1; $i <= 7; $i++)
        {
            $day = now()->startOfWeek()->addDay($i - 1);
            $transactions = $this->filterTransactionsPerCategoryType(Auth::user()->transactions
                ->where('created_at', '>=', $day->startOfDay())
                ->where('created_at', '<=', $day->endOfDay()), $category_type);
            $perDays->push([
                'label' => trans('day.' . $i),
                'amount' => $this->transactions_category_amount($transactions, $category_type)
            ]);
        }
        return $perDays;
    }

    /**
     * @param $type
     * @return mixed
     */
    protected function transactions($type)
    {
        if($type === Transaction::DAILY)
            return Auth::user()->transactions
                ->where('created_at', '>=', now()->startOfDay())
                ->where('created_at', '<=', now()->endOfDay());
        else if($type === Transaction::WEEKLY)
            return Auth::user()->transactions
                ->where('created_at', '>=', now()->startOfWeek())
                ->where('created_at', '<=', now()->endOfWeek());
        else if($type === Transaction::MONTHLY)
            return Auth::user()->transactions
                ->where('created_at', '>=', now()->startOfMonth())
                ->where('created_at', '<=', now()->endOfMonth());
        else
            return Auth::user()->transactions
                ->where('created_at', '>=', now()->startOfYear())
                ->where('created_at', '<=', now()->endOfYear());
    }

    /**
     * @param Collection $transactions
     * @param $type
     * @return string
     */
    protected function transactions_category_amount(Collection $transactions, $type)
    {
       $currency = $this->getCurrency();

        $transactions_amount = $transactions->sum(function (Transaction $transaction) use ($type) {
            if($transaction->category->type === $type && $transaction->is_stated)
                return $transaction->amount;
            return 0;
        }) / $currency->devaluation;

        return round($transactions_amount, 2);
    }

    /**
     * @param $transaction_type
     * @param Category $category
     * @return float|int
     */
    protected function category_amount($transaction_type, Category $category)
    {
        $transactions = $this->transactions($transaction_type)
            ->where('category_id', $category->id);
        return $this->transactions_category_amount($transactions, $category->type);
    }

    /**
     * @param $transaction_type
     * @param $category_type
     * @return float|int
     */
    protected function category_type_amount($transaction_type, $category_type)
    {
        $transactions = $this->filterTransactionsPerCategoryType($this->transactions($transaction_type), $category_type);
        return $this->transactions_category_amount($transactions, $category_type);
    }

    /**
     * @param $transaction_type
     * @param $category_type
     * @return float|int
     */
    protected function transactions_amount($transaction_type, $category_type)
    {
        $transactions = $this->transactions($transaction_type);
        $transactions_amount = $this->transactions_category_amount($transactions, $category_type);
        return $this->formatNumber($transactions_amount);
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
    protected function getCurrency()
    {
        return Auth::user()->currencies
            ->where('is_current', true)->first();
    }
}