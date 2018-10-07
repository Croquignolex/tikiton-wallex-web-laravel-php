<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Traits\LocaleDateTimeTrait;
use App\Traits\LocaleFunctionTrait;
use App\Traits\LocaleDescriptionTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed image
 * @property mixed extension
 */
class Testimonial extends Model
{
    use NameTrait, LocaleDescriptionTrait,
        LocaleDateTimeTrait, LocaleFunctionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 'name', 'extension', 'fr_function',
        'en_function', 'fr_description', 'en_description'
    ];

    /**
     * @return string
     */
    public function getImagePathAttribute()
    {
        return testimonial_img_asset($this->image, $this->extension);
    }
}
