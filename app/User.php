<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Broadcasting\PrivateChannel;
use DB;
use App\Party;

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
        'password', 'remember_token',
    ];

    public function getState()
    {
        return json_encode([
            'userid' => $this->id,
            'party' => $this->activeParty(),
            'loggedIn' => true
        ]);
    }

    public function routeNotificationForSlack()
    {
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
}
