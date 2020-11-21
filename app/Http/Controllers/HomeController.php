<?php

namespace App\Http\Controllers;

use App\Category;
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
        if (request('category_id')) {
            $datos['products'] = Product::where('category_id', request('category_id'))->paginate();
        } else {
            $datos['products'] = Product::paginate();
        }
        $datos['categories'] = Category::all();
        return view('home', $datos);
    }
}
