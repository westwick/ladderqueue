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
        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();
            if (!is_null($info)) {
                $user = Auth::user();
                $user->username = $info->personaname;
                $user->avatar = $info->avatarfull;
                $user->steamid64 = $info->steamID64;
                $user->steamid = $info->steamID;
                $user->steam_verified = true;
                $user->save();
                return redirect('/home'); // redirect to site
            }
        }
        return $this->steam->redirect(); // redirect to Steam login page
    }
}
