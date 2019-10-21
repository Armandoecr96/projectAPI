<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * SHOW-1
     *
     * @return void
     */
    public function test_client_product_show_test()
    {
        
        $productData = [
            'data' => [
                'type' => 'product',
                'attributes' => [
                    'name' => 'Super Product',
                    'price' => '23.30'
                ]
            ]
        ];

        $response = $this->json('POST', '/api/products', $productData);
        $response = $this->json('GET', '/api/products/1');
        $response->dump();
        $response->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'price'
                ]
            ]
        ]);

        $response->assertJsonFragment([
            'attributes' => [
                'name' => 'Super Product',
                'price' => '23.30'
            ]
        ]);

        $body = $response->decodeResponseJson();

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
    }

    /**
     * SHOW-2
     *
     * @return void
     */
    public function test_client_product_show_test_not_found()
    {
        $response = $this->json('GET', '/api/products/1');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'code' => 'ERROR-2',
            'title' => 'Not Found'
        ]);
    }
}
