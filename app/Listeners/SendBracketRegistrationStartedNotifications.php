<?php

namespace App\Listeners;

use App\Events\BracketRegistrationStarted;
use App\Notifications\TeammateBracketRegistrationStarted;
use App\Team;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SendBracketRegistrationStartedNotifications
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
     * @param  BracketRegistrationStarted  $event
     * @return void
     */
    public function handle(BracketRegistrationStarted $event)
    {
        foreach($event->party->players as $user) {
            // dont need to notify creator
            if($user->id !== $event->party->creator_id) {
                $user->notify(new TeammateBracketRegistrationStarted($event->party));
            }
        }
    }
}
