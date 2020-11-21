<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Currency extends Model
{
    protected $guarded = [];

    public static function getCachedCurrencies()
    {
        return Cache::rememberForever('currencies', function() {
            return Currency::all();
        });
    }
}
