<?php

namespace App\Http\Controllers;

use App\Events\PlayerLeftQueue;
use App\User;
use Illuminate\Http\Request;
use App\LadderGame;
use Illuminate\Support\Facades\Input;
use Auth;
use App\QueueUser;

class AdminController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['admin']);
    }

    public function getUsers()
    {
        return response()->json(User::orderBy('id', 'desc')->get());
    }

    public function clearQueue()
    {
        $players = QueueUser::with('user')->get();
        foreach($players as $player) {
            $user = $player->user;
            broadcast(new PlayerLeftQueue($user));
            $player->delete();
        }

        return response()->json(['success' => true]);
    }
    
    public function updateScore()
    {
        $user = Auth::user();
        $gameid = Input::get('gameid');
        $team1score = Input::get('team1score');
        $team2score = Input::get('team2score');

        $game = LadderGame::findOrFail($gameid);
        
        // get the old point differential
        $oldPoints = $game->getPoints($game->team1score, $game->team2score);
        $oldWinner = $game->getWinner($game->team1score, $game->team2score);
        // reset the point changes from the old differential
        foreach($game->players as $player) {
            if($player->team == $oldWinner) {
                // player was on winning team, so we need to subtract points
                $player->user->adjustPoints($oldPoints * -1, 'Points adjustment for Game ID#' . $game->id . ' (admin: ' . $user->name . ')');
            } else {
                // player was on losing team, add points
                $player->user->adjustPoints($oldPoints, 'Points adjustment for Game ID#' . $game->id . ' (admin: ' . $user->name . ')');
            }
        }
        
        // get the new differential
        $newPoints = $game->getPoints($team1score, $team2score);
        $newWinner = $game->getWinner($team1score, $team2score);
        
        // update the players new points
        foreach($game->players as $player) {
            if($player->team == $newWinner) {
                $player->user->adjustPoints($newPoints, 'Points adjustment for Game ID#' . $game->id . ' (admin: ' . $user->name . ')');
            } else {
                // player was on losing team, add points
                $player->user->adjustPoints($newPoints * -1, 'Points adjustment for Game ID#' . $game->id . ' (admin: ' . $user->name . ')');
            }
        }

        // update the game score
        $game->team1score = $team1score;
        $game->team2score = $team2score;
        $game->winner = $game->getWinner($team1score, $team2score);
        $game->save();

        return response()->json(['success' => true]);
    }

    public function approveUser()
    {
        $user = User::findOrFail(Input::get('userid'));
        $user->ladder_queue = 'vitalityx';
        $user->save();

        return response()->json(['success' => true]);
    }

    public function removeUser()
    {
        $user = User::findOrFail(Input::get('userid'));
        $user->ladder_queue = '';
        $user->save();

        return response()->json(['success' => true]);
    }

    public function adjustPoints()
    {
        $user = User::findOrFail(Input::get('userid'));
        $user->adjustPoints(Input::get('points'), Input::get('memo') . ' (admin: ' . Auth::user()->name . ')');

        return response()->json(['success' => true]);
    }
}
