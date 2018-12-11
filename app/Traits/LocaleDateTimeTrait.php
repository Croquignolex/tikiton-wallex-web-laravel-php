<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

trait LocaleDateTimeTrait
{
    //private $time_zone = 'America/Toronto';

    /**
     * @return string
     */
    public function getCreatedDateAttribute()
    {
        $date = new Carbon($this->created_at);
        return $date->format($this->dateFormat(App::getLocale()));
    }

    /**
     * @return string
     */
    public function getLongCreatedDateAttribute()
    {
        $date = new Carbon($this->created_at);
        return $this->dateLongFormat(App::getLocale(), $date);
    }

    /**
     * @return string
     */
    public function getCreatedTimeAttribute()
    {
        $date = new Carbon($this->created_at);
        return $date->format($this->timeFormat(App::getLocale())) . ' GMT';
    }

    /**
     * @return string
     *
     */
    public function getFrCreatedDateAttribute()
    {
        $date = new Carbon($this->created_at);
        return $date->format($this->dateFormat('fr'));
    }

    /**
     * @return string
     *
     */
    public function getFrLongCreatedDateAttribute()
    {
        $date = new Carbon($this->created_at);
        return $this->dateLongFormat('fr', $date);
    }

    /**
     * @return string
     *
     */
    public function getFrCreatedTimeAttribute()
    {
        $date = new Carbon($this->created_at);
        return $date->format($this->timeFormat('fr')) . ' GMT';
    }

    /**
     * @return string
     */
    public function getUpdatedDateAttribute()
    {
        $date = new Carbon($this->updated_at);
        return $date->format($this->dateFormat(App::getLocale()));
    }

    /**
     * @return string
     */
    public function getLongUpdatedDateAttribute()
    {
        $date = new Carbon($this->updated_at);
        return $this->dateLongFormat(App::getLocale(), $date);
    }

    /**
     * @return string
     */
    public function getUpdatedTimeAttribute()
    {
        $date = new Carbon($this->updated_at);
        return $date->format($this->timeFormat(App::getLocale())) . ' GMT';
    }

    /**
     * @return string
     */
    public function getFrUpdatedDateAttribute()
    {
        $date = new Carbon($this->updated_at);
        return $date->format($this->dateFormat('fr'));
    }

    /**
     * @return string
     */
    public function getFrLongUpdatedDateAttribute()
    {
        $date = new Carbon($this->updated_at);
        return $this->dateLongFormat('fr', $date);
    }

    /**
     * @return string
     */
    public function getFrUpdatedTimeAttribute()
    {
        $date = new Carbon($this->updated_at);
        return $date->format($this->timeFormat('fr')) . ' GMT';
    }

    /**
     * @param $locale
     * @return string
     */
    private function dateFormat($locale)
    {
        if($locale === 'fr') return 'd/m/Y';
        elseif ($locale === 'en') return 'm/d/Y';
        else return 'd/m/Y';
    }

    /**
     * @param $locale
     * @param Carbon $date
     * @return string
     */
    private function dateDayFormat($locale, Carbon $date)
    {
        if($locale === 'fr')
        {
            return trans('day.i' . $date->dayOfWeek) . ' ' .
                $date->day . ' ' .
                trans('month.i' . $date->month) . ' ' .
                $date->year;
        }
        elseif ($locale === 'en')
        {
            return trans('day.i' . $date->dayOfWeek) . ' ' .
                trans('month.i' . $date->month) . ' ' .
                $date->day . ' ' .
                $date->year;
        }
        else return trans('general.unknown');
    }

    /**
     * @param $locale
     * @param Carbon $date
     * @return string
     */
    private function dateWeekFormat($locale, Carbon $date)
    {
        if($locale === 'fr' || $locale === 'en')
            return trans('general.week') . ' ' .
                $date->weekOfYear . ' ' . trans('general.of') . ' ' . $date->year;
        else return trans('general.unknown');
    }

    /**
     * @param $locale
     * @param Carbon $date
     * @return string
     */
    private function dateShortFormat($locale, Carbon $date)
    {
        if($locale === 'fr' || $locale === 'en')
            return trans('month.' . $date->month) . ' ' . $date->year;
        else return trans('general.unknown');
    }

    /**
     * @param $locale
     * @param Carbon $date
     * @return string
     */
    private function dateMediumFormat($locale, Carbon $date)
    {
        if($locale === 'fr' || $locale === 'en')
        {
            return $this->dateDayFormat($locale, $date) . ' ' .
                $date->format($this->timeFormat($locale)) . ' GMT';
        }
        else return trans('general.unknown');
    }

    /**
     * @param $locale
     * @param Carbon $date
     * @return string
     */
    private function dateLongFormat($locale, Carbon $date)
    {
        if($locale === 'fr')
        {
            return trans('day.' . $date->dayOfWeek) . ' ' .
                $date->day . ' ' .
                trans('month.' . $date->month) . ' ' .
                $date->year . ' à ' .
                $date->format($this->timeFormat($locale)) . ' GMT';
        }
        elseif ($locale === 'en')
        {
            return trans('day.' . $date->dayOfWeek) . ' ' .
                trans('month.' . $date->month) . ' ' .
                $date->day . ' ' .
                $date->year . ' at ' .
                $date->format($this->timeFormat($locale)) . ' GMT';
        }
        else return trans('general.unknown');
    }

    /**
     * @param $locale
     * @return string
     */
    private function timeFormat($locale)
    {
        if($locale === 'fr') return 'H:i';
        elseif ($locale === 'en') return 'h:i A';
        else return 'H:i';
    }
}