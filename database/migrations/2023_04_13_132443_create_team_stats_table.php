<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_stats', function (Blueprint $table) {
            $table->id();
            $table->integer('season');
            $table->string('form');
            $table->integer('played');
            $table->integer('wins');
            $table->integer('ties');
            $table->integer('loses');
            $table->integer('goals');
            $table->integer('clean_sheets');
            $table->integer('yellow_cards');
            $table->integer('red_cards');
            $table->string('team');
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
        Schema::dropIfExists('team_stats');
    }
}
