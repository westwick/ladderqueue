<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $table = 'standings_season2';

    public function team()
    {
        return $this->hasOne('App\Team', 'id', 'id');
    }
}
