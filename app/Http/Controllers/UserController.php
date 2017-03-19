<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
}
