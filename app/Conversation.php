<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Participant;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Conversation extends Model
{
    public $appends = ['lastUpdatedDiff'];
    
    public function messages()
    {
        return $this->hasMany('App\Message')->with('from');
    }

    public function participants()
    {
        return $this->hasMany('App\Participant');
    }

    public function getLastMessageAttribute()
    {
        return $this->messages()->orderBy('created_at', 'desc')->first();
    }

    public function getLastUpdatedDiffAttribute()
    {
        if($this->updated_at->diffInHours(Carbon::now()) > 23)
        {
            return $this->updated_at->timezone('America/Los_Angeles')->format('M j');
        }
        elseif($this->updated_at->diffInMinutes(Carbon::now()) < 5)
        {
            return 'just now';
        }
        else
        {
            return str_replace('minutes', 'mins', $this->updated_at->timezone('America/Los_Angeles')->diffForHumans());
        }
    }

    public static function findOrFail(User $sender, User $recipient)
    {
        $conversation = static::whereHas('participants', function($query) use ($sender) {
            $query->where('user_id', $sender->id);
        })->whereHas('participants', function($query) use ($recipient) {
            $query->where('user_id', $recipient->id);
        })->first();

        if(!$conversation) {
            throw new HttpException(404);
        } else {
            return $conversation;
        }
    }

    public static function findOrCreate(User $sender, User $recipient)
    {
        $conversation = static::whereHas('participants', function($query) use ($sender) {
            $query->where('user_id', $sender->id);
        })->whereHas('participants', function($query) use ($recipient) {
            $query->where('user_id', $recipient->id);
        })->first();

        if(!$conversation) {
            $conversation = new static();
            $conversation->save();
            //create sender participant with last_read of now
            $p1 = new Participant();
            $p1->conversation_id = $conversation->id;
            $p1->user_id = $sender->id;
            $p1->last_read = Carbon::now();
            $p1->save();
            //create receiver participant with last_read of never
            $p2 = new Participant();
            $p2->conversation_id = $conversation->id;
            $p2->user_id = $recipient->id;
            $p2->last_read = Carbon::createFromTimestampUTC(0);
            $p2->save();
        } else {
            // update the sender participant's read_at timestamp
            $p = Participant::where('user_id', $sender->id)->where('conversation_id', $conversation->id)->first();
            $p->last_read = Carbon::now();
            $p->save();
        }

        return $conversation;
    }

}
