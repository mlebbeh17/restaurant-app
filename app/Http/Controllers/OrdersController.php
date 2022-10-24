<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use App\Models\ProductIngredient;
use App\Models\Order;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'products'              => ['required', 'array'],
                'products.*.product_id' => ['required', 'int', 'gt:0'],
                'products.*.quantity'   => ['required', 'int', 'gt:0']
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json($th->validator->errors(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }

        $check = ProductIngredient::isEnough(request('products'));

        if (!$check) {
            return response()->json(['message' => 'Some ingredients are not enough to prepare this order'], \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }

        $order = Order::createOrder(request('products'));


        // var_dump($check);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
