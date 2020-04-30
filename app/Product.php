<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';

    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['name', 'description','photo','price','currency','category_id'];
}
