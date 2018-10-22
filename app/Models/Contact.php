<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Traits\LocaleDateTimeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed email
 * @property mixed is_read
 * @property mixed subject
 * @property mixed format_name
 */
class Contact extends Model
{
    use LocaleDateTimeTrait, NameTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone',
        'subject', 'message'
    ];
}
