<?php

namespace App\Listeners;

use App\Events\PartyDisbanded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPartyDisbandedNotifications
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
     * @param  PartyDisbanded  $event
     * @return void
     */
    public function handle(PartyDisbanded $event)
    {
        //
    }
}
