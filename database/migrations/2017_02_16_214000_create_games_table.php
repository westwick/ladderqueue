<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team1_id')->unsigned();
            $table->foreign('team1_id')->references('id')->on('teams');
            $table->integer('team2_id')->unsigned();
            $table->foreign('team2_id')->references('id')->on('teams');
            $table->string('season');
            $table->string('map');
            $table->dateTime('start_time');
            $table->integer('status');
            $table->string('twitch_link');
            $table->string('caster');
            $table->integer('team1_score')->default(0);
            $table->integer('team2_score')->default(0);
            $table->integer('winner_id')->unsigned();
            $table->foreign('winner_id')->references('id')->on('teams');
            $table->integer('loser_id')->unsigned();
            $table->foreign('loser_id')->references('id')->on('teams');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
