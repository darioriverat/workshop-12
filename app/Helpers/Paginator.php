<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
    public static function paginate(Request $request, Collection $model, $perPage = 10): LengthAwarePaginator
    {
        $page = $request->input('page', 1);

        return new LengthAwarePaginator(
            $model->forPage($page, $perPage), $model->count(), $perPage, $page
        );
    }
}
