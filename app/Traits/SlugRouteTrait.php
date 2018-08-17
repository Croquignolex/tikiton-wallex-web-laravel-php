<?php

namespace App\Traits;

trait SlugRouteTrait
{
    /**
     * @return mixed
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}