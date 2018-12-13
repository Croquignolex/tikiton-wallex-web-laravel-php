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
 * @property mixed currency
 * @property mixed threshold
 * @property mixed is_stated
 * @property mixed authorised
 * @property mixed transactions
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
     * Boot functions
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($wallet) {
            $user = $wallet->currency->user;
            if ($wallet->balance === $wallet->threshold) {
                $user->notifications()->create([
                    'type' => Notification::REACHED,
                    'wallet_id' => $wallet->id
                ]);
            }
            elseif ($wallet->balance === 0.0) {
                $user->notifications()->create([
                    'type' => Notification::EMPTY,
                    'wallet_id' => $wallet->id
                ]);
            }
            elseif ($wallet->balance < $wallet->threshold) {
                $user->notifications()->create([
                    'type' => Notification::PASSED,
                    'wallet_id' => $wallet->id
                ]);
            }
        });

        static::created(function ($wallet) {
            $user = $wallet->currency->user;
            $user->notifications()->create([
                'type' => Notification::NEW,
                'wallet_id' => $wallet->id
            ]);
        });
    }

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
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    /**
     * @return string
     */
    public function getFormatThresholdAttribute()
    {
        $threshold = $this->threshold / $this->currency->devaluation;
        return $this->formatCurrency($this->formatNumber($threshold), $this->currency);
    }

    /**
     * @return string
     */
    public function getFormatBalanceAttribute()
    {
        $balance = $this->balance / $this->currency->devaluation;
        return $this->formatCurrency($this->formatNumber($balance), $this->currency);
    }

    /**
     * @return string
     */
    public function getFormatCurrentCurrencyBalanceAttribute()
    {
        $currency = Auth::user()->currencies()->where('is_current', true)->first();
        $balance = $this->balance / $currency->devaluation;
        return $this->formatNumber($balance);
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
        return $this->transactions->isEmpty();
    }

    /**
     * @return mixed
     */
    public function getAuthorisedAttribute()
    {
        return Auth::user()->wallets->contains($this);
    }
}
