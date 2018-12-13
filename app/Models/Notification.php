<?php

namespace App\Models;

use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed type
 * @property mixed wallet
 * @property mixed details
 * @property mixed authorised
 */
class Notification extends Model
{
    use LocaleDateTimeTrait;

    const NEW = 0;
    const REACHED = 1;
    const PASSED = 2;
    const EMPTY = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'user_id', 'wallet_id'
    ];

    /**
     * Honer of the account
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo('App\Models\Wallet');
    }

    /**
     * Honer of the account
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
        return Auth::user()->notifications->contains($this);
    }

    /**
     * @return mixed
     */
    public function getDetailsAttribute()
    {
        $wallet_name = $this->wallet->name;
        if ($this->type === Notification::NEW) return trans('notification.wallet_created', ['name' => $wallet_name]);
        elseif ($this->type == Notification::REACHED) return trans('notification.threshold_reached', ['name' => $wallet_name]);
        elseif ($this->type == Notification::PASSED) return trans('notification.threshold_passed', ['name' => $wallet_name]);
        elseif ($this->type == Notification::EMPTY) return trans('notification.wallet_empty', ['name' => $wallet_name]);
        else return trans('general.unknown');
    }

    /**
     * @return mixed
     */
    public function getUrlAttribute()
    {
        return locale_route('wallets.show', [$this->wallet]);
    }

    /**
     * @return mixed
     */
    public function getIconAttribute()
    {
        if($this->type == static::NEW) return 'battery-full';
        elseif ($this->type == static::REACHED) return 'battery-half';
        elseif ($this->type == static::PASSED) return 'battery-quarter';
        elseif ($this->type == static::EMPTY) return 'battery-empty';
        return 'exclamation-triangle';
    }

    /**
     * @return mixed
     */
    public function getColorAttribute()
    {
        if($this->type == static::NEW) return 'success';
        elseif ($this->type == static::REACHED) return 'info';
        elseif ($this->type == static::PASSED) return 'warning';
        elseif ($this->type == static::EMPTY) return 'danger';
        return 'danger';
    }
}