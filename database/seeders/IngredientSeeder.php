<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ingredients')->insert([
            [
                'name'          => 'Beef',
                'description'   => 'Beef',
                'quantity'      => 20000,
                'last_shipment' => 20000,
                'merchant_id'   => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],[
                'name'          => 'Cheese',
                'description'   => 'Cheese',
                'quantity'      => 5000,
                'last_shipment' => 5000,
                'merchant_id'   => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],[
                'name'          => 'Onion',
                'description'   => 'Onion',
                'quantity'      => 1000,
                'last_shipment' => 1000,
                'merchant_id'   => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ]
        ]);
    }
}
