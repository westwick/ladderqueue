<?php

namespace App\Http\Controllers;

use App\LadderGame;
use Illuminate\Http\Request;
use Auth;
use App\SeasonRegistration;
use App\QueueUser;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'test']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $team = Auth::user()->team;
        $seasonregistration = NULL;
        if($team) {
            $seasonregistration = SeasonRegistration::where('team_id', $team->id)->first();
        }
        
        return view('home')->with(compact('seasonregistration'));
    }

    public function showCreateTeamForm()
    {
        $user = Auth::user();
        if($user->team) {
            flash('You already have a team', 'error');
            return redirect('/home');
        }
        return view('create-team');
    }
}
