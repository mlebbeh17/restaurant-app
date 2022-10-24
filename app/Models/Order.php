<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $guarded = [];

    public function order_products() {
        return $this->hasMany(OrderProduct::class);
    }

    public function createOrder($order) {
        $order_products_quantities = Product::products_quantities($order);
        $product_ingredients       = collect(Product::with('ingredients')->whereIn('id', $order_products_quantities->keys())->get())->keyBy('id');

        $createdOrder = Order::create();

        foreach ($order_products_quantities as $product_id => $product_quantity) {
             OrderProduct::create([
                'order_id'   => $createdOrder->id,
                'product_id' => $product_id,
                'quantity'   => $product_quantity
            ]);

            foreach ($product_ingredients[$product_id]['ingredients'] as $prod_ing) {
                if (!isset($new_quantity[$prod_ing['id']])) {
                    $new_quantity[$prod_ing['id']] = $prod_ing['quantity'];
                }

                $new_quantity[$prod_ing['id']] -= $product_quantity * $prod_ing['product_ingredients']['quantity'];

                Ingredient::where('id', $prod_ing['id'])->update(['quantity' => $new_quantity[$prod_ing['id']]]);

                if (!$prod_ing['merchant_notified'] && empty($notifid[$prod_ing['id']]) && ($new_quantity[$prod_ing['id']] < ($prod_ing['last_shipment'] / 2))) {
                    Order::notifyMerchant($prod_ing['merchant_id'], $prod_ing['name']);
                    Ingredient::where('id', $prod_ing['id'])->update(['merchant_notified' => true]);
                    $notifid[$prod_ing['id']] = true;
                }
            }
        }
    }

    public function notifyMerchant($merchant_id, $ingredient_name) {
        $merchant = Merchant::find($merchant_id);

        \Mail::to($merchant['email'])->send(new \App\Mail\NewMerchantOrderMail($merchant['name'], $ingredient_name));
    }
}
