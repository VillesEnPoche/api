<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theaters_movies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('code_id')->unique();
            $table->string('title')->nullable();
            $table->json('actors')->nullable();
            $table->json('directors')->nullable();
            $table->json('genres')->nullable();
            $table->string('path_poster')->nullable();
            $table->string('path_trailer')->nullable();
            $table->unsignedInteger('runtime')->nullable();
            $table->float('rating')->nullable();
            $table->date('release')->nullable();
            $table->text('synopsis')->nullable();
            $table->timestamps();
        });

        Schema::create('theaters_movies_times', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('movie_id')->index();
            $table->boolean('is_3d')->default(false);
            $table->boolean('is_original')->default(false);
            $table->string('lang')->nullable();
            $table->dateTime('date');
            $table->timestamps();
            $table->foreign('movie_id')->references('id')->on('theaters_movies')->onDelete('cascade');
            $table->unique(['movie_id', 'is_3d', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('theaters_movies_times');
        Schema::dropIfExists('theaters_movies');
    }
}
