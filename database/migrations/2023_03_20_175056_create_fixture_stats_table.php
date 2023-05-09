<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixtureStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture_stats', function (Blueprint $table) {
            $table->id();
            $table->string('team');
            $table->integer('sh_on_goal');
            $table->integer('sh_off_goal');
            $table->integer('sh_total');
            $table->integer('sh_bloked');
            $table->integer('sh_in_box');
            $table->integer('sh_out_box');
            $table->integer('fouls');
            $table->integer('corners');
            $table->integer('offsides');
            $table->decimal('ball_possession');
            $table->integer('yellow');
            $table->integer('red');
            $table->integer('saves');
            $table->integer('passes');
            $table->integer('acc_passes');
            $table->decimal('pass_proc');
            $table->integer('fk');
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
        Schema::dropIfExists('fixture_stats');
    }
}
