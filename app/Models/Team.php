<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Traits\LocaleFunctionTrait;
use App\Traits\LocaleDateTimeTrait;
use App\Traits\LocaleDescriptionTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed image
 * @property mixed extension
 */
class Team extends Model
{
    use NameTrait, LocaleDescriptionTrait,
        LocaleDateTimeTrait, LocaleFunctionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image', 'extension',
        'fr_function', 'en_function',
    ];

    /**
     * @return string
     */
    public function getImagePathAttribute()
    {
        return team_img_asset($this->image, $this->extension);
    }
}
