<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');
            $table->integer('bracket_id')->unsigned();
            $table->foreign('bracket_id')->references('id')->on('brackets');
            $table->integer('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->integer('status_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('parties');
    }
}
