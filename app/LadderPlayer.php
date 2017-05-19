<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LadderPlayer extends Model
{
    public $with = ['user'];

    public static $STATUS_FORMING = 0;
    public static $STATUS_ACCEPTED = 10;
    public static $STATUS_DRAFTING = 20;
    public static $STATUS_PLAYING = 30;
    public static $STATUS_COMPLETE = 40;
    public static $STATUS_CANCELLED = 90;
    public static $STATUS_PLAYER_DECLINED = 91;
    public static $STATUS_OTHER_DECLINED = 92;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
