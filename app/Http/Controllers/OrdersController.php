<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Enums\OrderStatus;
use App\Http\Requests\ValidateOrdersStore;
use App\Orders;
use App\Products;
use App\Traits\LoggerDataBase;
use App\Traits\PlaceToPayService;
use PDOException;
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
            })->where('orders.user_id', '=', Auth::user()->id)
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
            return redirect($this->table . '/create/' . $order['product_id'])->with(['order' => $order])->withErrors(['missingFields' => 'Ocurrio un error ']);
        } catch (Exception $ex) {
            $message = 'Hubo un error al crear orden';
            Log::error('Error', ['data' => $request, 'error' => $ex]);
            Alert::toast($message, 'error');
            return redirect($this->table . '/create/' . $order['product_id'])->withErrors(['Error' => 'Ocurrio un error ']);
        } finally {
            LoggerDataBase::insert($this->table, $message, 'Crear Orden');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Orders::findOrFail($id);
        if (($order->status == OrderStatus::CREATED || $order->status == OrderStatus::PENDING) && $order->requestId != '') {
            $requestInformation = PlaceToPayService::requestInformation($order->requestId,$order->country);
            if ($requestInformation->status() == OrderStatus::APPROVED) {
                Orders::findOrFail($id)->update(
                    [
                        'status' => OrderStatus::PAYED
                    ]
                );
                print_r(Orders::findOrFail($id));
            } else if ($requestInformation->status()  == OrderStatus::PENDING) {
                Orders::findOrFail($id)->update(
                    [
                        'status' => OrderStatus::PENDING
                    ]
                );
            } else {
                Orders::findOrFail($id)->update(
                    [
                        'status' => OrderStatus::REJECTED
                    ]
                );
            }
        }
        // print_r($order);
        $order = $this->getOrder($id);
        return view('orders.summary', compact('order'));
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
    public function update($id)
    {
        try {
            $order = Orders::findOrFail($id);
            $order["user"] = Auth::user();
            $order["product"] = Products::findOrFail($order["product_id"]);
            $requestPlaceToPay = PlaceToPayService::createRequest($order);
            $servicePlaceToplay = PlaceToPayService::createServicePlaceToPay($order->country);
            $responsePlaceToPay = $servicePlaceToplay->request($requestPlaceToPay);
            if ($responsePlaceToPay->isSuccessful()) {
                Orders::findOrFail($id)->update(array(
                    'status' => OrderStatus::PENDING,
                    'requestId' => $responsePlaceToPay->requestId(),
                    'processUrl' => $responsePlaceToPay->processUrl()
                ));
                header("Location: " . $responsePlaceToPay->processUrl());
                exit;
            } else {
                echo $responsePlaceToPay->status()->message();
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
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
    /**
     * Obtiene un solo registro de orden en la base de datos
     * @param id codigo unico de la orden
     */
    public function getOrder($id)
    {
        return DB::table('orders')
            ->join('products', function ($join) {
                $join->on('orders.product_id', '=', 'products.id');
            })
            ->join('categories', function ($join) {
                $join->on('products.category_id', '=', 'categories.id');
            })
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'products.name', 'products.description', 'products.price', 'products.photo', 'products.currency', 'categories.name as category_name')
            ->get()[0];
    }
    
}
