<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Utils\FormatBoolean;
use App\Traits\SlugSaveTrait;
use App\Traits\SlugRouteTrait;
use App\Traits\DescriptionTrait;
use App\Traits\LocaleAmountTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed stated
 * @property mixed balance
 * @property mixed threshold
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
        'threshold', 'stated', 'user_id', 'currency_id'
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
        return $this->formatNumber($this->threshold);
    }

    /**
     * @return string
     */
    public function getFormatBalanceAttribute()
    {
        return $this->formatNumber($this->balance);
    }

    /**
     * @return string
     */
    public function getFormatStatedAttribute()
    {
        return $this->stated
            ? new FormatBoolean('success', 'fa fa-check', trans('general.stated'))
            : new FormatBoolean('danger', 'fa fa-times', trans('general.not_stated'));
    }
}
