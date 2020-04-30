<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\ValidateOrdersStore;
use App\Order;
use App\Product;
use App\Traits\PlaceToPayService;
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
        $datos['orders'] = Order::paginate(5);
        return view('orders.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateOrdersStore $request)
    {
        $order = $request->validated();
        $order['user_id'] = Auth::user()['id'];
        $order['paymentAmount'] = $order['quantity'] * Product::findOrFail($order['product_id'])->price;

        Order::create($order);

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $orders
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        if (($order->status == OrderStatus::CREATED || $order->status == OrderStatus::PENDING) && $order->requestId != '') {
            $requestInformation = PlaceToPayService::requestInformation($order->requestId, $order->country);
            if ($requestInformation->status() == OrderStatus::APPROVED) {
                Order::findOrFail($id)->update(['status' => OrderStatus::PAYED]);
            } elseif ($requestInformation->status() == OrderStatus::PENDING) {
                Order::findOrFail($id)->update(['status' => OrderStatus::PENDING]);
            } else {
                Order::findOrFail($id)->update(['status' => OrderStatus::REJECTED]);
            }
        }

        $order = Order::findOrFail($id);

        return view('orders.summary', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $orders
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $order = Order::findOrFail($id);
        $order['user'] = Auth::user();
        $order['product'] = Product::findOrFail($order['product_id']);

        $requestPlaceToPay = PlaceToPayService::createRequest($order);
        $servicePlaceToPay = PlaceToPayService::createServicePlaceToPay($order->country);
        $responsePlaceToPay = $servicePlaceToPay->request($requestPlaceToPay);

        if ($responsePlaceToPay->isSuccessful()) {
            Order::findOrFail($id)->update([
                'status' => OrderStatus::PENDING,
                'requestId' => $responsePlaceToPay->requestId(),
                'processUrl' => $responsePlaceToPay->processUrl(),
            ]);
            return redirect()->to($responsePlaceToPay->processUrl());
        }
    }
}
