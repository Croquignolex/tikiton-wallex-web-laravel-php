<?php

namespace App\Traits;

trait NameTrait
{
    /**
     * @return mixed
     */
    public function getFormatNameAttribute()
    {
        return ucfirst($this->name);
    }
}