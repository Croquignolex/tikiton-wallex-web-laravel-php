<?php

namespace App\Models;

use App\Traits\SlugSaveTrait;
use App\Traits\LocaleAmountTrait;
use App\Traits\CurrentElementTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property mixed symbol
 * @property mixed authorised
 * @property mixed is_current
 * @property mixed devaluation
 */
class Currency extends Model
{
    use LocaleDateTimeTrait, LocaleAmountTrait,
        SlugSaveTrait, SlugSaveTrait, CurrentElementTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'symbol', 'user_id',
        'is_current', 'devaluation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'slug'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return mixed
     */
    public function getAuthorisedAttribute()
    {
        return Auth::user()->currencies->contains($this);
    }

    /**
     * @return string
     */
    public function getFormatDevaluationAttribute()
    {
        $devaluation = $this->formatNumber($this->devaluation);

        if(App::getLocale() === 'fr')
            $devaluation = $devaluation . ' XAF';
        else if (App::getLocale() === 'en')
            $devaluation = 'XAF ' . $devaluation;
        else  return $this->formatNumber($this->devaluation) . ' XAF';

        return $devaluation;
    }
}
