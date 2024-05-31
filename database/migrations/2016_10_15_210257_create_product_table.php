<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ps_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            //$table->increments('id');
            //$table->string('reference');
            //$table->double('weight');

            $table->integer('manufacturer_id')->nullable()->unsigned();
            $table->foreign('manufacturer_id')->references('id')->on('aes_manufacturer');

            // content
            $table->double('content');
            $table->integer('measure_id')->nullable()->unsigned();
            $table->foreign('measure_id')->references('id')->on('aes_measure');

            // content_netto
            $table->double('content_netto');
            $table->integer('measure_netto_id')->nullable()->unsigned();
            $table->foreign('measure_netto_id')->references('id')->on('aes_measure');

            $table->double('nutrient_netto');
            $table->integer('nutrient_netto_id')->nullable()->unsigned();
            $table->foreign('nutrient_netto_id')->references('id')->on('aes_measure');

            $table->integer('country_id')->nullable()->unsigned();
            $table->foreign('country_id')->references('id')->on('aes_country');
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
            if (Schema::hasColumn('ps_product', 'manufacturer_id')) {
                $table->dropForeign('ps_product_manufacturer_id_foreign');
                $table->dropColumn('manufacturer_id');
            }

            if (Schema::hasColumn('ps_product', 'content'))
                $table->dropColumn('content');
            if (Schema::hasColumn('ps_product', 'measure_id')) {
                $table->dropForeign('ps_product_measure_id_foreign');
                $table->dropColumn('measure_id');
            }

            if (Schema::hasColumn('ps_product', 'content_netto'))
                $table->dropColumn('content_netto');
            if (Schema::hasColumn('ps_product', 'measure_netto_id')) {
                $table->dropForeign('ps_product_measure_netto_id_foreign');
                $table->dropColumn('measure_netto_id');
            }

            if (Schema::hasColumn('ps_product', 'nutrient_netto'))
                $table->dropColumn('nutrient_netto');
            if (Schema::hasColumn('ps_product', 'nutrient_netto_id')) {
                $table->dropForeign('ps_product_nutrient_netto_id_foreign');
                $table->dropColumn('nutrient_netto_id');
            }

            if (Schema::hasColumn('ps_product', 'country_id')) {
                $table->dropForeign('ps_product_country_id_foreign');
                $table->dropColumn('country_id');
            }

            if (Schema::hasColumn('ps_product', 'created_at'))
                $table->dropColumn('created_at');
            if (Schema::hasColumn('ps_product', 'updated_at'))
                $table->dropColumn('updated_at');
        });
    }
}
