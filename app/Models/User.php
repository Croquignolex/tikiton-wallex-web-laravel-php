<?php

namespace App\Models;

use App\Traits\DescriptionTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed id
 * @property mixed role
 * @property string city
 * @property mixed image
 * @property string phone
 * @property string token
 * @property string address
 * @property string country
 * @property mixed extension
 * @property string post_code
 * @property mixed authorised
 * @property mixed currencies
 * @property mixed is_factored
 * @property string profession
 * @property bool is_confirmed
 * @property string description
 * @property mixed user_settings
 * @property mixed password_reset
 * @property mixed format_full_name
 * @property mixed format_last_name
 * @property mixed format_first_name
 * @property array|null|string email
 * @property array|null|string password
 * @property array|null|string last_name
 * @property array|null|string first_name
 */
class User extends Authenticatable
{
    use LocaleDateTimeTrait, DescriptionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'post_code', 'extension',
        'city', 'country', 'phone', 'profession', 'address', 'role_id',
        'image', 'description', 'email', 'is_confirmed', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'is_confirmed', 'email'
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

        static::created(function ($user) {
            $user->admin_notifications()->create([
                'type' => AdminNotification::NEW
            ]);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function password_reset()
    {
        return $this->hasOne('App\Models\PasswordReset');
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
    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admin_notifications()
    {
        return $this->hasMany('App\Models\AdminNotification');
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
        if($this->role->type === Role::USER) return locale_route('account.validation', ['email' => $this->email, 'token' => $this->token]);
        else return route('admin.account.validation', ['email' => $this->email, 'token' => $this->token]);
    }

    /**
     * @return mixed
     */
    public function getDashboardRouteAttribute()
    {
        if($this->role->type === Role::USER) return locale_route('dashboard.index');
        else return route('admin.dashboard.index');
    }

    /**
     * @return mixed
     */
    public function getResetLinkAttribute()
    {
        if($this->role->type === Role::USER) return locale_route('password.reset', ['token' => $this->password_reset->token]);
        else return route('admin.password.reset', ['token' => $this->password_reset->token]);
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
    public function getAuthorisedAttribute()
    {
        return Auth::user()->role->type !== Role::USER;
    }
}
