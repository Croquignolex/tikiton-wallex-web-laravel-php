<?php 

namespace App\Utils;
 
class FormatBoolean
{
    public $text;
    public $color;

    /**
     * AccountStated constructor.
     * @param $color
     * @param $text
     */
    public function __construct($color, $text)
    {
        $this->text = $text;
        $this->color = $color;
    }
}