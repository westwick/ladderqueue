<?php

namespace App;

use App\Events\GameAccepted;
use App\Events\GameDraftComplete;
use App\Events\MapBanned;
use Illuminate\Database\Eloquent\Model;

class LadderGame extends Model
{
    public $with = ['players', 'players.user'];
    public $map_pool = ['inferno', 'cache', 'nuke', 'cobblestone', 'mirage', 'overpass', 'train'];

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
        return $this->created_at->tz('America/Los_Angeles')->format('M j @ g:ia');
    }

    public function getEndTimeAttribute()
    {
        return $this->updated_at->tz('America/Los_Angeles')->format('M j @ g:ia');
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
            $this->status_id = 20;
            $needsBroadcast = true;
        }
        broadcast(new MapBanned($this, $map))->toOthers();
        $this->map_bans = $bans;
        $this->save();

        if($needsBroadcast) {
            broadcast(new GameDraftComplete($this));
        }
    }
}
