<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GetPointGroupsTest extends TestCase
{
    use RefreshDatabase;

    public function test_pass_get_point_groups(): void
    {

        Artisan::call('db:seed', ["--class" => "PlayerSeeder"]);
        
        $response = $this->withHeaders(['X-API-Key' => env('SPRING_API_KEY')])->json('GET', '/api/v1/point-groups');
        $response
            ->assertStatus(200)
            ->assertJson([
                'Success' => true
            ]);

    }

    public function test_fail_get_point_groups(): void
    {
        $response = $this->withHeaders([])->json('GET', '/api/v1/point-groups');

        $response
            ->assertStatus(403)
            ->assertExactJson([
                'Success' => false,
                'ErrorMessage' => "Access Denied"
            ]);
    }
}
