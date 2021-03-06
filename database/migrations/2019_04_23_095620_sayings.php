<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sayings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saying', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('creator');
            $table->string('nickname');
            $table->string('content');
            $table->string('url_head_pic')->nullable();
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
        Schema::dropIfExists('saying');
        //
    }
}
