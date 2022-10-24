<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    public function product_ingredients() {
        return $this->hasMany(ProductIngredient::class);
    }

    public function order_details() {
        return $this->hasMany(OrderDetail::class);
    }
}
