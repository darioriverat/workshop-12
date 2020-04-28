<?php

use App\Categories;
use App\Products;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   
    if (request()->has('category_id')) {
        $datos["products"] = Products::where('category_id',request('category_id'))->paginate(5);
    } else {
        $datos["products"] = Products::paginate(5);
    }
    $datos["categories"] = Categories::all();
 
    return view('home', $datos);
});

Route::get('/locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Auth::routes();

Route::resource('categories', 'CategoriesController');
Route::resource('products', 'ProductsController');
Route::resource('orders', 'OrdersController');
Route::get('orders/create/{id?}', 'OrdersController@create');
Route::get('/home', 'HomeController@index')->name('home');
