<?php 

namespace App\Utils;
 
class AmountSeparator
{
    public $decimals;
    public $thousands;

    /**
     * AmountSeparator constructor.
     * @param $decimals
     * @param $thousands
     */
    public function __construct($decimals, $thousands)
    {
        $this->decimals = $decimals;
        $this->thousands = $thousands;
    }
}