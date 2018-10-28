<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('command', 64);
            $table->string('twitter', 64)->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('articles_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('partner_id')->index();
            $table->string('name');
            $table->string('twitter', 64)->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('articles_partners')->onDelete('cascade');
            $table->unique(['partner_id', 'name']);
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('partner_id');
            $table->string('unique_id');
            $table->string('title');
            $table->boolean('distant')->default(1);
            $table->text('href')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('date');
            $table->timestamps();
            $table->foreign('partner_id')->references('id')->on('articles_partners')->onDelete('cascade');
            $table->unique(['partner_id', 'unique_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('articles_authors');
        Schema::dropIfExists('articles_partners');
    }
}
