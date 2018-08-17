<?php

namespace App\Traits;

trait LocaleSlugSaveTrait
{
    /**
     * Boot functions
     */
    protected static function bootLocaleSlugSaveTrait()
    {
        static::creating(function ($model) {
            $model->slug = str_slug($model->en_name);
        });

        static::updating(function ($model) {
            $model->slug = str_slug($model->en_name);
        });
    }
}