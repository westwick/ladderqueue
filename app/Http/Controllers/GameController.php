<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Team;
use App\Game;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Jobs\GenerateSeason2Stats;

class GameController extends Controller
{
    public function addGame()
    {
        $teams = Team::all();
        return view('addgame')->with('teams', $teams);
    }

    public function createGame()
    {
        $input = Input::all();
        $user = Auth::user();

        $start_time = new Carbon($input['date'] . ' ' . $input['time'], 'America/New_York');
        $start_time->tz('UTC');

        $game = new Game;
        $game->team1_id = $input['team1'];
        $game->team2_id = $input['team2'];
        $game->season = 'csgo season 2';
        $game->map = $input['map'];
        $game->start_time = $start_time;
        $game->status = 0;
        $game->winner_id = NULL;
        $game->loser_id = NULL;
        $game->save();

        flash('Game created', 'success');

        $time = new Carbon($start_time, 'America/New_York');
        return redirect()->back()->with('thedate', $time->format('Y-m-d'));
    }

    public function editGameForm($id)
    {
        $game = Game::find($id);
        return view('editgame')->with('game', $game);
    }

    public function editGame()
    {
        $input = Input::all();
        $game = Game::find($input['gameid']);

        $team1score = $input['team1score'];
        $team2score = $input['team2score'];

        $game->team1_score = $team1score;
        $game->team2_score = $team2score;

        $game->winner_id = $team1score > $team2score ? $game->team1_id : $game->team2_id;
        $game->loser_id = $team1score < $team2score ? $game->team1_id : $game->team2_id;

        if($team1score == 0 && $team1score == 0) {
            $game->status = 0;
        } elseif($team1score >=15 && $team2score >= 15) {
            $game->status = 2;
        } else {
            $game->status = 1;
        }

        if(Input::get('forfeit')) {
            $game->status = 9;
        }

        $game->save();

        dispatch(new GenerateSeason2Stats());

        flash('Score updated', 'success');
        return redirect('/season2/schedule');
    }

    public function deleteGame()
    {
        $input = Input::all();
        $game = Game::find($input['gameid']);

        if(Auth::user() && Auth::user()->is_admin) {
            $game->delete();
            flash('Game deleted', 'success');
        } else {
            flash('Unauthorized', 'error');
        }

        return redirect('/season2/schedule');
    }
}
