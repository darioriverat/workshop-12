<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public $table = "categories";

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
        $datos[$this->table] = Categories::all();
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
        return view($this->table.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug('debug',[$request]);
        $message='';
        $category = $request->except('_token');
        Log::debug('debugCategory',[$request]);
        try {
            Categories::insert($category);
            $message= 'Categoria ' .$category['name'] .' agregado correctamente' ;
            Alert::toast($message, 'success'); 
            return redirect($this->table);
        } catch (\Throwable $th) {
            $message= 'Hubo un error al crear ' .$category['name'] ;
            Log::error('Error', ['data'=>$request ,'error' => $th]);
            Alert::toast($message, 'error'); 
            return redirect($this->table . '/create');
        } finally {
            $this->logCategories($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view($this->table . '.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $message ='';
        $category = $request->except(['_token', '_method']);
        try {
            $message = 'Categoria ' .$category['name'] .' modificada con éxito ';
            Categories::where('id', '=', $id)->update($category);
            Alert::toast($message, 'success'); 
            return redirect($this->table);
        } catch (\Throwable $th) {
            $message = 'Hubo un error al modificar la categoria ' .$category['name'] ;
            Log::error('Error', ['data'=>$request ,'error' => $th]);
            Alert::toast($message, 'error'); 
            return redirect($this->table . '/create');
        } finally {
            $this->logCategories($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $message ='';
        try {
            Categories::destroy($id);
            $message = 'Categoria ' . $category->name. ' eliminada con éxito ' ;
            Alert::toast($message, 'success'); 
            return redirect($this->table);
        } catch (\Throwable $th) {
            $message = 'Hubo un error al eliminar el categoria ' . $category->name;
            Log::error('Error', ['data'=>$category ,'error' => $th]);
            Alert::toast($message, 'error'); 
            return redirect($this->table);
        } finally {
            $this->logCategories($message);
        }
    }

    public function logCategories($description)
    {
        $log = [
            'user' =>Auth::user()['email'],
            'source'=>$this->table ,
            'type'=>'Audit',
            'ipAddress' =>  $_SERVER['REMOTE_ADDR'],
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],
            'description'=>$description,
        ];
        DB::table('logs')->insert($log);
    }
}
