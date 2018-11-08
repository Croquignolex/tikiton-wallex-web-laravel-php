<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Utils\FormatBoolean;
use App\Traits\SlugSaveTrait;
use App\Traits\SlugRouteTrait;
use App\Traits\DescriptionTrait;
use App\Traits\LocaleAmountTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed balance
 * @property mixed threshold
 * @property mixed is_stated
 * @property mixed can_delete
 * @property mixed authorised
 */
class Wallet extends Model
{
    use LocaleDateTimeTrait, NameTrait, SlugRouteTrait,
        DescriptionTrait, LocaleAmountTrait, SlugSaveTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'color', 'balance',
        'threshold', 'is_stated', 'user_id'
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
     * @return string
     */
    public function getFormatThresholdAttribute()
    {
        return $this->formatCurrency($this->formatNumber($this->threshold));
    }

    /**
     * @return string
     */
    public function getFormatBalanceAttribute()
    {
        return $this->formatCurrency($this->formatNumber($this->balance));
    }

    /**
     * @return string
     */
    public function getFormatStatedAttribute()
    {
        return $this->is_stated
            ? new FormatBoolean('info', trans('general.stated'))
            : new FormatBoolean('warning', trans('general.not_stated'));
    }

    /**
     * @return mixed
     */
    public function getCanDeleteAttribute()
    {
        return true;
        //return $this->transactions->count === 0;
    }

    /**
     * @return mixed
     */
    public function getAuthorisedAttribute()
    {
        return Auth::user()->wallets->contains($this);
    }
}
