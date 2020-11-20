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
            $datos['products'] = Product::with('category')
                ->where('category_id', request('category_id'))
                ->paginate(5);
        } else {
            $datos['products'] = Product::with('category')->paginate(5);
        }
        $datos['categories'] = Category::getCachedCategories();
        return view('home', $datos);
    }
}
