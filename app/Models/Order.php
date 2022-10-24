<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $guarded = [];

    public function order_details() {
        return $this->hasMany(OrderDetail::class);
    }

    public function createOrder($order) {
        $createdOrder = Order::create();

        foreach ($order as $key => $sub) {
            $details = OrderDetail::create([
                'order_id'   => $createdOrder->id,
                'product_id' => $sub['product_id'],
                'quantity'   => $sub['quantity']
            ]);

            $product_ingredients = ProductIngredient::ProductIngredientByProduct($sub['product_id']);

            foreach ($product_ingredients as $prod_ing) {
                $merchent = Ingredient::find($prod_ing['id'], ['merchant_id', 'merchant_notified']);

                Ingredient::where('id', $prod_ing['id'])->update(['quantity' => $prod_ing['ing_quantity'] - ($sub['quantity'] * $prod_ing['prod_ing_quantity'])]);
            }
        }
    }
}
