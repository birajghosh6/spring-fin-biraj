<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;


class PlayerHelper {
    
    public static function deletePlayerFromDB($playersId) {
        $rowsAffected = DB::table('players')->where('id', $playersId)->delete();
        if (! $rowsAffected) {
            throw new Exception("Could not delete player with id: $playersId.");
        }
    }
    

    public static function updatePlayerPointsInDB($playersId, $points) {
        $dbWithConditions = DB::table('players')->where('id', $playersId);
        if ($points < 0) {
            $dbWithConditions = $dbWithConditions->where('points', '>', 0);
        }
        $rowsAffected = $dbWithConditions->increment('points', $points);
        if (! $rowsAffected) {
            throw new Exception("Could not update point for player with id: $playersId");
        }
    }

    public static function fetchPlayersFromDB($sortBy = 'points', $order = 'desc') {
        return DB::table('players')
                    ->orderBy($sortBy, $order)
                    ->get();
    }

    public static function addPlayerToDB($name, $age, $address) {
        $rowsAffected = DB::table('players')->insert([
            'name' => $name,
            'age' => $age,
            'address' => $address
        ]);

        if (! $rowsAffected) {
            throw new Exception ('Could not add entry.');
        }
    }

    public static function groupByPointsFromDB() {
        $players = self::fetchPlayersFromDB();

        $pointGroups = [];

        foreach ($players as $player) {
            if (! array_key_exists($player->points, $pointGroups)) {
                $pointGroups[$player->points] = [
                    'names' => [],
                    'average_age' => []
                ];
            }
            array_push($pointGroups[$player->points]['names'], $player->name);
            array_push($pointGroups[$player->points]['average_age'], $player->age);
        }

        foreach ($pointGroups as $point => $info) {
            $pointGroups[$point]['average_age'] = intdiv( 
                array_sum($info['average_age']), 
                count($info['average_age'])
            );
        }

        return $pointGroups;
    }
}