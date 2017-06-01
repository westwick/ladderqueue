<?php

namespace App;

use App\Events\GameStarting;
use App\Events\PlayerJoinedQueue;
use App\Jobs\CheckPlayersReady;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Broadcasting\PrivateChannel;
use DB;
use App\Party;
use App\LadderGame;
use App\LadderPlayer;
use App\QueueUser;
use Log;
use Carbon\Carbon;
use Cache;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'avatar', 'steamid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'avatar', 'intro', 'steamid', 'server_preference',
        's5_rank', 's5_points', 's5_wins', 's5_losses', 's5_games_played', 's5_win_pct'
    ];

    // always add the image attribute to all model requests
    public $appends = ['image'];

    public function getState()
    {
        return json_encode([
            'userid' => $this->id,
            'username' => $this->name,
            'joinedQueue' => $this->joinedQueue(),
            'is_admin' => $this->is_admin,
            'canQueue' => $this->ladder_queue != '',
            'settings' => [
                'sound_enabled' => $this->sound_enabled,
                'notifications_enabled' => $this->notifications_enabled,
                'timezone' => $this->timezone
            ],
            'profile' => [
                'location' => $this->location,
                'age' => $this->age,
                'intro' => $this->intro,
                'twitch' => $this->twitch,
                'twitter' => $this->twitter
            ],
            //'party' => $this->activeParty(),
            'loggedIn' => true
        ]);
    }

    public function routeNotificationForSlack()
    {
        if(App::environment('local', 'dev', 'development')) {
            return false;
        }
        return 'https://hooks.slack.com/services/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';
    }

    public function team()
    {
        return $this->hasOne('App\Team', 'id', 'team_id');
    }

    public function hasTeam()
    {
        return $this->team_id !== NULL;
    }

    public function captainTeams()
    {
        $team_ids = DB::table('team_members')->where('user_id', $this->id)->where('role', '>', 0)->pluck('team_id');
        return Team::whereIn('id', $team_ids->all())->with('members')->get();
    }

    public function parties()
    {
        return $this->belongsToMany('App\Party', 'party_players');
    }

    public function conversations()
    {
        return $this->belongsToMany('App\Conversation', 'participants')->with('participants');
    }

    public function unreadMessagesCount()
    {
        $unread = 0;
        foreach($this->conversations as $convo) {
            foreach($convo->participants as $p) {
                if($p->user_id == $this->id) {
                    $unread += $p->unreadCount;
                }
            }
        }

        return $unread;
    }

    public function getMessages()
    {
        return $this->conversations()->orderBy('updated_at', 'desc')->get();
    }

    public function joinedQueue()
    {
        $user = QueueUser::where('user_id', $this->id)->first();
        if($user) {
            return Carbon::now()->diffInSeconds($user->created_at);
        }
        return 0;
    }

    public function activeParty()
    {
        $party = $this->parties->where('status_id', '<', Party::$STATUS_COMPLETE)->first();
        if(count($party) == 1) {
            $p = Party::where('id', $party->id)->with('players')->with('creator')->first();
            return $p;
        } else {
            return false;
        }
    }

    public function getImageAttribute()
    {
        return $this->avatar !== NUll ? $this->avatar : '/images/unknown.png';
    }

    public function getTzAttribute()
    {
        $tz = $this->timezone;
        if($tz === 'Pacific') return 'America/Los_Angeles';
        if($tz === 'Mountain') return 'America/Denver';
        if($tz === 'Central') return 'America/Chicago';
        if($tz === 'Eastern') return 'America/New_York';
        return 'America/New_York';
    }

    public function getGamesPlayedAttribute()
    {
        return LadderPlayer::where('user_id', $this->id)->where('status_id', LadderPlayer::$STATUS_COMPLETE)->count();
    }

    public function calculateRank()
    {
        $rank = DB::table('users')->select(DB::raw('
            FIND_IN_SET( ladder_points, (
                SELECT GROUP_CONCAT( ladder_points
                ORDER BY ladder_points DESC ) 
                FROM users where games_played > 0 )
            ) AS rank'))->where('id', $this->id)->first();
        return $rank->rank;
    }

    public function getMemberSinceAttribute()
    {
        return $this->created_at->format('M Y');
    }

    public function getGamesAttribute()
    {
        $result = [];
        $players = LadderPlayer::with('game')
            ->where('user_id', $this->id)
            ->where('status_id', LadderPlayer::$STATUS_COMPLETE)
            ->orderBy('id', 'desc')
            ->get();
        foreach($players as $player) {
            $win = false;
            if($player->team === $player->game->winner) {
                $win = true;
            }
            $result[] = [
                'id' => $player->game->id,
                'won' => $win,
                'score' => $player->game->team1score . ' - ' . $player->game->team2score,
                'when' => $player->game->ended_at->diffForHumans()
            ];
        }
        return $result;
    }

    public function getLogAttribute()
    {
        return PlayerLog::where('user_id', $this->id)->orderBy('id', 'desc')->get();
    }

    public function calculateGames()
    {
        $wins = 0;
        $losses = 0;
        $players = LadderPlayer::where('user_id', $this->id)->where('status_id', LadderPlayer::$STATUS_COMPLETE)->get();
        foreach($players as $player) {
            if($player->team == $player->game->winner) {
                $wins++;
            } else {
                $losses++;
            }
        }
        $total = $wins+$losses;
        $win_pct = $total > 0 ? $wins/$total : 0;
        return ['wins' => $wins, 'losses' => $losses, 'games_played' => $total, 'win_pct' => $win_pct];
    }

    public function calculateStreak()
    {
        $log = PlayerLog::where('user_id', $this->id)->orderBy('created_at', 'desc')->take(5)->pluck('points')->all();
        return array_sum($log);
    }

    public function getSparklineAttribute()
    {
        $log = PlayerLog::where('user_id', $this->id)->orderBy('created_at', 'desc')->take(5)->pluck('points');
        $streak = $this->streak;
        $sparkline = [$streak];
        for($i = 1; $i <= count($log); $i++) {
            $sparkline[] = $sparkline[$i - 1] + (-1 * $log[$i - 1]);
        }
        return array_reverse($sparkline);
    }


    public function getLadderGame()
    {
        $player = LadderPlayer::where('user_id', $this->id)->where('status_id', '<', 40)->first();
        if($player) {
            $game = LadderGame::where('id', $player->game_id)->where('status_id', '<', 40)->first();
        } else {
            $game = NULL;
        }

        return $game;
    }

    public function joinQueue()
    {
        $user = $this;
        $q = new QueueUser();
        $q->user_id = $user->id;
        $q->save();

        broadcast(new PlayerJoinedQueue($user))->toOthers();

        $all = QueueUser::with('user')
            ->join('users', 'user_id', '=', 'users.id')
            ->orderBy('users.ladder_points', 'DESC')
            ->orderBy('queue_users.created_at')
            ->limit(10)
            ->get();
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
            $player->status_id = 0;
            $player->isCaptain = true;
            $player->team = 1;
            $player->save();

            $player = new LadderPlayer();
            $player->user_id = $team2captain->user->id;
            $player->game_id = $game->id;
            $player->status_id = 0;
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
            $ids = $all->pluck('id')->toArray();
            QueueUser::whereIn('user_id', $ids)->delete();

            broadcast(new GameStarting($game));

            // dispatch a job to make sure everyone ready'd up
            $checkReady = (new CheckPlayersReady($game))->delay(Carbon::now()->addSeconds(23));
            dispatch($checkReady);
        }

        return true;
    }

    public function removeFromQueue()
    {
        QueueUser::where('user_id', $this->id)->delete();
    }

    public function canDraftIn(LadderGame $game)
    {
        foreach($game->players as $player) {
            if($player->isCaptain && 
               $player->user->id === $this->id && 
               $player->team === $game->draftTurn()) {
                return true;
            }
        }
        return false;
    }

    public function canBanMapIn(LadderGame $game)
    {
        return true;
    }

    public function adjustPoints($points, $memo)
    {
        $this->ladder_points += $points;
        $this->save();

        $log = new PlayerLog();
        $log->user_id = $this->id;
        $log->points = $points;
        $log->memo = $memo;
        $log->save();

        Cache::forget('leaderboard');
    }
}
