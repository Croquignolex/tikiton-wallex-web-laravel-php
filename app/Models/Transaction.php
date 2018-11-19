<?php

namespace App\Models;

use App\Traits\NameTrait;
use App\Utils\FormatBoolean;
use App\Traits\SlugSaveTrait;
use App\Traits\SlugRouteTrait;
use App\Traits\DescriptionTrait;
use App\Traits\LocaleAmountTrait;
use App\Traits\LocaleDateTimeTrait;
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
 * @property mixed created_at
 * @property mixed authorised
 * @property mixed transfer_wallet
 * @property mixed can_be_deleted
 * @property mixed transaction_wallets
 * @property mixed is_an_expense
 * @property mixed is_a_transfer
 * @property mixed is_an_income
 */
class Transaction extends Model
{
    use LocaleDateTimeTrait, NameTrait, SlugRouteTrait,
        DescriptionTrait, LocaleAmountTrait, SlugSaveTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'amount', 'category_id', 'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'slug', 'category_id'
    ];

    /**
     * Boot functions
     */
    protected static function boot()
    {
        static::deleting(function ($transaction) {
            if($transaction->is_an_income) $transaction->wallet->update(['balance' => $transaction->wallet->balance - $transaction->amount]);
            else if($transaction->is_an_expense) $transaction->wallet->update(['balance' => $transaction->wallet->balance + $transaction->amount]);
            else
            {
                if($transaction->wallet->id !== $transaction->transfer_wallet->id)
                {
                    $transaction->transfer_wallet->update(['balance' => $transaction->transfer_wallet->balance - $transaction->amount]);
                    $transaction->wallet->update(['balance' => $transaction->wallet->balance + $transaction->amount]);
                }
            }
        });
    }

    /**
     * @param Transaction $transaction
     * @return string
     */
    protected static function formatSlug(Transaction $transaction)
    {
        return $transaction->category->user->id . '-' .
            str_slug($transaction->name) . '-' .
            str_slug(now());
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
           ->withTimestamps();
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
        if($this->is_an_income)
            return $this->wallet->balance >= $this->amount;
        else if($this->is_a_transfer)
            return ($this->wallet->id === $this->transfer_wallet->id) ||
                ($this->transfer_wallet->balance >= $this->amount);

        return true;
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
    public function getIsAnIncomeAttribute()
    {
        return $this->category->type === Category::INCOME;
    }

    /**
     * @return mixed
     */
    public function getIsAnExpenseAttribute()
    {
        return $this->category->type === Category::EXPENSE;
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

    /**
     * @return mixed
     */
    public function getFormatTypeAttribute()
    {
        if($this->is_an_expense) return new FormatBoolean('text-danger', trans('general.expense'), 'arrow-down');
        else if($this->is_a_transfer) return new FormatBoolean('text-info', trans('general.transfer'), 'exchange');
        else if($this->is_an_income) return new FormatBoolean('text-success', trans('general.income'), 'arrow-up');

        return new FormatBoolean('text-danger', trans('general.unknown'));
    }
}
