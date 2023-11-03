<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DeletePlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pass_delete_player(): void
    {

        Artisan::call('db:seed', ["--class" => "PlayerSeeder"]);

        $players = DB::table('players')->get();
        
        $response = $this->withHeaders(['X-API-Key' => env('SPRING_API_KEY')])
                ->json('DELETE', '/api/v1/player/' . $players[0]->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'Success' => true
            ]);

    }

    public function test_fail_delete_player(): void
    {
        $response = $this->withHeaders(['X-API-Key' => env('SPRING_API_KEY')])
                ->json('DELETE', '/api/v1/player/100');

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'Success' => false,
                'ErrorMessage' => "Could not delete player with id: 100."
            ]);
    }
}
