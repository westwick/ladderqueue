<?php

namespace App\Console\Commands;

use App\LadderGame;
use App\LadderPlayer;
use Illuminate\Console\Command;

class ClearPendingGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:cleargames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        LadderPlayer::getQuery()->delete();
        LadderGame::getQuery()->delete();
    }
}
