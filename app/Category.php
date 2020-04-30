<?php

namespace App;

use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = ['name', 'description'];

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
     * Return products of category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
