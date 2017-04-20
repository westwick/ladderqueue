<?php

namespace App\Listeners;

use App\Events\UserAccountProgress;
use App\Notifications\UserAccountProgressUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class SendUserAccountProgressNotification
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
     * @param  UserAccountProgress  $event
     * @return void
     */
    public function handle(UserAccountProgress $event)
    {
        $user = User::find(1);
        $user->notify(new UserAccountProgressUpdated($event->user, $event->status));
    }
}
