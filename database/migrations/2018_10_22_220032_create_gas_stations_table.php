<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGasStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gas_stations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('pvid')->index();
            $table->string('name');
            $table->string('address');
            $table->string('city', 128);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('gas_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('station_id')->index();
            $table->string('gas');
            $table->float('price');
            $table->timestamps();
            $table->foreign('station_id')->references('id')->on('gas_stations')->onDelete('cascade');
            $table->unique(['station_id', 'gas']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gas_stations');
        Schema::dropIfExists('gas_prices');
    }
}
