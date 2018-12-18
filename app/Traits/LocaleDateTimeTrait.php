<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

trait LocaleDateTimeTrait
{
    /**
     * @return string
     */
    public function getCreatedDateAttribute()
    {
        return $this->dateFormat(App::getLocale(),
            $this->getTimezoneDate($this->created_at));
    }

    /**
     * @return string
     */
    public function getLongCreatedDateAttribute()
    {
        return $this->dateLongFormat(App::getLocale(),
            $this->getTimezoneDate($this->created_at));
    }

    /**
     * @return string
     */
    public function getCreatedTimeAttribute()
    {
        return $this->timeFormat(App::getLocale(),
            $this->getTimezoneDate($this->created_at));
    }

    /**
     * @return string
     *
     */
    public function getFrCreatedDateAttribute()
    {
        return $this->dateFormat('fr',
            $this->getTimezoneDate($this->created_at));
    }

    /**
     * @return string
     *
     */
    public function getFrLongCreatedDateAttribute()
    {
        return $this->dateLongFormat('fr',
            $this->getTimezoneDate($this->created_at));
    }

    /**
     * @return string
     *
     */
    public function getFrCreatedTimeAttribute()
    {
        return $this->timeFormat('fr',
            $this->getTimezoneDate($this->created_at));
    }

    /**
     * @return string
     */
    public function getUpdatedDateAttribute()
    {
        return $this->dateFormat(App::getLocale(),
            $this->getTimezoneDate($this->updated_at));
    }

    /**
     * @return string
     */
    public function getLongUpdatedDateAttribute()
    {
        return $this->dateLongFormat(App::getLocale(),
            $this->getTimezoneDate($this->updated_at));
    }

    /**
     * @return string
     */
    public function getUpdatedTimeAttribute()
    {
        return $this->timeFormat(App::getLocale(),
            $this->getTimezoneDate($this->updated_at));
    }

    /**
     * @return string
     */
    public function getFrUpdatedDateAttribute()
    {
        return $this->dateFormat('fr',
            $this->getTimezoneDate($this->updated_at));
    }

    /**
     * @return string
     */
    public function getFrLongUpdatedDateAttribute()
    {
        return $this->dateLongFormat('fr',
            $this->getTimezoneDate($this->updated_at));
    }

    /**
     * @return string
     */
    public function getFrUpdatedTimeAttribute()
    {
        return $this->timeFormat('fr',
            $this->getTimezoneDate($this->updated_at));
    }

    /**
     * @param $locale
     * @param Carbon $date
     * @return string
     */
    private function dateDayFormat($locale, Carbon $date)
    {
        if($locale === 'en')
        {
            return trans('day.i' . $date->dayOfWeek) . ' ' .
                trans('month.i' . $date->month) . ' ' .
                $date->day . ' ' .
                $date->year;
        }
        else
        {
            return trans('day.i' . $date->dayOfWeek) . ' ' .
                $date->day . ' ' .
                trans('month.i' . $date->month) . ' ' .
                $date->year;
        }
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
                $this->timeFormat($locale, $date);
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
        if($locale === 'en')
        {
            return trans('day.' . $date->dayOfWeek) . ' ' .
                trans('month.' . $date->month) . ' ' .
                $date->day . ' ' .
                $date->year . ' at ' .
                $this->timeFormat($locale, $date);
        }
        else
        {
            return trans('day.' . $date->dayOfWeek) . ' ' .
                $date->day . ' ' .
            trans('month.' . $date->month) . ' ' .
                $date->year . ' à ' .
            $this->timeFormat($locale, $date);
        }
    }

    /**
     * @param $locale
     * @param Carbon $date
     * @return string
     */
    private function dateFormat($locale, Carbon $date)
    {
        if($locale === 'en') $format = 'm/d/Y';
        else $format = 'd/m/Y';

        return $date->format($format);
    }

    /**
     * @param $locale
     * @param Carbon $date
     * @return string
     */
    private function timeFormat($locale, Carbon $date)
    {
        if($locale === 'en') $format = 'h:i A';
        else $format = 'H:i';

        return $date->format($format);
    }

    /**
     * @param Carbon $date
     * @return Carbon
     */
    private function getTimezoneDate(Carbon $date)
    {
        $timezone_date = new Carbon($date, 'UTC');
        $timezone_date->setTimezone(session('timezone'));
        return $timezone_date;
    }
}