<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aes_tag', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('tag_id')->unsigned()->nullable();
            $table->foreign('tag_id')->references('id')->on('aes_tag');
            
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
        Schema::dropIfExists('aes_tag_lang');
        Schema::dropIfExists('aes_product_tag');
        Schema::dropifExists('aes_feature');
        Schema::dropIfExists('aes_tag');
    }
}
