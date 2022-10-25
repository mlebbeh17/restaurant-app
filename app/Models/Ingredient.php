<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model 
{
    use HasFactory;

    public function merchant() 
    {
        return $this->belongsTo(Merchant::class);
    }

    public function product_ingredients() 
    {
        return $this->hasMany(ProductIngredient::class);
    }
}
