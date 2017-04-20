<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Team;
use DB;

class Bracket extends Model
{
    public static $STATUS_DRAFT = 0;
    public static $STATUS_REGISTRATION_OPEN = 10;
    public static $STATUS_REGISTRATION_CLOSED = 20;
    public static $STATUS_LIVE = 30;
    public static $STATUS_COMPLETE = 40;
    public static $STATUS_CANCELLED = 99;
    protected $dates = ['start_time', 'completed_at'];

    public function teams()
    {
        $team_ids = DB::table('parties')->where('bracket_id', $this->id)->pluck('team_id');
        return Team::whereIn('id', $team_ids->all())->with('members');
    }

    public function status_display()
    {
        $status_id = $this->status_id;
        switch($status_id) {
            case self::$STATUS_DRAFT:
                return 'Draft';
                break;
            case self::$STATUS_REGISTRATION_OPEN:
                return 'Registration Open';
                break;
            case self::$STATUS_REGISTRATION_CLOSED:
                return 'Registration Closed - Starting Soon';
                break;
            case self::$STATUS_LIVE:
                return 'Live';
                break;
            case self::$STATUS_COMPLETE:
                return 'Complete';
                break;
            case self::$STATUS_CANCELLED:
                return 'Cancelled';
                break;
        }
    }
}
