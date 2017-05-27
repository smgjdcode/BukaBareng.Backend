<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('jumlah');
            $table->string('product_id')->unique();
            $table->integer('massdrop_id')->unsigned();
            $table->string('user_id')->unsigned();
            $table->integer('status');
            $table->date('bought_time');
            $table->timestamps();
            $table->foreign('massdrop_id')->references('id')->on('massdrops');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buys');
    }
}
