<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Traits\SlugSaveTrait;
use App\Traits\SlugRouteTrait;
use App\Traits\DescriptionTrait;
use App\Traits\LocaleAmountTrait;
use App\Traits\LocaleDateTimeTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed pivot
 * @property mixed amount
 * @property mixed wallet
 * @property mixed wallets
 * @property mixed category
 * @property mixed authorised
 * @property mixed can_be_deleted
 * @property mixed transaction_wallets
 */
class Transaction extends Model
{
    use LocaleDateTimeTrait, NameTrait, SlugRouteTrait,
        DescriptionTrait, LocaleAmountTrait, SlugSaveTrait;

    const BEGIN = 0;
    const END = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'amount', 'category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'slug', 'category_id'
    ];

    protected static function formatSlug(Transaction $transaction)
    {
        return $transaction->category->user->id . '-' . str_slug($transaction->name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wallets()
    {
        return $this->belongsToMany('App\Models\Wallet')
            ->withPivot('type')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction_wallets()
    {
        return $this->hasMany('App\Models\TransactionWallet');
    }

    /**
     * @return string
     */
    public function getFormatAmountAttribute()
    {
        return $this->formatCurrency($this->formatNumber($this->amount), $this->wallet->currency);
    }

    /**
     * @return mixed
     */
    public function getCanBeDeletedAttribute()
    {
        //TODO: write the good condition
        return true;
        //return $this->transactions->count === 0;
    }

    /**
     * @return mixed
     */
    public function getIsATransferAttribute()
    {
        return $this->category->type === Category::TRANSFER;
    }

    /**
     * @return mixed
     */
    public function getAuthorisedAttribute()
    {
        return Auth::user()->transactions->contains($this);
    }

    /**
     * @return mixed
     */
    public function getWalletAttribute()
    {
        return $this->wallets->first();
    }

    /**
     * @return mixed
     */
    public function getTransferWalletAttribute()
    {
        return $this->wallets->last();
    }
}
