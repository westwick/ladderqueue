<?php

namespace App;

use App\Events\GameAccepted;
use App\Events\GameCompleted;
use App\Events\GameDraftComplete;
use App\Events\MapBanned;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Log;

class LadderGame extends Model
{
    public $with = ['players', 'players.user'];
    public $map_pool = ['inferno', 'cache', 'nuke', 'cobblestone', 'mirage', 'overpass', 'train'];
    protected $dates = ['created_at', 'updated_at', 'ended_at'];

    protected $casts = [
        'map_bans' => 'array'
    ];

    public $appends = ['start_time', 'end_time'];

    public static $STATUS_CREATED = 0;
    public static $STATUS_ACCEPTED = 10;
    public static $STATUS_DRAFT_COMPLETE = 20;
    public static $STATUS_PLAYING = 30;
    public static $STATUS_COMPLETE = 40;
    public static $STATUS_CANCELLED = 90;
    public static $STATUS_PLAYER_DECLINED = 91;
    public static $STATUS_OTHER_DECLINED = 92;

    public function players()
    {
        return $this->hasMany('App\LadderPlayer', 'game_id');
    }

    public function getStartTimeAttribute()
    {
        return $this->created_at->tz('America/New_York')->format('M j @ g:ia');
    }

    public function getEndTimeAttribute()
    {
        if($this->ended_at) {
            return $this->ended_at->tz('America/New_York')->format('g:ia');
        }
        return null;
    }

    public function draftTurn()
    {
        $undrafted = $this->players->where('team', 0)->count();
        switch($undrafted) {
            case 8:
                return 1;
                break;
            case 7:
                return 2;
                break;
            case 6:
                return 2;
                break;
            case 5:
                return 1;
                break;
            case 4:
                return 2;
                break;
            case 3:
                return 1;
                break;
            case 2:
                return 2;
                break;
            case 1:
                return 1;
                break;
        }
        return false;
    }

    public function checkReady()
    {
        if($this->status_id == 10) {
            return true;
        }
        $ready_players = LadderPlayer::where('game_id', $this->id)->where('status_id', '10')->count();
        if($ready_players == 10 && $this->status_id == 0) {
            $this->status_id = 10;
            $this->save();
            broadcast(new GameAccepted($this));
            return true;
        }
        return false;
    }

    public function draftPosition()
    {
        $undrafted = $this->players->where('team', 0)->count();
        return 9 - $undrafted;
    }

    public function draft(User $captain, User $player)
    {
        $draftPos = $this->draftPosition();
        $ladderplayer = $this->players->where('user_id', $player->id)->first();
        $laddercaptain = $this->players->where('user_id', $captain->id)->first();
        $ladderplayer->team = $laddercaptain->team;
        $ladderplayer->status_id = 10;
        $ladderplayer->draft_position = $draftPos;
        $ladderplayer->save();

        // event();

        return $ladderplayer;
    }

    public function mapBan($map)
    {
        $bans = $this->map_bans;
        if(empty($bans)) $bans = [];
        foreach($bans as $ban) {
            if($ban === $map) {
                return false;
            }
        }
        $bans[] = $map;
        $needsBroadcast = false;
        if(count($bans) === 6) {
            $lastmap = array_values(array_diff($this->map_pool, $bans));
            $this->map = $lastmap[0];
            $this->status_id = 30;
            $this->url = 'vx' . $this->id . '-' . time();
            $needsBroadcast = true;
        }
        broadcast(new MapBanned($this, $map))->toOthers();
        $this->map_bans = $bans;
        $this->save();

        if($needsBroadcast) {
            broadcast(new GameDraftComplete($this));
        }
    }

    public function complete($team1score, $team2score)
    {
        if($this->status_id == 30) {
            $winner = $this->getWinner($team1score, $team2score);

            $points = $this->getPoints($team1score, $team2score);

            if($points > 11) {
                Log::info('ANOMALY DETECTED! points:' . $points);
                Log::info('team1score: ' . $team1score);
                Log::info('team2score: ' . $team2score);
            }

            $this->team1score = $team1score;
            $this->team2score = $team2score;
            $this->winner = $winner;
            $this->status_id = LadderGame::$STATUS_COMPLETE;
            $this->ended_at = Carbon::now();
            $this->save();

            foreach($this->players as $player) {
                $player->status_id = 40;
                $player->save();
                if($player->team == $winner) {
                    $player->user->adjustPoints($points, 'won game id #' . $this->id);
                } else {
                    $player->user->adjustPoints($points * -1, 'lost game id #' . $this->id);
                }
            }

            broadcast(new GameCompleted($this));
        }
    }

    public function getWinner($team1score, $team2score)
    {
        if($team1score > $team2score) {
            $winner = 1;
        } else {
            $winner = 2;
        }
        return $winner;
    }

    public function getPoints($team1score, $team2score) 
    {
        return floor(abs($team1score - $team2score)/2) + 3;
    }
}
