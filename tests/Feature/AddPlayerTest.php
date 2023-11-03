<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AddPlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pass_add_player(): void
    {
        
        $response = $this->withHeaders(['X-API-Key' => env('SPRING_API_KEY')])
                ->json('POST', '/api/v1/player', ['Name' => 'Ruskin', 'Age' => '32', 'Address' => 'Earth']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'Success' => true
            ]);

        $this->assertEquals($response->json()['Players'][0]['name'], 'Ruskin');
        $this->assertEquals($response->json()['Players'][0]['age'], '32');
        $this->assertEquals($response->json()['Players'][0]['address'], 'Earth');
    }

    public function test_fail_add_player(): void
    {
        $response = $this->withHeaders(['X-API-Key' => env('SPRING_API_KEY')])
                ->json('POST', '/api/v1/player', ['Name' => 'Ruskin']);

                $response
                ->assertStatus(200)
                ->assertJson([
                    'Success' => false,
                    'ErrorMessage' => 'Age, Address cannot be empty.'
                ]);
    }
}
