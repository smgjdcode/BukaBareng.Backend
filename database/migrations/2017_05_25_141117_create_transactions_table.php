<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('jumlah');
            $table->integer('massdrop_id')->unsigned();
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('transactions');
    }
}
