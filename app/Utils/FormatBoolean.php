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
     * @param $text
     * @param string $icon
     */
    public function __construct($color, $text, $icon = '')
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->color = $color;
    }
}