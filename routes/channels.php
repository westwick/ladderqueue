<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Party;
use App\LadderGame;
use App\Conversation;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('queue', function ($user) {
    return true;
});

Broadcast::channel('laddergame.{id}', function ($user, $id) {
    $game = LadderGame::findOrFail($id);
    foreach ($game->players as $player) {
        if ($player->user->id === $user->id) return true;
    }
    return false;
});

Broadcast::channel('convo.{id}', function($user, $id) {
    $convo = Conversation::findByIdOrFail($id);
    foreach($convo->participants as $participant) {
        if($participant->user->id === $user->id) return true;
    }
    return false;
});

Broadcast::channel('party.{partyId}', function ($user, $partyId) {
    $party = Party::findOrFail($partyId);
    foreach($party->players as $player) {
        if($user->id === $player->id) return true;
    }
    return false;
});