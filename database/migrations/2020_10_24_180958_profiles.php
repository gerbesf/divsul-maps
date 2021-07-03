<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Profiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_clan')->nullable();
            $table->string('id_steam')->nullable();
            $table->integer('points')->default(0);
            $table->string('nickname');
            $table->string('hash');
            $table->integer('steam_level')->nullable();
            $table->json('steam_tags')->nullable();
            $table->string('status')->default('avaliable');
            $table->string('password')->nullable();
            $table->boolean('deleted')->default(false);
            $table->json('search')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
