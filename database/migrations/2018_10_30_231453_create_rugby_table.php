<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRugbyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rugby_phases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('championship');
            $table->string('name');
            $table->unsignedMediumInteger('phase_id')->unique();
            $table->timestamps();
        });

        Schema::create('rugby_matchs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('ffr_id')->index();
            $table->unsignedMediumInteger('phase_id')->index();
            $table->dateTime('date')->index();
            $table->string('statut', 32);
            $table->smallInteger('t1_score')->nullable();
            $table->smallInteger('t2_score')->nullable();
            $table->string('t1_name');
            $table->string('t2_name');
            $table->string('t1_city');
            $table->string('t2_city');
            $table->string('terrain')->nullable();
            $table->timestamps();
            $table->unique(['date', 'phase_id', 't1_name', 't2_name']);
        });

        Schema::create('rugby_rankings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('phase_id')->index();
            $table->unsignedMediumInteger('poule_id')->index();
            $table->unsignedMediumInteger('team_id');
            $table->string('name');
            $table->unsignedSmallInteger('position');
            $table->smallInteger('regulationPointsTerrain')->nullable();
            $table->smallInteger('pointTerrain')->nullable();
            $table->unsignedSmallInteger('joues');
            $table->unsignedSmallInteger('gagnes');
            $table->unsignedSmallInteger('nuls');
            $table->unsignedSmallInteger('perdus');
            $table->mediumInteger('pointsDeMarqueAquis');
            $table->mediumInteger('pointsDeMarqueConcedes');
            $table->mediumInteger('goalAverage');
            $table->unsignedSmallInteger('essaisMarques');
            $table->unsignedSmallInteger('essaisConcedes');
            $table->unsignedSmallInteger('bonusOffensif');
            $table->unsignedSmallInteger('bonusDefensif');
            $table->timestamps();

            $table->unique(['phase_id', 'team_id']);
            $table->foreign('phase_id')->references('phase_id')->on('rugby_phases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rugby_rankings');
        Schema::dropIfExists('rugby_matchs');
        Schema::dropIfExists('rugby_phases');
    }
}
