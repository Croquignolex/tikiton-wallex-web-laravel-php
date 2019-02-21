<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\Category;
use App\Utils\FormatBoolean;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\App;

class TransactionService
{
    use LocaleDateTimeTrait;

    /**
     * @param $date
     * @return string
     */
    public function getDayFormatDate(Carbon $date)
    {
        return $this->dateDayFormat(App::getLocale(), $this->getTimezoneDate($date));
    }

    /**
     * @param $date
     * @return string
     */
    public function getWeekFormatDate(Carbon $date)
    {
        return $this->dateWeekFormat(App::getLocale(), $this->getTimezoneDate($date));
    }

    /**
     * @param $date
     * @return string
     */
    public function getMonthFormatDate(Carbon $date)
    {
        return $this->dateShortFormat(App::getLocale(), $this->getTimezoneDate($date));
    }

    /**
     * @param $date
     * @return string
     */
    public function getMediumFormatDate(Carbon $date)
    {
        return $this->dateMediumFormat(App::getLocale(), $date);
    }

    /**
     * @param Carbon $date
     * @param string $tz
     * @return string
     */
    public function getNormalFormatDate(Carbon $date, $tz = '')
    {
        $locale = App::getLocale();
        if($locale === 'fr' || $locale === 'en')
        {
            if($tz === '') return $this->dateFormat($locale, $date) . ' ' . $this->timeFormat($locale, $date);
            else
            {
                $timezone_date = $this->getTimezoneDate($date);
                return $this->dateFormat($locale, $timezone_date) . ' ' . $this->timeFormat($locale, $timezone_date);
            }
        }
        else return trans('general.unknown');
    }

    /**
     * @param $date_range
     * @param string $type
     * @param $route
     * @return \Illuminate\Support\Collection
     */
    public function getDateRangeChanger($date_range, $type, $route = '')
    {
        $monthChanger = collect();
        $monthChanger->push($route . '?date=' . $date_range . '&type=' . $type);
        $date = now(session('timezone'));

        if($type === Transaction::DAILY)
        {
            $date->addDay($date_range);
            $monthChanger->push($this->getDayFormatDate($date));
        }
        else if($type === Transaction::WEEKLY)
        {
            $date->addWeek($date_range);
            $monthChanger->push($this->getWeekFormatDate($date));
        }
        else if($type === Transaction::MONTHLY)
        {
            $date->addMonth($date_range);
            $monthChanger->push($this->getMonthFormatDate($date));
        }
        else
        {
            $date->addYear($date_range);
            $monthChanger->push($date->year);
        }

        return $monthChanger;
    }

    /**
     * @param $type
     * @return string
     */
    public function getFormatType($type)
    {
        if($type === Category::EXPENSE) return new FormatBoolean('text-danger', trans('general.expense'), 'arrow-down');
        else if($type === Category::TRANSFER) return new FormatBoolean('text-info', trans('general.transfer'), 'exchange');
        else if($type === Category::INCOME) return new FormatBoolean('text-success', trans('general.income'), 'arrow-up');

        return new FormatBoolean('text-danger', trans('general.unknown'));
    }
}