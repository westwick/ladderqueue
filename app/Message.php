<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Conversation;
use Carbon\Carbon;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'sender_id', 'content'];

    public $appends = ['sentDate', 'sentTime'];

    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }

    public function from()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }
    
    public static function send(User $sender, User $recipient, $message)
    {
        $convo = Conversation::findOrCreate($sender, $recipient);
        $convo->touch();
        $message = Static::create([
            'conversation_id' => $convo->id,
            'sender_id' => $sender->id,
            'content' => $message]);

        $message->load('from');

        return $message;
    }

    public function getSentTimeAttribute()
    {
        return $this->created_at->timezone('America/Los_Angeles')->format('g:i a');
    }

    public function getSentDateAttribute()
    {
        return $this->created_at->timezone('America/Los_Angeles')->format('M j');
    }
}
