<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
{

    use RefreshDatabase;
    
    /** @test */
    public function can_create_a_order()
    {

        $response =  $this->post('api/orders/create', [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 3
                ]
            ]
        ]);

        $response->assertStatus(201);

        $response->assertJson(["message" => "The order has been created"]);
    }

    /** @test */
    public function product_is_required()
    {

        $response =  $this->post('api/orders/create',
            [
            ],
            [
                'Accept' => "application/json"
            ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrorFor('products', $responseKey = 'errors');
    }

    /** @test */
    public function ingredients_is_not_enough()
    {

        $response =  $this->post('api/orders/create', [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 1000000
                ]
            ]
        ],
        [
            'Accept' => "application/json"
        ]);


        $response->assertStatus(422);

        $response->assertJsonValidationErrorFor(0, $responseKey = 'errors');
    }

    /** @test */
    public function product_is_not_valid()
    {

        $response =  $this->post('api/orders/create', [
            "products" => [
                [
                    "product_id" => 17,
                    "quantity" => 2
                ]
            ]
        ],
        [
            'Accept' => "application/json"
        ]);


        $response->assertStatus(422);

        $response->assertJsonValidationErrorFor(0, $responseKey = 'errors');
    }
}
