<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\ValidateCategories;
use App\Logs ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FFI\Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log as Log;
use PDOException;

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
        $datos[$this->table] = Categories::paginate(5);
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
        return view($this->table . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateCategories $request)
    {
        $message = '';
        $category = $request->validated();
        try {
            Categories::create($category);
            $message = 'Categoria ' . $category['name'] . ' agregado correctamente';
            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (Exception $ex) {
            $message = 'Hubo un error al crear ' . $category['name'];
            Log::error('Error', ['data' => $request, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table . '/create')->withErrors(['Error' => 'Ocurrio un error ']);
        } finally {
            $this->LogCategories($message);
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
    public function update(ValidateCategories $request, $id)
    {
        //
        $oldCategory = Categories::findOrFail($id);
        $message = '';
        $category = $request->validated();
        try {
            $message = 'Categoria ' . $category['name'] . ' modificada con éxito ';
            Categories::findOrFail($id)->update($category);
            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (Exception $ex) {
            $message = 'Hubo un error al modificar la categoria ' . $category['name'];
            Log::error('Error', ['data' => $request, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table  . '/' . $id . '/edit')->with(['category' => $oldCategory])->withErrors(['Error' => 'Ocurrio un error ']);
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

        $message = '';
        try {
            $category = Categories::findOrFail($id);
            Categories::destroy($category->id);
            $message = 'Categoria ' . $category->name . ' eliminada con éxito ';
            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (Exception $ex) {
            $message = 'Hubo un error al eliminar el categoria ' . $category->name;
            Log::error('Error', ['data' => $category, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table)->withErrors(['Error' => 'Ocurrio un error ']);
        } finally {
            $this->logCategories($message);
        }
    }

    public function logCategories($description)
    {
        try {

            $log = [
                'user' => Auth::user()['email'],
                'source' => $this->table,
                'type' => 'Audit',
                'ipAddress' =>  $_SERVER['HTTP_CLIENT_IP'] ?? '1270.0.1',
                'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'description' => $description,
            ];
            Logs::create($log);
        } catch (Exception $ex) {
        }
    }
}
