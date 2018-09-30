<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait LocaleNameTrait
{
    /**
     * @return mixed
     */
    public function getFormatNameAttribute()
    {
        $name = '';

        if(App::getLocale() === 'fr') $name = $this->fr_name;
        else if (App::getLocale() === 'en') $name = $this->en_name;

        return ucfirst($name);
    }
}