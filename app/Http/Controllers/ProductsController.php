<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\ValidateProducts;
use App\Products;
use Illuminate\Support\Facades\Auth;
use FFI\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Logs;
use App\Traits\LoggerDataBase;
use Illuminate\Support\Facades\Lang;
use PDOException;
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
        $datos[$this->table] = Products::paginate(5);
        return view($this->table . '.index', $datos);
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
        return view($this->table . '.create', $datos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateProducts $request)
    {
        //
        $message = '';
        $product = $request->validated();
        try {
            if ($request->file('photo')) {
                $product['photo'] = $request->file('photo')->store('public/uploads');
                $product['photo'] = str_replace("public/uploads", "uploads", $product['photo']);
            }
            Products::create($product);
            $message = Lang::get('products.singular'). ' ' . $product['name'] . Lang::get('actions.create.success.male');

            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (PDOException $ex) {
            $message =  Lang::get('actions.create.error.male'). $product['name'];
            Log::error('Error', ['data' => $product, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table . '/create')->with(['product' => $product])->withErrors(['missingFields' =>  Lang::get('actions.create.error.male')]);
        } catch (Exception $ex) {
            Log::error('Error', ['data' => $product, 'error' => $ex]);
            $message =  Lang::get('actions.create.error.male');
            Alert::toast($message, 'error');
            return redirect($this->table . '/create');
        } finally {
            LoggerDataBase::insert($this->table,'Audit',$message);
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
        return view($this->table . '.edit', $datos, compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateProducts $request, $id)
    {
        //
        $message = '';
        $product = $request->validated();
        try {
            if ($request->file('photo')) {
                $oldProduct = products::findOrFail($id);
                Storage::delete('public/' . $oldProduct->photo);
                $product['photo'] = $request->file('photo')->store('public/uploads');
                $product['photo'] = str_replace("public/uploads", "uploads", $product['photo']);
            }

            $message = Lang::get('products.singular'). ' ' . $product['name'] . Lang::get('actions.edit.success.male');
            Products::findOrFail($id)->update($product);
            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (PDOException $ex) {
            $message = Lang::get('actions.edit.error.male');
            Log::error('Error', ['data' => $product, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table  . '/' . $id . '/edit')->with(['product' => $product])->withErrors(['missingFields' => Lang::get('actions.edit.error.male')]);
        } catch (Exception $ex) {
            $message = Lang::get('actions.edit.error.male');
            Log::error('Error', ['data' => $product, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table  . '/' . $id . '/edit')->with(['product' => $product])->withErrors(['Error' => Lang::get('actions.edit.error.male')]);
        } finally {
            LoggerDataBase::insert($this->table,'Audit',$message);
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
        $message = '';
        try {
            Products::destroy($id);
            if (Storage::delete('public/' . $product->photo)) {
                products::destroy($id);
            }
            $message = Lang::get('products.singular'). ' ' . $product->name .  Lang::get('actions.delete.success.male');
            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (PDOException $ex) {
            $message =  Lang::get('actions.delete.error.male');
            Log::error('Error', ['data' => $product, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table)->with(['product' => $product])->withErrors(['missingFields' =>  Lang::get('actions.delete.error.male')]);
        }catch (Exception $ex) {
            $message = Lang::get('actions.delete.error.male');
            Log::error('Error', ['data' => $product, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table);
        } finally {
            LoggerDataBase::insert($this->table,'Audit',$message);
        }
    }
}
