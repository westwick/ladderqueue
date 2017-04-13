<?php

namespace App\Events;

use App\Conversation;
use App\Message;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConversationMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;
    public $from;
    public $message;

    public function __construct(Conversation $conversation, User $from, Message $message)
    {
        $this->conversation = $conversation;
        $this->from = $from;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('convo.' . $this->conversation->id);
    }
}
