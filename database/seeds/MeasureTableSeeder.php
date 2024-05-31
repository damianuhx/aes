<?php

use Illuminate\Database\Seeder;

class MeasureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aes_measure')->insert([
            [
                'id' => 1,
                'short' => 'mg',
                'code' => 'mg'
            ], 
            [
                'id' => 2,
                'short' => 'ml',
                'code' => 'ml'
            ], 
            [
                'id' => 3,
                'short' => 'g',
                'code' => 'g'
            ]
        ]);

        DB::table('aes_measure_lang')->insert([
            [
                'measure_id' => 1,
                'language_id' => 1,
                'name' => 'miligrams '
            ], 
            [
                'measure_id' => 1,
                'language_id' => 2,
                'name' => 'miligrams (German)'
            ], 
            [
                'measure_id' => 1,
                'language_id' => 3,
                'name' => 'miligrams (French)'
            ],
            [
                'measure_id' => 2,
                'language_id' => 1,
                'name' => 'mililiters'
            ],
            [
                'measure_id' => 2,
                'language_id' => 2,
                'name' => 'mililiters (German)'
            ],
            [
                'measure_id' => 2,
                'language_id' => 3,
                'name' => 'mililiters (French)'
            ],
            [
                'measure_id' => 3,
                'language_id' => 1,
                'name' => 'grams'
            ],
            [
                'measure_id' => 3,
                'language_id' => 2,
                'name' => 'grams (German)'
            ],
            [
                'measure_id' => 3,
                'language_id' => 3,
                'name' => 'grams (French)'
            ]
        ]);
    }
}
