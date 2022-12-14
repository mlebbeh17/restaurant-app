<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model 
{
    use HasFactory;

    public function products() 
    {
        return $this->belongsTo(Product::class);
    }

    public function ingredients() 
    {
        return $this->belongsTo(Ingredient::class);
    }
}
