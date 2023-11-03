<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GetPlayersTest extends TestCase
{
    use RefreshDatabase;

    public function test_pass_get_players(): void
    {
        Artisan::call('db:seed', ["--class" => "PlayerSeeder"]);
        
        $response = $this->withHeaders(['X-API-Key' => env('SPRING_API_KEY')])->json('GET', '/api/v1/players');
        $response
            ->assertStatus(200)
            ->assertJson([
                'Success' => true
            ]);
    }

    public function test_fail_get_players(): void
    {
        $response = $this->withHeaders([])->json('GET', '/api/v1/players');
        $response
            ->assertStatus(403)
            ->assertExactJson([
                'Success' => false,
                'ErrorMessage' => 'Access Denied'
            ]);
    }
}
