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
use Illuminate\Support\Facades\Input;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/steam/auth', 'Auth\SteamController@steamAuth');

Route::get('/home', 'HomeController@index');
Route::get('/about', function() {
    return view('static.about');
});
Route::get('/get-involved', function() {
    return view('static.get-involved');
});
Route::get('/coming-soon', function() {
    return view('static.coming-soon');
});
Route::get('/code-of-conduct', function() {
    return view('static.code-of-conduct');
});

Route::get('/checkout', function() {
    $team = Auth::user()->team;
    $registration = App\SeasonRegistration::where('team_id', $team->id)->first();
    if(!$registration) {
        flash('Please apply first', 'warning');
        return redirect('/season3/registration');
    }
    if($registration->paid) {
        flash('Your team has already paid', 'info');
        return redirect('/home');
    }
    return view('checkout');
})->middleware('auth');
Route::post('/complete-checkout', function() {
    // dd(Input::all());

    $token = Input::get('stripeToken');
    $email = Input::get('stripeEmail');
    $customer = Stripe::customers()->create([
        'email' => $email,
        'source' => $token
    ]);
    $charge = Stripe::charges()->create([
        'customer' => $customer['id'],
        'currency' => 'USD',
        'amount' => 30.00
    ]);

    $team = Auth::user()->team;
    $registration = App\SeasonRegistration::where('team_id', $team->id)->first();
    $registration->paid = true;
    $registration->save();

    flash('Payment received!', 'success');
    return redirect('/home');

})->middleware('auth');

Route::post('/update-profile', function() {
    $user = Auth::user();

    $age = Input::get('age');
    if($age < 14) {
        flash('You must be older than 13 to use this site', 'error');
        return redirect()->back();
    }
    if($age == 69) {
        flash('lololololol', 'error');
        return redirect()->back();
    }
    if($age > 90) {
        flash('Go back to your retirement home, grandpa', 'error');
        return redirect()->back();
    }

    $user->intro = Input::get('intro');
    $user->server_preference = Input::get('serverpreference');
    $user->location = Input::get('location');
    $user->age = $age;
    $user->save();

    flash('Profile updated', 'success');
    return redirect()->back();

})->middleware('auth');

Route::get('/bracket/{id}', 'BracketController@showBracket');
Route::get('/assemble/{id}', 'BracketController@showRegistrationRoom');
Route::post('/start-bracket-registration', 'BracketController@startRegistration');
Route::post('/decline-party', 'BracketController@declineParty');
Route::post('/join-party', 'BracketController@joinParty');
Route::post('/enter-bracket', 'BracketController@enterBracket');

Route::get('/userstate', function() {
    $user = Auth::user();
    return response()->json(['userid' => $user->id]);
});

/*
 * User Controller
 */

Route::get('/u/{slug}', 'UserController@showUser');

/*
 * Team Controller
 */

Route::get('/create-team', 'HomeController@showCreateTeamForm');
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
Route::get('/season3/registration', 'TeamController@season3registration');
Route::post('/season3/register', 'TeamController@season3register');

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
        //->with('team')
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
        //->with('team')
        //->take(32)
        ->get();
    return view('standings')->with('divisions', $divisions)->with('standings', $overall);
});

Route::post('profile-image-upload', 'ImageController@profile_image_upload');
Route::post('user-profile-image-save', 'ImageController@user_profile_image_save');