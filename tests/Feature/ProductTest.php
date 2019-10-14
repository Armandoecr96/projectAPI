<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * CREATE-1
     */
    public function test_client_can_create_a_product()
    {
        // Given
        $productData = [
            'name' => 'Super Product',
            'price' => '23.30'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);

        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        // Assert the product was created
        // with the correct data
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
    }

    /**
     * CREATE-2
     */
    public function test_client_cant_create_a_product_name()
    { 
        $productData = [
            'price' => '23.30'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);
        $response->assertStatus(422);

        $response->assertJsonFragment([
            'code' => 'ERROR-1',
            'title' => 'Unprocessable Entity'
        ]);
    }

    
    /**
     * CREATE-3
     */
    public function test_client_cant_create_a_product_price()
    { 
       $productData = [
           'name' => 'Super product'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);
        $response->assertStatus(422);
        
        $response->assertJsonFragment([
            'code' => 'ERROR-1',
            'title' => 'Unprocessable Entity'
        ]);
    }

    
    /**
     * CREATE-4
     */
    public function test_client_cant_create_a_product_price_no_num()
    { 
        $productData = [
            'price' => 'abs'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);
        $response->assertStatus(422);
        
        $response->assertJsonFragment([
            'code' => 'ERROR-1',
            'title' => 'Unprocessable Entity'
        ]);
    }

    
    /**
     * CREATE-5
     */
    public function test_client_cant_create_a_product_price_zero()
    { 
        $productData = [
            'price' => -5
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);
        $response->assertStatus(422);
        
        $response->assertJsonFragment([
            'code' => 'ERROR-1',
            'title' => 'Unprocessable Entity'
        ]);
    }
}
