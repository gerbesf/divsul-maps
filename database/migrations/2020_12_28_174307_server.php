<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Server extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ipAddress('ip')->nullable();
            $table->string('server_id');
            $table->string('name');
            $table->string('status');
            $table->text('hash_endpoint')->nullable();
            $table->string('http_username',45)->nullable();
            $table->string('http_password',45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server');
    }
}
