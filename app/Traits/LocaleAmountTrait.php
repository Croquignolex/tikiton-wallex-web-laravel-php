<?php

namespace App\Traits;

use App\Models\Currency;
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
        $separator = $this->separatorDisplay('fr');
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
        $separator = $this->separatorDisplay('en');
        return number_format(
            $amount, 2,
            $separator->decimals,
            $separator->thousands
        );
    }

    /**
     * @param $amount
     * @param Currency $currency
     * @return string
     */
    private function enFormatCurrency($amount, Currency $currency)
    {
        return $this->currencyDisplay(App::getLocale(), $amount, $currency->symbol);
    }

    /**
     * @param $amount
     * @param Currency $currency
     * @return string
     */
    private function frFormatCurrency($amount, Currency $currency)
    {
        return $this->currencyDisplay(App::getLocale(), $amount, $currency->symbol);
    }

    /**
     * @param $amount
     * @param Currency $currency
     * @return string
     */
    private function formatCurrency($amount, Currency $currency)
    {
        return $this->currencyDisplay(App::getLocale(), $amount, $currency->symbol);
    }

    /**
     * @param $amount
     * @return string
     */
    private function formatNumber($amount)
    {
        $separator = $this->separatorDisplay(App::getLocale());
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
    private function separatorDisplay($locale)
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
    private function currencyDisplay($locale, $amount, $symbol)
    {
        if($locale === 'fr') return $amount . ' ' . $symbol;
        else if ($locale === 'en') return $symbol . ' ' . $amount;
        else return $amount . $symbol;
    }
}