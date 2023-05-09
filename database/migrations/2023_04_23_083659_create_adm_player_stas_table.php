<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmPlayerStasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_player_stas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->integer('min');
            $table->integer('shots');
            $table->integer('shots_on_goal');
            $table->integer('goals');
            $table->integer('assists');
            $table->integer('yellow');
            $table->integer('red');
            $table->integer('fixtureID');
            $table->integer('teamID');
            $table->string('userID');
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
        Schema::dropIfExists('adm_player_stas');
    }
}
