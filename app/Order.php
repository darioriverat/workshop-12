<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['quantity', 'paymentAmount', 'user_id', 'product_id', 'country', 'processUrl', 'requestId', 'status'];
}
