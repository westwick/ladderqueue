<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bracket;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Party;
use App\User;
use App\PartyPlayer;
use App\Events\BracketRegistrationStarted;
use Log;
use App\Events\PartyPlayerStatusChange;

class BracketController extends Controller
{
    public function showBracket($id)
    {
        $bracket = Bracket::findOrFail($id);
        $teams = $bracket->teams()->get();
        return view('bracket')->with(compact('teams', 'bracket'));
    }

    public function startRegistration()
    {
        $creator = Auth::user();
        $input = Input::all();

        $bracket_id = $input['bracketid'];
        $team_id = $input['teamid'];
        $player_ids = explode(',', $input['playerids']);

        // TODO: add validation
        // make sure user is in team list
        // make sure user has no other teams registered at same time
        // make sure no other players are also registered...

        $users = [];
        foreach($player_ids as $player_id) {
            $users[] = User::findOrFail($player_id);
        }

        $party = new Party();
        $party->creator_id = $creator->id;
        $party->bracket_id = $bracket_id;
        $party->team_id = $team_id;
        $party->save();

        // create party players
        foreach($users as $user) {
            $pp = new PartyPlayer();
            $pp->user_id = $user->id;
            $pp->party_id = $party->id;
            // set the creator to joined
            if($user->id === $creator->id) {
                $pp->status_id = 10;
            }
            $pp->save();
        }
        
        event(new BracketRegistrationStarted($party));
        
        return redirect('/assemble/' . $party->id);
    }

    public function showRegistrationRoom($id)
    {
        $party = Party::findOrFail($id);
        $players = PartyPlayer::with('user')->where('party_id', $party->id)->get();
        return view('bracket.party')->with('party', $party)->with('players', $players);
    }

    public function declineParty()
    {
        $user = Auth::user();
        $partyid = Input::get('partyid');

        $party = Party::with('players')->findOrFail($partyid);
        $canDecline = false;
        foreach($party->players as $player) {
            if($player->id === $user->id) {
                $canDecline = true;
            }
        }

        if($canDecline) {
            // set party status to declined
            $party->status_id = 90;
            $party->save();

            // set party player status to declined
            $partyPlayer = PartyPlayer::where('party_id', $partyid)->where('user_id', $user->id)->first();
            $partyPlayer->status_id = 90;
            $partyPlayer->save();
        }

        return response()->json(['success' => true]);
    }

    public function joinParty()
    {
        $user = Auth::user();
        $partyid = Input::get('partyId');

        $party = Party::with('players')->findOrFail($partyid);
        if(!($party->status_id <= $party::$STATUS_PLAYING)) {
            flash('Unable to join', 'error');
            return redirect()->back();
        } else {
            $partyPlayer = PartyPlayer::where('party_id', $partyid)->where('user_id', $user->id)->first();
            $partyPlayer->status_id = 10;
            $partyPlayer->save();

            event(new PartyPlayerStatusChange($partyPlayer, $party));

            return redirect('/assemble/' . $party->id);
        }
    }

    public function enterBracket()
    {
        $user = Auth::user();
        $partyid = Input::get('partyid');

        $party = Party::findOrFail($partyid);

        $partyPlayer = PartyPlayer::where('party_id', $partyid)->where('user_id', $user->id)->first();
        $partyPlayer->status_id = 20;
        $partyPlayer->save();

        event(new PartyPlayerStatusChange($partyPlayer, $party));

        return response()->json(['success' => 'andrewiscool']);
    }
}
