<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServerHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('map_key');
            $table->string('map_mode');
            $table->string('map_size');
            $table->integer('players');
            $table->boolean('valid');
            $table->dateTime('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_history');
    }
}
