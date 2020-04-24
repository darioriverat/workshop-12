<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductsController extends Controller
{
    public $table = "products";

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos[$this->table] = Products::all();
        return view($this->table.'.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $datos["categories"] = Categories::all();
        return view($this->table.'.create', $datos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $message='';
        $product = $request->except('_token');
        try {
            if ($request->file('photo')) {
                $product['photo'] = $request->file('photo')->store('public/uploads');
                $product['photo'] = str_replace("public/uploads", "uploads", $product['photo']);
            }
            Products::insert($product);
            $message= 'Producto ' .$product['name'] .' agregado correctamente' ;
            Alert::toast($message, 'success'); 
            return redirect($this->table);
        } catch (\Throwable $th) {
            Log::error('Error', ['data'=>$product ,'error' => $th]);
            $message= 'Hubo un error al crear ' .$product['name'] ;
            Alert::toast($message, 'error'); 
            return redirect($this->table);
        } finally {
            $this->logProducts($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Products::findOrFail($id);
        $datos["categories"] = Categories::all();
        return view($this->table . '.edit', $datos,compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $message ='';
        $product = $request->except(['_token', '_method']);
        try {
            if ($request->file('photo')) {
                $oldProduct = products::findOrFail($id);
                Storage::delete('public/' . $oldProduct->photo);
                $product['photo'] = $request->file('photo')->store('public/uploads');
                $product['photo'] = str_replace("public/uploads", "uploads", $product['photo']);
            }
            $message = 'Producto ' .$product['name'] .' modificado con éxito ';
            Products::where('id', '=', $id)->update($product);
            Alert::toast($message, 'success'); 
            return redirect($this->table);
        } catch (\Throwable $th) {
            $message = 'Hubo un error al modificar el producto ' .$product['name'] ;
            Alert::toast($message, 'error'); 
            return redirect($this->table);
        } finally {
            $this->logProducts($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $message ='';
        try {
            Products::destroy($id);
            if (Storage::delete('public/' . $product->photo)) {
                products::destroy($id);
            }
            $message = 'Producto ' . $product->name. ' eliminada con éxito ' ;
            Alert::toast($message, 'success'); 
            return redirect($this->table);
        } catch (\Throwable $th) {
            $message = 'Hubo un error al eliminar el producto ' . $product->name;
            Alert::toast($message, 'error'); 
            return redirect($this->table);
        } finally {
            $this->logProducts($message);
        }
    }

    public function logProducts($description)
    {
        $log = [
            'user' =>Auth::user()['email'],
            'source'=>$this->table ,
            'type'=>'Audit',
            'description'=>$description,
            'ipAddress' =>  $_SERVER['REMOTE_ADDR'],
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],
        ];

        DB::table('logs')->insert($log);
    }
}
