<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $dates = ['start_time'];

    public function team1()
    {
        return $this->hasOne('App\Team', 'id', 'team1_id');
    }

    public function team2()
    {
        return $this->hasOne('App\Team', 'id', 'team2_id');
    }
}
