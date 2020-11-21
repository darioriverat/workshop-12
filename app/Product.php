<?php

namespace App;

use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'photo', 'price', 'currency_id', 'category_id'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => EntityCreated::class,
        'updating' => EntityUpdating::class,
        'deleted' => EntityDeleted::class,
    ];

    /**
     * return Category of product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Return orders of products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeForIndex(Builder $query): Builder
    {
        return $query
            ->select('id', 'photo', 'name', 'description', 'price')
            ->addSelect(
                [
                'currency_code' => Currency::select('alpha_code')
                    ->whereColumn('products.currency_id', 'id')
                    ->limit(1),
                'category_name' => Category::select('name')
                    ->whereColumn('products.category_id', 'id')
                    ->limit(1)
                ]
            );
    }

    public function scopeForShow(Builder $query): Builder
    {
        return $query->select(
            'products.id',
            'products.photo',
            'products.name',
            'products.description',
            'products.price',
            'currencies.alpha_code as currency_code',
            'categories.name as category_name',
            'categories.id as category_id',
            'users.name as created_by'
        )
            ->join('currencies', 'currencies.id', '=', 'products.currency_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('users', 'users.id', '=', 'products.category_id');
    }
}
