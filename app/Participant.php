<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Message;

class Participant extends Model
{
    public $dates = ['last_read'];
    public $timestamps = false;
    public $appends = ['lastMessage', 'unreadCount'];

    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getLastMessageAttribute()
    {
        return Message::where('conversation_id', $this->conversation->id)
            ->where('sender_id', $this->user->id)
            ->orderByDesc('created_at')
            ->first();
    }

    public function getUnreadCountAttribute()
    {
        return Message::where('conversation_id', $this->conversation->id)
            ->where('created_at', '>', $this->last_read)
            ->count();
    }
}
