<?php

namespace App\Listeners;

use App\Notifications\UserAccountProgressUpdated;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = User::find($event->user->id);
        $user->touch();
        // $user->notify(new UserAccountProgressUpdated($user, 'logged in from ' . \Request::ip()));
    }
}
