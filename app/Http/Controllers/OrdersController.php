<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\ValidateOrdersStore;
use App\Logs;
use App\Orders;
use App\Products;
use App\Traits\LoggerDataBase;
use PDOException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;


class OrdersController extends Controller
{
    public $table = "orders";

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
        $datos["orders"] =  DB::table('orders')
        ->join('products', function ($join) {
            $join->on('orders.product_id', '=', 'products.id');
        })->where('orders.user_id','=',Auth::user()->id)
        ->select('orders.*', 'products.name', 'products.description', 'products.price', 'products.photo', 'products.currency')
        ->paginate(5);
        return view($this->table . '.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = "")
    {
        //

        $product = Products::findOrFail($id);
        $product->category = Categories::findOrFail($product->category_id);
        return view($this->table . '.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateOrdersStore $request)
    {
        $message = '';
        $order = $request->validated();
        $order["user_id"] =  Auth::user()['id'];
        $order["paymentAmount"] = $order["quantity"] * Products::findOrFail($order['product_id'])->price;
        // echo $order;
        try {
            Orders::create($order);
            $message = 'Orden agregada correctamente';
            Alert::toast($message, 'success');
            return redirect($this->table);
        } catch (PDOException $ex) {
            $message = 'Ocurrio un error';
            Log::error('Error', ['data' => $order, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table . '/create')->with(['order' => $order])->withErrors(['missingFields' => 'Ocurrio un error ']);
        } catch (Exception $ex) {
            $message = 'Hubo un error al crear orden';
            Log::error('Error', ['data' => $request, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table . '/create')->withErrors(['Error' => 'Ocurrio un error ']);
        } finally {
            LoggerDataBase::insert($this->table,$message, 'Crear Orden');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
