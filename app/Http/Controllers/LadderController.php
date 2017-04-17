<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\QueueUser;
use App\User;

class LadderController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth')->except('showLeaderboard');
    }

    public function showQueue()
    {
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

        return view('ladder.queue')->with(compact('players', 'game', 'canQueue'));
    }

    public function showLeaderboard()
    {
        $players = User::where('ladder_queue', '!=', NULL)->orderBy('ladder_points', 'desc')->get();

        return view('ladder.leaderboard')->with(compact('players'));
    }
}
