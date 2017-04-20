<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season');
            $table->integer('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->string('server_preference');
            $table->string('team_time_zone');
            $table->boolean('paid')->default(0);
            $table->boolean('accepted')->default(0);
            $table->string('division')->nullable();
            $table->text('available_times');
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
        Schema::drop('season_registrations');
    }
}
