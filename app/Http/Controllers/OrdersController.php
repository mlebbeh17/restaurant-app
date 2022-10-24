<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class OrdersController extends Controller {
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'products'              => ['required', 'array'],
            'products.*.product_id' => ['required', 'int', 'gt:0'],
            'products.*.quantity'   => ['required', 'int', 'gt:0']
        ]);

        $check = Product::isEnough(request('products'));

        if (!$check) {
            return response()->json(['message' => 'Some ingredients are not enough to prepare this order'], \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }

        $order = Order::createOrder(request('products'));

        return response()->json(['message' => 'The order has been created'], \Illuminate\Http\Response::HTTP_CREATED);
    }
}
