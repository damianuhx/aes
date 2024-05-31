<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrstshpLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ps_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->boolean('aes_active')->default(1);           
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
        Schema::table('ps_lang', function (Blueprint $table) {
            if (Schema::hasColumn('ps_lang', 'created_at'))            
                $table->dropColumn('created_at');
            if (Schema::hasColumn('ps_lang', 'updated_at'))  
                $table->dropColumn('updated_at');
            if (Schema::hasColumn('ps_lang', 'aes_active'))  
                $table->dropColumn('aes_active');
        });
        
    }
}
