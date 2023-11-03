<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\PlayerHelper;
use App\Helpers\APIHelper;
use App\Jobs\GenerateQR;
use Exception;

class PlayerController extends Controller
{
    // Endpoint functions


    public function getPlayers(Request $request) {
        try {
            $sortBy = $request->query('SortBy', 'points');
            $order = $request->query('Order', 'desc');
            
            return APIHelper::getSuccessResponse([
                'Players' => PlayerHelper::fetchPlayersFromDB($sortBy, $order)
            ]);

        } catch (Exception $e) {
            return APIHelper::getExceptionResponse($e);
        }
    }

    public function updatePlayer(Request $request, string $playersId) {
        try {

            $incrementPoint = $request->input('IncrementPoint', false);
            $decrementPoint = $request->input('DecrementPoint', false);

            if ( !(boolval($incrementPoint) xor boolval($decrementPoint))) {
                throw new Exception("Provide either 'IncrementPoint' or 'DecrementPoint'");
            }
            
            PlayerHelper::updatePlayerPointsInDB($playersId, $incrementPoint?1:-1);

            return APIHelper::getSuccessResponse([
                'Players' => PlayerHelper::fetchPlayersFromDB()
            ]);
            
        } catch (Exception $e) {
            return APIHelper::getExceptionResponse($e);
        }
    }

    public function deletePlayer(Request $request, string $playersId) {
        try {
            PlayerHelper::deletePlayerFromDB($playersId);

            return APIHelper::getSuccessResponse([
                'Players' => PlayerHelper::fetchPlayersFromDB()
            ]);
        } catch (Exception $e) {
            return APIHelper::getExceptionResponse($e);
        }
    }


    public function addPlayer(Request $request) {
        try {
            $name = $request->input('Name');
            $age = $request->input('Age');
            $address = $request->input('Address');

            $inputs = ['Name' => $name, 'Age' => $age, 'Address' => $address];
            APIHelper::requireInputs($inputs);

            PlayerHelper::addPlayerToDB($name, $age, $address);

            GenerateQR::dispatch($address);

            return APIHelper::getSuccessResponse([
                'Players' => PlayerHelper::fetchPlayersFromDB()
            ]);
            
        } catch (Exception $e) {
            return APIHelper::getExceptionResponse($e);
        }
    }


    public function getPointGroups(Request $request) {
        try {
            $pointGroups = PlayerHelper::groupByPointsFromDB();
            return APIHelper::getSuccessResponse([
                'PointGroups' => $pointGroups
            ]);
        } catch (Exception $e) {
            return APIHelper::getExceptionResponse($e);
        }
    }
    
}
