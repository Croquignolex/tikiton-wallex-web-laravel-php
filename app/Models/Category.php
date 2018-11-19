<?php

namespace App\Models;

use App\Traits\SlugRouteTrait;
use App\Traits\SlugSaveTrait;
use App\Traits\LocaleAmountTrait;
use App\Traits\LocaleDateTimeTrait;
use App\Utils\FormatBoolean;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed icon
 * @property mixed user
 * @property mixed categories
 * @property mixed authorised
 * @property mixed transactions
 * @property mixed can_be_deleted
 * @property array|null|string type
 * @property array|null|string color
 * @property array|null|string user_id
 * @property array|null|string description
 */
class Category extends Model
{
    use LocaleDateTimeTrait, LocaleAmountTrait,
        SlugSaveTrait, SlugRouteTrait;

    const EXPENSE = 'expense';
    const TRANSFER = 'transfer';
    const INCOME = 'income';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'icon', 'color', 'type', 'user_id'
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
     * @param Category $category
     * @return string
     */
    protected static function formatSlug(Category $category)
    {
        return $category->user->id . '-' . str_slug($category->name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    /**
     * @return mixed
     */
    public function getAuthorisedAttribute()
    {
        return Auth::user()->categories->contains($this);
    }

    /**
     * @return mixed
     */
    public function getFormatTypeAttribute()
    {
        if($this->type === Category::EXPENSE) return new FormatBoolean('text-danger', trans('general.expense'), 'arrow-down');
        else if($this->type === Category::TRANSFER) return new FormatBoolean('text-info', trans('general.transfer'), 'exchange');
        else if($this->type === Category::INCOME) return new FormatBoolean('text-success', trans('general.income'), 'arrow-up');

        return new FormatBoolean('text-danger', trans('general.unknown'));
    }

    /**
     * @return mixed
     */
    public function getCanBeDeletedAttribute()
    {
        return $this->transactions->isEmpty();
    }
}
