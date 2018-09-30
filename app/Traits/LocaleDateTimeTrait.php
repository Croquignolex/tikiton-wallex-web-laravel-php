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
     * @return string
     */
    private function timeFormat($locale)
    {
        if($locale === 'fr') return 'H:i';
        elseif ($locale === 'en') return 'h:i A';
        else return 'H:i';
    }
}