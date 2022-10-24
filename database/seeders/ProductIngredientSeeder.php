<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('product_ingredients')->insert([
            [
                'product_id'        => 1,
                'ingredient_id' => 1,
                'quantity'    => 150,
                'created_at'  => now(),
                'updated_at'  => now()
            ],[
                'product_id'        => 1,
                'ingredient_id' => 2,
                'quantity'    => 30,
                'created_at'  => now(),
                'updated_at'  => now()
            ],[
                'product_id'        => 1,
                'ingredient_id' => 3,
                'quantity'    => 20,
                'created_at'  => now(),
                'updated_at'  => now()
            ]
        ]);
    }
}
