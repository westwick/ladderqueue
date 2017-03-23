<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserRegistered' => [
            'App\Listeners\SendUserRegisteredNotification',
            //'App\Listeners\SendWelcomeEmail'
        ],
        'App\Events\UserAuthenticatedSteam' => [
            'App\Listeners\SendUserSteamAuthNotification'
        ],
        'App\Events\BracketRegistrationStarted' => [
            'App\Listeners\SendBracketRegistrationStartedNotifications'
        ],
        'App\Events\PartyDisbanded' => [
            'App\Listeners\SendPartyDisbandedNotifications'
        ],
        'App\Events\PartyPlayerStatusChange' => [
            'App\Listeners\SendPartyPlayerStatusChangeNotifications'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
