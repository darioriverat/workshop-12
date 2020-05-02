<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home', ['category_id' => request('category_id')]);
});

Route::get('/locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Auth::routes();

Route::resource('categories', 'CategoriesController')
    ->middleware('auth');

Route::resource('products', 'ProductsController')
    ->middleware('auth');

Route::resource('orders', 'OrdersController')
    ->middleware('auth');

Route::get('orders/create/{id?}', 'OrdersController@create')
    ->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
