<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('merchants')->insert([
            [
                'name'        => 'Restaurant supplier',
                'email'       => env('MERCHANT_EMAIL'),
                'description' => 'This merchant provide the restaurant with beef, onion and cheese.',
                'created_at'  => now(),
                'updated_at'  => now()
            ]
        ]);
    }
}
