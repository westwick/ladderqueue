<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Input;
use Auth;

class UserController extends Controller
{
    public function updateSettings()
    {
        $user = Auth::user();
        $settings = Input::get('settings');
        $profile = Input::get('profile');
        $age = $profile['age'];
        $profile['twitch'] = str_replace('twitch.tv/', '', $profile['twitch']);
        $profile['twitter'] = str_replace('@', '', $profile['twitter']);

        if($age && ($age < 15 || $age > 80)) {
            abort(400);
        }

        $user->age = $age;
        $user->intro = $profile['intro'];
        $user->location = $profile['location'];
        $user->twitch = $profile['twitch'];
        $user->twitter = $profile['twitter'];
        $user->sound_enabled = $settings['sound_enabled'];
        $user->notifications_enabled = $settings['notifications_enabled'];
        $user->timezone = $settings['timezone'];
        $user->save();
        
        return response()->json($profile);
    }
}
