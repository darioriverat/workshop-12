<?php

namespace App;

use App\Events\EntityCreated;
use App\Events\EntityUpdating;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['quantity', 'paymentAmount', 'user_id', 'product_id', 'country', 'processUrl', 'requestId', 'status'];

    protected $dispatchesEvents = [
        'created' => EntityCreated::class,
        'updating' => EntityUpdating::class,
    ];

    /**
     * return product of order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
