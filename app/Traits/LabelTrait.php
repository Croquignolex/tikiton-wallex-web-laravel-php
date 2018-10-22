<?php

namespace App\Traits;

trait LabelTrait
{
    /**
     * @return mixed
     */
    public function getFormatLabelAttribute()
    {
        return ucfirst($this->label);
    }
}