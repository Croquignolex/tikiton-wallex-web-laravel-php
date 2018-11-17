<?php 

namespace App\Utils;
 
class Link
{
    public $text;
    public $icon;
    public $href;

    /**
     * AccountStated constructor.
     * @param $text
     * @param $href
     * @param string $icon
     */
    public function __construct($text, $href, $icon = '')
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->href = $href;
    }
}