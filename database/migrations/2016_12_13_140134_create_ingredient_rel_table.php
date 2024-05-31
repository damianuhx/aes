<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientRelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aes_ingredient_rel', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('aes_ingredient');
            $table->integer('child_id')->unsigned();
            $table->foreign('child_id')->references('id')->on('aes_ingredient');

            $table->double('position');
            $table->string('amount');
            $table->integer('country_id')->default(0);

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
        Schema::dropIfExists('aes_ingredient_rel');
    }
}
