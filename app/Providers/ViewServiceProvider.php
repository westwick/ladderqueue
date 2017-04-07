<?php 

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->composeNavigation();
    }

    public function register()
    {
        //
    }

    public function composeNavigation()
    {
        view()->composer('layouts.app', function ($view) {

            $unreadCount = 0;

            if ($user = Auth::user())
            {
                // do something
                $unreadCount = $user->unreadMessagesCount();
            }

            $view->with('user', $user)->with('unreadCount', $unreadCount);
        });
    }

}