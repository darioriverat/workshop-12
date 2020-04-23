<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
 
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['name', 'description'];
}
