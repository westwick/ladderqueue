<?php

namespace App\Listeners;

use App\Events\PartyPlayerStatusChange;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPartyPlayerStatusChangeNotifications
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PartyPlayerStatusChange  $event
     * @return void
     */
    public function handle(PartyPlayerStatusChange $event)
    {
        //
    }
}
