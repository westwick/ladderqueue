<?php 

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Comment;

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
                if($user->updated_at->diffInMinutes() > 3) {
                    $user->touch();
                }
            }

            $recentComments = $comments = Comment::with('author')->where('parent_id', NULL)->orderBy('updated_at', 'desc')->limit(3)->get();

            $view->with('user', $user)->with(compact('unreadCount', 'recentComments'));
        });
    }

}