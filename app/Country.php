<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Country extends Model
{
    protected $guarded = [];

    protected $casts = [
        'dial_codes' => 'array'
    ];

    public static function getCachedCountries()
    {
        return Cache::rememberForever('country', function () {
            return Country::all();
        });
    }
}
