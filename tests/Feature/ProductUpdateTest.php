<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * UPDATE-1
     */
    public function test_client_can_update_a_product()
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

        // When
        $response = $this->json('POST', '/api/products', $productData);
        // Given
        $productData = [
            'data' => [
                'type' => 'product',
                'attributes' => [
                    'name' => 'Super Product',
                    'price' => '26.60'
                ]
            ]
        ];

        // When
        $response = $this->json('PUT', '/api/products/1', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);

        // Assert the response has the correct structure
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

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'attributes' => [
                'name' => 'Super Product',
                'price' => '26.60'
            ]
        ]);

        $body = $response->decodeResponseJson();
    }

    /**
     * UPDATE-2
     */
    public function test_client_can_update_a_product_price_no_num()
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

        // When
        $response = $this->json('POST', '/api/products', $productData);
        // Given
        $productData = [
            'data' => [
                'type' => 'product',
                'attributes' => [
                    'name' => 'Super Product',
                    'price' => 'abs'
                ]
            ]
        ];

        // When
        $response = $this->json('PUT', '/api/products/1', $productData);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'code' => 'ERROR-1',
            'title' => 'Unprocessable Entity'
        ]);
    }

    /**
     * UPDATE-3
     */
    public function test_client_can_update_a_product_price_zero()
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

        // When
        $response = $this->json('POST', '/api/products', $productData);
        // Given
        $productData = [
            'data' => [
                'type' => 'product',
                'attributes' => [
                    'name' => 'Super Product',
                    'price' => -3
                ]
            ]
        ];

        // When
        $response = $this->json('PUT', '/api/products/1', $productData);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'code' => 'ERROR-1',
            'title' => 'Unprocessable Entity'
        ]);
    }

    /**
     * UPDATE-4
     */
    public function test_client_can_update_a_product_not_found()
    {
        // Given
        $productData = [
            'data' => [
                'type' => 'product',
                'attributes' => [
                    'name' => 'Super Product',
                    'price' => '26.60'
                ]
            ]
        ];

        // When
        $response = $this->json('PUT', '/api/products/1', $productData);

        $response->assertStatus(404);
        $response->assertJsonFragment([
            'code' => 'ERROR-2',
            'title' => 'Not Found'
        ]);
    }
}
