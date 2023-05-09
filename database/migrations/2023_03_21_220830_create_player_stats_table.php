<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('league');
            $table->integer('app');
            $table->integer('min');
            $table->double('rating');
            $table->integer('sh_total');
            $table->integer('sh_on_goal');
            $table->integer('goals');
            $table->integer('assists');
            $table->integer('passes');
            $table->integer('key');
            $table->integer('drb_a');
            $table->integer('drb_succ');
            $table->integer('yellow');
            $table->integer('red');
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
        Schema::dropIfExists('player_stats');
    }
}
