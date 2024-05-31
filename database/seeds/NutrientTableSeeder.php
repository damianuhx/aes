<?php

use Illuminate\Database\Seeder;

class NutrientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aes_nutrient')->insert([
            [
                'id' => 1,
                'dailyrec' => 20,
                'calories' => 30,
                'measure_id' => 3
            ], 
            [
                'id' => 2,
                'dailyrec' => 20,
                'calories' => 30,
                'measure_id' => 3
            ], 
            [
                'id' => 3,
                'dailyrec' => 20,
                'calories' => 30,
                'measure_id' => 3
            ]
        ]);

        DB::table('aes_nutrient_lang')->insert([
            [
                'nutrient_id' => 1,
                'language_id' => 1,
                'name' => 'Sugar'
            ], 
            [
                'nutrient_id' => 1,
                'language_id' => 2,
                'name' => 'Zucker'
            ], 
            [
                'nutrient_id' => 1,
                'language_id' => 3,
                'name' => 'Suckre'
            ],
            [
                'nutrient_id' => 2,
                'language_id' => 1,
                'name' => 'Fat'
            ],
            [
                'nutrient_id' => 2,
                'language_id' => 2,
                'name' => 'Fett'
            ],
            [
                'nutrient_id' => 2,
                'language_id' => 3,
                'name' => 'Graisse'
            ],
            [
                'nutrient_id' => 3,
                'language_id' => 1,
                'name' => 'Protein'
            ],
            [
                'nutrient_id' => 3,
                'language_id' => 2,
                'name' => 'Protein (German)'
            ],
            [
                'nutrient_id' => 3,
                'language_id' => 3,
                'name' => 'Protein (English)'
            ]
        ]);
    }
}
