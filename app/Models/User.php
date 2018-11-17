<?php

namespace App\Models;

use App\Traits\DescriptionTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string city
 * @property mixed image
 * @property string phone
 * @property string token
 * @property bool is_admin
 * @property string address
 * @property string country
 * @property mixed extension
 * @property string post_code
 * @property string profession
 * @property bool is_confirmed
 * @property string description
 * @property bool is_super_admin
 * @property mixed format_last_name
 * @property mixed format_first_name
 * @property array|null|string email
 * @property array|null|string password
 * @property array|null|string last_name
 * @property array|null|string first_name
 */
class User extends Authenticatable
{
    //TODO:Create user default settings where a new user is added
    use LocaleDateTimeTrait, DescriptionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'post_code', 'extension',
        'city', 'country', 'phone', 'profession', 'address',
        'image', 'description', 'email', 'is_confirmed', 'is_admin',
        'is_super_admin', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'is_confirmed', 'is_admin', 'is_super_admin', 'email'
    ];

    /**
     * Boot functions
     */
    protected static function boot()
    {
        static::creating(function ($user) {
            $user->token = str_random(64);
            $user->password = Hash::make($user->password);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function transactions()
    {
        return $this->hasManyThrough('App\Models\Transaction', 'App\Models\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function wallets()
    {
        return $this->hasManyThrough('App\Models\Wallet', 'App\Models\Currency');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currencies()
    {
        return $this->hasMany('App\Models\Currency');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_settings()
    {
        return $this->hasMany('App\Models\UserSetting');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

    /**
     * @return string
     */
    public function getImagePathAttribute()
    {
        return user_img_asset($this->image, $this->extension);
    }

    /**
     * @return mixed
     */
    public function getConfirmationLinkAttribute()
    {
        return locale_route('account.validation', [
            'email' => $this->email, 'token' => $this->token
        ]);
    }

    /**
     * @return mixed
     */
    public function getFormatFirstNameAttribute()
    {
        return ucfirst($this->first_name);
    }

    /**
     * @return mixed
     */
    public function getFormatLastNameAttribute()
    {
        return mb_strtoupper($this->last_name);
    }

    /**
     * @return mixed
     */
    public function getFormatFullNameAttribute()
    {
        return $this->format_first_name . ' ' . $this->format_last_name;
    }

    /**
     * @return mixed
     */
    public function getFormatRoleAttribute()
    {
        if($this->is_super_admin) return trans('general.super_admin');
        elseif($this->is_admin) return trans('general.admin');

        return trans('general.user');
    }
}
