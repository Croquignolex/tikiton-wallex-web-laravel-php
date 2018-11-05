<?php 

namespace App\Utils;
 
class FormatBoolean
{
    public $text;
    public $icon;
    public $color;

    /**
     * AccountStated constructor.
     * @param $color
     * @param $icon
     * @param $text
     */
    public function __construct($color, $icon, $text)
    {
        $this->icon = $icon;
        $this->text = $text;
        $this->color = $color;
    }
}