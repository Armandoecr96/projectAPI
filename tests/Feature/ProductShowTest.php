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
            'name' => 'Super Product',
            'price' => '23.30'
        ];

        $response = $this->json('POST', '/api/products', $productData);

        $response = $this->json('GET', '/api/products/1');

        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        $response->assertJsonFragment([
            'name' => 'Super Product',
            'price' => '23.30'
        ]);

        $body = $response->decodeResponseJson();

        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' => 'Super Product',
                'price' => '23.30'
            ]
        );

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
