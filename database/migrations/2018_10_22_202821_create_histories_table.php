<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollutants_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pollutant_id');
            $table->enum('type', ['analyse', 'prevision']);
            $table->enum('var', ['MOYJ0', 'MOYJ1', 'MOYJ2', 'MOYJ3', 'MAXJ0', 'MAXJ1', 'MAXJ2', 'MAXJ3', 'MAXJ', 'MOYJ']);
            $table->date('date');
            $table->float('value');
            $table->unsignedTinyInteger('alert')->default(0);
            $table->timestamps();
            $table->foreign('pollutant_id')->references('id')->on('pollutants')->onDelete('cascade');
            $table->unique(['type', 'var', 'date', 'pollutant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pollutants_histories');
    }
}
