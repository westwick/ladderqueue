<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Team;
use App\Game;
use DB;

class GenerateSeason2Stats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // clear old results

        // get and save new results
        $teams = Team::where('division_season2', '!=', NULL);
        // calc new RWP first
        foreach($teams as $team) {
            $team->calculateRWP();
        }
        // drop then recreate create view
        // we don't really need to do this every time, but it helps set the view up
        // for dev environment, or if we ever need to make changes to the view
        DB::statement("drop view if exists standings_season2;");
        DB::statement("
            create view standings_season2 as
            select count(distinct g.id) as wins,count(distinct g2.id) as otlosses, count(distinct g.id)*3+count(distinct g2.id) as totalpoints, t.* 
            from teams t
              left join games g on g.winner_id = t.id
              left join games g2 on g2.loser_id = t.id and (g2.team1_score >= 15 and g2.team2_score >= 15)
            where t.division_season2 != ''
            group by t.id;
        ");
    }
}
