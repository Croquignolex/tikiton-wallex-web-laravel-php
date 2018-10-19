<?php 

namespace App\Utils;
 
class Image
{
    public $name;
    public $extension;

    /**
     * AmountSeparator constructor.
     * @param $name
     * @param $extension
     */
    public function __construct($name, $extension)
    {
        $this->name = $name;
        $this->extension = $extension;
    }
}