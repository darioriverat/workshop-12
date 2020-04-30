<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $datos['products'] = Product::paginate(5);

        $datos['categories'] = Category::all();
        return view('home', $datos);
    }
}
