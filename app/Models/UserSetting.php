<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Utils\FormatBoolean;
use App\Traits\SlugSaveTrait;
use App\Traits\SlugRouteTrait;
use App\Traits\DescriptionTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed id
 * @property bool tips
 * @property mixed name
 * @property mixed is_current
 * @property mixed authorised
 */
class UserSetting extends Model
{
    use LocaleDateTimeTrait, NameTrait, DescriptionTrait,
        SlugSaveTrait, SlugRouteTrait;

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
            ? new FormatBoolean('success', 'fa fa-check', trans('general.yes'))
            : new FormatBoolean('danger', 'fa fa-times', trans('general.no'));
    }

    /**
     * @return mixed
     */
    public function getFormatCurrentAttribute()
    {
        return $this->is_current
            ? new FormatBoolean('success', 'fa fa-check', trans('general.activated'))
            : new FormatBoolean('danger', 'fa fa-times', trans('general.not_activated'));
    }

    public function getAuthorisedAttribute()
    {
       return Auth::user()->user_settings->contains($this);
    }
}
