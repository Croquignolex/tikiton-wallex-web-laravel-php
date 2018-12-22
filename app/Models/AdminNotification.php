<?php

namespace App\Models;

use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed type
 * @property mixed user
 * @property mixed details
 * @property mixed authorised
 */
class AdminNotification extends Model
{
    use LocaleDateTimeTrait;

    const NEW = 0;
    const CONFIRMED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'user_id'
    ];

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
        return Auth::user()->role->type !== Role::USER;
    }

    /**
     * @return mixed
     */
    public function getDetailsAttribute()
    {
        $user_name = $this->user->format_full_name;
        if ($this->type === static::NEW) return trans('notification.user_registered', ['name' => $user_name]);
        elseif ($this->type == static::CONFIRMED) return trans('notification.user_confirmed', ['name' => $user_name]);
        else return trans('general.unknown');
    }

    /**
     * @return mixed
     */
    public function getUrlAttribute()
    {
        return route('admin.users.show', [$this->user]);
    }

    /**
     * @return mixed
     */
    public function getIconAttribute()
    {
        if($this->type == static::NEW) return 'check';
        elseif ($this->type == static::CONFIRMED) return 'thumbs-up';
        return 'exclamation-triangle';
    }

    /**
     * @return mixed
     */
    public function getColorAttribute()
    {
        if($this->type == static::NEW) return 'info';
        elseif ($this->type == static::CONFIRMED) return 'success';
        return 'danger';
    }
}