<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlayerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',
    'middleware' => 'with_spring_api_key'
], function () {
    Route::get('/players', [PlayerController::class, 'getPlayers']);
    Route::put('/player/{playersId}', [PlayerController::class, 'updatePlayer']);
    Route::delete('/player/{playersId}', [PlayerController::class, 'deletePlayer']);
    Route::post('/player', [PlayerController::class, 'addPlayer']);
    Route::get('/point-groups', [PlayerController::class, 'getPointGroups']);
});
