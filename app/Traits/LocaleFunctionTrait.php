<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait LocaleFunctionTrait
{
    /**
     * @return mixed
     */
    public function getFormatFunctionAttribute()
    {
        $name = '';

        if(App::getLocale() === 'fr')   $name = $this->fr_function;
        else if (App::getLocale() === 'en')  $name = $this->en_function;

        return ucfirst($name);
    }
}