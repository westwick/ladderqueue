<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBracketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brackets', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->integer('status_id')->default(0);
            $table->string('name');
            $table->string('location');
            $table->integer('max_teams');
            $table->integer('rounds');
            $table->integer('prize_pool');
            $table->integer('winner_id')->unsigned()->nullable();
            $table->foreign('winner_id')->references('id')->on('teams');
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
        Schema::drop('brackets');
    }
}
