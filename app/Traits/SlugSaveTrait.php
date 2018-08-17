<?php

namespace App\Traits;

trait SlugSaveTrait
{
    /**
     * Boot functions
     */
    protected static function bootSlugSaveTrait()
    {
        static::creating(function ($model) {
            $model->slug = str_slug($model->name);
        });

        static::updating(function ($model) {
            $model->slug = str_slug($model->name);
        });
    }
}