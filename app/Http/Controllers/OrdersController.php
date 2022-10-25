<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use App\Services\OrderService;


class OrdersController extends Controller {
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $service = (new OrderService());

        $service->makeOrder($request->all());
        die;
        $request->validate();

        $check = Product::isEnough(request('products'));

        if (!$check) {
            return response()->json(['message' => 'Some ingredients are not enough to prepare this order'], \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }

        $order = Order::createOrder(request('products'));

        return response()->json(['message' => 'The order has been created'], \Illuminate\Http\Response::HTTP_CREATED);
    }
}
