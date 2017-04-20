<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Game;
use App\User;

class Team extends Model
{
    public function owner()
    {
        return $this->hasOne('App\User', 'id', 'owner_id');
    }

    public function players()
    {
        return User::where('team_id', $this->id)->get();
    }

    public function members()
    {
        return $this->belongsToMany('App\User', 'team_members');
    }

    public function memberCount()
    {
        return $this->players()->count();
    }

    public function wins()
    {
        return DB::table('games')->where('winner_id', $this->id)->count();
    }

    public function losses()
    {
        return DB::table('games')->where('loser_id', $this->id)->count();
    }

    public function record()
    {
        return $this->wins() . ' - ' . $this->losses();
    }

    public function calculateRWP()
    {
        $rounds = 0;
        $roundswon = 0;
        $games = Game::where('team1_id', $this->id)->orWhere('team2_id', $this->id)->get();
        foreach($games as $game) {
            if($game->status !== 9) {
                $rounds += $game->team1_score + $game->team2_score;

                if($game->team1_id == $this->id) {
                    $roundswon += $game->team1_score;
                } else {
                    $roundswon += $game->team2_score;
                }

                if($rounds > 0) {
                    $this->rwp = ($roundswon / $rounds) * 1000;
                } else {
                    $this->rwp = 0;
                }

                $this->save();
            }
        }
    }

    public function makeSlug($name)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }
}
