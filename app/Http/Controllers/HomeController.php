<?php

namespace App\Http\Controllers;

use App\Category;
use App\Currency;
use App\Product;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $datos['products'] = Product::query()
            ->forIndex()
            ->paginate();

        $datos['categories'] = Category::all();
        return view('home', $datos);
    }
}
