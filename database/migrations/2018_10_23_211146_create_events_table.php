<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('place_id')->nullable()->index();
            $table->string('name');
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->text('description')->nullable();
            $table->point('position')->nullable();
            $table->boolean('premium')->default(0);
            $table->dateTime('confirm')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->unique(['start', 'name']);
        });

        Schema::create('events_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->string('path');
            $table->tinyInteger('order')->default(0);
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_pictures');
        Schema::dropIfExists('events');
    }
}
