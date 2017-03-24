<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SeasonRegistration;

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
        $team = Auth::user()->team;
        $seasonregistration = NULL;
        if($team) {
            $seasonregistration = SeasonRegistration::where('team_id', $team->id)->first();
        }
        return view('home')->with('seasonregistration', $seasonregistration);
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
