<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Team;
use App\Game;
use Illuminate\Support\Facades\Input;
use App\TeamMember;
use App\SeasonRegistration;

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
        $team = Team::findOrFail($id);
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
        $team->division_season2 = '';
        $team->rwp = 0;
        $team->save();

        $user->team_id = $team->id;
        $user->team_role = 1;
        $user->save();

        $tm = new TeamMember();
        $tm->user_id = $user->id;
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
            $tm->user_id = $user->id;
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
    
    public function season3registration()
    {
        $user = Auth::user();
        $team = $user->team;
        if(!$team) {
            flash('You must create a team first', 'error');
            return redirect('/home');
        }
        if($user->team_role != 1) {
            flash('Only the team leader may apply', 'error');
            return redirect('/home');
        }
        $exists = SeasonRegistration::where('team_id', $team->id)->first();
        if($exists) {
            flash('You have already applied for Season 3', 'warning');
            return redirect('/home');
        }
        return view('season3.registration');
    }

    public function season3register()
    {
        $user = Auth::user();
        $team = $user->team;
        if(!$team) {
            flash('You must create a team first', 'error');
            return redirect('/home');
        }
        $times = [
            'monday_6', 'monday_7', 'monday_8', 'monday_9',
            'tuesday_6', 'tuesday_7', 'tuesday_8', 'tuesday_9',
            'wednesday_6', 'wednesday_7', 'wednesday_8', 'wednesday_9',
            'thursday_6', 'thursday_7', 'thursday_8', 'thursday_9',
            'friday_6', 'friday_7', 'friday_8', 'friday_9', 'friday_10', 'friday_11',
            'saturday_12', 'saturday_1', 'saturday_2', 'saturday_3', 'saturday_4', 'saturday_5',
            'saturday_6', 'saturday_7', 'saturday_8', 'saturday_9', 'saturday_10', 'saturday_11',
            'sunday_12', 'sunday_1', 'sunday_2', 'sunday_3', 'sunday_4', 'sunday_5',
            'sunday_6', 'sunday_7', 'sunday_8', 'sunday_9', 'sunday_10', 'sunday_11',
        ];

        for($i = 1; $i <= 5; $i++) {
            if(Input::get('cb' . $i) !== 'on') {
                flash('You must agree to all terms', 'error');
                return redirect()->back();
            }
        }

        $selectedTimes = [];

        foreach($times as $time) {
            if (Input::get($time) === 'on') {
                $selectedTimes[] = $time;
            }
        }

        if(count($selectedTimes) < 5) {
            flash('You must select a minimum of 5 times your team can play', 'error');
            return redirect()->back();
        }

        // all validation is good, let's create the application
        $reg = new SeasonRegistration();
        $reg->team_id = $team->id;
        $reg->season = 3;
        $reg->server_preference = Input::get('serverpreference');
        $reg->team_time_zone = Input::get('teamtimezone');
        $reg->available_times = json_encode($selectedTimes);
        $reg->save();

        flash('Your application has been submitted!', 'success');
        return redirect('/home');
    }
}
