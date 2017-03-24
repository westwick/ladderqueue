<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Announcement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(190);
        //$announcements = Announcement::orderBy('created_at', 'desc')->limit(3)->get();
        //view()->share('announcements', $announcements);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
