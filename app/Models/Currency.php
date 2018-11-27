<?php

namespace App\Models;

use App\Traits\SlugRouteTrait;
use App\Traits\SlugSaveTrait;
use App\Traits\LocaleAmountTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed user
 * @property mixed symbol
 * @property mixed wallets
 * @property mixed authorised
 * @property mixed is_current
 * @property mixed devaluation
 * @property mixed can_be_deleted
 */
class Currency extends Model
{
    use LocaleDateTimeTrait, LocaleAmountTrait,
        SlugSaveTrait, SlugRouteTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'symbol', 'user_id',
        'devaluation', 'is_current'
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
     * @param Currency $currency
     * @return string
     */
    protected static function formatSlug(Currency $currency)
    {
        return $currency->user->id . '-' . str_slug($currency->name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets()
    {
        return $this->hasMany('App\Models\Wallet');
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

    /**
     * @return mixed
     */
    public function getCanBeDeletedAttribute()
    {
        return $this->wallets->isEmpty() && !$this->is_current;
    }
}
