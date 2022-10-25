<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class OrdersController extends Controller 
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        $service = (new OrderService());

        $service->makeOrder($request->all());

        return response(['message' => 'The order has been created'], \Illuminate\Http\Response::HTTP_CREATED);
    }
}
