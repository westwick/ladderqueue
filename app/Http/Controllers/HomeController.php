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
        //$this->middleware('auth', ['except' => 'test']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user) {
            $user = Auth::user();
            $canQueue = true;
            $players = [];
            $game = [];
            if(!$user || !$user->ladder_queue) {
                $canQueue = false;
                return view('ladder.queue')->with(compact('players', 'game', 'canQueue'));
            }
            $ids = QueueUser::all()->pluck('user_id');
            $players = User::whereIn('id', $ids)->get();

            $game = $user->getLadderGame();
            return view('home')->with(compact('players', 'game', 'canQueue'));
        } else {
            return view('welcome');
        }

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
