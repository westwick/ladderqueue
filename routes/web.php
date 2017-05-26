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
use App\Team;

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/steam/auth', 'Auth\SteamController@steamAuth');

//Route::get('/home', 'HomeController@index');
//Route::get('/about', function() {
//    return view('static.about');
//});
//Route::get('/get-involved', function() {
//    return view('static.get-involved');
//});
//Route::get('/coming-soon', function() {
//    return view('static.coming-soon');
//});
//Route::get('/code-of-conduct', function() {
//    return view('static.code-of-conduct');
//});
//Route::get('/announcements', function() {
//    $announcements = App\Announcement::all();
//    return view('announcements')->with(compact('announcements'));
//});
//
//Route::get('/test', 'CommentController@test');
//Route::get('/forum', 'CommentController@showForum');
//Route::get('/forum/post/{id}', 'CommentController@showPost');
//Route::post('/post-comment', 'CommentController@postComment')->middleware('auth');
//
//Route::get('/forum/post', 'CommentController@showPostThreadForm')->middleware('auth');
//Route::post('/post-thread', 'CommentController@postThread')->middleware('auth');

//Route::get('/ladder/queue', 'LadderController@showQueue');
//Route::get('/ladder/leaderboard', 'LadderController@showLeaderboard');

Route::post('/admin/users', 'AdminController@getUsers');
Route::post('/admin/updatescore', 'AdminController@updateScore');
Route::post('/admin/clearqueue', 'AdminController@clearQueue');
Route::post('/admin/approve', 'AdminController@approveUser');
Route::post('/admin/remove', 'AdminController@removeUser');
Route::post('/admin/news', 'AdminController@postNews');
Route::post('/admin/cancelgame', 'AdminController@cancelGame');
Route::post('/admin/adjust-points', 'AdminController@adjustPoints');

Route::post('/games', 'BracketController@games');
Route::post('/gameinfo', 'BracketController@gameInfo');
Route::post('/leaderboard', 'BracketController@leaderboard');
Route::post('/playerlog', 'BracketController@playerlog');
Route::post('/readycheck', 'BracketController@ready');
Route::post('/enter-queue', 'BracketController@joinQueue')->middleware('throttle:2,1');
Route::post('/leave-queue', 'BracketController@leaveQueue');
Route::post('/get-queue', 'BracketController@getQueue');
Route::post('/draft-player', 'BracketController@draftPlayer');
Route::post('/ban-map', 'BracketController@banMap');
Route::post('/reportscore', 'BracketController@reportScore');


//Route::get('/checkout', function() {
//    $team = Auth::user()->team;
//    $registration = App\SeasonRegistration::where('team_id', $team->id)->first();
//    if(!$registration) {
//        flash('Please apply first', 'warning');
//        return redirect('/season3/registration');
//    }
//    if($registration->paid) {
//        flash('Your team has already paid', 'info');
//        return redirect('/home');
//    }
//    return view('checkout');
//})->middleware('auth');
//Route::post('/complete-checkout', function() {
//    // dd(Input::all());
//
//    $token = Input::get('stripeToken');
//    $email = Input::get('stripeEmail');
//    $customer = Stripe::customers()->create([
//        'email' => $email,
//        'source' => $token
//    ]);
//    $charge = Stripe::charges()->create([
//        'customer' => $customer['id'],
//        'currency' => 'USD',
//        'amount' => 30.00
//    ]);
//
//    $team = Auth::user()->team;
//    $registration = App\SeasonRegistration::where('team_id', $team->id)->first();
//    $registration->paid = true;
//    $registration->save();
//
//    flash('Payment received!', 'success');
//    return redirect('/home');
//
//})->middleware('auth');

//Route::post('/update-profile', 'UserController@updateProfile')->middleware('auth');
//
//Route::get('/bracket/{id}', 'BracketController@showBracket');
//Route::get('/assemble/{id}', 'BracketController@showRegistrationRoom');
//Route::post('/start-bracket-registration', 'BracketController@startRegistration');
//Route::post('/decline-party', 'BracketController@declineParty');
//Route::post('/join-party', 'BracketController@joinParty');
//Route::post('/enter-bracket', 'BracketController@enterBracket');

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

