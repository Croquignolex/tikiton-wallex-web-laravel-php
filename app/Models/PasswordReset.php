<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed token
 */
class PasswordReset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email'
    ];

    /**
     * Boot functions
     */
    protected static function boot()
    {
        static::creating(function ($password_reset) {
            $password_reset->token = str_random(64);
        });
    }

    /**
     * @return mixed
     */
    public function getResetLinkAttribute()
    {
        return locale_route('password.reset', [
            'token' => $this->token
        ]);
    }
}
