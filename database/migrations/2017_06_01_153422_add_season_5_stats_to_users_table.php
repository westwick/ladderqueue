<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeason5StatsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('s5_rank')->default(0);
            $table->integer('s5_points')->default(0);
            $table->integer('s5_wins')->default(0);
            $table->integer('s5_losses')->default(0);
            $table->integer('s5_games_played')->default(0);
            $table->decimal('s5_win_pct', 4, 3)->default(0);
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
            $table->dropColumn('s5_rank');
            $table->dropColumn('s5_wins');
            $table->dropColumn('s5_losses');
            $table->dropColumn('s5_games_played');
            $table->dropColumn('s5_win_pct');
            $table->dropColumn('s5_points');
        });
    }
}
