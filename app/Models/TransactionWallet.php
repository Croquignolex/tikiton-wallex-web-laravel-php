<?php

namespace App\Models;

use App\Traits\LocaleDateTimeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed amount
 * @property mixed category
 * @property mixed authorised
 * @property mixed can_be_deleted
 */
class TransactionWallet extends Model
{
    use LocaleDateTimeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet_id', 'transaction_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'wallet_id', 'transaction_id'
    ];
}
