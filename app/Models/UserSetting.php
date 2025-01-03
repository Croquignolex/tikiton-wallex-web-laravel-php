<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Utils\FormatBoolean;
use App\Traits\SlugSaveTrait;
use App\Traits\SlugRouteTrait;
use App\Traits\TableNameTrait;
use App\Traits\DescriptionTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property bool tips
 * @property mixed name
 * @property mixed user
 * @property mixed is_current
 * @property mixed authorised
 * @property mixed can_be_deleted
 */
class UserSetting extends Model
{
    use LocaleDateTimeTrait, NameTrait, DescriptionTrait,
        SlugSaveTrait, SlugRouteTrait, TableNameTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'tips', 'user_id', 'is_current'
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
     * @param UserSetting $userSetting
     * @return string
     */
    protected static function formatSlug(UserSetting $userSetting)
    {
        return $userSetting->user->id . '-' . str_slug($userSetting->name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return mixed
     */
    public function getFormatTipsAttribute()
    {
        return $this->tips
            ? new FormatBoolean('info', trans('general.yes'))
            : new FormatBoolean('warning', trans('general.no'));
    }

    /**
     * @return mixed
     */
    public function getAuthorisedAttribute()
    {
       return Auth::user()->user_settings->contains($this)
           || Auth::user()->role->type !== Role::USER;
    }

    /**
     * @return mixed
     */
    public function getCanBeDeletedAttribute()
    {
        return !$this->is_current;
    }
}
