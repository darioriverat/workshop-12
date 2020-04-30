<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        if (request()->has('category_id')) {
            $datos["products"] = Product::where('category_id',request('category_id'))->paginate(5);
        } else {
            $datos["products"] = Product::paginate(5);
        }
        $datos["categories"] = Category::all();
        return view('home',$datos);
    }

}
