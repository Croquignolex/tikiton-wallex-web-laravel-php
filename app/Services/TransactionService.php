<?php

namespace App\Services;

use App\Utils\Link;
use Carbon\Carbon;
use App\Models\Transaction;

class TransactionService
{
    /**
     * @param $date_range
     * @param string $type
     * @return string
     */
    public function getDateRange($date_range, $type)
    {
        if($type === Transaction::BEGIN) $date = Carbon::now()->addMonth($date_range)->startOfMonth();
        else $date =  Carbon::now()->addMonth($date_range)->endOfMonth();
        return $date->day . ' ' . trans('month.' . $date->month) . ' ' . $date->year;
    }

    /**
     * @param $date_range
     * @param $route
     * @return Link
     */
    public function getMonthChanger($date_range, $route)
    {
        $date = Carbon::now()->addMonth($date_range);
        return new Link(trans('month.' . $date->month) . ' ' . $date->year,
            $route . '?date=' . $date_range);
    }
}