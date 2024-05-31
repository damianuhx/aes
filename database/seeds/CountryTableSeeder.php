<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aes_country')->insert([
            [
                'id' => 1,
                'code' => 'ENG',
            ], 
            [
                'id' => 2,
                'code' => 'GER',
            ], 
            [
                'id' => 3,
                'code' => 'FRA',
            ]
        ]);

        DB::table('aes_country_lang')->insert([
            [
                'country_id' => 1,
                'language_id' => 1,
                'name' => 'England',
            ], 
            [
                'country_id' => 1,
                'language_id' => 2,
                'name' => 'England'
            ], 
            [
                'country_id' => 1,
                'language_id' => 3,
                'name' => 'L\'Angleterre'
            ],
            [
                'country_id' => 2,
                'language_id' => 1,
                'name' => 'Germany'
            ],
            [
                'country_id' => 2,
                'language_id' => 2,
                'name' => 'Deutschland'
            ],
            [
                'country_id' => 2,
                'language_id' => 3,
                'name' => 'L\'Allemagne'
            ],
            [
                'country_id' => 3,
                'language_id' => 1,
                'name' => 'France'
            ],
            [
                'country_id' => 3,
                'language_id' => 2,
                'name' => 'Frankreich'
            ],
            [
                'country_id' => 3,
                'language_id' => 3,
                'name' => 'La France'
            ]
        ]);
    }
}
