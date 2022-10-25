<?php

namespace App\Services;

use App\Events\ProductIngredientsCreated;
use App\Jobs\SendEmailJob;
use App\Models\Ingredient;

class IngredientService {

    public function handleOrderCreation($order) 
    {
        $order->load('order_products.product.ingredients.merchant');

        $deductions = [];

        $merchantOrder = [];

        $order->order_products->each(function ($orderProduct) use (&$deductions)
         {
            $orderProduct->product->ingredients->each(function ($ingredient) use ($orderProduct, &$deductions) 
            {
                $deductedQuantity = $ingredient->pivot->quantity * $orderProduct->quantity;

                if (!isset($deductions[$ingredient->id])) {
                    $deductions[$ingredient->id] = 0;
                }

                $deductions[$ingredient->id] += $deductedQuantity;
            });
        });

        foreach ($deductions as $ingredientId => $deductedAmount) {
            $ingredient           = Ingredient::find($ingredientId);
            $ingredient->quantity = $ingredient->quantity - $deductedAmount;
            $ingredient->save();
            $merchantOrder[$ingredientId] = $ingredient;
        }

        SendEmailJob::dispatch(array_keys($deductions));
    }
}