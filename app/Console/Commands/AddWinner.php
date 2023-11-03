<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Winner;
use App\Helpers\PlayerHelper;
use DB;

class AddWinner extends Command {
    protected $signature = 'add:winner';
    protected $description = 'Add to winners table from players table';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        
        $playerWhoWon = PlayerHelper::getWinner();

        if (! is_null($playerWhoWon)) {
            DB::table('winners')->insert([
                'players_id' => $playerWhoWon->id,
                'points' => $playerWhoWon->points,
                'win_timestamp' => \Carbon\Carbon::now()
            ]);
        }
    }
}