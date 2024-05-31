<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManufacturerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aes_manufacturer', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('name')->unique();
            
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

        /*Schema::table('ps_product', function (Blueprint $table) {
            if (Schema::hasColumn('ps_product', 'manufacturer_id'))
                $table->dropColumn('manufacturer_id');
        });*/

        Schema::dropIfExists('aes_manufacturer');
    }
}
