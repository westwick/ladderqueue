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
    foreach($game->players as $player) {
        if($player->user->id === $user->id) return true;
    }
    return false;
});