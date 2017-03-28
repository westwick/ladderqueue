<?php

namespace App\Http\Controllers;

use App\Events\MapBanned;
use App\Events\PlayerDrafted;
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
use App\QueueUser;
use App\Events\PlayerJoinedQueue;
use App\Events\PlayerLeftQueue;
use App\LadderGame;
use App\LadderParty;
use App\LadderPlayer;

class BracketController extends Controller
{
    public function joinQueue()
    {
        $user = Auth::user();
        
        $q = new QueueUser();
        $q->user_id = $user->id;
        $q->save();
        
        broadcast(new PlayerJoinedQueue($user))->toOthers();

        $all = QueueUser::with('user')->orderBy('created_at')->limit(10)->get();
        if(count($all) === 10) {
            $team1captain = $all[0];
            $team2captain = $all[1];


            // create game
            $game = new LadderGame();
            $game->save();

            // create captains
            $player = new LadderPlayer();
            $player->user_id = $team1captain->user->id;
            $player->game_id = $game->id;
            $player->status_id = 50;
            $player->isCaptain = true;
            $player->team = 1;
            $player->save();

            $player = new LadderPlayer();
            $player->user_id = $team2captain->user->id;
            $player->game_id = $game->id;
            $player->status_id = 50;
            $player->isCaptain = true;
            $player->team = 2;
            $player->save();

            // create rest of players
            for($i = 2; $i <= 9; $i++) {
                $player = new LadderPlayer();
                $player->user_id = $all[$i]->user->id;
                $player->game_id = $game->id;
                $player->status_id = 0;
                $player->save();
            }

            // remove users from queue
            foreach($all as $q) {
                $q->delete();
            }

            //broadcast(new GameStarting($game));
        }

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function leaveQueue()
    {
        $user = Auth::user();

        $q = QueueUser::where('user_id', $user->id);
        $q->delete();

        broadcast(new PlayerLeftQueue($user))->toOthers();

        return response()->json(['success' => true]);
    }

    public function draftPlayer() {
        $user = Auth::user();
        $input = Input::all();

        $game = LadderGame::findOrFail($input['gameId']);
        $player = User::findOrFail($input['userId']);

        if($user->canDraftIn($game)) {
            $updated = $game->draft($user, $player);
            broadcast(new PlayerDrafted($updated, $game))->toOthers();
        } else {
            return response()->json(['success' => false], 403);
        }

        return response()->json(['success' => true, 'player' => $updated]);
    }

    public function banMap()
    {
        $user = Auth::user();
        $input = Input::all();

        $game = LadderGame::findOrFail($input['gameId']);
        if($user->canBanMapIn($game)) {
            $game->mapBan($input['map']);
            broadcast(new MapBanned($game, $input['map']))->toOthers();
        }

        return response()->json(['success' => true]);
    }
    
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
