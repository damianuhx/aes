<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aes_measure', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('short');
            $table->string('code')->unique();
            
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
        Schema::table('ps_product', function (Blueprint $table) {
            if (Schema::hasColumn('ps_product', 'measure_id'))
                $table->dropColumn('measure_id');
            if (Schema::hasColumn('ps_product', 'measure_netto_id'))
                $table->dropColumn('measure_netto_id');
            if (Schema::hasColumn('ps_product', 'nutrient_netto_id'))
                $table->dropColumn('nutrient_netto_id');
        });
        Schema::dropIfExists('aes_measure_lang');
        Schema::dropIfExists('aes_measure');
    }
}
