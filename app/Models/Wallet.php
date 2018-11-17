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
 * @property mixed currency
 * @property mixed balance
 * @property mixed threshold
 * @property mixed is_stated
 * @property mixed authorised
 * @property mixed can_be_deleted
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
        'threshold', 'is_stated', 'currency_id'
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
     * @param Wallet $wallet
     * @return string
     */
    protected static function formatSlug(Wallet $wallet)
    {
        return $wallet->currency->user->id . '-' . str_slug($wallet->name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transactions()
    {
        return $this->belongsToMany('App\Models\Transaction')
            ->withPivot('type')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction_wallets()
    {
        return $this->hasMany('App\Models\TransactionWallet');
    }

    /**
     * @return string
     */
    public function getFormatThresholdAttribute()
    {
        return $this->formatCurrency($this->formatNumber($this->threshold), $this->currency);
    }

    /**
     * @return string
     */
    public function getFormatBalanceAttribute()
    {
        return $this->formatCurrency($this->formatNumber($this->balance), $this->currency);
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
    public function getCanBeDeletedAttribute()
    {
        //TODO: write the good condition
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
