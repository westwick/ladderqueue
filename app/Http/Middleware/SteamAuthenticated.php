<?php

namespace App\Http\Middleware;

use Closure;

class SteamAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! $request->user()->steam_verified) {
            flash('You must connect your Steam account before performing that action', 'warning');
            return redirect('/home');
        }

        return $next($request);
    }
}
