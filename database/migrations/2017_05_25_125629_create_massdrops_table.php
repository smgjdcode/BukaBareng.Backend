<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMassdropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('massdrops', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('product_id')->unique();
            $table->string('product_name');
            $table->string('product_img');
            $table->integer('lower_bound');
            $table->integer('lower_price');
            $table->integer("quantity");
            $table->date('deadline');
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
        Schema::dropIfExists('massdrops');
    }
}
