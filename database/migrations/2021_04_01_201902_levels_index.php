<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LevelsIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels_index', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('map_key');      // map
            $table->string('size');         // mapsize
            $table->string('game_mode');    // ins, cq
            $table->string('players');      // players
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels_index');
    }
}
