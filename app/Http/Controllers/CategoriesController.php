<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ValidateCategories;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['categories'] = Category::paginate(5);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateCategories $request)
    {
        $category = $request->validated();
        Category::create($category);

        return redirect()->route('categories.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ValidateCategories $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateCategories $request, int $id)
    {
        $category = $request->validated();
        Category::findOrFail($id)->update($category);

        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('categories.index');
    }
}
