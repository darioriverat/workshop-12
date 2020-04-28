<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\ValidateCategories;
use App\Logs ;
use App\Traits\LoggerDataBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FFI\Exception;
use Illuminate\Support\Facades\Lang;
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
            $message = Lang::get('categories.singular'). ' ' . $category['name'] . Lang::get('actions.create.success.female');
            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (Exception $ex) {
            $message =  Lang::get('actions.create.error.female'). $category['name'];
            Log::error('Error', ['data' => $request, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table . '/create')->withErrors(['Error' => Lang::get('actions.create.error.female')]);
        } finally {
            LoggerDataBase::insert($this->table,'Audit',$message);
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
            $message = Lang::get('categories.singular'). ' ' . $category['name'] . Lang::get('actions.edit.success.female');
           Categories::findOrFail($id)->update($category);
            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (Exception $ex) {
            $message =  Lang::get('actions.edit.error.female'). $category['name'];
            Log::error('Error', ['data' => $request, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table  . '/' . $id . '/edit')->with(['category' => $oldCategory])->withErrors(['Error' => Lang::get('actions.edit.error.female')]);
        } finally {
            LoggerDataBase::insert($this->table,'Audit',$message);
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
            $message = Lang::get('products.singular'). ' ' . $category->name .  Lang::get('actions.delete.success.female');
            Alert::toast($message, 'success');
            return redirect($this->table);
        }  catch (PDOException $ex) {
            $message =  Lang::get('actions.delete.error.female');
            Log::error('Error', ['data' => $category, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table)->with(['category' => $category])->withErrors(['missingFields' =>  Lang::get('actions.delete.error.female')]);
        }catch (Exception $ex) {
            $message = 'Hubo un error al eliminar el categoria ' . $category->name;
            Log::error('Error', ['data' => $category, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table)->withErrors(['Error' => Lang::get('actions.delete.error.female')]);
        } finally {
            LoggerDataBase::insert($this->table,'Audit',$message);
        }
    }
}
