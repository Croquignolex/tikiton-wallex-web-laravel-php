<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Traits\LocaleDateTimeTrait;
use App\Traits\LocaleDescriptionTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed image
 * @property mixed function
 * @property mixed extension
 * @property mixed format_name
 */
class Testimonial extends Model
{
    use NameTrait, LocaleDescriptionTrait, LocaleDateTimeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 'name', 'extension', 'function',
        'fr_description', 'en_description'
    ];

    /**
     * @return string
     */
    public function getImagePathAttribute()
    {
        return testimonial_img_asset($this->image, $this->extension);
    }

    /**
     * @return mixed
     */
    public function getFormatFunctionAttribute()
    {
        return ucfirst($this->function);
    }
}
