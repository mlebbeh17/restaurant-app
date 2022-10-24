<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients')->withPivot('quantity')->as('product_ingredients');
    }

    public function order_products() {
        return $this->hasMany(OrderProduct::class);
    }

    public function isEnough($products) {
        $products_quantities = Product::products_quantities($products);
        $product_ingredients = Product::with('ingredients')->whereIn('id', $products_quantities->keys())->get();

        foreach ($product_ingredients as $product) {
            foreach ($product['ingredients'] as $ingredient) {
                if (!isset($quantities[$ingredient['name']])) {
                    $quantities[$ingredient['name']] = $ingredient['quantity'];
                }

                $quantities[$ingredient['name']] = $quantities[$ingredient['name']] - ($ingredient['product_ingredients']['quantity'] * $products_quantities[$product['id']]);
            }
        }

        $quantities = array_filter($quantities, function ($value) {
            return ($value < 0);
        });

        return empty($quantities) ? true : false;
    }

    public function products_quantities($products) {
        return collect($products)->groupBy('product_id')->map(function ($group) {
            return $group->sum('quantity');
        });
    }
}
