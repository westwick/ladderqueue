<?php

namespace App\Jobs;

use App\Events\GameCancelled;
use App\LadderGame;
use App\LadderPlayer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;

class CheckPlayersReady implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $game;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(LadderGame $game)
    {
        $this->game = $game;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $game_started = $this->game->checkReady();

        if(!$game_started) {

            // update ladder_player statuses to cancelled
            foreach($this->game->players as $player) {
                if($player->status_id == 0) {
                    $player->status_id = LadderPlayer::$STATUS_PLAYER_DECLINED;
                    // subtract points?
                } else {
                    $player->status_id = LadderPlayer::$STATUS_OTHER_DECLINED;
                }
                $player->save();
            }

            // set game status to cancelled
            $this->game->status_id = 91;
            $this->game->save();
            broadcast(new GameCancelled($this->game));
        }
    }
}
