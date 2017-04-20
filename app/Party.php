<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    public $timestamps = false;

    public static $STATUS_FORMING = 0;
    public static $STATUS_PAID = 10;
    public static $STATUS_ACCEPTED = 20;
    public static $STATUS_PLAYING = 30;
    public static $STATUS_COMPLETE = 40;
    public static $STATUS_WITHDREW = 90;
    public static $STATUS_PLAYER_DECLINED = 91;
    public static $STATUS_REJECTED = 92;
    public static $STATUS_CANCELLED = 93;

    public function players()
    {
        return $this->belongsToMany('App\User', 'party_players')->withPivot('status_id');
    }

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'creator_id');
    }

}
