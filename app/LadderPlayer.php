<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LadderPlayer extends Model
{
    public $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
