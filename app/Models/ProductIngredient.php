<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model {
    use HasFactory;

    public function products() {
        return $this->belongsTo(Product::class);
    }

    public function ingredients() {
        return $this->belongsTo(Ingredient::class);
    }

    public function isEnough($products) {
        foreach ($products as $product) {
            $ingredients = ProductIngredient::ProductIngredientByProduct($product['product_id']);

            foreach ($ingredients as $ingredient) {
                if (!isset($quantities[$ingredient['name']])) {
                    $quantities[$ingredient['name']] = $ingredient['ing_quantity'];
                }

                $quantities[$ingredient['name']] = $quantities[$ingredient['name']] - ($ingredient['prod_ing_quantity'] * $product['quantity']);
            }
        }

        $quantities = array_filter($quantities, function ($value) {
            return ($value < 0);
        });

        return empty($quantities) ? true : false;
    }

    public function ProductIngredientByProduct($productId) {
        return ProductIngredient::select('ingredients.id', 'ingredients.name', 'ingredients.quantity as ing_quantity', 'product_ingredients.quantity as prod_ing_quantity')
                ->join('ingredients', 'ingredients.id', 'product_ingredients.ingredient_id')
                ->where('product_ingredients.product_id', $productId)
                ->get()
                ->toArray();
    }
}
