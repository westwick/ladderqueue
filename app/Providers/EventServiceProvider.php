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
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'App\Events\UserAccountProgress' => [
            'App\Listeners\SendUserAccountProgressNotification',
            //'App\Listeners\SendWelcomeEmail'
        ],
        'App\Events\BracketRegistrationStarted' => [
            'App\Listeners\SendBracketRegistrationStartedNotifications'
        ],
        'App\Events\PartyPlayerStatusChange' => [
            'App\Listeners\SendPartyPlayerStatusChangeNotifications'
        ],
        'App\Events\ConversationsUpdated' => [
        ],
        'App\Events\ConversationMessage' => [
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
