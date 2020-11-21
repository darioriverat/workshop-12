<?php

namespace App\Http\Controllers;

use App\Category;
use App\Currency;
use App\Http\Requests\ValidateProducts;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $datos['products'] = Product::query()
            ->forIndex()
            ->paginate();
        return view('products.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {

        return view('products.create', [
            'categories' => Category::all(),
            'currencies' => Currency::all(),
            'product' => new Product(),
        ]);
    }

    public function show($productId)
    {

        $product = Product::query()
            ->forShow()
            ->findOrFail($productId);

        return view('products.show', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidateProducts $request
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $datos['categories'] = Category::getCachedCategories();
        $datos['currencies'] = Currency::getCachedCurrencies();

        return view('products.edit', $datos, compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ValidateProducts $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('products.index');
    }
}
