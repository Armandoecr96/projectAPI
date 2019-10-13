<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_client_can_delete_a_product()
    {        
                // When
                $response = $this->json('DELETE', '/api/products/3'); 
        
                // Then
                // Assert it sends the correct HTTP Status
                $response->assertStatus(204);
    }
}
