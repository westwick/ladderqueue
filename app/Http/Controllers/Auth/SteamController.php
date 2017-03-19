<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Invisnik\LaravelSteamAuth\SteamAuth;
use App\User;
use Auth;

class SteamController extends Controller
{

    private $steam;

    public function __construct(SteamAuth $steam)
    {
        $this->middleware('auth');
        $this->steam = $steam;
    }

    public function steamAuth()
    {
        $user = Auth::user();
        if($user->steam_verified) {
            flash('You have already connected steam to this account', 'error');
            return redirect('/home');
        }

        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();
            if (!is_null($info)) {

                $exists = User::where('steamid64', $info->steamID64)->first();
                if($exists) {
                    flash('That steam account is already connected to another user', 'error');
                    return redirect('/home');
                }

                $user->username = $info->personaname;
                $user->avatar = $info->avatarfull;
                $user->steamid64 = $info->steamID64;
                $user->steamid = $info->steamID;
                $user->steam_verified = true;
                $user->save();
                flash('Your steam account has been connected', 'success');
                return redirect('/home'); // redirect to site
            }
        }
        return $this->steam->redirect(); // redirect to Steam login page
    }
}