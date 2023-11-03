<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PutPlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pass_put_player(): void
    {

        Artisan::call('db:seed', ["--class" => "PlayerSeeder"]);

        $players = DB::table('players')->get();
        
        $response = $this->withHeaders(['X-API-Key' => env('SPRING_API_KEY')])
                ->json('PUT', '/api/v1/player/' . $players[0]->id, ['IncrementPoint' => true]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'Success' => true
            ]);

    }

    public function test_fail_put_player(): void
    {
        $response = $this->withHeaders(['X-API-Key' => env('SPRING_API_KEY')])
                ->json('PUT', '/api/v1/player/1', ['IncrementPoint' => true, 'DecrementPoint' => true]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'Success' => false,
                'ErrorMessage' => "Provide either 'IncrementPoint' or 'DecrementPoint'"
            ]);
    }
}
