<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Online extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profile_id')->nullable();
            $table->string('tag')->nullable();
            $table->string('nick')->nullable();
            $table->integer('team')->nullable();
            $table->integer('deaths')->nullable();
            $table->integer('kills')->nullable();
            $table->integer('score')->nullable();
            $table->boolean('valid')->nullable();
            $table->json('tags')->nullable();
            $table->json('nicks')->nullable();
            $table->json('ips')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online');
    }
}
