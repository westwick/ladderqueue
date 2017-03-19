<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use GuzzleHttp\Client;
use App\Standing;
use App\Game;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/steam/auth', 'Auth\SteamController@steamAuth');

Route::get('/home', 'HomeController@index');

/*
 * User Controller
 */

Route::get('/u/{slug}', 'UserController@showUser');

/*
 * Team Controller
 */

Route::post('/create-team', 'TeamController@createTeam');
Route::post('/update-team', 'TeamController@updateTeam');
Route::post('/join-team',   'TeamController@joinTeam');
Route::get('/teams',        'TeamController@viewAll');
Route::get('/team/{id}',    'TeamController@viewTeam');

/*
 * Game Controller
 */

Route::get('/addgame',        'GameController@addGame');
Route::post('/create-game',   'GameController@createGame');
Route::post('/edit-game',     'GameController@editGame');
Route::post('/delete-game',   'GameController@deleteGame');
Route::get('/game/{id}/edit', 'GameController@editGameForm');


/*
 *  Season 3
 */

Route::get('/season3', 'SeasonController@season3info');
Route::get('/season3/rules', 'SeasonController@season3rules');

/*
 * Schedule/Standings
 */

Route::get('/season2/schedule', function () {
    $games = Game::orderBy('start_time')->get();
    $formatted = [];

    foreach($games as $game) {
        $formatted[] = array(
            'game_id' => $game->id,
            'team1_name' => $game->team1->name,
            'team1_id' => $game->team1->id,
            'team1_logo' => $game->team1->logo,
            'team1_record' => $game->team1->record(),
            'team1_score' => $game->team1_score,
            'team2_name' => $game->team2->name,
            'team2_id' => $game->team2->id,
            'team2_logo' => $game->team2->logo,
            'team2_record' => $game->team2->record(),
            'team2_score' => $game->team2_score,
            'match_time' => $game->start_time->toDateTimeString(),
            'map' => $game->map,
            'game_status' => $game->status,
            'winner_id' => $game->winner_id,
            'loser_id' => $game->loser_id
        );
    }

    return view('schedule')->with('games', json_encode($formatted));
});

Route::get('/season2/standings', function () {
    $standings = Standing::orderBy('division_season2')
        ->orderBy('totalpoints', 'desc')
        ->orderBy('rwp', 'desc')
        ->orderBy('name')
        ->with('team')
        ->get();
    $divisions = [];
    $currentDivision = '';
    foreach($standings as $standing) {
        if($currentDivision != $standing->division_season2) {
            $currentDivision = $standing->division_season2;
            $divisions[$currentDivision] = ['name' => $currentDivision, 'standings' => []];
        }
        $divisions[$currentDivision]['standings'][] = $standing;
    }
    $overall = Standing::orderBy('totalpoints', 'desc')
        ->orderBy('rwp', 'desc')
        ->orderBy('name')
        ->with('team')
        //->take(32)
        ->get();
    return view('standings')->with('divisions', $divisions)->with('standings', $overall);
});