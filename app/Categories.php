<?php

namespace App;

use App\Events\EntityCreated;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['name', 'description'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => EntityCreated::class,
    ];
}
