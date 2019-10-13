<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductUpdateTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_client_can_update_a_product()
    {
    // Given
    $productData = [
        'name' => 'Super Product Update',
        'price' => '26.30'
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
        'name' => 'Super Product Update',
        'price' => '26.30'
    ]);
    
    $body = $response->decodeResponseJson();

    // Assert product is on the database
    $this->assertDatabaseHas(
        'products',
        [
            'id' => $body['id'],
            'name' => 'Super Product Update',
            'price' => '26.30'
        ]
    );
}
}
