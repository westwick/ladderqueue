<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\PartyPlayer;
use App\Party;

class PartyPlayerStatusChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $player;
    public $party;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PartyPlayer $player, Party $party)
    {
        $this->player = $player;
        $this->party = $party;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('party.' . $this->party->id);
    }
}
