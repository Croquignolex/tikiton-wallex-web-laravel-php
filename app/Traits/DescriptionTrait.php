<?php

namespace App\Traits;

trait DescriptionTrait
{
    /**
     * @return mixed
     */
    public function getFormatDescriptionAttribute()
    {
        return ucfirst($this->description);
    }
}