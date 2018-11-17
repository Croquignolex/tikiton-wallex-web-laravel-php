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
            $model->slug = static::formatSlug($model);
        });

        static::updating(function ($model) {
            $model->slug =  static::formatSlug($model);
        });
    }
}