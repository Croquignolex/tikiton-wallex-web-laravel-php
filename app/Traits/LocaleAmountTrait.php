<?php

namespace App\Traits;

use App\Utils\AmountSeparator;
use Illuminate\Support\Facades\App;

trait LocaleAmountTrait
{
    /**
     * @param $amount
     * @return string
     */
    public function frFormatNumber($amount)
    {
        $separator = $this->separator('fr');
        return number_format(
            $amount, 2,
            $separator->decimals,
            $separator->thousands
        );
    }

    /**
     * @param $amount
     * @return string
     */
    public function enFormatNumber($amount)
    {
        $separator = $this->separator('en');
        return number_format(
            $amount, 2,
            $separator->decimals,
            $separator->thousands
        );
    }

    /**
     * @param $amount
     * @return string
     */
    private function formatNumber($amount)
    {
        $separator = $this->separator(App::getLocale());
        return number_format(
            $amount, 2,
            $separator->decimals,
            $separator->thousands
        );
    }

    /**
     * @param $locale
     * @return AmountSeparator
     */
    private function separator($locale)
    {
        if($locale === 'fr') return new AmountSeparator(',', '.');
        else if ($locale === 'en') return new AmountSeparator('.', ',');

        return new AmountSeparator(',', '.');
    }
}