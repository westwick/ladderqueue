<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateUserStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();


        foreach($users as $user) {
            $stats = $user->calculateGames();
            $user->wins = $stats['wins'];
            $user->losses = $stats['losses'];
            $user->games_played = $stats['games_played'];
            $user->win_pct = $stats['win_pct'];
            $user->streak = $user->calculateStreak();
            $user->save();
        }

        foreach($users as $user) {
            $user->rank = $user->games_played == 0 ? 0 : $user->calculateRank();
            $user->save();
        }
    }
}
