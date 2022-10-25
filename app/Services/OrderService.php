<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Validation\ValidationException;
use App\Events\OrderCreated;

class OrderService 
{

	public function makeOrder(array $data) 
	{

		$validator = validator()->make($data, [
            'products'              => ['required', 'array'],
            'products.*.product_id' => ['required', 'int', 'gt:0'],
            'products.*.quantity'   => ['required', 'int', 'gt:0']
        ])->validate();

		$groupedProducts = collect($data['products'])->groupBy('product_id')->map(function ($group) {
            return $group->sum('quantity');
        });

        $this->validateIngredientsEnough($groupedProducts);

        $order = Order::create();

        $groupedProducts->each(function($quantity, $productId) use ($order) {
        	OrderProduct::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => $quantity
            ]);
        });

        OrderCreated::dispatch($order);

	}

	public function validateIngredientsEnough($data)
	{

		$products = Product::with('ingredients')->whereIn('id', $data->keys())->get();

		$errors = [];

		$products->each(function($product) use (&$errors, $data) {
			$product->ingredients->each(function($ingredient) use ($product, &$errors, $data) {
				if ($ingredient->pivot->quantity * $data[$product->id] > $ingredient->quantity) {
					$errors[$product->id] = 'no enough ingredients for product ' . $product->name;
				}
			});
		});

		if (!empty($errors)) {
			throw ValidationException::withMessages(array_values($errors));
		}
	}
}