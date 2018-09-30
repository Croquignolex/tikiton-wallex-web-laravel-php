<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed image
 * @property mixed function
 * @property mixed extension
 * @property mixed format_name
 */
class Partner extends Model
{
    use NameTrait, LocaleDateTimeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 'name', 'extension'
    ];

    /**
     * @return string
     */
    public function getImagePathAttribute()
    {
        return partner_img_asset($this->image, $this->extension);
    }
}
