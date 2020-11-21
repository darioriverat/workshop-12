<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
    public static function paginate(Request $request, Collection $collection, $perPage = 15): LengthAwarePaginator
    {
        $page = $request->input('page', 1);

        return new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page
        );
    }
}
