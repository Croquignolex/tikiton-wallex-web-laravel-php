<?php

namespace App\Traits;

use App\Utils\AmountSeparator;
use Illuminate\Support\Facades\App;

trait LocaleAmountTrait
{
    /**
     * @return string
     */
    public function getAmountAttribute()
    {
        return $this->formatAmount($this->price);
    }

    /**
     * @return string
     */
    public function getFrAmountAttribute()
    {
        return $this->frFormatAmount($this->price);
    }

    /**
     * @return string
     */
    public function getEnAmountAttribute()
    {
        return $this->enFormatAmount($this->price);
    }

    /**
     * @return string
     */
    public function getNewPriceAttribute()
    {
        $discount = ($this->price * $this->discount) / 100;
        return $this->formatAmount($this->price - $discount);
    }

    /**
     * @return string
     */
    public function getFrNewPriceAttribute()
    {
        $discount = ($this->price * $this->discount) / 100;
        return $this->frFormatAmount($this->price - $discount);
    }

    /**
     * @return string
     */
    public function getEnNewPriceAttribute()
    {
        $discount = ($this->price * $this->discount) / 100;
        return $this->enFormatAmount($this->price - $discount);
    }

    /**
     * @param $amount
     * @return string
     */
    public function frFormatAmount($amount)
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
    public function enFormatAmount($amount)
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
    private function formatAmount($amount)
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