<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBracketGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bracket_games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bracket_id')->unsigned();
            $table->foreign('bracket_id')->references('id')->on('brackets');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bracket_games');
    }
}
