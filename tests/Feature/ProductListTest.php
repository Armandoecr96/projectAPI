<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * LIST-1
     *
     * @return void
     */
    public function test_client_can_list_products()
    {
        // Enter DATA
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
        $productData = [
            'data' => [
                'type' => 'product',
                'attributes' => [
                    'name' => 'Product',
                    'price' => '25'
                ]
            ]
        ];
        $response = $this->json('POST', '/api/products', $productData);
        $response = $this->get('/api/products');
        $response->assertJsonStructure([
            '*' => ['data' => [
                'type',
                'id',
                'attributes' => [
                    'name',
                    'price'
                ]
            ]]
        ]);

        $response->assertJsonFragment([
            'attributes' => [
                'name' => 'Super Product',
                'price' => '23.30'
            ]
        ]);
        $response->assertStatus(200);
    }

    /**
     * LIST-1
     *
     * @return void
     */
    public function test_client_can_list_products_empty()
    {
        $response = $this->json('GET', '/api/products');
        $response->assertJsonStructure([]);
        $response->assertJsonFragment([]);
        $response->assertStatus(200);
    }
}
