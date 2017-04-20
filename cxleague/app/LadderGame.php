<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LadderGame extends Model
{
    public $with = ['players', 'players.user'];
    public $map_pool = ['inferno', 'cache', 'nuke', 'cobblestone', 'mirage', 'overpass', 'train'];

    protected $casts = [
        'map_bans' => 'array'
    ];

    public function players()
    {
        return $this->hasMany('App\LadderPlayer', 'game_id');
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
        if(count($bans) === 6) {
            $lastmap = array_values(array_diff($this->map_pool, $bans));
            $this->map = $lastmap[0];
        }
        $this->map_bans = $bans;
        $this->save();
    }
}
