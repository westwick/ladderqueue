<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('sound_enabled')->default(true);
            $table->boolean('notifications_enabled')->default(false);
            $table->string('timezone')->default('Eastern');
            $table->string('twitch')->nullable();
            $table->string('twitter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sound_enabled');
            $table->dropColumn('notifications_enabled');
            $table->dropColumn('timezone');
            $table->dropColumn('twitch');
            $table->dropColumn('twitter');
        });
    }
}