//Route::get('/create-team', 'HomeController@showCreateTeamForm');
//Route::post('/create-team', 'TeamController@createTeam');
//Route::post('/update-team', 'TeamController@updateTeam');
//Route::post('/join-team',   'TeamController@joinTeam');
//Route::get('/teams',        'TeamController@viewAll');
//Route::get('/team/{slug}',    'TeamController@viewTeam');
//Route::get('/edit-team', 'TeamController@showUpdateForm');

/*
 * Game Controller
 */

//Route::get('/addgame',        'GameController@addGame');
//Route::post('/create-game',   'GameController@createGame');
Route::post('/edit-game',     'GameController@editGame');
//Route::post('/delete-game',   'GameController@deleteGame');
Route::get('/game/{id}/edit', 'GameController@editGameForm');


/*
 *  Season 3
 */

//Route::get('/season3', 'SeasonController@season3info');
//Route::get('/season3/rules', 'SeasonController@season3info');
//Route::get('/season3/registration', 'TeamController@season3registration');
//Route::post('/season3/register', 'TeamController@season3register');

/*
 *  Message Controller
 */

//Route::get('/messages', 'ConversationController@index');
//Route::post('/send-msg', 'ConversationController@sendMessage');
//Route::post('/sendmsg', 'ConversationController@sendMessageForm');
//Route::post('/get-messages', 'ConversationController@getMessages');
//Route::post('/read-convo', 'ConversationController@convoRead');
//Route::get('/messages/{withUser}', 'ConversationController@viewConversation');

/*
 * Schedule/Standings
 */

//Route::get('/season2/schedule', function () {
//    $games = Game::orderBy('start_time')->get();
//    $formatted = [];
//
//    foreach($games as $game) {
//        $formatted[] = array(
//            'game_id' => $game->id,
//            'team1_name' => $game->team1->name,
//            'team1_id' => $game->team1->id,
//            'team1_slug' => $game->team1->slug,
//            'team1_logo' => $game->team1->logo,
//            'team1_record' => $game->team1->record(),
//            'team1_score' => $game->team1_score,
//            'team2_name' => $game->team2->name,
//            'team2_id' => $game->team2->id,
//            'team2_slug' => $game->team2->slug,
//            'team2_logo' => $game->team2->logo,
//            'team2_record' => $game->team2->record(),
//            'team2_score' => $game->team2_score,
//            'match_time' => $game->start_time->toDateTimeString(),
//            'map' => $game->map,
//            'game_status' => $game->status,
//            'winner_id' => $game->winner_id,
//            'loser_id' => $game->loser_id
//        );
//    }
//
//    return view('schedule')->with('games', json_encode($formatted));
//});
//
//Route::get('/season2/standings', function () {
//    $standings = Standing::orderBy('division_season2')
//        ->orderBy('totalpoints', 'desc')
//        ->orderBy('rwp', 'desc')
//        ->orderBy('name')
//        //->with('team')
//        ->get();
//    $divisions = [];
//    $currentDivision = '';
//    foreach($standings as $standing) {
//        if($currentDivision != $standing->division_season2) {
//            $currentDivision = $standing->division_season2;
//            $divisions[$currentDivision] = ['name' => $currentDivision, 'standings' => []];
//        }
//        $divisions[$currentDivision]['standings'][] = $standing;
//    }
//    $overall = Standing::orderBy('totalpoints', 'desc')
//        ->orderBy('rwp', 'desc')
//        ->orderBy('name')
//        //->with('team')
//        //->take(32)
//        ->get();
//    return view('standings')->with('divisions', $divisions)->with('standings', $overall);
//});
//
//Route::post('profile-image-upload', 'ImageController@profile_image_upload');
//Route::post('user-profile-image-save', 'ImageController@user_profile_image_save');

Route::any('{url}', 'HomeController@index')->where('url', '(.*)');