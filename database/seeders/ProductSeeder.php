<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('products')->insert([
            'name'        => 'Burger',
            'description' => 'This Burger ingredients are bread, 150g of beef, 30g of cheese and 20g of onion.',
            'created_at'  => now(),
            'updated_at'  => now()
        ]);
    }
}
