<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Player;
use DB;

class ResetPoints extends Command {
    protected $signature = 'reset:points';
    protected $description = 'Reset points to 0 for all players';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        DB::table('players')->update(['points'=>0]);
    }
}