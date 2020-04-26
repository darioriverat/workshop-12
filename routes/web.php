<?php

use App\Products;
use Illuminate\Support\Facades\Route;

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
    $datos["products"]=Products::paginate(5);
    return view('home',$datos);
});

Auth::routes();

Route::resource('categories', 'CategoriesController');
Route::resource('products', 'ProductsController');
Route::resource('orders', 'OrdersController');
Route::get('orders/create/{id?}', 'OrdersController@create');
Route::get('/home', 'HomeController@index')->name('home');
