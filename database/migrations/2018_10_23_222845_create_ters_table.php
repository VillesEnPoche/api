<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ters', function (Blueprint $table) {
            $table->increments('id');
            $table->date('day');
            $table->enum('data', ['arrivals', 'departures']);
            $table->json('json');
            $table->timestamps();
            $table->unique(['day', 'data']);
        });

        Schema::create('ters_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number', 32);
            $table->json('json');
            $table->timestamps();
            $table->unique(['number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ters');
        Schema::dropIfExists('ters_details');
    }
}
