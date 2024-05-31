<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutrientProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aes_nutrient_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('nutrient_id')->unsigned();
            $table->foreign('nutrient_id')->references('id')->on('aes_nutrient');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id_product')->on('ps_product');
            $table->double('amount');

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
        Schema::dropIfExists('aes_nutrient_product');
    }
}
