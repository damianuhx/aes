<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ps_product_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            //$table->increments('id');
            $table->string('text');
            $table->string('posttext');

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
        Schema::table('ps_product_lang', function (Blueprint $table) {
            if (Schema::hasColumn('ps_product_lang', 'text'))
                $table->dropColumn('text');
            if (Schema::hasColumn('ps_product_lang', 'posttext'))
                $table->dropColumn('posttext');
            if (Schema::hasColumn('ps_product_lang', 'created_at'))
                $table->dropColumn('created_at');
            if (Schema::hasColumn('ps_product_lang', 'updated_at'))
                $table->dropColumn('updated_at');
        });
    }
}
