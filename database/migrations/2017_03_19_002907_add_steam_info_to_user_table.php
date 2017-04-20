<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSteamInfoToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->default(NULL);
            $table->string('avatar')->nullable()->default(NULL);
            $table->string('steamid')->nullable()->default(NULL);
            $table->string('steamid64')->nullable()->unique()->default(NULL);
            $table->boolean('steam_verified')->default(false);
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
            $table->dropColumn('username');
            $table->dropColumn('avatar');
            $table->dropColumn('steamid');
            $table->dropColumn('steamid64');
            $table->dropColumn('steam_verified');
        });
    }
}
