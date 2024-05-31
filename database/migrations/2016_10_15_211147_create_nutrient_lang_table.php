<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutrientLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aes_nutrient_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('nutrient_id')->unsigned();
            $table->foreign('nutrient_id')->references('id')->on('aes_nutrient');
            $table->integer('language_id');
            $table->foreign('language_id')->references('id_lang')->on('ps_lang');
            $table->string('name');

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
        Schema::dropIfExists('aes_nutrient_lang');
    }
}
