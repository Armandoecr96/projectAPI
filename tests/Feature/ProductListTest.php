<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_client_can_list_products()
    {
        $response = $this->json('GET', '/api/products');

        $response->assertStatus(200);

        $body = $response->decodeResponseJson();

        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' => 'Super Product',
                'price' => '23.30'
            ]
        );
    }
}
