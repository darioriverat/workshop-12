<?php

namespace App\Http\Controllers;

use App\Category;
use App\Country;
use App\Currency;
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $datos['orders'] = Order::query()
            ->addSelect([
                'currency_name' => Currency::select('alpha_code')
                    ->where([
                        'id' => function ($query) {
                            $query->select([
                                'product_id' => Product::select('currency_id')
                                    ->whereColumn('orders.product_id', 'products.id')
                                    ->limit(1)
                            ]);
                        }
                    ])
                    ->limit(1),
                'product_photo' => Product::select('photo')
                    ->whereColumn('orders.product_id', 'products.id')
                    ->limit(1),
                'product_name' => Product::select('name')
                    ->whereColumn('orders.product_id', 'products.id')
                    ->limit(1),
                'country_name' => Country::select('alpha_2_code')
                    ->whereColumn('id', 'orders.country_id')
                    ->limit(1),
            ])->paginate();
        return view('orders.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create($id)
    {
        $product = Product::findOrFail($id);
        $countries = Country::all();
        return view('orders.create', compact('product', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidateOrdersStore $request
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
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
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function update(Order $order)
    {
        $order->product = $order->product->first();
        $order->user = Auth::user();

        $pay = event(new PayOrder($order));

        if ($pay) {
            return redirect()->to($order->process_url);
        }

        return view('orders.summary', compact('order'));
    }
}
