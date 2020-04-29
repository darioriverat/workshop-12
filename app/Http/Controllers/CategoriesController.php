<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Events\EntityCreated;
use App\Events\ModelError;
use App\Http\Requests\ValidateCategories;
use App\Listeners\LogModelError;
use App\Traits\LoggerDataBase;
use Exception;
use Illuminate\Support\Facades\Lang;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use PDOException;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['categories'] = Categories::paginate(5);
        return view('categories.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateCategories $request)
    {
        $category = $request->validated();
        Categories::create($category);

        return redirect()->route('categories.index');
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
