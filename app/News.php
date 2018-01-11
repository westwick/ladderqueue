<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $with = ['user'];
    public $appends = ['posted_on'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getPostedOnAttribute()
    {
        return $this->created_at->tz('America/New_York')->format('F j, Y');
    }

    public function getBodyAttribute($body)
    {
        return '<p>' . nl2br($body) . '</p>';
    }
}
