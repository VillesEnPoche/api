<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('path')->nullable();
            $table->unsignedInteger('place_type_id_parent')->nullable()->index();
            $table->boolean('show')->default(1);
            $table->timestamps();
            $table->foreign('place_type_id_parent')->references('id')->on('places_types')->onDelete('cascade');
        });

        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('place_type_id')->index();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('city', 32)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('website')->nullable();
            $table->json('timetable')->nullable();
            $table->point('position')->nullable()->index();
            $table->boolean('premium')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('place_type_id')->references('id')->on('places_types')->onDelete('cascade');
            $table->unique(['name', 'phone']);
        });

        Schema::create('places_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('place_id');
            $table->string('path');
            $table->tinyInteger('order')->default(0);
            $table->timestamps();
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places_pictures');
        Schema::dropIfExists('places');
        Schema::dropIfExists('places_types');
    }
}
