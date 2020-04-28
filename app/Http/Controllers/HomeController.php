<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Products;
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
            $datos["products"] = Products::where('category_id',request('category_id'))->paginate(5);
        } else {
            $datos["products"] = Products::paginate(5);
        }
        $datos["categories"] = Categories::all();
        return view('home',$datos);
    }

}
