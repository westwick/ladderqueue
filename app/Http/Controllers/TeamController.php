<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Team;
use App\Game;
use Illuminate\Support\Facades\Input;
use App\TeamMember;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'steamauth'])->except(['viewAll', 'viewTeam']);
    }

    public function viewAll()
    {
        $teams = Team::all();
        return view('teams')->with('teams', $teams);
    }

    public function viewTeam($id)
    {
        $team = Team::find($id);
        $upcoming = [];
        $recent = [];
        $games = Game::where('team1_id', $team->id)->orWhere('team2_id', $team->id)->orderBy('start_time', 'desc')->get();
        foreach($games as $game) {
            if($game->status == 0) {
                $upcoming[] = $game;
            } else {
                $recent[] = $game;
            }
        }
        return view('teamview')->with(compact('team', 'upcoming', 'recent'));
    }

    public function createTeam()
    {
        $user = Auth::user();

        $team = new Team();
        $team->name = Input::get('teamname');
        $team->owner_id = $user->id;
        $team->logo = Input::get('logo');
        $team->join_password = Input::get('joinpw');
        $team->save();

        $user->team_id = $team->id;
        $user->team_role = 1;
        $user->save();

        $tm = new TeamMember();
        $tm->player_id = $user->id;
        $tm->team_id = $team->id;
        $tm->role = 2;
        $tm->save();

        flash('Your team has been created', 'success');
        return redirect('/home');
    }

    public function updateTeam()
    {
        $user = Auth::user();
        $team = Auth::user()->team;
        $input = Input::all();
        $team->join_password = Input::get('joinpw');
        $team->logo = Input::get('logo');
        $team->save();

        flash('Updated', 'success');
        return redirect('/home');
    }

    public function joinTeam()
    {
        $team_id = Input::get('teamid');
        $pw = Input::get('joinpw');

        $team = Team::find($team_id);
        if($team->join_password === $pw) {
            $user = Auth::user();
            $user->team_id = $team->id;
            $user->save();

            $tm = new TeamMember();
            $tm->player_id = $user->id;
            $tm->team_id = $team->id;
            $tm->role = 0;
            $tm->save();

            flash('You have joined ' . $team->name, 'success');
            return redirect('/home');
        } else {
            flash('Wrong password', 'error');
            return redirect()->back();
        }
    }
}
