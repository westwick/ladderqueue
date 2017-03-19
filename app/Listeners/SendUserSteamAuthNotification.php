<?php

namespace App\Listeners;

use App\Events\UserAuthenticatedSteam;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserSteamAuthNotification
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
     * @param  UserAuthenticatedSteam  $event
     * @return void
     */
    public function handle(UserAuthenticatedSteam $event)
    {
        //
    }
}
