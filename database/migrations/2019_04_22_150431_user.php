<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account')->unique();
            $table->string('password');
            $table->string('nickname')->unique;
            $table->integer('sex')->nullable();
            $table->integer('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('url_head_pic')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
        //
    }
}
