<?php

namespace App\Traits;

use App\Models\Currency;
use App\Utils\AmountSeparator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
    private function enFormatCurrency($amount)
    {
        return $this->currency(App::getLocale(), $amount,
            Currency::where('is_current', true)->first()->symbol);
    }

    /**
     * @param $amount
     * @return string
     */
    private function frFormatCurrency($amount)
    {
        return $this->currency(App::getLocale(), $amount,
            Currency::where('is_current', true)->first()->symbol);
    }

    /**
     * @param $amount
     * @return string
     */
    private function formatCurrency($amount)
    {
        return $this->currency(App::getLocale(), $amount,
            Auth::user()->currencies->where('is_current', true)->first()->symbol);
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

    /**
     * @param $locale
     * @param $amount
     * @param $symbol
     * @return string
     */
    private function currency($locale, $amount, $symbol)
    {
        if($locale === 'fr') return $amount . ' ' . $symbol;
        else if ($locale === 'en') return $symbol . ' ' . $amount;
        else return $amount . $symbol;
    }
}