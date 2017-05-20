<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerLog extends Model
{
    public $appends = ['time_ago'];

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
