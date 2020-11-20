<?php

namespace App\Http\Controllers;

use App\Events\GetResponsePayment;
use App\Events\PayOrder;
use App\Http\Requests\ValidateOrdersStore;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['orders'] = Order::with('product')->paginate(5);
        return view('orders.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = '')
    {
        $product = Product::findOrFail($id);
        return view('orders.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidateOrdersStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateOrdersStore $request)
    {
        $order = $request->validated();
        $order['user_id'] = Auth::user()['id'];
        $order['payment_amount'] = $order['quantity'] * Product::findOrFail($order['product_id'])->price;

        Order::create($order);

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        event(new GetResponsePayment(Order::findOrFail($id)));

        $order = Order::findOrFail($id);

        return view('orders.summary', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $order = Order::find($id);
        $order->product = $order->product()->get()->first();
        $order->user = Auth::user();

        $pay = event(new PayOrder($order));

        if ($pay) {
            return redirect()->to(Order::findOrFail($id)->process_url);
        } else {
            $order = Order::findOrFail($id);
            return view('orders.summary', compact('order'));
        }
    }
}
