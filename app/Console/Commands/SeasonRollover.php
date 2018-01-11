<?php

namespace App\Console\Commands;

use App\Jobs\GenerateUserStats;
use App\PlayerLog;
use App\User;
use App\LadderPlayer;
use App\LadderGame;
use Illuminate\Console\Command;

class SeasonRollover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:seasoncomplete';

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
        $users = User::all();

        // copy all stats over
        foreach($users as $user) {
            if($user->games_played > 0) {
                $user->s5_rank = $user->rank;
                $user->s5_points = $user->ladder_points;
                $user->s5_wins = $user->wins;
                $user->s5_losses = $user->losses;
                $user->s5_games_played = $user->games_played;
                $user->s5_win_pct = $user->win_pct;
                $user->save();
            }
        }

        // reset points to 50
        User::where('ladder_points', '!=', 50)->update(['ladder_points' => 50]);

        // delete old games data
        LadderPlayer::getQuery()->delete();
        LadderGame::getQuery()->delete();
        PlayerLog::getQuery()->delete();

        // recalculate sets (resets everyone to 0 now that game data is gone)
        dispatch(new GenerateUserStats());
    }
}
