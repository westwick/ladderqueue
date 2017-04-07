<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Input;
use Auth;

class UserController extends Controller
{
    public function showUser($slug)
    {
        $user = User::where('name', $slug)->first();
        if(!$user) {
            return response(404);
        } else {
            return view('player')->with('player', $user);
        }
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $age = Input::get('age');
        if($age < 14) {
            flash('You must be older than 13 to use this site', 'error');
            return redirect()->back();
        }
        if($age == 69) {
            flash('lololololol', 'error');
            return redirect()->back();
        }
        if($age > 90) {
            flash('Go back to your retirement home, grandpa', 'error');
            return redirect()->back();
        }

        $user->intro = Input::get('intro');
        $user->server_preference = Input::get('serverpreference');
        $user->location = Input::get('location');
        $user->age = $age;
        $user->save();

        flash('Profile updated', 'success');
        return redirect()->back();
    }
}
