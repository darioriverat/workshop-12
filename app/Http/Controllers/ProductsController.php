<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ValidateProducts;
use App\Product;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['products'] = Product::paginate(5);
        return view('products.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datos['categories'] = Category::getCachedCategories();

        return view('products.create', $datos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidateProducts $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateProducts $request)
    {
        $product = $request->validated();

        if ($request->file('photo')) {
            $product['photo'] = $request->file('photo')->store('public/uploads');
            $product['photo'] = str_replace('public/uploads', 'uploads', $product['photo']);
        }

        Product::create($product);

        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('category')->findOrFail(
            $id,
            ['id', 'name', 'description', 'price', 'currency', 'category_id']
        );
        $datos['categories'] = Category::getCachedCategories();

        return view('products.edit', $datos, compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ValidateProducts $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateProducts $request, $id)
    {
        $product = $request->validated();

        if ($request->file('photo')) {
            $oldProduct = Product::findOrFail($id);
            Storage::delete('public/' . $oldProduct->photo);
            $product['photo'] = $request->file('photo')->store('public/uploads');
            $product['photo'] = str_replace('public/uploads', 'uploads', $product['photo']);
        }

        Product::findOrFail($id)->update($product);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('products.index');
    }
}
