<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamScoresToLadderGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ladder_games', function(Blueprint $table) {
            $table->integer('team1score')->nullable();
            $table->integer('team2score')->nullable();
            $table->integer('winner')->nullable();
            $table->timestamp('ended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ladder_games', function(Blueprint $table) {
            $table->dropColumn('team1score');
            $table->dropColumn('team2score');
            $table->dropColumn('winner');
            $table->dropColumn('ended_at');
        });
    }
}
