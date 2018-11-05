<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

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

    private static function formatSlug(Model $model)
    {
        return $model->user->id . '-' . str_slug($model->name);
    }
}