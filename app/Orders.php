<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
    protected $table = 'orders';
 
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['quantity', 'paymentAmount','user_id','product_id','country','processUrl','requestId','status'];
}
