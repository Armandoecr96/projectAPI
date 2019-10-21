<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDeleteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * DELETE-1
     *
     * @return void
     */
    public function test_client_can_delete_a_product()
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
        $response = $this->json('DELETE', '/api/products/1');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(204);
    }

    /**
     * DELETE-2
     *
     * @return void
     */
    public function test_client_can_delete_a_product_not_found()
    {
        $response = $this->json('DELETE', '/api/products/1');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(404);
    }
}
