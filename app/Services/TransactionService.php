<?php

namespace App\Services;

use App\Models\Category;
use App\Utils\FormatBoolean;
use Carbon\Carbon;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\App;

class TransactionService
{
    use LocaleDateTimeTrait;

    /**
     * @param $date
     * @return string
     */
    public function getMediumFormatDate(Carbon $date)
    {
        return $this->dateMediumFormat(App::getLocale(), $date);
    }

    /**
     * @param $date
     * @return string
     */
    public function getNormalFormatDate(Carbon $date)
    {
        $locale = App::getLocale();
        if($locale === 'fr' || $locale === 'en')
        {
            return $date->format($this->dateFormat($locale)) . ' ' .
                $date->format($this->timeFormat($locale));
        }
        else return trans('general.unknown');
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