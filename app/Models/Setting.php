<?php

namespace App\Models;

use App\Traits\LabelTrait;
use App\Traits\DescriptionTrait;
use App\Traits\LocaleAmountTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed tva
 * @property mixed label
 * @property mixed is_activated
 */
class Setting extends Model
{
    use LocaleAmountTrait, LocaleDateTimeTrait, LabelTrait, DescriptionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receive_email_from_contact', 'tva','receive_email_from_register',
        'label', 'description'
    ];

    /**
     * @return mixed
     */
    public function getFormatTvaAttribute()
    {
        return $this->formatAmount($this->tva);
    }
}
