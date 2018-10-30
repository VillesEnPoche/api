<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFootballsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('football_seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('fff_id')->unique();
            $table->string('name', 32);
            $table->string('championship', 32);
            $table->timestamps();
        });

        Schema::create('football_matchs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('season_id');
            $table->unsignedInteger('fff_id')->unique();
            $table->string('t1_name', 32);
            $table->string('t2_name', 32);
            $table->unsignedInteger('t1_id');
            $table->unsignedInteger('t2_id');
            $table->unsignedTinyInteger('t1_score');
            $table->unsignedTinyInteger('t2_score');
            $table->string('statut', 32);
            $table->string('day', 3);
            $table->dateTime('date');
            $table->string('diffuser', 32)->nullable();
            $table->string('stade_name', 64)->nullable();
            $table->string('twitter', 12)->nullable();
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('football_seasons')->onDelete('cascade');
        });

        Schema::create('football_rankings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('season_id');
            $table->unsignedInteger('team_id');
            $table->string('team_name', 32);
            $table->unsignedInteger('position');
            $table->string('evolution', 1);
            $table->unsignedSmallInteger('played');
            $table->unsignedSmallInteger('points');
            $table->unsignedSmallInteger('win');
            $table->unsignedSmallInteger('drawn');
            $table->unsignedSmallInteger('lose');
            $table->unsignedSmallInteger('gf');
            $table->unsignedSmallInteger('ga');
            $table->smallInteger('diff');
            $table->string('day', 3);
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('football_seasons')->onDelete('cascade');
            $table->unique(['season_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('football_rankings');
        Schema::dropIfExists('football_matchs');
        Schema::dropIfExists('football_seasons');
    }
}
